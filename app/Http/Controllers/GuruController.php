<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Schedule;

class GuruController extends Controller
{
    public function dashboard()
    {
        // =========================
        // STATISTIK (WAJIB SESUAI NAMA DI BLADE)
        // =========================
        $jumlahKelas        = Schedule::distinct('class_id')->count('class_id');
        $totalJam           = Schedule::count();
        $tugasPerluDinilai  = Assignment::whereDoesntHave('submissions')->count();
        $totalSiswa         = Student::count();

        // =========================
        // JADWAL MENGAJAR
        // =========================
        $jadwal = Schedule::with(['subject', 'schoolClass'])
            ->latest()
            ->take(2)
            ->get();

        // =========================
        // TUGAS AKTIF
        // =========================
        $tugas = Assignment::latest()->take(3)->get();

        // =========================
        // KEHADIRAN (WAJIB ADA!)
        // =========================
        $totalKapasitas = 36;

        $hadir = 28;
        $izin  = 5;
        $sakit = 2;
        $alpha = 1;

        $kehadiranStats = [
            [
                'icon' => 'check-circle',
                'label' => 'Hadir',
                'count' => $hadir,
                'percentage' => ($hadir / $totalKapasitas) * 100,
                'bg_color' => 'bg-emerald-400',
                'text_color' => 'text-emerald-600',
            ],
            [
                'icon' => 'file-text',
                'label' => 'Izin',
                'count' => $izin,
                'percentage' => ($izin / $totalKapasitas) * 100,
                'bg_color' => 'bg-amber-400',
                'text_color' => 'text-amber-600',
            ],
            [
                'icon' => 'activity',
                'label' => 'Sakit',
                'count' => $sakit,
                'percentage' => ($sakit / $totalKapasitas) * 100,
                'bg_color' => 'bg-blue-400',
                'text_color' => 'text-blue-600',
            ],
            [
                'icon' => 'alert-circle',
                'label' => 'Alpha',
                'count' => $alpha,
                'percentage' => ($alpha / $totalKapasitas) * 100,
                'bg_color' => 'bg-rose-400',
                'text_color' => 'text-rose-600',
            ],
        ];

        // =========================
        // NILAI TERBARU (KOSONG DULU)
        // =========================
        $nilaiTerbaru = [];

        return view('guru.dashboard', compact(
            'jumlahKelas',
            'totalJam',
            'tugasPerluDinilai',
            'totalSiswa',
            'jadwal',
            'tugas',
            'kehadiranStats',
            'nilaiTerbaru'
        ));
    }

    // =========================
    // HALAMAN JADWAL (FIX ERROR DI ATAS)
    // =========================
    public function jadwal()
    {
        $jadwal = Schedule::with(['subject', 'schoolClass'])->get();

        return view('guru.jadwal', compact('jadwal'));
    }

    // =========================
    // HALAMAN LAIN
    // =========================
    public function absensi()
    {
        return view('guru.absensi');
    }

    public function tugas()
    {
        $tugas = Assignment::latest()->get();
        return view('guru.tugas', compact('tugas'));
    }

    public function raport()
    {
        return view('guru.raport');
    }

    public function pengumuman()
    {
        return view('guru.pengumuman');
    }

    public function profil()
    {
        return view('guru.profil');
    }
}
