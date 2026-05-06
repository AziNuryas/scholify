{{-- resources/views/gurubk/catatan_konseling/index.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Catatan Konseling')
@section('page-title', 'Catatan Konseling')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css"/>
<style>
    .ts-wrapper.single .ts-control, .ts-control {
        border: 1px solid var(--border) !important;
        border-radius: 0.5rem !important;
        padding: 0.4rem 0.75rem !important;
        font-size: 0.875rem !important;
        color: var(--text-primary) !important;
        background: var(--bg) !important;
        box-shadow: none !important;
        min-height: unset !important;
        cursor: pointer;
    }
    .ts-wrapper.single.focus .ts-control, .ts-wrapper.focus .ts-control {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 2px rgba(124,58,237,0.2) !important;
        outline: none !important;
    }
    .ts-dropdown {
        border: 1px solid var(--border) !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        font-size: 0.875rem !important;
        background: var(--bg-card) !important;
        overflow: hidden; z-index: 9999 !important;
    }
    .ts-dropdown .option { padding: 0.5rem 0.75rem !important; color: var(--text-primary) !important; }
    .ts-dropdown .option:hover, .ts-dropdown .option.active {
        background: rgba(168,85,247,.12) !important;
        color: var(--accent-light) !important;
    }
    .ts-wrapper .placeholder { color: var(--text-muted) !important; }
</style>

<div class="animate-fadeInUp space-y-6">

    <div>
        <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Catatan Konseling</h1>
        <p class="text-sm mt-1" style="color: var(--text-secondary)">Rekam dan pantau sesi konseling siswa secara terstruktur.</p>
    </div>

    @if(session('success'))
        <div class="px-4 py-3 rounded-lg text-sm border"
             style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== FORM TAMBAH ===== --}}
    <div class="neo-flat rounded-2xl p-6">
        <h2 class="text-sm font-semibold mb-4 pb-3" style="color: var(--text-primary); border-bottom: 1px solid var(--border)">
            Tambah catatan konseling baru
        </h2>
        <form action="{{ route('gurubk.catatan-konseling.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Nama siswa</label>
                    <select id="siswa-select" name="siswa_id" placeholder="Ketik nama atau kelas...">
                        <option value="">Ketik nama atau kelas untuk mencari...</option>
                        @foreach($siswaList as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->name }} — {{ $siswa->kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Tanggal sesi</label>
                    <input type="date" name="tanggal_sesi" value="{{ old('tanggal_sesi', date('Y-m-d')) }}"
                           class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"/>
                    @error('tanggal_sesi')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Jenis konseling</label>
                    <select name="jenis_konseling"
                            class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="">Pilih jenis...</option>
                        @foreach(\App\Models\CatatanKonseling::$jenisLabels as $value => $label)
                            <option value="{{ $value }}" {{ old('jenis_konseling') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis_konseling')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Status</label>
                    <select name="status"
                            class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        @foreach(\App\Models\CatatanKonseling::$statusLabels as $value => $label)
                            <option value="{{ $value }}" {{ old('status', 'berjalan') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Masalah / topik yang dibahas</label>
                <textarea name="masalah" rows="3" placeholder="Tuliskan masalah atau topik yang disampaikan siswa..."
                          class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                          style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ old('masalah') }}</textarea>
                @error('masalah')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Tindakan / intervensi guru BK</label>
                <textarea name="tindakan" rows="3" placeholder="Tuliskan tindakan atau saran yang diberikan..."
                          class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                          style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ old('tindakan') }}</textarea>
                @error('tindakan')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Rencana tindak lanjut</label>
                <input type="text" name="rencana_tindak_lanjut" value="{{ old('rencana_tindak_lanjut') }}"
                       placeholder="Contoh: jadwal pertemuan berikutnya, tugas siswa, dll"
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
                        onmouseout="this.style.background='var(--accent)'">Simpan catatan</button>
            </div>
        </form>
    </div>

    {{-- ===== TABEL RIWAYAT ===== --}}
    <div class="neo-flat rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold" style="color: var(--text-primary)">Riwayat catatan konseling</h2>
            <form method="GET" action="{{ route('gurubk.catatan-konseling.index') }}" class="flex gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari siswa..."
                       class="text-xs rounded-lg px-3 py-2 w-44 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"/>
                <select name="status"
                        class="text-xs rounded-lg px-3 py-2 outline-none"
                        style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                    <option value="">Semua status</option>
                    @foreach(\App\Models\CatatanKonseling::$statusLabels as $val => $lbl)
                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
                <button class="px-3 py-2 text-xs text-white rounded-lg transition"
                        style="background: var(--accent)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border)">
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-2 px-3" style="color: var(--text-muted)">Siswa</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-2 px-3" style="color: var(--text-muted)">Tanggal</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-2 px-3" style="color: var(--text-muted)">Jenis</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-2 px-3" style="color: var(--text-muted)">Status</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-2 px-3" style="color: var(--text-muted)">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($catatanList as $catatan)
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.04)'" onmouseout="this.style.background=''">
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-medium flex-shrink-0"
                                     style="background: var(--accent)">
                                    {{ strtoupper(substr($catatan->siswa->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium" style="color: var(--text-primary)">{{ $catatan->siswa->name }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $catatan->siswa->kelas }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-3" style="color: var(--text-secondary)">{{ $catatan->tanggal_sesi->format('d M Y') }}</td>
                        <td class="py-3 px-3" style="color: var(--text-secondary)">{{ $catatan->jenis_label }}</td>
                        <td class="py-3 px-3">
                            @php
                                $badge = match($catatan->status) {
                                    'selesai'       => 'bg-blue-50 text-blue-800',
                                    'tindak_lanjut' => 'bg-amber-50 text-amber-800',
                                    default         => '',
                                };
                            @endphp
                            @if($catatan->status === 'berjalan')
                                <span class="text-xs font-medium px-3 py-1 rounded-full"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                                    {{ $catatan->status_label }}
                                </span>
                            @else
                                <span class="text-xs font-medium px-3 py-1 rounded-full {{ $badge }}">
                                    {{ $catatan->status_label }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('gurubk.catatan-konseling.show', $catatan) }}"
                                   class="text-xs hover:opacity-70 transition" style="color: var(--accent-light)">Detail</a>
                                <a href="{{ route('gurubk.catatan-konseling.edit', $catatan) }}"
                                   class="text-xs hover:opacity-70 transition" style="color: var(--text-muted)">Edit</a>
                                <form action="{{ route('gurubk.catatan-konseling.destroy', $catatan) }}" method="POST"
                                      onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-500 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-sm" style="color: var(--text-muted)">
                            Belum ada catatan konseling.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($catatanList->hasPages())
            <div class="mt-4">{{ $catatanList->links() }}</div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#siswa-select', {
        placeholder: 'Ketik nama atau kelas untuk mencari...',
        searchField: ['text'], maxOptions: 200, create: false, allowEmptyOption: true,
        render: { no_results: function() { return '<div style="padding:.5rem .75rem;color:var(--text-muted);font-size:.875rem;">Siswa tidak ditemukan</div>'; } }
    });
</script>
@endsection