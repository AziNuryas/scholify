{{-- resources/views/catatan_konseling/edit.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Edit Catatan Konseling')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Edit Catatan Konseling</h1>
    <p class="text-sm text-gray-500 mt-1">Perbarui catatan sesi konseling.</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-6">
    <form action="{{ route('catatan-konseling.update', $catatanKonseling) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Nama siswa</label>
                <select name="siswa_id"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    @foreach($siswaList as $siswa)
                        <option value="{{ $siswa->id }}"
                            {{ old('siswa_id', $catatanKonseling->siswa_id) == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->name }} — {{ $siswa->kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal sesi</label>
                <input type="date" name="tanggal_sesi"
                    value="{{ old('tanggal_sesi', $catatanKonseling->tanggal_sesi->format('Y-m-d')) }}"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400"/>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Jenis konseling</label>
                <select name="jenis_konseling"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    @foreach(\App\Models\CatatanKonseling::$jenisLabels as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('jenis_konseling', $catatanKonseling->jenis_konseling) === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
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
            <label class="block text-xs font-medium text-gray-500 mb-1">Masalah / topik yang dibahas</label>
            <textarea name="masalah" rows="3"
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">{{ old('masalah', $catatanKonseling->masalah) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-xs font-medium text-gray-500 mb-1">Tindakan / intervensi guru BK</label>
            <textarea name="tindakan" rows="3"
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">{{ old('tindakan', $catatanKonseling->tindakan) }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-xs font-medium text-gray-500 mb-1">Rencana tindak lanjut</label>
            <input type="text" name="rencana_tindak_lanjut"
                value="{{ old('rencana_tindak_lanjut', $catatanKonseling->rencana_tindak_lanjut) }}"
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400"/>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('catatan-konseling.index') }}"
                class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium transition">
                Perbarui catatan
            </button>
        </div>
    </form>
</div>
@endsection