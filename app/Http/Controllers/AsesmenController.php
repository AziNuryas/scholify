<?php

namespace App\Http\Controllers;

use App\Models\AsesmenSiswa;
use App\Services\DeteksiDiniService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsesmenController extends Controller
{
    public function __construct(private DeteksiDiniService $deteksiService) {}

    public function index()
    {
        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');
        $siswaId     = Auth::id();

        $jenisAsesmen = [
            'sosiometri'       => ['label' => 'Sosiometri', 'icon' => 'people', 'deskripsi' => 'Pemetaan hubungan pertemanan di kelas'],
            'minat_bakat'      => ['label' => 'Minat & Bakat', 'icon' => 'star', 'deskripsi' => 'Temukan minat dan potensi karirmu (Holland RIASEC)'],
            'gaya_belajar'     => ['label' => 'Gaya Belajar', 'icon' => 'book', 'deskripsi' => 'Apakah kamu Visual, Auditori, atau Kinestetik?'],
            'kesehatan_mental' => ['label' => 'Kesehatan Mental', 'icon' => 'heart', 'deskripsi' => 'Skrining awal kondisi mental dan emosional'],
            'masalah_umum'     => ['label' => 'Daftar Cek Masalah', 'icon' => 'clipboard-check', 'deskripsi' => 'Apa saja masalah yang kamu alami saat ini?'],
        ];

        $statusAsesmen = AsesmenSiswa::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()
            ->keyBy('jenis_asesmen');

        return view('siswa.asesmen.index', compact('jenisAsesmen', 'statusAsesmen', 'tahunAjaran', 'semester'));
    }

    public function isi(string $jenis)
    {
        $jenisValid = ['sosiometri', 'minat_bakat', 'gaya_belajar', 'kesehatan_mental', 'masalah_umum'];
        abort_unless(in_array($jenis, $jenisValid), 404);

        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');

        $asesmen = AsesmenSiswa::firstOrCreate(
            [
                'siswa_id'      => Auth::id(),
                'jenis_asesmen' => $jenis,
                'tahun_ajaran'  => $tahunAjaran,
                'semester'      => $semester,
            ],
            ['jawaban' => [], 'status' => 'draft']
        );

        abort_unless($asesmen->siswa_id === Auth::id(), 403);

        if ($asesmen->status === 'selesai') {
            return redirect()
                ->route('siswa.asesmen.hasil', $asesmen->id)
                ->with('info', 'Kamu sudah menyelesaikan asesmen ini. Berikut hasilnya.');
        }

        $pertanyaan = $this->getPertanyaan($jenis);

        return view("siswa.asesmen.form_{$jenis}", compact('asesmen', 'pertanyaan'));
    }

    public function simpan(Request $request, AsesmenSiswa $asesmen)
    {
        abort_unless($asesmen->siswa_id === Auth::id(), 403);
        abort_if($asesmen->status === 'selesai', 403, 'Asesmen sudah dikunci.');

        $request->validate([
            'jawaban' => 'required|array',
            'selesai' => 'sometimes|boolean',
        ]);

        $asesmen->update(['jawaban' => $request->jawaban]);

        if ($request->boolean('selesai')) {
            $hasilAnalisis = $this->analisisHasil($asesmen);

            $asesmen->update([
                'status'         => 'selesai',
                'selesai_at'     => now(),
                'hasil_analisis' => $hasilAnalisis,
            ]);

            $this->deteksiService->hitungSkorRisiko(
                $asesmen->siswa_id,
                $asesmen->tahun_ajaran,
                $asesmen->semester
            );

            return redirect()
                ->route('siswa.asesmen.hasil', $asesmen->id)
                ->with('success', 'Asesmen selesai! Lihat hasil analisismu di bawah.');
        }

        return back()->with('success', 'Jawaban tersimpan. Kamu bisa melanjutkan nanti.');
    }

    public function hasil(AsesmenSiswa $asesmen)
    {
        abort_unless($asesmen->siswa_id === Auth::id(), 403);
        abort_unless($asesmen->status === 'selesai', 403);

        return view('siswa.asesmen.hasil', compact('asesmen'));
    }

    private function getPertanyaan(string $jenis): array
    {
        return config("bk.pertanyaan.{$jenis}", []);
    }

    private function analisisHasil(AsesmenSiswa $asesmen): array
    {
        return match ($asesmen->jenis_asesmen) {
            'gaya_belajar' => $asesmen->hitungGayaBelajar(),
            'minat_bakat'  => $asesmen->hitungMinatBakat(),
            default        => ['total_jawaban' => count($asesmen->jawaban ?? [])],
        };
    }
}