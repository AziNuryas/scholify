<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Chat;
use App\Models\Absensi;
use App\Models\Submission;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StudentMenuController extends Controller
{
    private function getStudent()
    {
        if (auth()->check()) {
            $student = Student::with('schoolClass')
                ->where('user_id', auth()->id())
                ->first();
                
            if ($student) {
                return $student;
            }
        }

        return Student::with('schoolClass')->first();
    }

    private function formatStudent($studentData)
    {
        return collect($studentData ? $studentData->toArray() : [
            'name' => 'Siswa',
            'avatar' => null
        ]);
    }

    // ================= DASHBOARD MENU =================

    public function schedule()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $classId = $studentData->class_id ?? null;

        $schedules = collect([]);

        if ($classId) {
            try {
                $schedules = Schedule::with(['subject', 'teacher'])
                    ->where('class_id', $classId)
                    ->orderBy('day_of_week')
                    ->orderBy('start_time')
                    ->get();
            } catch (\Exception $e) {}
        }

        $schedulesGrouped = $schedules->groupBy(fn($item) => $item->day_of_week ?? 'Senin');

        return view('student.schedule', compact('student', 'schedulesGrouped'));
    }

    public function assignments()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $classId = $studentData->class_id ?? null;

        $assignments = collect([]);

        if ($classId) {
            try {
                $studentId = $studentData->id;
                
                $assignments = Assignment::with(['subject', 'submissions' => function($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                }])
                ->where('class_id', $classId)
                ->latest()
                ->get();
                
                // Proses status tugas
                foreach ($assignments as $assignment) {
                    $submission = $assignment->submissions->first();
                    
                    if ($submission && in_array($submission->status, ['submitted', 'late', 'graded'])) {
                        $assignment->status = $submission->status;
                        $assignment->submission_id = $submission->id;
                        $assignment->submission_file = $submission->file;
                        $assignment->submission_note = $submission->note;
                        $assignment->submitted_at = $submission->submitted_at;
                        $assignment->score = $submission->score;
                        $assignment->is_late = ($submission->status == 'late');
                    } else if ($assignment->due_date && Carbon::parse($assignment->due_date)->isPast()) {
                        $assignment->status = 'pending';
                        $assignment->is_late = true;
                    } else {
                        $assignment->status = 'pending';
                        $assignment->is_late = false;
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Assignment fetch error: ' . $e->getMessage());
            }
        }

        return view('student.assignments', compact('student', 'assignments'));
    }

    public function submitAssignment(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'submission_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);
        
        $studentData = $this->getStudent();
        if (!$studentData || !$studentData->id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Data profil siswa tidak ditemukan. Lengkapi profil Anda terlebih dahulu.']);
            }
            return back()->with('error', 'Data profil siswa tidak ditemukan. Lengkapi profil Anda terlebih dahulu.');
        }
        
        try {
            $assignment = Assignment::findOrFail($request->assignment_id);
            
            // Cek apakah sudah submit
            $existing = Submission::where('assignment_id', $assignment->id)
                ->where('student_id', $studentData->id)
                ->first();
                
            if ($existing) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Anda sudah mengumpulkan tugas ini']);
                }
                return back()->with('error', 'Anda sudah mengumpulkan tugas ini');
            }
            
            $status = 'submitted';
            if ($assignment->due_date && Carbon::parse($assignment->due_date)->isPast()) {
                $status = 'late';
            }
            
            $submission = Submission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $studentData->id,
                'file' => $request->submission_link,
                'note' => $request->notes,
                'status' => $status,
                'submitted_at' => now(),
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Tugas berhasil dikumpulkan',
                    'data' => $submission
                ]);
            }
            
            return redirect()->route('student.assignments')->with('success', '✅ Tugas berhasil dikumpulkan!');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Submit assignment error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengumpulkan tugas: ' . $e->getMessage()]);
            }
            
            return back()->with('error', 'Gagal mengumpulkan tugas: ' . $e->getMessage());
        }
    }

    public function grades()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $studentId = $studentData->id ?? null;

        $grades = collect([]);

        if ($studentId) {
            try {
                $grades = collect(
                    DB::table('grades')
                        ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
                        ->select('grades.*', 'subjects.name as subject_name')
                        ->where('student_id', $studentId)
                        ->get()
                );
            } catch (\Exception $e) {}
        }

        return view('student.grades', compact('student', 'grades'));
    }

    // ================= ABSENSI SISWA =================

    public function absensi()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        
        $absensi = collect([]);
        $statistik = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        $todayAbsen = null;
        
        if ($studentData && $studentData->id) {
            try {
                $absensi = Absensi::where('siswa_id', $studentData->id)
                    ->orderBy('tanggal', 'desc')
                    ->paginate(10);
                
                $statistik = [
                    'hadir' => Absensi::where('siswa_id', $studentData->id)->where('status', 'hadir')->count(),
                    'izin' => Absensi::where('siswa_id', $studentData->id)->where('status', 'izin')->count(),
                    'sakit' => Absensi::where('siswa_id', $studentData->id)->where('status', 'sakit')->count(),
                    'alpha' => Absensi::where('siswa_id', $studentData->id)->where('status', 'alpha')->count(),
                ];
                
                $todayAbsen = Absensi::where('siswa_id', $studentData->id)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
                    
            } catch (\Exception $e) {
                $absensi = collect([]);
            }
        }
        
        return view('student.absensi', compact('student', 'studentData', 'absensi', 'statistik', 'todayAbsen'));
    }

    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);
        
        $studentData = $this->getStudent();
        
        if (!$studentData || !$studentData->id) {
            return back()->with('error', 'Data siswa tidak ditemukan! Silakan hubungi admin.');
        }
        
        try {
            $existing = Absensi::where('siswa_id', $studentData->id)
                ->where('tanggal', $request->tanggal)
                ->first();
                
            if ($existing) {
                return back()->with('error', 'Anda sudah melakukan absensi untuk tanggal ' . date('d/m/Y', strtotime($request->tanggal)) . '!');
            }
            
            Absensi::create([
                'siswa_id' => $studentData->id,
                'kelas_id' => $studentData->class_id,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]);
            
            return back()->with('success', '✅ Absensi berhasil direkam! Terima kasih.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    // ================= KONSULTASI =================

    public function counseling()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);

        $counselingHistory = Chat::where(function ($q) use ($studentData) {
                $q->where('sender_id', $studentData->user_id)
                  ->orWhere('receiver_id', $studentData->user_id);
            })
            ->orderBy('created_at')
            ->get();

        Chat::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $bkUser = User::where('role', 'guru_bk')->first();

        return view('student.counseling', compact('student', 'counselingHistory', 'bkUser'));
    }

    public function sendCounselingMessage(Request $request)
    {
        $request->validate(['message' => 'required']);

        $bkUser = User::where('role', 'guru_bk')->first();

        Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $bkUser->id ?? auth()->id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    // ================= PROFIL =================

    public function profile()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $user = auth()->user();

        return view('student.profile', compact('student', 'studentData', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $studentModel = $this->getStudent();
        $user = auth()->user();

        if (!$studentModel) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($studentModel->avatar) {
                $oldPath = str_replace('/storage/', '', $studentModel->avatar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');
            $studentModel->avatar = $path;
        }

        if ($request->has('phone')) {
            $studentModel->phone = $request->phone;
        }
        if ($request->has('address')) {
            $studentModel->address = $request->address;
        }

        $studentModel->save();

        return redirect()->route('student.profile')->with('success', '✅ Profil berhasil diperbarui!');
    }

    // ================= APPOINTMENT =================

    public function appointments()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);

        $appointments = $studentData
            ? \App\Models\Appointment::with('teacher')
                ->where('student_id', $studentData->id)
                ->latest()
                ->get()
            : collect([]);

        $bkUsers = \App\Models\Teacher::whereHas('user', function($q) {
            $q->where('role', 'guru_bk');
        })->get();

        return view('student.appointments', compact('student', 'appointments', 'bkUsers'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'required'
        ]);

        $studentData = $this->getStudent();

        \App\Models\Appointment::create([
            'student_id' => $studentData->id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Berhasil membuat jadwal');
    }

    // ================= DISIPLIN =================

    public function discipline()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);

        $records = $studentData
            ? \App\Models\DisciplinaryRecord::with('teacher')
                ->where('student_id', $studentData->id)
                ->latest()
                ->get()
            : collect([]);

        return view('student.discipline', compact('student', 'records'));
    }

    // ================= NOTIFIKASI (LENGKAP) =================

    public function notifications()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        
        $userId = auth()->id();
        $notifications = UserNotification::where('user_id', $userId)
            ->latest()
            ->paginate(15);
            
        return view('student.notifications', compact('student', 'notifications'));
    }

    public function fetchNotifications()
    {
        $userId = auth()->id();
        $unreadCount = UserNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
            
        $latest = UserNotification::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'notifications' => $latest
        ]);
    }

    public function markNotificationAsRead($id)
    {
        $notif = UserNotification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($notif) {
            $notif->is_read = true;
            $notif->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function deleteNotification($id)
    {
        $notif = UserNotification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($notif) {
            $notif->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function deleteAllNotifications()
    {
        UserNotification::where('user_id', auth()->id())->delete();
        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead()
    {
        UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    // ================= SETTINGS =================

    public function settings()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $user = auth()->user();

        return view('student.settings', compact('student', 'studentData', 'user'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = auth()->user();

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
            return back()->with('success', 'Kata sandi berhasil diperbarui!');
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}