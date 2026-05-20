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
            'school_class_id' => 'required|exists:classes,id',
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

        $jadwal = JadwalPelajaran::create($validated);

        // Sinkronisasi dengan tabel schedules lama agar muncul di Dashboard Guru
        $subject = \App\Models\Subject::firstOrCreate(['name' => $validated['mata_pelajaran']]);
        \App\Models\Schedule::create([
            'class_id'    => $validated['school_class_id'],
            'subject_id'  => $subject->id,
            'teacher_id'  => $validated['guru_id'],
            'day_of_week' => $validated['hari'],
            'start_time'  => $validated['jam_mulai'],
            'end_time'    => $validated['jam_selesai'],
            'room'        => $validated['ruangan'],
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    // ── CREATE BULK ─────────────────────────────────────────
    public function createBulk()
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

        return view('admin.createjadwal_bulk', compact(
            'classes', 'teachers', 'hari', 'mapel', 'tahunAjaranOptions'
        ));
    }

    // ── STORE BULK ──────────────────────────────────────────
    public function storeBulk(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:classes,id',
            'semester'        => 'required|in:1,2',
            'tahun_ajaran'    => 'required|string|max:10',
            'jadwal'          => 'required|array|min:1',
            'jadwal.*.hari'            => ['required', Rule::in(self::HARI)],
            'jadwal.*.jam_mulai'       => 'required|date_format:H:i',
            'jadwal.*.jam_selesai'     => 'required|date_format:H:i|after:jadwal.*.jam_mulai',
            'jadwal.*.mata_pelajaran'  => 'required|string|max:100',
            'jadwal.*.guru_id'         => 'required|exists:teachers,id',
            'jadwal.*.ruangan'         => 'nullable|string|max:50',
        ]);

        $classId = $request->school_class_id;
        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;
        
        $count = 0;

        foreach ($request->jadwal as $j) {
            // Cek bentrok jadwal (opsional, bisa di skip agar lebih cepat)
            $bentrok = $this->cekBentrok($classId, $j['hari'], $j['jam_mulai'], $j['jam_selesai']);
            
            if ($bentrok) {
                // Lanjutkan ke jadwal berikutnya jika bentrok, atau lempar error
                // Untuk bulk insert, lebih baik skip yang bentrok atau biarkan saja
                continue;
            }

            // Simpan JadwalPelajaran
            $jadwalBaru = JadwalPelajaran::create([
                'school_class_id' => $classId,
                'guru_id'         => $j['guru_id'],
                'mata_pelajaran'  => $j['mata_pelajaran'],
                'hari'            => $j['hari'],
                'jam_mulai'       => $j['jam_mulai'],
                'jam_selesai'     => $j['jam_selesai'],
                'ruangan'         => $j['ruangan'],
                'semester'        => $semester,
                'tahun_ajaran'    => $tahunAjaran,
                'status'          => 'aktif',
                'keterangan'      => null,
            ]);

            // Sinkronisasi dengan tabel schedules lama
            $subject = \App\Models\Subject::firstOrCreate(['name' => $j['mata_pelajaran']]);
            \App\Models\Schedule::create([
                'class_id'    => $classId,
                'subject_id'  => $subject->id,
                'teacher_id'  => $j['guru_id'],
                'day_of_week' => $j['hari'],
                'start_time'  => $j['jam_mulai'],
                'end_time'    => $j['jam_selesai'],
                'room'        => $j['ruangan'],
            ]);
            
            $count++;
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', "$count Jadwal pelajaran kelas berhasil ditambahkan secara massal!");
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
            'school_class_id' => 'required|exists:classes,id',
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

        // Simpan data lama untuk mencari schedule yang akan diupdate
        $oldHari = $jadwal->hari;
        $oldJamMulai = $jadwal->jam_mulai;
        $oldClassId = $jadwal->school_class_id;

        $jadwal->update($validated);

        // Sinkronisasi update ke tabel schedules lama
        $subject = \App\Models\Subject::firstOrCreate(['name' => $validated['mata_pelajaran']]);
        
        $schedule = \App\Models\Schedule::where([
            'class_id' => $oldClassId,
            'day_of_week' => $oldHari,
        ])->whereTime('start_time', \Carbon\Carbon::parse($oldJamMulai)->format('H:i:s'))->first();

        if ($schedule) {
            $schedule->update([
                'class_id'    => $validated['school_class_id'],
                'subject_id'  => $subject->id,
                'teacher_id'  => $validated['guru_id'],
                'day_of_week' => $validated['hari'],
                'start_time'  => $validated['jam_mulai'],
                'end_time'    => $validated['jam_selesai'],
                'room'        => $validated['ruangan'],
            ]);
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal pelajaran berhasil diperbarui!');
    }

    // ── DESTROY ─────────────────────────────────────────────
    public function destroy(JadwalPelajaran $jadwal)
    {
        // Hapus juga dari tabel schedules lama
        \App\Models\Schedule::where([
            'class_id' => $jadwal->school_class_id,
            'day_of_week' => $jadwal->hari,
        ])->whereTime('start_time', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i:s'))->delete();

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