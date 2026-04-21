<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class StudentMenuController extends Controller
{
    private function getStudent()
    {
        if (auth()->check() && auth()->user()->role === 'siswa') {
            return Student::with('schoolClass')
                ->where('user_id', auth()->user()->id)
                ->first();
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

    public function assignments(Request $request)
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);
        $classId = $studentData->class_id ?? null;
        $studentId = $studentData->id ?? null;
        
        $filter = $request->query('filter', 'active');
        $assignments = collect([]);

        if ($classId && $studentId) {
            try {
                $submittedIds = DB::table('submissions')
                    ->where('student_id', $studentId)
                    ->pluck('assignment_id')
                    ->toArray();

                $query = Assignment::with('subject')->where('class_id', $classId);

                if ($filter === 'active') {
                    $query->whereNotIn('id', $submittedIds)
                          ->where(function($q) {
                              $q->whereNull('due_date')->orWhere('due_date', '>=', now());
                          });
                } else if ($filter === 'completed') {
                    $query->whereIn('id', $submittedIds);
                }

                $assignments = $query->orderBy('due_date')->get();
            } catch (\Exception $e) {}
        }

        return view('student.assignments', compact('student', 'assignments'));
    }

    public function submitAssignment(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240', // 10MB Max
        ]);

        $studentData = $this->getStudent();
        
        if (!$studentData) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        try {
            // Cek jika sudah pernah submit
            $existing = DB::table('submissions')
                ->where('assignment_id', $request->assignment_id)
                ->where('student_id', $studentData->id)
                ->first();

            if ($existing) {
                return back()->with('error', 'Kamu sudah mengumpulkan tugas ini sebelumnya.');
            }

            $path = $request->file('file')->store('submissions', 'public');

            DB::table('submissions')->insert([
                'assignment_id' => $request->assignment_id,
                'student_id' => $studentData->id,
                'file_url' => '/storage/' . $path,
                'notes' => $request->notes,
                'status' => 'Submitted',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Tugas berhasil dikumpulkan!');
        } catch (\Exception $e) {
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

        return view('student.profile', compact('student', 'studentData'));
    }

    public function updateProfile(Request $request)
    {
        $studentModel = $this->getStudent();

        if (!$studentModel) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $studentModel->avatar = '/storage/' . $path;
        }

        $studentModel->first_name = $request->name ?? $studentModel->first_name;

        try {
            $studentModel->name = $request->name ?? $studentModel->name;
        } catch (\Exception $e) {}

        $studentModel->nisn = $request->nisn;
        $studentModel->phone = $request->phone;
        $studentModel->birth_place = $request->birth_place;
        $studentModel->address = $request->address;

        $studentModel->save();

        return back()->with('success', 'Profil berhasil diupdate');
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

        $bkUsers = User::where('role', 'guru_bk')->get();

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

    // ================= ✅ PENGUMUMAN (FIX ERROR) =================

    public function announcements()
    {
        $studentData = $this->getStudent();
        $student = $this->formatStudent($studentData);

        try {
            $announcements = DB::table('announcements')
                ->latest()
                ->get();
        } catch (\Exception $e) {
            $announcements = collect([]);
        }

        return view('student.announcements', compact('student', 'announcements'));
    }
}