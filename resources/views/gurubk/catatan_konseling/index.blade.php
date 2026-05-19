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

    #form-tambah {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.35s ease, opacity 0.25s ease;
    }
    #form-tambah.show {
        max-height: 2000px;
        opacity: 1;
    }

    #filter-panel {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.3s ease, opacity 0.2s ease;
    }
    #filter-panel.show {
        max-height: 500px;
        opacity: 1;
    }

    .filter-input {
        width: 100%;
        font-size: 0.8rem;
        border-radius: 0.5rem;
        padding: 0.45rem 0.75rem;
        outline: none;
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--text-primary);
        transition: border-color .2s;
    }
    .filter-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 2px rgba(124,58,237,0.15);
    }
    .filter-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 0.3rem;
        color: var(--text-muted);
    }
</style>

<div class="animate-fadeInUp space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Catatan Konseling</h1>
            <p class="text-sm mt-1" style="color: var(--text-secondary)">Rekam dan pantau sesi konseling siswa secara terstruktur.</p>
        </div>
        <button onclick="toggleForm()"
                class="flex items-center gap-2 px-4 py-2 text-sm text-white rounded-lg font-medium transition"
                style="background: var(--accent)"
                onmouseover="this.style.background='var(--accent-hover)'"
                onmouseout="this.style.background='var(--accent)'">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Catatan
        </button>
    </div>

    {{-- ===== SUMMARY CARDS ===== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @php
            $cards = [
                ['label' => 'Total Catatan',   'value' => $totalSemua,         'color' => 'rgba(168,85,247,.15)',  'text' => 'var(--accent-light)'],
                ['label' => 'Berjalan',         'value' => $totalBerjalan,      'color' => 'rgba(168,85,247,.1)',   'text' => 'var(--accent-light)'],
                ['label' => 'Tindak Lanjut',    'value' => $totalTindakLanjut,  'color' => 'rgba(251,191,36,.15)', 'text' => '#d97706'],
                ['label' => 'Selesai',          'value' => $totalSelesai,       'color' => 'rgba(59,130,246,.12)', 'text' => '#2563eb'],
            ];
        @endphp
        @foreach($cards as $card)
        <div class="neo-flat rounded-xl px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-base"
                 style="background: {{ $card['color'] }}; color: {{ $card['text'] }}">
                {{ $card['value'] }}
            </div>
            <p class="text-xs font-medium" style="color: var(--text-secondary)">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    @if(session('success'))
        <div class="px-4 py-3 rounded-lg text-sm border"
             style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== FORM TAMBAH ===== --}}
    <div id="form-tambah" class="{{ $errors->any() || old('masalah') ? 'show' : '' }}">
        <div class="neo-flat rounded-2xl p-6 mb-2">
            <h2 class="text-sm font-semibold mb-4 pb-3" style="color: var(--text-primary); border-bottom: 1px solid var(--border)">
                Tambah catatan konseling baru
            </h2>
            <form action="{{ route('gurubk.catatan-konseling.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Nama siswa</label>
                        <select id="siswa-select" name="siswa_id">
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
                    <button type="button" onclick="toggleForm()"
                            class="px-4 py-2 text-sm rounded-lg transition"
                            style="border: 1px solid var(--border); color: var(--text-secondary)">Batal</button>
                    <button type="submit"
                            class="px-5 py-2 text-sm text-white rounded-lg font-medium transition"
                            style="background: var(--accent)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">Simpan catatan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== TABEL RIWAYAT ===== --}}
    <div class="neo-flat rounded-2xl p-6">

        {{-- Header tabel + tombol filter --}}
        <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
            <h2 class="text-sm font-semibold" style="color: var(--text-primary)">Riwayat catatan konseling</h2>
            <div class="flex items-center gap-2">
                {{-- Badge jumlah filter aktif --}}
                @php
                    $activeFilters = collect(['cari','status','jenis','kelas','dari','sampai'])->filter(fn($k) => request()->filled($k))->count();
                @endphp
                <button onclick="toggleFilter()" id="btn-filter"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition"
                        style="border: 1px solid var(--border); color: var(--text-secondary); background: var(--bg)">
                    <i class='bx bx-filter-alt'></i>
                    Filter
                    @if($activeFilters > 0)
                    <span class="w-4 h-4 rounded-full text-[10px] font-bold text-white flex items-center justify-center"
                          style="background: var(--accent)">{{ $activeFilters }}</span>
                    @endif
                </button>
                @if($activeFilters > 0)
                <a href="{{ route('gurubk.catatan-konseling.index') }}"
                   class="text-xs px-3 py-1.5 rounded-lg transition"
                   style="border: 1px solid rgba(239,68,68,.3); color: #f87171; background: rgba(239,68,68,.08)">
                    <i class='bx bx-x'></i> Reset
                </a>
                @endif
            </div>
        </div>

        {{-- Panel filter (collapsible) --}}
        <div id="filter-panel" class="{{ $activeFilters > 0 ? 'show' : '' }}">
            <form method="GET" action="{{ route('gurubk.catatan-konseling.index') }}"
                  class="rounded-xl p-4 mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                  style="background: rgba(168,85,247,.05); border: 1px solid rgba(168,85,247,.15)">

                {{-- Cari nama --}}
                <div>
                    <label class="filter-label">Nama Siswa</label>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                           placeholder="Cari nama siswa..."
                           class="filter-input"/>
                </div>

                {{-- Filter Kelas --}}
                <div>
                    <label class="filter-label">Kelas</label>
                    <select name="kelas" class="filter-input">
                        <option value="">Semua kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Jenis --}}
                <div>
                    <label class="filter-label">Jenis Konseling</label>
                    <select name="jenis" class="filter-input">
                        <option value="">Semua jenis</option>
                        @foreach(\App\Models\CatatanKonseling::$jenisLabels as $val => $lbl)
                            <option value="{{ $val }}" {{ request('jenis') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div>
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">Semua status</option>
                        @foreach(\App\Models\CatatanKonseling::$statusLabels as $val => $lbl)
                            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Tanggal Dari --}}
                <div>
                    <label class="filter-label">Tanggal Dari</label>
                    <input type="date" name="dari" value="{{ request('dari') }}" class="filter-input"/>
                </div>

                {{-- Filter Tanggal Sampai --}}
                <div>
                    <label class="filter-label">Tanggal Sampai</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="filter-input"/>
                </div>

                {{-- Tombol --}}
                <div class="sm:col-span-2 lg:col-span-3 flex justify-end gap-2 pt-1">
                    <a href="{{ route('gurubk.catatan-konseling.index') }}"
                       class="px-4 py-1.5 text-xs rounded-lg transition"
                       style="border: 1px solid var(--border); color: var(--text-secondary)">Reset</a>
                    <button type="submit"
                            class="px-5 py-1.5 text-xs text-white rounded-lg font-medium transition"
                            style="background: var(--accent)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">
                        <i class='bx bx-search'></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Info hasil filter --}}
        @if($activeFilters > 0)
        <div class="mb-3 text-xs px-3 py-2 rounded-lg flex items-center gap-2"
             style="background: rgba(168,85,247,.08); color: var(--accent-light)">
            <i class='bx bx-info-circle'></i>
            Menampilkan <strong>{{ $catatanList->total() }}</strong> catatan berdasarkan {{ $activeFilters }} filter aktif.
        </div>
        @endif

        {{-- Tabel --}}
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
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $catatan->siswa->kelas ?? ($catatan->siswa->schoolClass->name ?? '-') }}</p>
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
                                      onsubmit="return confirm('Hapus catatan konseling {{ $catatan->siswa->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400 hover:text-red-500 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-sm" style="color: var(--text-muted)">
                            @if($activeFilters > 0)
                                Tidak ada catatan yang sesuai dengan filter.
                                <a href="{{ route('gurubk.catatan-konseling.index') }}" class="underline" style="color: var(--accent-light)">Reset filter</a>
                            @else
                                Belum ada catatan konseling.
                            @endif
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
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#siswa-select', {
            placeholder: 'Ketik nama atau kelas untuk mencari...',
            searchField: ['text'], maxOptions: 200, create: false, allowEmptyOption: true,
            render: { no_results: function() { return '<div style="padding:.5rem .75rem;color:var(--text-muted);font-size:.875rem;">Siswa tidak ditemukan</div>'; } }
        });
    });

    function toggleForm() {
        const form = document.getElementById('form-tambah');
        form.classList.toggle('show');
        if (form.classList.contains('show')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function toggleFilter() {
        const panel = document.getElementById('filter-panel');
        panel.classList.toggle('show');
    }
</script>
@endsection