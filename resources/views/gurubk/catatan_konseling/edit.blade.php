{{-- resources/views/gurubk/catatan_konseling/edit.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Edit Catatan Konseling')
@section('page-title', 'Edit Catatan Konseling')

@section('content')
<div class="animate-fadeInUp max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Edit Catatan Konseling</h1>
        <p class="text-sm mt-1" style="color: var(--text-secondary)">Perbarui catatan sesi konseling.</p>
    </div>

    <div class="neo-flat rounded-2xl p-6">
        <form action="{{ route('gurubk.catatan-konseling.update', $catatanKonseling) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Nama siswa</label>
                    <select name="siswa_id"
                            class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        @foreach($siswaList as $siswa)
                            <option value="{{ $siswa->id }}"
                                {{ old('siswa_id', $catatanKonseling->siswa_id) == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->name }} — {{ $siswa->kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Tanggal sesi</label>
                    <input type="date" name="tanggal_sesi"
                           value="{{ old('tanggal_sesi', $catatanKonseling->tanggal_sesi->format('Y-m-d')) }}"
                           class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"/>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Jenis konseling</label>
                    <select name="jenis_konseling"
                            class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        @foreach(\App\Models\CatatanKonseling::$jenisLabels as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('jenis_konseling', $catatanKonseling->jenis_konseling) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Status</label>
                    <select name="status"
                            class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        @foreach(\App\Models\CatatanKonseling::$statusLabels as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('status', $catatanKonseling->status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Masalah / topik yang dibahas</label>
                <textarea name="masalah" rows="3"
                          class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                          style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ old('masalah', $catatanKonseling->masalah) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Tindakan / intervensi guru BK</label>
                <textarea name="tindakan" rows="3"
                          class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                          style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ old('tindakan', $catatanKonseling->tindakan) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Rencana tindak lanjut</label>
                <input type="text" name="rencana_tindak_lanjut"
                       value="{{ old('rencana_tindak_lanjut', $catatanKonseling->rencana_tindak_lanjut) }}"
                       class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"/>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('gurubk.catatan-konseling.index') }}"
                   class="px-4 py-2 text-sm rounded-lg transition"
                   style="border: 1px solid var(--border); color: var(--text-secondary)">Batal</a>
                <button type="submit"
                        class="px-5 py-2 text-sm text-white rounded-lg font-medium transition"
                        style="background: var(--accent)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">Perbarui catatan</button>
            </div>
        </form>
    </div>
</div>
@endsection