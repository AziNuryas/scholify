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
            if ($end->greaterThan($start)) {
                $totalJam += $end->diffInMinutes($start) / 60;
            }
        }
        $totalJam = round($totalJam, 1);
        
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
            if ($end->greaterThan($start)) {
                $totalJamHariIni += $end->diffInMinutes($start) / 60;
            }
        }
        $totalJamHariIni = round($totalJamHariIni, 1);
        
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
                    $student->average_score = round($item->average_score, 1);
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
            if ($end->greaterThan($start)) {
                $totalJam += $end->diffInMinutes($start) / 60;
            }
        }
        $totalJam = round($totalJam, 1);
        
        // Hitung total kelas yang diajar
        $totalKelas = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->count('class_id');
        
        // Daftar hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        // Selected day (default hari ini)
        $selectedDay = request('day', $this->getDayName(Carbon::now()->dayOfWeek));
        
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
     * HALAMAN REKAP ABSENSI SISWA
     */
    public function rekapAbsensi(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        $classId = $request->get('class_id');
        $studentId = $request->get('student_id');
        $startDate = $request->get('start_date', date('Y-m-d', strtotime('-30 days')));
        $endDate = $request->get('end_date', date('Y-m-d'));
        
        $classes = SchoolClass::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        
        $students = collect();
        if ($classId) {
            $class = SchoolClass::find($classId);
            if ($class) {
                $students = $class->students;
            }
        }
        
        $absensi = collect();
        if ($classId) {
            $query = Attendance::with('student')
                ->whereIn('student_id', $students->pluck('id'))
                ->whereBetween('date', [$startDate, $endDate]);
            
            if ($studentId) {
                $query->where('student_id', $studentId);
            }
            
            $absensi = $query->orderBy('date', 'desc')->get();
        }
        
        $statistikSiswa = [];
        foreach ($students as $student) {
            $studentAbsensi = $absensi->where('student_id', $student->id);
            $statistikSiswa[$student->id] = [
                'nama' => $student->name,
                'nis' => $student->nis,
                'hadir' => $studentAbsensi->where('status', 'hadir')->count(),
                'izin' => $studentAbsensi->where('status', 'izin')->count(),
                'sakit' => $studentAbsensi->where('status', 'sakit')->count(),
                'alpha' => $studentAbsensi->where('status', 'alpha')->count(),
                'total' => $studentAbsensi->count(),
            ];
        }
        
        return view('guru.rekap-absensi', compact(
            'classes', 'students', 'absensi', 'statistikSiswa',
            'classId', 'studentId', 'startDate', 'endDate'
        ));
    }

    /**
     * HALAMAN INPUT NILAI SISWA
     */
    public function nilai(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $teacherId = $teacher->id;
        
        // Ambil kelas yang diajar guru
        $classes = SchoolClass::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        
        // Ambil mata pelajaran yang diajar guru
        $subjectIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('subject_id')
            ->pluck('subject_id');
        
        $subjects = Subject::whereIn('id', $subjectIds)->orderBy('name')->get();
        
        // Filter
        $classId = $request->get('class_id');
        $subjectId = $request->get('subject_id');
        $assessmentType = $request->get('assessment_type');
        
        $students = collect();
        
        if ($classId && $subjectId) {
            $class = SchoolClass::find($classId);
            if ($class) {
                $students = $class->students;
                
                foreach ($students as $student) {
                    $query = Grade::where('student_id', $student->id)
                        ->where('subject_id', $subjectId);
                    
                    if ($assessmentType) {
                        $query->where('assessment_type', $assessmentType);
                    }
                    
                    $grade = $query->first();
                    $student->grade = $grade;
                }
            }
        }
        
        return view('guru.nilai', compact('classes', 'subjects', 'students', 'classId', 'subjectId', 'assessmentType'));
    }

    /**
     * SIMPAN NILAI SISWA (MASSAL ATAU SINGLE VIA AJAX)
     */
    public function nilaiStore(Request $request)
    {
        // PERBAIKAN: ganti school_classes menjadi classes
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'grades' => 'required|array',
            'grades.*.score' => 'nullable|numeric|min:0|max:100',
            'grades.*.assessment_type' => 'nullable|string|in:tugas,quiz,uts,uas,praktikum',
            'grades.*.notes' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            if ($request->ajax() || $request->has('_ajax')) {
                return response()->json(['success' => false, 'message' => 'Data guru tidak ditemukan']);
            }
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $savedCount = 0;
        $lastGrade = null;
        
        DB::beginTransaction();
        
        try {
            foreach ($request->grades as $studentId => $gradeData) {
                // Skip jika tidak ada nilai
                if (empty($gradeData['score']) && empty($gradeData['assessment_type'])) {
                    continue;
                }
                
                $student = Student::find($studentId);
                if (!$student) {
                    continue;
                }
                
                // Update atau create nilai
                $grade = Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $request->subject_id,
                        'assessment_type' => $gradeData['assessment_type'] ?? 'tugas',
                    ],
                    [
                        'score' => !empty($gradeData['score']) ? $gradeData['score'] : null,
                        'class_id' => $request->class_id,
                        'teacher_id' => $teacher->id,
                        'notes' => $gradeData['notes'] ?? null,
                    ]
                );
                
                $lastGrade = $grade;
                $savedCount++;
            }
            
            DB::commit();
            
            $message = "Berhasil menyimpan {$savedCount} nilai";
            
            if ($request->ajax() || $request->has('_ajax')) {
                return response()->json([
                    'success' => true, 
                    'message' => $message,
                    'saved_count' => $savedCount,
                    'grade' => $lastGrade
                ]);
            }
            
            return redirect()->route('guru.nilai', [
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'assessment_type' => $request->assessment_type
            ])->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax() || $request->has('_ajax')) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * UPDATE NILAI SINGLE (LEGACY)
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
        
        $classes = SchoolClass::whereHas('schedules', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();
        
        $subjectIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('subject_id')
            ->pluck('subject_id');
        
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        
        return view('guru.tugas-create', compact('classes', 'subjects'));
    }

    /**
     * SIMPAN TUGAS
     */
    public function tugasStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
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
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
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