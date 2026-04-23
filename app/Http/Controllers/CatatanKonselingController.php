<?php

namespace App\Http\Controllers;

use App\Models\CatatanKonseling;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanKonselingController extends Controller
{
    /**
     * Tampilkan daftar + form tambah catatan konseling.
     */
    public function index(Request $request)
    {
        $query = CatatanKonseling::with('siswa')
            ->where('guru_bk_id', Auth::id())
            ->latest('tanggal_sesi');

        // Filter pencarian nama siswa
        if ($request->filled('cari')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $catatanList = $query->paginate(10)->withQueryString();
        $siswaList   = Student::orderBy('name')->get();

        return view('gurubk.catatan_konseling.index', compact('catatanList', 'siswaList'));
    }

    /**
     * Simpan catatan konseling baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'              => 'required|exists:students,id',
            'tanggal_sesi'          => 'required|date',
            'jenis_konseling'       => 'required|in:konseling_individual,konseling_karir,konseling_akademik,konseling_sosial_emosional,tindak_lanjut_disiplin',
            'masalah'               => 'required|string|max:2000',
            'tindakan'              => 'required|string|max:2000',
            'rencana_tindak_lanjut' => 'nullable|string|max:1000',
            'status'                => 'required|in:berjalan,tindak_lanjut,selesai',
        ], [
            'siswa_id.required'        => 'Silakan pilih siswa.',
            'tanggal_sesi.required'    => 'Tanggal sesi wajib diisi.',
            'jenis_konseling.required' => 'Jenis konseling wajib dipilih.',
            'masalah.required'         => 'Kolom masalah wajib diisi.',
            'tindakan.required'        => 'Kolom tindakan wajib diisi.',
        ]);

        $validated['guru_bk_id'] = Auth::id();

        CatatanKonseling::create($validated);

        return redirect()
            ->route('gurubk.catatan-konseling.index')
            ->with('success', 'Catatan konseling berhasil disimpan.');
    }

    /**
     * Tampilkan detail satu catatan.
     */
    public function show(CatatanKonseling $catatanKonseling)
    {
        $catatanKonseling->load('siswa', 'guruBk');

        return view('gurubk.catatan_konseling.show', compact('catatanKonseling'));
    }

    /**
     * Form edit catatan.
     */
    public function edit(CatatanKonseling $catatanKonseling)
    {
        $siswaList = Student::orderBy('name')->get();

        return view('gurubk.catatan_konseling.edit', compact('catatanKonseling', 'siswaList'));
    }

    /**
     * Update catatan konseling.
     */
    public function update(Request $request, CatatanKonseling $catatanKonseling)
    {
        $validated = $request->validate([
            'siswa_id'              => 'required|exists:students,id',
            'tanggal_sesi'          => 'required|date',
            'jenis_konseling'       => 'required|in:konseling_individual,konseling_karir,konseling_akademik,konseling_sosial_emosional,tindak_lanjut_disiplin',
            'masalah'               => 'required|string|max:2000',
            'tindakan'              => 'required|string|max:2000',
            'rencana_tindak_lanjut' => 'nullable|string|max:1000',
            'status'                => 'required|in:berjalan,tindak_lanjut,selesai',
        ]);

        $catatanKonseling->update($validated);

        return redirect()
            ->route('gurubk.catatan-konseling.index')
            ->with('success', 'Catatan konseling berhasil diperbarui.');
    }

    /**
     * Hapus catatan konseling.
     */
    public function destroy(CatatanKonseling $catatanKonseling)
    {
        $catatanKonseling->delete();

        return redirect()
            ->route('gurubk.catatan-konseling.index')
            ->with('success', 'Catatan konseling berhasil dihapus.');
    }
}