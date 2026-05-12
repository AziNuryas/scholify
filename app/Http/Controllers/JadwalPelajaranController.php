<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalPelajaranController extends Controller
{
    // ── Konstanta hari & mata pelajaran ────────────────────
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    private const MAPEL = [
        'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS',
        'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Geografi', 'Ekonomi',
        'Sosiologi', 'PKN', 'Pendidikan Agama', 'Penjaskes', 'Seni Budaya',
        'Prakarya', 'TIK / Informatika', 'BK', 'Bahasa Jawa', 'Lainnya',
    ];

    // ── INDEX ───────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['schoolClass', 'guru']);

        // Filter
        if ($request->filled('hari'))         $query->where('hari', $request->hari);
        if ($request->filled('kelas'))        $query->where('school_class_id', $request->kelas);
        if ($request->filled('guru'))         $query->where('guru_id', $request->guru);
        if ($request->filled('tahun_ajaran')) $query->where('tahun_ajaran', $request->tahun_ajaran);
        if ($request->filled('status'))       $query->where('status', $request->status);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mata_pelajaran', 'like', "%{$search}%")
                  ->orWhere('ruangan', 'like', "%{$search}%")
                  ->orWhereHas('guru', fn($g) => $g->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('schoolClass', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        // Urut berdasarkan hari kemudian jam
        $jadwal = $query->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                        ->orderBy('jam_mulai')
                        ->paginate(15)
                        ->withQueryString();

        $classes       = SchoolClass::orderBy('name')->get();
        $teachers      = Teacher::orderBy('name')->get();
        $tahunAjaranList = JadwalPelajaran::select('tahun_ajaran')
                            ->distinct()->orderByDesc('tahun_ajaran')->pluck('tahun_ajaran');

        // Statistik ringkasan
        $stats = [
            'total'    => JadwalPelajaran::count(),
            'aktif'    => JadwalPelajaran::where('status', 'aktif')->count(),
            'nonaktif' => JadwalPelajaran::where('status', 'nonaktif')->count(),
            'hari_ini' => JadwalPelajaran::where('hari', now()->locale('id')->isoFormat('dddd'))->where('status','aktif')->count(),
        ];

        // PERBAIKAN: arahkan ke view yang benar
        return view('admin.jadwal', compact(
            'jadwal', 'classes', 'teachers', 'tahunAjaranList', 'stats'
        ));
    }

    // ── CREATE ──────────────────────────────────────────────
    public function create()
    {
        $classes  = SchoolClass::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $hari     = self::HARI;
        $mapel    = self::MAPEL;

        // Tahun ajaran saat ini & berikutnya
        $tahunSekarang = now()->year;
        $tahunAjaranOptions = [
            ($tahunSekarang - 1) . '/' . $tahunSekarang,
            $tahunSekarang . '/' . ($tahunSekarang + 1),
            ($tahunSekarang + 1) . '/' . ($tahunSekarang + 2),
        ];

        // PERBAIKAN: arahkan ke view yang benar
        return view('admin.createjadwal', compact(
            'classes', 'teachers', 'hari', 'mapel', 'tahunAjaranOptions'
        ));
    }

    // ── STORE ───────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'guru_id'         => 'required|exists:teachers,id',
            'mata_pelajaran'  => 'required|string|max:100',
            'hari'            => ['required', Rule::in(self::HARI)],
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'         => 'nullable|string|max:50',
            'semester'        => 'required|in:1,2',
            'tahun_ajaran'    => 'required|string|max:10',
            'status'          => 'required|in:aktif,nonaktif',
            'keterangan'      => 'nullable|string|max:500',
        ], [
            'school_class_id.required' => 'Kelas wajib dipilih.',
            'guru_id.required'         => 'Guru wajib dipilih.',
            'mata_pelajaran.required'  => 'Mata pelajaran wajib diisi.',
            'hari.required'            => 'Hari wajib dipilih.',
            'jam_mulai.required'       => 'Jam mulai wajib diisi.',
            'jam_selesai.after'        => 'Jam selesai harus setelah jam mulai.',
            'semester.required'        => 'Semester wajib dipilih.',
            'tahun_ajaran.required'    => 'Tahun ajaran wajib diisi.',
        ]);

        // Cek bentrok jadwal
        $bentrok = $this->cekBentrok(
            $validated['school_class_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai']
        );

        if ($bentrok) {
            return back()->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok dengan jadwal lain pada kelas dan hari yang sama.']);
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    // ── SHOW ────────────────────────────────────────────────
    public function show(JadwalPelajaran $jadwal)
    {
        $jadwal->load(['schoolClass', 'guru']);
        return view('admin.jadwal', compact('jadwal'));
    }

    // ── EDIT ────────────────────────────────────────────────
    public function edit(JadwalPelajaran $jadwal)
    {
        $classes  = SchoolClass::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $hari     = self::HARI;
        $mapel    = self::MAPEL;

        $tahunSekarang = now()->year;
        $tahunAjaranOptions = [
            ($tahunSekarang - 1) . '/' . $tahunSekarang,
            $tahunSekarang . '/' . ($tahunSekarang + 1),
            ($tahunSekarang + 1) . '/' . ($tahunSekarang + 2),
        ];

        return view('admin.editjadwal', compact(
            'jadwal', 'classes', 'teachers', 'hari', 'mapel', 'tahunAjaranOptions'
        ));
    }

    // ── UPDATE ──────────────────────────────────────────────
    public function update(Request $request, JadwalPelajaran $jadwal)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'guru_id'         => 'required|exists:teachers,id',
            'mata_pelajaran'  => 'required|string|max:100',
            'hari'            => ['required', Rule::in(self::HARI)],
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'         => 'nullable|string|max:50',
            'semester'        => 'required|in:1,2',
            'tahun_ajaran'    => 'required|string|max:10',
            'status'          => 'required|in:aktif,nonaktif',
            'keterangan'      => 'nullable|string|max:500',
        ], [
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        $bentrok = $this->cekBentrok(
            $validated['school_class_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwal->id
        );

        if ($bentrok) {
            return back()->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok dengan jadwal lain pada kelas dan hari yang sama.']);
        }

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil diperbarui!');
    }

    // ── DESTROY ─────────────────────────────────────────────
    public function destroy(JadwalPelajaran $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus!');
    }

    // ── TOGGLE STATUS (AJAX) ─────────────────────────────────
    public function toggleStatus(JadwalPelajaran $jadwal)
    {
        $jadwal->update([
            'status' => $jadwal->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return response()->json([
            'success' => true,
            'status'  => $jadwal->status,
            'message' => 'Status jadwal berhasil diubah.',
        ]);
    }

    // ── HELPER: Cek Bentrok ─────────────────────────────────
    private function cekBentrok(
        int $classId,
        string $hari,
        string $jamMulai,
        string $jamSelesai,
        ?int $excludeId = null
    ): bool {
        $query = JadwalPelajaran::where('school_class_id', $classId)
            ->where('hari', $hari)
            ->where('status', 'aktif')
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                  ->orWhere(function ($q2) use ($jamMulai, $jamSelesai) {
                      $q2->where('jam_mulai', '<=', $jamMulai)
                         ->where('jam_selesai', '>=', $jamSelesai);
                  });
            });

        if ($excludeId) $query->where('id', '!=', $excludeId);

        return $query->exists();
    }
}