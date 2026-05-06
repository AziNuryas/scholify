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
        // 3. AKTIVITAS HARI INI (Pengganti Statistik Kehadiran)
        // =========================
        $totalJamHariIni = 0;
        $jumlahKelasHariIni = $jadwal->unique('class_id')->count();
        $totalPertemuanHariIni = $jadwal->count();
        
        foreach ($jadwal as $j) {
            $start = Carbon::parse($j->start_time);
            $end = Carbon::parse($j->end_time);
            $totalJamHariIni += $start->diffInHours($end);
        }
        
        // Hitung progress mengajar (persentase waktu yang sudah lewat)
        $now = Carbon::now();
        $progressMengajar = 0;
        
        if ($totalJamHariIni > 0) {
            $totalMenitHariIni = $totalJamHariIni * 60;
            $menitSudahLewat = 0;
            
            foreach ($jadwal as $j) {
                $start = Carbon::parse($j->start_time);
                $end = Carbon::parse($j->end_time);
                
                if ($now->greaterThan($end)) {
                    // Jadwal sudah selesai
                    $menitSudahLewat += $start->diffInMinutes($end);
                } elseif ($now->between($start, $end)) {
                    // Jadwal sedang berlangsung
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

    // =========================
    // HALAMAN JADWAL
    // =========================
    public function jadwal(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        // Ambil semua jadwal
        $allSchedules = Schedule::with(['subject', 'schoolClass'])
            ->where('teacher_id', $teacherId)
            ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('start_time')
            ->get();
        
        // Hitung total jam
        $totalJam = 0;
        foreach ($allSchedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $totalJam += $start->diffInHours($end);
        }
        
        // Hitung total kelas (distinct)
        $totalKelas = $allSchedules->unique('class_id')->count();
        
        // Daftar hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Kelompokkan jadwal per hari
        $jadwalPerHari = [];
        foreach ($hariList as $hari) {
            $jadwalPerHari[$hari] = $allSchedules->where('day_of_week', $hari);
        }
        
        // Hari yang dipilih (default: hari ini)
        $currentDay = $this->getDayName(Carbon::now()->dayOfWeek);
        $selectedDay = $request->get('day', $currentDay);
        
        // Cari kelas berikutnya
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $currentIndex = array_search($currentDay, $hariList);
        
        $nextSchedule = null;
        foreach ($allSchedules as $schedule) {
            $scheduleIndex = array_search($schedule->day_of_week, $hariList);
            if ($scheduleIndex > $currentIndex) {
                $nextSchedule = $schedule;
                break;
            }
            if ($scheduleIndex == $currentIndex && $schedule->start_time > $currentTime) {
                $nextSchedule = $schedule;
                break;
            }
        }
        
        $nextClassTime = '';
        if ($nextSchedule) {
            $startTimeToday = Carbon::today()->setTimeFromTimeString($nextSchedule->start_time);
            
            if ($startTimeToday->isPast()) {
                $startTimeToday->addDay();
            }
            
            $diffMinutes = $now->diffInMinutes($startTimeToday, false);
            
            if ($diffMinutes > 0 && $diffMinutes < 60) {
                $nextClassTime = $diffMinutes . ' Menit Lagi';
            } elseif ($diffMinutes >= 60) {
                $nextClassTime = floor($diffMinutes / 60) . ' Jam Lagi';
            } else {
                $nextClassTime = 'Segera';
            }
        }
        
        return view('guru.jadwal', compact(
            'jadwalPerHari',
            'hariList',
            'selectedDay',
            'totalJam',
            'totalKelas',
            'nextSchedule',
            'nextClassTime'
        ));
    }

    // =========================
    // HALAMAN ABSENSI
    // =========================
    public function absensi(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        $classIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $classes = SchoolClass::whereIn('id', $classIds)->get();
        
        $classId = $request->get('class_id');
        $date = $request->get('date', Carbon::today()->toDateString());
        $scheduleId = $request->get('schedule_id');
        
        // Ambil siswa berdasarkan kelas
        $students = Student::when($classId, function($query) use ($classId) {
            $query->where('class_id', $classId);
        })->get();
        
        // Ambil jadwal untuk filter schedule
        $schedules = Schedule::where('teacher_id', $teacherId)
            ->where('day_of_week', $this->getDayName(Carbon::parse($date)->dayOfWeek))
            ->get();
        
        return view('guru.absensi', compact('classes', 'classId', 'date', 'students', 'schedules', 'scheduleId'));
    }

    // =========================
    // STORE ABSENSI (SIMPAN DATA ABSENSI)
    // =========================
    public function absensiStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();

        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }

        $classId = $request->class_id;

        foreach ($request->attendance as $studentId => $status) {
            // Gunakan DB::table karena model Attendance mungkin belum ada
            DB::table('attendances')->updateOrInsert(
                [
                    'student_id' => $studentId,
                    'schedule_id' => $request->schedule_id,
                    'date' => $request->date,
                ],
                [
                    'teacher_id' => $teacherId,
                    'class_id' => $classId,
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->route('guru.absensi', [
            'class_id' => $classId,
            'schedule_id' => $request->schedule_id,
            'date' => $request->date
        ])->with('success', 'Absensi berhasil disimpan!');
    }

    // =========================
    // HALAMAN TUGAS
    // =========================
    public function tugas()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Assignment::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        $tugas = Assignment::where('teacher_id', $teacherId)
            ->with(['subject'])
            ->latest()
            ->paginate(10);
        
        foreach ($tugas as $item) {
            $kelas = SchoolClass::find($item->class_id);
            $item->class_name = $kelas ? $kelas->name : 'Kelas';
        }
            
        return view('guru.tugas', compact('tugas'));
    }

    // =========================
    // HALAMAN TUGAS CREATE
    // =========================
    public function tugasCreate()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        $classIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $classes = SchoolClass::whereIn('id', $classIds)->get();
        $subjects = Subject::all();
        
        return view('guru.tugas-create', compact('classes', 'subjects'));
    }

    // =========================
    // HALAMAN TUGAS STORE
    // =========================
    public function tugasStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'nullable|date',
        ]);
        
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        Assignment::create([
            'teacher_id' => $teacher->id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);
        
        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dibuat!');
    }

    // =========================
    // HALAMAN RAPORT
    // =========================
    public function raport(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            $teacherId = Schedule::first()->teacher_id ?? 1;
        } else {
            $teacherId = $teacher->id;
        }
        
        $classIds = Schedule::where('teacher_id', $teacherId)
            ->distinct('class_id')
            ->pluck('class_id');
        
        $classes = SchoolClass::whereIn('id', $classIds)->get();
        
        $classId = $request->get('class_id');
        
        $siswa = Student::when($classId, function($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->whereIn('class_id', $classIds)
            ->get();
        
        // Hitung rata-rata nilai per siswa
        foreach ($siswa as $student) {
            $averageScore = Submission::whereHas('assignment', function($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })
                ->where('student_id', $student->id)
                ->whereNotNull('score')
                ->avg('score');
            
            $student->average_score = round($averageScore ?? 0, 2);
        }
        
        return view('guru.raport', compact('siswa', 'classes', 'classId'));
    }

    // =========================
    // HALAMAN PENGUMUMAN
    // =========================
    public function pengumuman()
    {
        $pengumuman = Announcement::where('target', 'teacher')
            ->orWhere('target', 'all')
            ->latest()
            ->paginate(10);
            
        return view('guru.pengumuman', compact('pengumuman'));
    }

    // =========================
    // HALAMAN NILAI
    // =========================
    public function nilai(Request $request)
    {
        $assignmentId = $request->get('assignment_id');
        $assignment = Assignment::with(['submissions.student', 'subject', 'schoolClass'])
            ->findOrFail($assignmentId);
        
        return view('guru.nilai', compact('assignment'));
    }

    // =========================
    // UPDATE NILAI
    // =========================
    public function nilaiUpdate(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);
        
        $submission = Submission::findOrFail($request->submission_id);
        $submission->score = $request->score;
        $submission->save();
        
        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }

    // =========================
    // HALAMAN PROFIL
    // =========================
    public function profil()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        return view('guru.profil', compact('user', 'teacher'));
    }

    // =========================
    // UPDATE PROFIL
    // =========================
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
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($teacher) {
            $teacher->update([
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // =========================
    // HELPER FUNCTION
    // =========================
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