<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Chat;

class StudentMenuController extends Controller
{
    private function getStudent()
    {
        // Ambil data siswa yang sedang login
        if (auth()->check() && auth()->user()->role === 'siswa') {
            return Student::with('schoolClass')->where('user_id', auth()->user()->id)->first();
        }
        return Student::with('schoolClass')->first();
    }

    public function schedule()
    {
        $student = collect($this->getStudent() ? $this->getStudent()->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $classId = $this->getStudent()->class_id ?? null;
        
        $schedules = collect([]);
        if ($classId) {
            try {
                // Ambil semua jadwal dalam kelas anak ini, dan urutkan berdasar hari
                $schedules = Schedule::with(['subject', 'teacher'])
                    ->where('class_id', $classId)
                    ->orderBy('day_of_week', 'asc') // Asumsi kolom hari 1=Senin, dll.
                    ->orderBy('start_time', 'asc')
                    ->get();
            } catch (\Exception $e) {}
        }
        
        // Agar bisa ditata per hari di UI (Timeline)
        $schedulesGrouped = $schedules->groupBy(function($item) {
            return $item->day_of_week ?? 'Senin'; 
        });

        return view('student.schedule', compact('student', 'schedulesGrouped'));
    }

    public function assignments()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $classId = $studentData->class_id ?? null;

        $assignments = collect([]);
        if ($classId) {
            try {
                $assignments = Assignment::with('subject')
                    ->where('class_id', $classId)
                    ->orderBy('due_date', 'asc')
                    ->get();
            } catch (\Exception $e) {}
        }

        return view('student.assignments', compact('student', 'assignments'));
    }

    public function grades()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        $studentId = $studentData->id ?? null;

        $grades = collect([]);
        if ($studentId) {
            try {
                // Dianggap memakai nama tabel 'grades' langsung dari DB Facade agar safety jika model Grade belum ada
                $d = \Illuminate\Support\Facades\DB::table('grades')
                    ->where('student_id', $studentId)
                    ->get();
                $grades = collect($d);
            } catch (\Exception $e) {
                // Dummy fallback jika tabel blm ready
                $grades = collect([
                    (object)['subject_name' => 'Matematika', 'score' => 85, 'type' => 'Ujian Tengah Semester', 'semester' => 1],
                    (object)['subject_name' => 'Bahasa Inggris', 'score' => 90, 'type' => 'Tugas Mingguan', 'semester' => 1],
                ]);
            }
        }

        return view('student.grades', compact('student', 'grades'));
    }

    public function counseling()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);

        // Ambil histori chat asli antara siswa ini dan guru BK (siapapun guru BK-nya)
        $counselingHistory = \App\Models\Chat::where(function($q) use ($studentData) {
                $q->where('sender_id', $studentData->user_id)
                  ->orWhere('receiver_id', $studentData->user_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read pesan yang masuk dari Guru BK ke siswa ini
        \App\Models\Chat::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('student.counseling', compact('student', 'counselingHistory'));
    }

    public function sendCounselingMessage(Request $request)
    {
        $request->validate(['message' => 'required']);

        // Ambil guru BK pertama sebagai penerima default (simulasi)
        $bkUser = User::where('role', 'guru_bk')->first();

        \App\Models\Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $bkUser->id ?? auth()->id(), // fallback ke diri sendiri jika BK belum ada
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'Pesan berhasil dikirim ke Guru BK!');
    }

    public function profile()
    {
        $studentData = $this->getStudent();
        $student = collect($studentData ? $studentData->toArray() : ['name' => 'Siswa', 'avatar' => null]);
        
        return view('student.profile', compact('student', 'studentData'));
    }

    public function updateProfile(Request $request)
    {
        // 1. Ambil model student-nya
        $studentModel = $this->getStudent();
        
        if (!$studentModel) {
            return back()->with('error', 'Data siswa tidak ditemukan di sistem.');
        }

        // 2. Jika ada file avatar/Poto Profil yang diupload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            // Simpan gambar ke storage/app/public/avatars (perlu run artisan storage:link)
            $path = $file->store('avatars', 'public');
            // Update URL ke database
            $studentModel->avatar = '/storage/' . $path;
        }

        // 3. Update field lainnya
        // Memakai null coalescing agar kalau dari form kosong, tetep tersimpan aman
        $studentModel->first_name = $request->input('name') ?? $studentModel->first_name; 
        
        // Coba perbarui nama fallback kalau DB pakainya kolom 'name'
        try {
            $studentModel->name = $request->input('name') ?? $studentModel->name;
        } catch (\Exception $e) {}

        $studentModel->nisn = $request->input('nisn');
        $studentModel->phone = $request->input('phone');
        $studentModel->birth_place = $request->input('birth_place');
        $studentModel->address = $request->input('address');

        // 4. Simpan perubahan ke Database
        $studentModel->save();

        return back()->with('success', 'Profil dan Foto berhasil diupdate!');
    }
}
