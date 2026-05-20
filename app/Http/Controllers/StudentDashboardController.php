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
                    $schedulesQuery = \App\Models\JadwalPelajaran::with(['guru'])
                        ->where('school_class_id', $studentModel->class_id)
                        ->get();
                } catch (\Exception $e) {}
            }
            
            $todaySchedules = [];
            foreach ($schedulesQuery as $sched) {
                $todaySchedules[] = [
                    'time'    => (\Carbon\Carbon::parse($sched->jam_mulai)->format('H:i') ?? '00:00') . ' - ' . (\Carbon\Carbon::parse($sched->jam_selesai)->format('H:i') ?? '00:00'),
                    'subject' => $sched->mata_pelajaran ?? 'Mata Pelajaran',
                    'teacher' => $sched->guru->name ?? 'Guru',
                    'room'    => $sched->ruangan ?? '-',
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

            // 3. Statistik Absensi (Attendance)
            $attendanceStats = [
                'percentage' => '0%',
                'completed_assignments' => 0
            ];
            
            if ($studentModel->id) {
                try {
                    // Hitung Kehadiran
                    $totalAttendances = \App\Models\Attendance::where('student_id', $studentModel->id)->count();
                    if ($totalAttendances > 0) {
                        $presentCount = \App\Models\Attendance::where('student_id', $studentModel->id)
                            ->where('status', 'hadir')
                            ->count();
                        $attendanceStats['percentage'] = round(($presentCount / $totalAttendances) * 100) . '%';
                    } else {
                        $attendanceStats['percentage'] = '100%';
                    }

                    // Hitung Tugas Selesai
                    $attendanceStats['completed_assignments'] = \App\Models\Submission::where('student_id', $studentModel->id)->count();
                    
                } catch (\Exception $e) {}
            }

            // 4. Statistik Nilai (Grades Chart Data)
            $chartData = [
                'categories' => [],
                'series' => []
            ];

            if ($studentModel->id) {
                try {
                    // Ambil 7 nilai terbaru dari tabel grades untuk siswa ini, urutkan berdasarkan id agar terurut kronologis
                    $recentGrades = \App\Models\Grade::with('subject')
                        ->where('student_id', $studentModel->id)
                        ->latest('id')
                        ->take(7)
                        ->get()
                        ->reverse() // Balik agar yang terlama di sebelah kiri grafik
                        ->values();

                    foreach ($recentGrades as $grade) {
                        // Singkat nama mata pelajaran agar pas di grafik
                        $subjectName = $grade->subject->name ?? 'Mapel';
                        // Ambil kata pertama saja jika terlalu panjang
                        $shortName = explode(' ', trim($subjectName))[0];
                        
                        $chartData['categories'][] = $shortName;
                        $chartData['series'][] = (int) ($grade->score ?? 0);
                    }

                    // Jika tidak ada data nilai, set fallback agar grafik tidak error
                    if (empty($chartData['categories'])) {
                        $chartData['categories'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $chartData['series'] = [0, 0, 0, 0, 0, 0, 0];
                    }
                } catch (\Exception $e) {
                    $chartData['categories'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    $chartData['series'] = [0, 0, 0, 0, 0, 0, 0];
                }
            } else {
                $chartData['categories'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $chartData['series'] = [0, 0, 0, 0, 0, 0, 0];
            }

            return view('student.dashboard', compact('student', 'todaySchedules', 'urgentAssignments', 'attendanceStats', 'chartData'));

        } catch (\Exception $e) {
            // Jika koneksi DB / struktur tabel error total
            return "Terjadi masalah teknis: " . $e->getMessage();
        }
    }
}
