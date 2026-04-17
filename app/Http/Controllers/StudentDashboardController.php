<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Assignment;
use App\Models\Grade;
use App\Models\Payment;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Jika bukan siswa, redirect ke dashboard sesuai role
        if (!auth()->check() || auth()->user()->role !== 'siswa') {
            return redirect()->route('dashboard');
        }

        try {
            // Ambil data siswa yang sedang login
            $studentModel = Student::with('schoolClass')
                ->where('user_id', auth()->id())
                ->first();

            if (!$studentModel) {
                return view('student.dashboard', [
                    'student' => ['name' => 'Data siswa belum ada', 'class' => '-', 'avatar' => '', 'nis' => '-'],
                    'todaySchedules' => [],
                    'urgentAssignments' => [],
                    'sppInfo' => null,
                    'gradeChartData' => ['labels' => [], 'scores' => []],
                    'gradeProgress' => 0,
                ]);
            }

            // Memformat data langsung dari Object Database
            $student = [
                'name'   => $studentModel->name ?? $studentModel->first_name ?? 'Siswa',
                'class'  => $studentModel->schoolClass->name ?? $studentModel->schoolClass->class_name ?? 'Kelas Belum Diatur',
                'nis'    => $studentModel->nis ?? '0000',
                'avatar' => $studentModel->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($studentModel->name ?? 'Siswa') . '&background=6366f1&color=fff'
            ];

            // =====================================================
            // 1. JADWAL HARI INI — Filter berdasarkan hari sekarang
            // =====================================================
            $todaySchedules = [];
            if ($studentModel->class_id) {
                try {
                    // Map hari bahasa Indonesia
                    $dayMap = [
                        'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
                    ];
                    $todayName = $dayMap[Carbon::now()->format('l')] ?? 'Senin';

                    $schedulesQuery = Schedule::with(['subject', 'teacher'])
                        ->where('class_id', $studentModel->class_id)
                        ->where('day_of_week', $todayName)
                        ->orderBy('start_time', 'asc')
                        ->get();

                    foreach ($schedulesQuery as $sched) {
                        // Tentukan status: past, active, atau upcoming
                        $now = Carbon::now();
                        $startTime = Carbon::parse($sched->start_time);
                        $endTime = Carbon::parse($sched->end_time);

                        if ($now->format('H:i') > $endTime->format('H:i')) {
                            $status = 'past';
                        } elseif ($now->format('H:i') >= $startTime->format('H:i') && $now->format('H:i') <= $endTime->format('H:i')) {
                            $status = 'active';
                        } else {
                            $status = 'upcoming';
                        }

                        $todaySchedules[] = [
                            'time'    => Carbon::parse($sched->start_time)->format('H:i') . ' - ' . Carbon::parse($sched->end_time)->format('H:i'),
                            'subject' => $sched->subject->name ?? 'Mata Pelajaran',
                            'teacher' => $sched->teacher->name ?? 'Guru',
                            'room'    => $sched->room ?? '-',
                            'status'  => $status
                        ];
                    }
                } catch (\Exception $e) {}
            }

            // =====================================================
            // 2. TUGAS MENDESAK — 5 tugas terdekat yang belum lewat
            // =====================================================
            $urgentAssignments = [];
            if ($studentModel->class_id) {
                try {
                    $assignmentsQuery = Assignment::with('subject')
                        ->where('class_id', $studentModel->class_id)
                        ->where('due_date', '>=', Carbon::now())
                        ->orderBy('due_date', 'asc')
                        ->take(5)
                        ->get();

                    foreach ($assignmentsQuery as $assign) {
                        $deadline = $assign->due_date ?? $assign->deadline ?? $assign->created_at;
                        $urgentAssignments[] = [
                            'title'    => $assign->title ?? 'Tugas Baru',
                            'subject'  => $assign->subject->name ?? 'Mata Pelajaran',
                            'due_date' => $deadline ? Carbon::parse($deadline)->format('d M, H:i') : '-',
                            'type'     => $assign->type ?? 'Tugas'
                        ];
                    }
                } catch (\Exception $e) {}
            }

            // =====================================================
            // 3. INFO SPP — Status pembayaran bulan ini
            // =====================================================
            $sppInfo = null;
            try {
                $currentMonth = Carbon::now()->translatedFormat('F Y'); // "April 2026"
                $sppInfo = Payment::where('student_id', $studentModel->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
            } catch (\Exception $e) {}

            // =====================================================
            // 4. CHART DATA — Nilai per mata pelajaran untuk grafik
            // =====================================================
            $gradeChartData = ['labels' => [], 'scores' => []];
            $gradeProgress = 0;
            try {
                $grades = Grade::with('subject')
                    ->where('student_id', $studentModel->id)
                    ->orderBy('created_at', 'asc')
                    ->get();

                if ($grades->count() > 0) {
                    foreach ($grades as $g) {
                        $gradeChartData['labels'][] = $g->subject->name ?? 'Mapel';
                        $gradeChartData['scores'][] = $g->score ?? 0;
                    }

                    // Hitung progress: bandingkan rata-rata vs KKM (75)
                    $avg = $grades->avg('score');
                    $gradeProgress = round((($avg - 75) / 75) * 100, 1);
                }
            } catch (\Exception $e) {}

            return view('student.dashboard', compact(
                'student', 'todaySchedules', 'urgentAssignments',
                'sppInfo', 'gradeChartData', 'gradeProgress'
            ));

        } catch (\Exception $e) {
            // Jika koneksi DB / struktur tabel error total
            return "Terjadi masalah teknis: " . $e->getMessage();
        }
    }
}
