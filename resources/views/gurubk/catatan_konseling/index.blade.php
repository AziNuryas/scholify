{{-- resources/views/gurubk/catatan_konseling/index.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Catatan Konseling')

@section('content')

{{-- Tom Select CSS --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
    .ts-wrapper.single .ts-control {
        width: 100%;
        font-size: 0.875rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        box-shadow: none;
        background: white;
    }
    .ts-wrapper.single.focus .ts-control {
        border-color: #2dd4bf;
        box-shadow: 0 0 0 2px rgba(45, 212, 191, 0.3);
        outline: none;
    }
    .ts-dropdown {
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        font-size: 0.875rem;
    }
    .ts-wrapper .ts-control input {
        font-size: 0.875rem !important;
    }
</style>

<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Catatan Konseling</h1>
    <p class="text-sm text-gray-500 mt-1">Rekam dan pantau sesi konseling siswa secara terstruktur.</p>
</div>

{{-- Alert sukses --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-teal-50 border border-teal-200 text-teal-800 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- ===== FORM TAMBAH ===== --}}
<div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
    <h2 class="text-sm font-semibold text-gray-700 mb-4 pb-3 border-b border-gray-100">
        Tambah catatan konseling baru
    </h2>

    <form action="{{ route('catatan-konseling.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            {{-- Siswa --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Nama siswa</label>
                <select name="siswa_id" id="pilih-siswa"
                    class="@error('siswa_id') border-red-400 @enderror">
                    <option value="">Pilih siswa...</option>
                    @foreach($siswaList as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->name }} — {{ $siswa->kelas }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal sesi</label>
                <input type="date" name="tanggal_sesi" value="{{ old('tanggal_sesi', date('Y-m-d')) }}"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 @error('tanggal_sesi') border-red-400 @enderror"/>
                @error('tanggal_sesi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jenis --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Jenis konseling</label>
                <select name="jenis_konseling"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 @error('jenis_konseling') border-red-400 @enderror">
                    <option value="">Pilih jenis...</option>
                    @foreach(\App\Models\CatatanKonseling::$jenisLabels as $value => $label)
                        <option value="{{ $value }}" {{ old('jenis_konseling') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_konseling') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status"
                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    @foreach(\App\Models\CatatanKonseling::$statusLabels as $value => $label)
                        <option value="{{ $value }}" {{ old('status', 'berjalan') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Masalah --}}
        <div class="mb-4">
            <label class="block text-xs font-medium text-gray-500 mb-1">Masalah / topik yang dibahas</label>
            <textarea name="masalah" rows="3"
                placeholder="Tuliskan masalah atau topik yang disampaikan siswa..."
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 @error('masalah') border-red-400 @enderror">{{ old('masalah') }}</textarea>
            @error('masalah') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tindakan --}}
        <div class="mb-4">
            <label class="block text-xs font-medium text-gray-500 mb-1">Tindakan / intervensi guru BK</label>
            <textarea name="tindakan" rows="3"
                placeholder="Tuliskan tindakan atau saran yang diberikan..."
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 @error('tindakan') border-red-400 @enderror">{{ old('tindakan') }}</textarea>
            @error('tindakan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Rencana tindak lanjut --}}
        <div class="mb-5">
            <label class="block text-xs font-medium text-gray-500 mb-1">Rencana tindak lanjut</label>
            <input type="text" name="rencana_tindak_lanjut" value="{{ old('rencana_tindak_lanjut') }}"
                placeholder="Contoh: jadwal pertemuan berikutnya, tugas siswa, dll"
                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400"/>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('catatan-konseling.index') }}"
                class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium transition">
                Simpan catatan
            </button>
        </div>
    </form>
</div>

{{-- ===== TABEL RIWAYAT ===== --}}
<div class="bg-white border border-gray-200 rounded-xl p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-700">Riwayat catatan konseling</h2>
        <form method="GET" action="{{ route('catatan-konseling.index') }}" class="flex gap-2">
            <input type="text" name="cari" value="{{ request('cari') }}"
                placeholder="Cari siswa..."
                class="text-xs border border-gray-200 rounded-lg px-3 py-2 w-44 focus:outline-none focus:ring-2 focus:ring-teal-400"/>
            <select name="status" class="text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                <option value="">Semua status</option>
                @foreach(\App\Models\CatatanKonseling::$statusLabels as $val => $lbl)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 text-xs bg-teal-600 text-white rounded-lg hover:bg-teal-700">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-2 px-3">Siswa</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-2 px-3">Tanggal</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-2 px-3">Jenis</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-2 px-3">Status</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-2 px-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($catatanList as $catatan)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-xs font-medium flex-shrink-0">
                                {{ strtoupper(substr($catatan->siswa->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $catatan->siswa->name }}</p>
                                <p class="text-xs text-gray-400">{{ $catatan->siswa->kelas }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-3 text-gray-600">
                        {{ $catatan->tanggal_sesi->format('d M Y') }}
                    </td>
                    <td class="py-3 px-3 text-gray-600">{{ $catatan->jenis_label }}</td>
                    <td class="py-3 px-3">
                        @php
                            $badge = match($catatan->status) {
                                'selesai'       => 'bg-blue-50 text-blue-800',
                                'tindak_lanjut' => 'bg-amber-50 text-amber-800',
                                default         => 'bg-teal-50 text-teal-800',
                            };
                        @endphp
                        <span class="text-xs font-medium px-3 py-1 rounded-full {{ $badge }}">
                            {{ $catatan->status_label }}
                        </span>
                    </td>
                    <td class="py-3 px-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('catatan-konseling.show', $catatan) }}"
                                class="text-xs text-teal-600 hover:underline">Detail</a>
                            <a href="{{ route('catatan-konseling.edit', $catatan) }}"
                                class="text-xs text-gray-500 hover:underline">Edit</a>
                            <form action="{{ route('catatan-konseling.destroy', $catatan) }}" method="POST"
                                onsubmit="return confirm('Hapus catatan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-400 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-sm text-gray-400">
                        Belum ada catatan konseling.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($catatanList->hasPages())
        <div class="mt-4">{{ $catatanList->links() }}</div>
    @endif
</div>

{{-- Tom Select JS --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#pilih-siswa', {
        placeholder: 'Cari nama siswa...',
        allowEmptyOption: true,
        render: {
            no_results: function() {
                return '<div class="no-results px-3 py-2 text-sm text-gray-400">Siswa tidak ditemukan</div>';
            }
        }
    });
</script>

@endsection