<?php

namespace App\Http\Controllers;

use App\Models\LaporanGuru;
use App\Models\Student;
use App\Services\DeteksiDiniService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanSiswaController extends Controller
{
    public function __construct(private DeteksiDiniService $deteksiService) {}

    public function index()
    {
        $laporan = LaporanGuru::with(['siswa.schoolClass'])
            ->where('guru_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('guru.laporan.index', compact('laporan'));
    }

    public function create()
    {
        $siswaDiajar = Student::with('schoolClass')
            ->orderBy('name')
            ->get();

        $kategori = [
            'akademik'  => 'Akademik (Nilai / Tugas)',
            'kehadiran' => 'Kehadiran / Absensi',
            'perilaku'  => 'Perilaku / Disiplin',
            'sosial'    => 'Sosial (Pergaulan / Bullying)',
            'keluarga'  => 'Masalah Keluarga',
            'lainnya'   => 'Lainnya',
        ];

        return view('guru.laporan.create', compact('siswaDiajar', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'        => 'required|exists:students,id',
            'kategori'        => 'required|in:akademik,kehadiran,perilaku,sosial,keluarga,lainnya',
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required|string|min:20',
            'tingkat_urgensi' => 'required|in:rendah,sedang,tinggi,kritis',
            'bukti.*'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'deskripsi.min' => 'Deskripsi minimal 20 karakter agar informasi cukup untuk BK.',
        ]);

        $buktiBerkas = [];
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                $path = $file->store('laporan-guru/' . now()->format('Y/m'), 'public');
                $buktiBerkas[] = $path;
            }
        }

        $laporan = LaporanGuru::create([
            ...$validated,
            'guru_id'         => Auth::id(),
            'status'          => 'baru',
            'bukti_pendukung' => $buktiBerkas,
        ]);

        // Ambil user_id dari student untuk hitung skor risiko
        $student = Student::find($laporan->siswa_id);
        if ($student && $student->user_id) {
            $this->deteksiService->hitungSkorRisiko(
                $student->user_id,
                config('bk.tahun_ajaran_aktif'),
                config('bk.semester_aktif')
            );
        }

        return redirect()
            ->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil dikirim ke BK. Terima kasih sudah melaporkan!');
    }

    public function show(LaporanGuru $laporan)
    {
        abort_unless($laporan->guru_id === Auth::id(), 403);
        $laporan->load(['siswa.schoolClass', 'penanggungjawab']);

        return view('guru.laporan.show', compact('laporan'));
    }
}