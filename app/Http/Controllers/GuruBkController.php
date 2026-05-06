<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Submission;
use App\Models\Announcement;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruController extends Controller
{
    /**
     * Dashboard Guru - Menampilkan semua statistik
     */
    public function dashboard()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }
        
        // =========================
        // 1. STATISTIK
        // =========================
        $jumlahKelas = Schedule::where('teacher_id', $teacher->id)
            ->distinct('class_id')
            ->count('class_id');
        
        // Total jam mengajar per minggu
        $totalJam = Schedule::where('teacher_id', $teacher->id)
            ->select(DB::raw('SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total_jam'))
            ->value('total_jam') ?? 0;
        
        // Tugas yang perlu dinilai (ada submission tapi belum dinilai)
        $tugasPerluDinilai = Assignment::where('teacher_id', $teacher->id)
            ->whereHas('submissions', function($q) {
                $q->whereNull('score');
            })
            ->count();
        
        // Total siswa binaan
        $totalSiswa = Student::whereHas('class.schedules', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();

        // =========================
        // 2. JADWAL HARI INI
        // =========================
        $hariIni = $this->getDayName(Carbon::now()->dayOfWeek);
        $jadwal = Schedule::with(['subject', 'class'])
            ->where('teacher_id', $teacher->id)
            ->where('day', $hariIni)
            ->orderBy('start_time')
            ->get();

        // =========================
        // 3. TUGAS PERLU DINILAI (DETAIL)
        // =========================
        $tugas = Assignment::where('teacher_id', $teacher->id)
            ->with(['submissions' => function($q) {
                $q->whereNull('score');
            }, 'class'])
            ->whereHas('submissions', function($q) {
                $q->whereNull('score');
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($assignment) {
                $totalSiswa = $assignment->class->students->count();
                $belumDinilai = $assignment->submissions->count();
                $assignment->submitted_count = $belumDinilai;
                $assignment->total_siswa = $totalSiswa;
                return $assignment;
            });

        // =========================
        // 4. KEHADIRAN HARI INI
        // =========================
        $classIds = Schedule::where('teacher_id', $teacher->id)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $totalSiswaHariIni = Student::whereIn('class_id', $classIds)->count();
        
        $absensiHariIni = Attendance::whereIn('class_id', $classIds)
            ->whereDate('date', Carbon::today())
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');
        
        $kehadiranStats = [];
        $statusMapping = [
            'present' => ['label' => 'Hadir', 'icon' => 'check-circle', 'bg' => 'bg-emerald-400', 'text' => 'text-emerald-600'],
            'permit' => ['label' => 'Izin', 'icon' => 'file-text', 'bg' => 'bg-amber-400', 'text' => 'text-amber-600'],
            'sick' => ['label' => 'Sakit', 'icon' => 'activity', 'bg' => 'bg-blue-400', 'text' => 'text-blue-600'],
            'absent' => ['label' => 'Alpha', 'icon' => 'alert-circle', 'bg' => 'bg-rose-400', 'text' => 'text-rose-600'],
        ];
        
        foreach ($statusMapping as $key => $data) {
            $count = $absensiHariIni[$key]->total ?? 0;
            $kehadiranStats[] = [
                'icon' => $data['icon'],
                'label' => $data['label'],
                'count' => $count,
                'percentage' => $totalSiswaHariIni > 0 ? ($count / $totalSiswaHariIni) * 100 : 0,
                'bg_color' => $data['bg'],
                'text_color' => $data['text'],
            ];
        }
        
        $totalKehadiranPersen = $totalSiswaHariIni > 0 && isset($kehadiranStats[0]) 
            ? round(($kehadiranStats[0]['count'] / $totalSiswaHariIni) * 100, 1) 
            : 0;

        // =========================
        // 5. SISWA BERPRESTASI
        // =========================
        $siswaBerprestasi = Submission::whereNotNull('score')
            ->whereHas('assignment', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->with('student')
            ->select('student_id', DB::raw('AVG(score) as average_score'))
            ->groupBy('student_id')
            ->orderBy('average_score', 'DESC')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return $item->student;
            });

        // =========================
        // 6. PENGUMUMAN TERBARU
        // =========================
        $pengumumanTerbaru = Announcement::where('target', 'teacher')
            ->orWhere('target', 'all')
            ->latest()
            ->take(3)
            ->get();

        return view('guru.dashboard', compact(
            'jumlahKelas',
            'totalJam',
            'tugasPerluDinilai',
            'totalSiswa',
            'jadwal',
            'tugas',
            'kehadiranStats',
            'totalKehadiranPersen',
            'siswaBerprestasi',
            'pengumumanTerbaru'
        ));
    }

    /**
     * Halaman Jadwal
     */
    public function jadwal()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }
        
        $jadwal = Schedule::with(['subject', 'class'])
            ->where('teacher_id', $teacher->id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
        
        // Kelompokkan berdasarkan hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jadwalPerHari = [];
        
        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = $jadwal->where('day', $hari);
        }
        
        return view('guru.jadwal', compact('jadwalPerHari', 'hariList'));
    }

    /**
     * Halaman Absensi
     */
    public function absensi(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }
        
        $classIds = Schedule::where('teacher_id', $teacher->id)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $classes = SchoolClass::whereIn('id', $classIds)->get();
        
        $classId = $request->get('class_id');
        $date = $request->get('date', Carbon::today()->toDateString());
        
        $absensi = Attendance::with(['student', 'class'])
            ->when($classId, function($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->whereIn('class_id', $classIds)
            ->whereDate('date', $date)
            ->paginate(20);
        
        return view('guru.absensi', compact('absensi', 'classes', 'classId', 'date'));
    }

    /**
     * Halaman Raport
     */
    public function raport(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }
        
        $classIds = Schedule::where('teacher_id', $teacher->id)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $classes = SchoolClass::whereIn('id', $classIds)->get();
        
        $classId = $request->get('class_id');
        
        $siswa = Student::when($classId, function($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->whereIn('class_id', $classIds)
            ->with(['submissions' => function($q) use ($teacher) {
                $q->whereHas('assignment', function($sq) use ($teacher) {
                    $sq->where('teacher_id', $teacher->id);
                })->whereNotNull('score');
            }])
            ->get()
            ->map(function($student) {
                $student->average_score = $student->submissions->avg('score') ?? 0;
                return $student;
            });
        
        return view('guru.raport', compact('siswa', 'classes', 'classId'));
    }

    /**
     * Halaman Profil
     */
    public function profil()
    {
        $teacher = Auth::user()->teacher;
        return view('guru.profil', compact('teacher'));
    }

    /**
     * Helper: konversi angka hari ke nama hari Indonesia
     */
    private function getDayName($dayNumber)
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        
        return $days[$dayNumber] ?? 'Senin';
    }
}