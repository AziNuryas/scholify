@extends('layouts.gurubk')

@section('title', 'Catatan Disiplin - Schoolify')
@section('page-title', 'Catatan Disiplin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css"/>
<style>
    .ts-wrapper.single .ts-control, .ts-control {
        border: 1px solid var(--border) !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
        font-size: 0.75rem !important;
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
        font-size: 0.75rem !important;
        background: var(--bg-card) !important;
        overflow: hidden;
        z-index: 9999 !important;
    }
    .ts-dropdown .option { padding: 0.5rem 0.75rem !important; color: var(--text-primary) !important; }
    .ts-dropdown .option:hover, .ts-dropdown .option.active {
        background: rgba(168,85,247,.12) !important;
        color: var(--accent-light) !important;
    }
    .ts-wrapper .placeholder { color: var(--text-muted) !important; }
</style>
<div class="space-y-6 pt-2 animate-fadeInUp">

    <div class="mb-2">
        <h1 class="font-outfit font-bold text-3xl mb-1" style="color: var(--text-primary)">Catatan Disiplin</h1>
        <p class="text-sm" style="color: var(--text-secondary)">Kelola riwayat pelanggaran dan poin kedisiplinan siswa.</p>
    </div>

    @if(session('success'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    {{-- Filter --}}
    <div class="neo-flat rounded-2xl p-4">
        <form method="GET" action="{{ route('gurubk.discipline') }}" class="flex flex-wrap gap-3 items-end">

            {{-- Filter Siswa --}}
            <div class="flex flex-col gap-1" style="min-width: 200px;">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Siswa</label>
                <select id="filter-siswa" name="siswa_id">
                    <option value="">Semua Siswa</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->schoolClass->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Jenis Pelanggaran --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Jenis Pelanggaran</label>
                <select name="jenis"
                        class="text-xs rounded-lg px-3 py-2 outline-none"
                        style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                    <option value="">Semua Jenis</option>
                    <option value="Terlambat Masuk"      {{ request('jenis') === 'Terlambat Masuk'      ? 'selected' : '' }}>Terlambat Masuk</option>
                    <option value="Bolos Sekolah"         {{ request('jenis') === 'Bolos Sekolah'         ? 'selected' : '' }}>Bolos Sekolah</option>
                    <option value="Atribut Tidak Lengkap" {{ request('jenis') === 'Atribut Tidak Lengkap' ? 'selected' : '' }}>Atribut Tidak Lengkap</option>
                    <option value="Berkelahi"             {{ request('jenis') === 'Berkelahi'             ? 'selected' : '' }}>Berkelahi</option>
                    <option value="Merokok"               {{ request('jenis') === 'Merokok'               ? 'selected' : '' }}>Merokok</option>
                    <option value="Lainnya"               {{ request('jenis') === 'Lainnya'               ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- Filter Dari Tanggal --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                       class="text-xs rounded-lg px-3 py-2 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
            </div>

            {{-- Filter Sampai Tanggal --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                       class="text-xs rounded-lg px-3 py-2 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
            </div>

            {{-- Tombol Filter + Reset --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 text-xs text-white rounded-lg transition flex items-center gap-1"
                        style="background: var(--accent)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">
                    <i class='bx bx-filter-alt'></i> Filter
                </button>
                @if(request()->hasAny(['siswa_id','jenis','dari','sampai']))
                    <a href="{{ route('gurubk.discipline') }}"
                       class="px-4 py-2 text-xs rounded-lg transition flex items-center gap-1"
                       style="border: 1px solid var(--border); color: var(--text-secondary)">
                        <i class='bx bx-x'></i> Reset
                    </a>
                @endif
            </div>

            {{-- Tombol Tambah Catatan (paling kanan) --}}
            <div class="ml-auto">
                <button type="button"
                        onclick="document.getElementById('modal-add-discipline').classList.remove('hidden')"
                        class="text-white px-5 py-2 rounded-xl font-bold text-sm transition flex items-center gap-2"
                        style="background: var(--accent); box-shadow: 0 4px 14px rgba(124,58,237,.3)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">
                    <i class='bx bx-plus'></i> Tambah Catatan
                </button>
            </div>

        </form>
    </div>

    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid var(--border)">
            <h2 class="font-outfit font-bold text-lg" style="color: var(--text-primary)">Riwayat Pelanggaran Terbaru</h2>
            @if($records->count() > 0)
            <span class="text-xs font-medium px-3 py-1 rounded-full"
                  style="background: rgba(168,85,247,.12); color: var(--accent-light)">
                {{ $records->count() }} data
            </span>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs uppercase font-bold tracking-wider" style="border-bottom: 1px solid var(--border); color: var(--text-muted)">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Jenis Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.06)'" onmouseout="this.style.background=''">
                        <td class="px-6 py-4 font-medium" style="color: var(--text-secondary)">
                            {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $record->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($record->student->name) }}"
                                     class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold" style="color: var(--text-primary)">{{ $record->student->name }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $record->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-red-400">{{ $record->violation_type }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" style="color: var(--text-secondary)" title="{{ $record->description }}">
                            {{ $record->description }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg font-bold">+{{ $record->points }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center" style="color: var(--text-muted)">
                            @if(request()->hasAny(['siswa_id','jenis','dari','sampai']))
                                Tidak ada data yang sesuai filter.
                                <a href="{{ route('gurubk.discipline') }}" class="underline" style="color: var(--accent-light)">Reset filter</a>
                            @else
                                Belum ada catatan pelanggaran.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
                {{ $records->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Modal Add Discipline --}}
<div id="modal-add-discipline"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background: rgba(0,0,0,.5); backdrop-filter: blur(4px);"
     onclick="if(event.target===this) this.classList.add('hidden')">

    <div class="rounded-3xl w-full max-w-lg shadow-2xl relative flex flex-col"
         style="background: var(--bg-card); max-height: 90vh;">

        {{-- Header --}}
        <div class="p-6 flex justify-between items-center flex-shrink-0"
             style="border-bottom: 1px solid var(--border)">
            <div class="flex items-center gap-2">
                <i class='bx bx-shield-x text-xl' style="color: var(--accent-light)"></i>
                <h3 class="font-outfit font-bold text-xl" style="color: var(--text-primary)">Catat Pelanggaran Baru</h3>
            </div>
            <button onclick="document.getElementById('modal-add-discipline').classList.add('hidden')"
                    class="w-8 h-8 rounded-full flex items-center justify-center transition hover:bg-red-100 hover:text-red-500"
                    style="color: var(--text-muted)">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>

        {{-- Form (scrollable) --}}
        <div class="overflow-y-auto flex-1">
            <form action="{{ route('gurubk.discipline.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color: var(--text-secondary)">
                        Pilih Siswa <span class="text-red-400">*</span>
                    </label>
                    <select name="student_id" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->schoolClass->name ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color: var(--text-secondary)">
                        Tanggal <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color: var(--text-secondary)">
                        Jenis Pelanggaran <span class="text-red-400">*</span>
                    </label>
                    <select name="violation_type" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="Terlambat Masuk">Terlambat Masuk</option>
                        <option value="Bolos Sekolah">Bolos Sekolah</option>
                        <option value="Atribut Tidak Lengkap">Atribut Tidak Lengkap</option>
                        <option value="Berkelahi">Berkelahi</option>
                        <option value="Merokok">Merokok</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color: var(--text-secondary)">
                        Poin Hukuman <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="points" required placeholder="0" min="0"
                           class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1.5" style="color: var(--text-secondary)">
                        Keterangan / Kronologi Singkat <span class="text-red-400">*</span>
                    </label>
                    <textarea name="description" rows="3" required
                              placeholder="Tuliskan kronologi singkat pelanggaran..."
                              class="w-full rounded-xl px-4 py-2 text-sm outline-none resize-none"
                              style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"></textarea>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button"
                            onclick="document.getElementById('modal-add-discipline').classList.add('hidden')"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm transition"
                            style="border: 1px solid var(--border); color: var(--text-secondary)">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 text-white rounded-xl py-2.5 font-bold text-sm transition"
                            style="background: var(--accent); box-shadow: 0 4px 14px rgba(124,58,237,.3)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">
                        <i class='bx bx-save mr-1'></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#filter-siswa', {
            placeholder: 'Cari nama siswa...',
            searchField: ['text'],
            maxOptions: 200,
            create: false,
            allowEmptyOption: true,
            render: {
                no_results: function() {
                    return '<div style="padding:.5rem .75rem;color:var(--text-muted);font-size:.75rem;">Siswa tidak ditemukan</div>';
                }
            }
        });
    });
</script>
@endsection