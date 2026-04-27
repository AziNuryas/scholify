<?php

namespace App\Http\Controllers;

use App\Models\LaporanGuru;
use App\Models\AsesmenSiswa;
use App\Models\DeteksiDiniSiswa;
use App\Models\User;
use App\Services\DeteksiDiniService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeteksiDiniController extends Controller
{
    public function __construct(private DeteksiDiniService $deteksiService) {}

    public function index()
    {
        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');

        $statistik = [
            'total_siswa'     => User::role('siswa')->count(),
            'kritis'          => DeteksiDiniSiswa::where('kategori_risiko', 'kritis')->count(),
            'berisiko'        => DeteksiDiniSiswa::where('kategori_risiko', 'berisiko')->count(),
            'perhatian'       => DeteksiDiniSiswa::where('kategori_risiko', 'perhatian')->count(),
            'laporan_baru'    => LaporanGuru::where('status', 'baru')->count(),
            'asesmen_selesai' => AsesmenSiswa::where('status', 'selesai')
                                    ->where('tahun_ajaran', $tahunAjaran)
                                    ->where('semester', $semester)
                                    ->distinct('siswa_id')->count(),
        ];

        $siswaBerisiko = DeteksiDiniSiswa::with('siswa')
            ->whereIn('kategori_risiko', ['kritis', 'berisiko'])
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->orderByDesc('skor_risiko')
            ->paginate(10, ['*'], 'berisiko_page');

        $laporanBaru = LaporanGuru::with(['guru', 'siswa'])
            ->where('status', 'baru')
            ->latest()
            ->take(10)
            ->get();

        return view('bk.deteksi-dini.index', compact(
            'statistik', 'siswaBerisiko', 'laporanBaru', 'tahunAjaran', 'semester'
        ));
    }

    public function daftarSiswa(Request $request)
    {
        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');

        $query = DeteksiDiniSiswa::with('siswa')
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester);

        if ($request->filled('risiko')) {
            $query->where('kategori_risiko', $request->risiko);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $request->kelas));
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->whereHas('siswa', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('nis', 'like', "%{$keyword}%");
            });
        }

        $daftarSiswa = $query->orderByDesc('skor_risiko')->paginate(20)->withQueryString();
        $daftarKelas = User::role('siswa')->distinct()->pluck('kelas')->sort()->values();

        return view('bk.deteksi-dini.daftar-siswa', compact('daftarSiswa', 'daftarKelas'));
    }

    public function detailSiswa(int $siswaId)
    {
        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');

        $siswa = User::findOrFail($siswaId);

        $deteksi = DeteksiDiniSiswa::firstOrCreate(
            ['siswa_id' => $siswaId, 'tahun_ajaran' => $tahunAjaran, 'semester' => $semester],
            ['skor_risiko' => 0, 'kategori_risiko' => 'aman']
        );

        $laporan = LaporanGuru::with('guru')
            ->where('siswa_id', $siswaId)
            ->latest()
            ->get();

        $asesmen = AsesmenSiswa::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get();

        $deteksi = $this->deteksiService->hitungSkorRisiko($siswaId, $tahunAjaran, $semester);

        return view('bk.deteksi-dini.detail-siswa', compact('siswa', 'deteksi', 'laporan', 'asesmen'));
    }

    public function daftarLaporan(Request $request)
    {
        $query = LaporanGuru::with(['guru', 'siswa', 'penanggungjawab'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $laporan = $query->paginate(20)->withQueryString();
        return view('bk.deteksi-dini.laporan', compact('laporan'));
    }

    public function prosesLaporan(Request $request, LaporanGuru $laporan)
    {
        $request->validate([
            'status'        => 'required|in:diproses,selesai,ditutup',
            'tindak_lanjut' => 'required|string|min:10',
        ]);

        $laporan->update([
            'status'         => $request->status,
            'tindak_lanjut'  => $request->tindak_lanjut,
            'ditangani_oleh' => Auth::id(),
            'ditangani_at'   => now(),
        ]);

        $this->deteksiService->hitungSkorRisiko(
            $laporan->siswa_id,
            config('bk.tahun_ajaran_aktif'),
            config('bk.semester_aktif')
        );

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function detailAsesmen(AsesmenSiswa $asesmen)
    {
        $asesmen->load('siswa');
        return view('bk.deteksi-dini.detail-asesmen', compact('asesmen'));
    }

    public function catatanAsesmen(Request $request, AsesmenSiswa $asesmen)
    {
        $request->validate(['catatan_bk' => 'required|string|min:5']);

        $asesmen->update([
            'catatan_bk'    => $request->catatan_bk,
            'ditinjau_oleh' => Auth::id(),
        ]);

        return back()->with('success', 'Catatan berhasil disimpan.');
    }

    public function refreshSemuaSkor()
    {
        $tahun    = config('bk.tahun_ajaran_aktif');
        $semester = config('bk.semester_aktif');

        $siswaIds = User::role('siswa')->pluck('id');
        foreach ($siswaIds as $id) {
            $this->deteksiService->hitungSkorRisiko($id, $tahun, $semester);
        }

        return back()->with('success', 'Skor risiko semua siswa berhasil diperbarui.');
    }
}