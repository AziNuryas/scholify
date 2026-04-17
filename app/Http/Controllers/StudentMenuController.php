<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Submission;
use App\Models\User;
use App\Models\Appointment;
use App\Models\DisciplinaryRecord;

class StudentMenuController extends Controller
{
    private function getStudent()
    {
        if (auth()->check() && auth()->user()->role === 'siswa') {
            return Student::with('schoolClass')->where('user_id', auth()->user()->id)->first();
        }
        return null;
    }

    // ===========================
    // JADWAL KELAS
    // ===========================
    public function schedule()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $classId = $studentData->class_id ?? null;
        
        $schedules = collect([]);
        if ($classId) {
            try {
                $schedules = Schedule::with(['subject', 'teacher'])
                    ->where('class_id', $classId)
                    ->orderBy('start_time', 'asc')
                    ->get();
            } catch (\Exception $e) {}
        }
        
        $schedulesGrouped = $schedules->groupBy(function($item) {
            return $item->day_of_week ?? 'Senin'; 
        });

        return view('student.schedule', compact('student', 'schedulesGrouped'));
    }

    // ===========================
    // TUGAS (ASSIGNMENTS)
    // ===========================
    public function assignments(Request $request)
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $classId = $studentData->class_id ?? null;
        $studentId = $studentData->id ?? null;

        $filter = $request->input('filter', 'active');

        $assignments = collect([]);
        $submittedIds = collect([]);

        if ($classId && $studentId) {
            try {
                $submittedIds = Submission::where('student_id', $studentId)
                    ->pluck('assignment_id');

                $query = Assignment::with(['subject', 'teacher'])
                    ->where('class_id', $classId);

                if ($filter === 'completed') {
                    $query->whereIn('id', $submittedIds);
                } else {
                    $query->whereNotIn('id', $submittedIds);
                }

                $assignments = $query->orderBy('due_date', 'asc')->get();
            } catch (\Exception $e) {}
        }

        return view('student.assignments', compact('student', 'assignments', 'filter', 'submittedIds'));
    }

    // ===========================
    // KUMPULKAN TUGAS (SUBMIT)
    // ===========================
    public function submitAssignment(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'notes' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:10240', // max 10MB
        ]);

        $studentData = $this->getStudent();
        if (!$studentData) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah sudah pernah submit
        $existing = Submission::where('assignment_id', $request->assignment_id)
            ->where('student_id', $studentData->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mengumpulkan tugas ini sebelumnya.');
        }

        $fileUrl = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('submissions', 'public');
            $fileUrl = '/storage/' . $path;
        }

        // Cek apakah terlambat
        $assignment = Assignment::find($request->assignment_id);
        $isLate = $assignment->due_date && $assignment->due_date->isPast();

        Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $studentData->id,
            'file_url' => $fileUrl,
            'notes' => $request->notes,
            'score' => null, // Belum dinilai
            'status' => $isLate ? 'Late' : 'Submitted',
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan!' . ($isLate ? ' (Terlambat)' : ''));
    }

    // ===========================
    // NILAI (GRADES)
    // ===========================
    public function grades(Request $request)
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $studentId = $studentData->id ?? null;

        $semester = $request->input('semester', 'Ganjil');
        $availableSemesters = collect([]);
        $grades = collect([]);
        $averageScore = 0;

        if ($studentId) {
            try {
                $availableSemesters = Grade::where('student_id', $studentId)
                    ->distinct()
                    ->pluck('semester')
                    ->filter();

                $grades = Grade::with('subject')
                    ->where('student_id', $studentId)
                    ->where('semester', $semester)
                    ->orderBy('subject_id', 'asc')
                    ->get();

                if ($grades->count() > 0) {
                    $averageScore = round($grades->avg('score'), 1);
                }
            } catch (\Exception $e) {
                $grades = collect([]);
            }
        }

        return view('student.grades', compact('student', 'grades', 'semester', 'availableSemesters', 'averageScore'));
    }

    // ===========================
    // LAYANAN BK (Info + Janji Temu) — TANPA CHAT
    // ===========================
    public function counseling()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);

        // Ambil data Guru BK
        $bkUsers = User::where('role', 'guru_bk')->get();
        $bkUser = $bkUsers->first();

        // Ambil info guru BK (profil teacher)
        $bkTeacher = null;
        if ($bkUser) {
            $bkTeacher = \App\Models\Teacher::where('user_id', $bkUser->id)->first();
        }

        // Ambil riwayat appointment siswa ini
        $appointments = collect([]);
        if ($studentData) {
            $appointments = Appointment::with('teacher')
                ->where('student_id', $studentData->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('student.counseling', compact('student', 'bkUser', 'bkUsers', 'bkTeacher', 'appointments'));
    }

    // ===========================
    // SIMPAN JANJI TEMU
    // ===========================
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'notes' => 'required|string'
        ]);

        $studentData = $this->getStudent();
        if (!$studentData) {
            return back()->with('error', 'Data siswa tidak ditemukan. Pastikan kamu login sebagai siswa.');
        }

        try {
            Appointment::create([
                'student_id' => $studentData->id,
                'teacher_id' => $request->teacher_id,
                'date' => $request->date,
                'time' => $request->time,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);
            return back()->with('success', 'Jadwal temu berhasil diajukan! Menunggu persetujuan dari Guru BK.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat jadwal temu: ' . $e->getMessage());
        }
    }

    // ===========================
    // PROFIL (Edit terbatas: foto, HP, alamat)
    // ===========================
    public function profile()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        
        return view('student.profile', compact('student', 'studentData'));
    }

    public function updateProfile(Request $request)
    {
        $studentModel = $this->getStudent();
        
        if (!$studentModel) {
            return back()->with('error', 'Data siswa tidak ditemukan di sistem.');
        }

        // Hanya boleh update: avatar, phone, address
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $studentModel->avatar = '/storage/' . $path;
        }

        $studentModel->phone = $request->input('phone', $studentModel->phone);
        $studentModel->address = $request->input('address', $studentModel->address);

        $studentModel->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ===========================
    // CATATAN DISIPLIN
    // ===========================
    public function discipline()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        
        $records = collect([]);
        if ($studentData) {
            $records = DisciplinaryRecord::with('teacher')
                ->where('student_id', $studentData->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('student.discipline', compact('student', 'records'));
    }
}
