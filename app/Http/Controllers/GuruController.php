<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\Submission;
use App\Models\Announcement;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function dashboard()
    {
        // Ambil data guru yang login
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        // =========================
        // 1. STATISTIK
        // =========================
        $jumlahKelas = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->count('class_id');
        
        $schedules = Schedule::where('teacher_id', $teacherId)->get();
        $totalJam = 0;
        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $totalJam += $start->diffInHours($end);
        }
        
        $tugasPerluDinilai = Assignment::where('teacher_id', $teacherId)
            ->whereHas('submissions', function($q) {
                $q->whereNull('score');
            })
            ->count();
        
        $classIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->pluck('class_id');
        $totalSiswa = Student::whereIn('class_id', $classIds)->count();

        // =========================
        // 2. JADWAL HARI INI
        // =========================
        $hariIni = $this->getDayName(Carbon::now()->dayOfWeek);
        $jadwal = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->where('day_of_week', $hariIni)
            ->orderBy('start_time')
            ->get();

        // =========================
        // 3. AKTIVITAS HARI INI
        // =========================
        $totalJamHariIni = 0;
        $jumlahKelasHariIni = $jadwal->unique('class_id')->count();
        $totalPertemuanHariIni = $jadwal->count();
        
        foreach ($jadwal as $j) {
            $start = Carbon::parse($j->start_time);
            $end = Carbon::parse($j->end_time);
            $totalJamHariIni += $start->diffInHours($end);
        }
        
        $now = Carbon::now();
        $progressMengajar = 0;
        
        if ($totalJamHariIni > 0) {
            $totalMenitHariIni = $totalJamHariIni * 60;
            $menitSudahLewat = 0;
            
            foreach ($jadwal as $j) {
                $start = Carbon::parse($j->start_time);
                $end = Carbon::parse($j->end_time);
                
                if ($now->greaterThan($end)) {
                    $menitSudahLewat += $start->diffInMinutes($end);
                } elseif ($now->between($start, $end)) {
                    $menitSudahLewat += $start->diffInMinutes($now);
                }
            }
            
            $progressMengajar = min(100, round(($menitSudahLewat / $totalMenitHariIni) * 100));
        }

        // =========================
        // 4. TUGAS PERLU DINILAI
        // =========================
        $tugas = Assignment::where('teacher_id', $teacherId)
            ->with(['submissions' => function($q) {
                $q->whereNull('score');
            }])
            ->whereHas('submissions', function($q) {
                $q->whereNull('score');
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($assignment) {
                $kelas = SchoolClass::find($assignment->class_id);
                $totalSiswa = $kelas ? $kelas->students->count() : 0;
                $belumDinilai = $assignment->submissions->count();
                $assignment->submitted_count = $belumDinilai;
                $assignment->total_siswa = $totalSiswa;
                $assignment->class_name = $kelas ? $kelas->name : 'Kelas';
                return $assignment;
            });

        // =========================
        // 5. SISWA BERPRESTASI
        // =========================
        $siswaBerprestasi = Submission::whereNotNull('score')
            ->whereHas('assignment', function($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })
            ->with('student')
            ->select('student_id', DB::raw('AVG(score) as average_score'))
            ->groupBy('student_id')
            ->orderBy('average_score', 'DESC')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $student = $item->student;
                if ($student) {
                    $student->average_score = $item->average_score;
                }
                return $student;
            })
            ->filter();

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
            'siswaBerprestasi',
            'pengumumanTerbaru',
            'totalJamHariIni',
            'jumlahKelasHariIni',
            'totalPertemuanHariIni',
            'progressMengajar'
        ));
    }

    /**
     * HALAMAN JADWAL GURU
     */
    public function jadwal()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        // Hitung total jam mengajar
        $schedulesAll = Schedule::where('teacher_id', $teacherId)->get();
        $totalJam = 0;
        foreach ($schedulesAll as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $totalJam += $start->diffInHours($end);
        }
        
        // Hitung total kelas yang diajar
        $totalKelas = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->count('class_id');
        
        // Daftar hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        // Selected day (default hari ini)
        $selectedDay = $this->getDayName(Carbon::now()->dayOfWeek);
        
        // Ambil semua jadwal mengajar
        $schedules = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time', 'asc')
            ->get();
        
        // Group jadwal berdasarkan hari
        $jadwalPerHari = [];
        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = [];
        }
        
        foreach ($schedules as $schedule) {
            $hari = $schedule->day_of_week;
            if (isset($jadwalPerHari[$hari])) {
                $jadwalPerHari[$hari][] = $schedule;
            }
        }
        
        // ========== CARI JADWAL BERIKUTNYA ==========
        $now = Carbon::now();
        $hariIni = $this->getDayName($now->dayOfWeek);
        $currentTime = $now->format('H:i:s');
        
        // Cari jadwal hari ini yang belum lewat
        $nextSchedule = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->where('day_of_week', $hariIni)
            ->where('start_time', '>', $currentTime)
            ->orderBy('start_time', 'asc')
            ->first();
        
        $nextClassTime = null;
        if ($nextSchedule) {
            $startTime = Carbon::parse($nextSchedule->start_time);
            $nextClassTime = $startTime->format('H:i') . ' WIB';
        }
        
        return view('guru.jadwal', compact('jadwalPerHari', 'schedules', 'totalJam', 'totalKelas', 'nextSchedule', 'nextClassTime', 'hariList', 'selectedDay'));
    }

    /**
     * HALAMAN ABSENSI GURU
     * SEMUA KELAS AKAN MUNCUL (TIDAK HANYA YANG PUNYA JADWAL)
     */
    public function absensi(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        // Ambil parameter filter
        $classId = $request->get('class_id');
        $scheduleId = $request->get('schedule_id');
        $date = $request->get('date', date('Y-m-d'));
        
        // ========== PERUBAHAN UTAMA ==========
        // Ambil SEMUA kelas (sama seperti di admin/students-edit)
        // Kelas yang sudah dibuat di admin akan langsung muncul di sini
        $classes = SchoolClass::orderBy('name')->get();
        // ====================================
        
        // Ambil semua jadwal guru
        $allSchedules = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
        
        // Filter jadwal berdasarkan kelas jika ada
        $schedules = $allSchedules;
        if ($classId) {
            $schedules = $allSchedules->where('class_id', $classId);
        }
        
        // Ambil daftar siswa berdasarkan kelas yang dipilih
        $students = collect();
        if ($classId) {
            $class = SchoolClass::find($classId);
            if ($class) {
                $students = $class->students;
                
                // Cek status absensi untuk setiap siswa pada tanggal yang dipilih
                $existingAttendances = Attendance::whereDate('date', $date)
                    ->whereIn('student_id', $students->pluck('id'))
                    ->get()
                    ->keyBy('student_id');
                
                foreach ($students as $student) {
                    $attendance = $existingAttendances->get($student->id);
                    $student->attendance_status = $attendance ? $attendance->status : 'hadir';
                    $student->attendance_notes = $attendance ? $attendance->notes : '';
                    $student->attendance_id = $attendance ? $attendance->id : null;
                }
            }
        }
        
        // Hitung statistik untuk card
        $hadirCount = 0;
        $izinCount = 0;
        $sakitCount = 0;
        $alphaCount = 0;
        
        if ($students->count() > 0) {
            $hadirCount = $students->where('attendance_status', 'hadir')->count();
            $izinCount = $students->where('attendance_status', 'izin')->count();
            $sakitCount = $students->where('attendance_status', 'sakit')->count();
            $alphaCount = $students->where('attendance_status', 'alpha')->count();
        }
        
        // Hitung total jam mengajar
        $schedulesAll = Schedule::where('teacher_id', $teacherId)->get();
        $totalJam = 0;
        foreach ($schedulesAll as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $totalJam += $start->diffInHours($end);
        }
        
        // Hitung total kelas yang diajar
        $totalKelas = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->count('class_id');
        
        // Cari jadwal berikutnya untuk card info
        $today = Carbon::today();
        $hariIni = $this->getDayName($today->dayOfWeek);
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        
        $nextSchedule = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->where('day_of_week', $hariIni)
            ->where('start_time', '>', $currentTime)
            ->orderBy('start_time', 'asc')
            ->first();
        
        $nextClassTime = null;
        if ($nextSchedule) {
            $startTime = Carbon::parse($nextSchedule->start_time);
            $nextClassTime = $startTime->format('H:i') . ' WIB';
        }
        
        // Daftar hari untuk sidebar
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $selectedDay = $hariIni;
        
        return view('guru.absensi', compact(
            'students',
            'classes',
            'schedules',
            'classId',
            'scheduleId',
            'date',
            'hadirCount',
            'izinCount',
            'sakitCount',
            'alphaCount',
            'totalJam',
            'totalKelas',
            'nextSchedule',
            'nextClassTime',
            'hariList',
            'selectedDay'
        ));
    }

    /**
     * SIMPAN ABSENSI
     */
    public function absensiStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:hadir,izin,sakit,alpha',
            'notes' => 'nullable|array',
        ]);
        
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                    'class_id' => $request->class_id,
                    'recorded_by' => $teacher ? $teacher->id : null,
                    'recorded_at' => now(),
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    }

    /**
     * HALAMAN TUGAS
     */
    public function tugas()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        $assignments = Assignment::with(['class', 'subject'])
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('guru.tugas', compact('assignments'));
    }

    /**
     * FORM BUAT TUGAS
     */
    public function tugasCreate()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        // Ambil kelas yang diajar
        $classes = SchoolClass::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();
        
        // Ambil mata pelajaran yang diajar
        $subjects = Subject::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->distinct()->get();
        
        return view('guru.tugas-create', compact('classes', 'subjects'));
    }

    /**
     * SIMPAN TUGAS
     */
    public function tugasStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);
        
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        Assignment::create([
            'teacher_id' => $teacher ? $teacher->id : null,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);
        
        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dibuat');
    }

    /**
     * HALAMAN RAPORT/NILAI
     */
    public function raport()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        // Ambil kelas yang diajar
        $classes = SchoolClass::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->with(['students', 'subjects'])->get();
        
        return view('guru.raport', compact('classes'));
    }

    /**
     * HALAMAN PENGUMUMAN
     */
    public function pengumuman()
    {
        $announcements = Announcement::where('target', 'teacher')
            ->orWhere('target', 'all')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('guru.pengumuman', compact('announcements'));
    }

    /**
     * UPDATE NILAI
     */
    public function nilaiUpdate(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);
        
        $grade = Grade::findOrFail($request->grade_id);
        $grade->score = $request->score;
        $grade->save();
        
        return redirect()->back()->with('success', 'Nilai berhasil diupdate');
    }

    /**
     * HALAMAN PROFIL
     */
    public function profil()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        return view('guru.profil', compact('user', 'teacher'));
    }

    /**
     * UPDATE PROFIL
     */
    public function profilUpdate(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        if ($teacher) {
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->save();
        }
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * HELPER FUNCTION - Mendapatkan nama hari dalam Bahasa Indonesia
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