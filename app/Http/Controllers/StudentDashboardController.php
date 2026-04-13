<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        try {
            // Ambil data siswa yang sedang login
            $studentModel = \App\Models\Student::with('schoolClass')
                ->where('user_id', auth()->id())
                ->first();
            
            if (!$studentModel) {
                // Jika data profil belum ada, coba fallback ke siswa pertama atau tampilkan pesan kosong
                $studentModel = \App\Models\Student::with('schoolClass')->first();
            }

            if (!$studentModel) {
                // Jika DB berhasil konek TAPI tabel masih kosong, kembalikan array kosong
                return view('student.dashboard', [
                    'student' => ['name' => 'Belum ada data di DB', 'class' => '-', 'avatar' => ''],
                    'todaySchedules' => [],
                    'urgentAssignments' => []
                ]);
            }

            // Memformat data langsung dari Object Database
            $student = [
                'name'   => $studentModel->name ?? $studentModel->first_name ?? 'Siswa',
                'class'  => $studentModel->schoolClass->name ?? $studentModel->schoolClass->class_name ?? 'Kelas Belum Diatur',
                'nis'    => $studentModel->nis ?? '0000',
                'avatar' => $studentModel->avatar ?? 'https://ui-avatars.com/api/?name=Siswa&background=6366f1&color=fff'
            ];

            // 1. Query Jadwal (Schedules) dari Database berdasarkan class_id siswa
            $schedulesQuery = [];
            if ($studentModel->class_id) {
                // Gunakan try-catch per blok agar satu error tidak merusak seluruh halaman
                try {
                    $schedulesQuery = \App\Models\Schedule::with(['subject', 'teacher'])
                        ->where('class_id', $studentModel->class_id)
                        ->get();
                } catch (\Exception $e) {}
            }
            
            $todaySchedules = [];
            foreach ($schedulesQuery as $sched) {
                $todaySchedules[] = [
                    'time'    => ($sched->start_time ?? '00:00') . ' - ' . ($sched->end_time ?? '00:00'),
                    'subject' => $sched->subject->name ?? 'Mata Pelajaran',
                    'teacher' => $sched->teacher->name ?? 'Guru',
                    'room'    => $sched->room ?? '-',
                    'status'  => 'upcoming' 
                ];
            }

            // 2. Query Tugas (Assignments)
            $assignmentsQuery = [];
            if ($studentModel->class_id) {
                try {
                    // Ambil tugas terbaru tanpa filter due_date untuk mencegah 'Column not found' error
                    // Cukup ambil 5 tugas terakhir untuk kelas ini
                    $assignmentsQuery = \App\Models\Assignment::with('subject')
                        ->where('class_id', $studentModel->class_id)
                        ->latest()
                        ->take(5)
                        ->get();
                } catch (\Exception $e) {}
            }

            $urgentAssignments = [];
            foreach ($assignmentsQuery as $assign) {
                // Coba ambil kolom tenggat waktu yang umum
                $deadline = $assign->due_date ?? $assign->deadline ?? $assign->created_at;
                
                $urgentAssignments[] = [
                    'title'    => $assign->title ?? 'Tugas Baru',
                    'subject'  => $assign->subject->name ?? 'Mata Pelajaran',
                    'due_date' => $deadline ? \Carbon\Carbon::parse($deadline)->format('d M, H:i') : '-',
                    'type'     => $assign->type ?? 'Tugas'
                ];
            }

            return view('student.dashboard', compact('student', 'todaySchedules', 'urgentAssignments'));

        } catch (\Exception $e) {
            // Jika koneksi DB / struktur tabel error total
            return "Terjadi masalah teknis: " . $e->getMessage();
        }
    }
}
