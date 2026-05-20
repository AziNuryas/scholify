@extends('layouts.admin')
@section('title', 'Jadwal Pelajaran - Schoolify Admin')
@section('page-title', 'Manajemen Jadwal Pelajaran')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <div class="neo-flat rounded-3xl p-5 flex flex-col items-center text-center neo-card-hover group">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <h3 class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Total Jadwal</h3>
            <div class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ $stats['total'] ?? 0 }}</div>
        </div>
        
        <div class="neo-flat rounded-3xl p-5 flex flex-col items-center text-center neo-card-hover group">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Aktif</h3>
            <div class="font-outfit font-black text-2xl text-emerald-500">{{ $stats['aktif'] ?? 0 }}</div>
        </div>

        <div class="neo-flat rounded-3xl p-5 flex flex-col items-center text-center neo-card-hover group">
            <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Nonaktif</h3>
            <div class="font-outfit font-black text-2xl text-rose-500">{{ $stats['nonaktif'] ?? 0 }}</div>
        </div>

        <div class="neo-flat rounded-3xl p-5 flex flex-col items-center text-center neo-card-hover group">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="sun" class="w-6 h-6"></i>
            </div>
            <h3 class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Hari Ini</h3>
            <div class="font-outfit font-black text-2xl text-amber-500">{{ $stats['hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Header Actions & Search -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-[var(--accent)]/10 text-[var(--accent)] flex items-center justify-center shadow-inner">
                <i data-lucide="table" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-outfit font-black text-xl text-[var(--text-primary)]">Daftar Jadwal</h3>
                <p class="text-xs text-[var(--text-secondary)] font-bold">Total: {{ $jadwal->total() }} record ditemukan</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex flex-1 lg:flex-none items-center gap-2">
                <div class="relative flex-1 lg:w-64">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Mapel, Guru..." 
                           class="w-full neo-input pl-10 py-2.5 text-sm font-bold">
                </div>
                <button type="submit" class="neo-btn p-2.5 rounded-xl text-[var(--accent)] hover:bg-[var(--accent)] hover:text-white transition-all">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
            </form>
            <a href="{{ route('admin.jadwal.create') }}" class="neo-btn px-6 py-2.5 rounded-xl bg-[var(--accent)] text-white text-sm font-black flex items-center gap-2 shadow-lg shadow-blue-500/30 hover:scale-105 transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> TAMBAH JADWAL
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="neo-flat rounded-3xl p-6">
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest ml-1">Filter Hari</label>
                <select name="hari" class="w-full neo-input py-2 text-xs font-bold appearance-none cursor-pointer">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                    <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest ml-1">Filter Kelas</label>
                <select name="kelas" class="w-full neo-input py-2 text-xs font-bold appearance-none cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @foreach($classes ?? [] as $k)
                    <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest ml-1">Filter Guru</label>
                <select name="guru" class="w-full neo-input py-2 text-xs font-bold appearance-none cursor-pointer">
                    <option value="">Semua Guru</option>
                    @foreach($teachers ?? [] as $g)
                    <option value="{{ $g->id }}" {{ request('guru') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest ml-1">Status</label>
                <select name="status" class="w-full neo-input py-2 text-xs font-bold appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 neo-btn py-2.5 bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20">
                    <i data-lucide="filter" class="w-3 h-3 inline-block mr-1"></i> FILTER
                </button>
                <a href="{{ route('admin.jadwal.index') }}" class="neo-btn p-2.5 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="neo-flat rounded-[2rem] overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] border-b border-[var(--shadow-dark)]/10">
                        <th class="px-6 py-5">Hari & Jam</th>
                        <th class="px-6 py-5">Mata Pelajaran</th>
                        <th class="px-6 py-5">Kelas & Guru</th>
                        <th class="px-6 py-5">Lokasi</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($jadwal ?? [] as $j)
                    <tr class="group hover:bg-white/40 dark:hover:bg-black/10 transition-all duration-300 border-b border-[var(--shadow-dark)]/5 last:border-0">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex flex-col items-center justify-center font-black {{ $j->hari == 'Senin' ? 'bg-blue-100 text-blue-600' : ($j->hari == 'Selasa' ? 'bg-emerald-100 text-emerald-600' : ($j->hari == 'Rabu' ? 'bg-purple-100 text-purple-600' : ($j->hari == 'Kamis' ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600'))) }}">
                                    <span class="text-[10px] uppercase">{{ substr($j->hari, 0, 3) }}</span>
                                </div>
                                <div>
                                    <p class="font-black text-[var(--text-primary)] text-sm">{{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }}</p>
                                    <p class="text-[10px] text-[var(--text-muted)] font-bold italic">{{ $j->durasi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-black text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">{{ $j->mata_pelajaran }}</p>
                            <p class="text-[10px] text-[var(--text-muted)] font-bold uppercase tracking-widest">SMT {{ $j->semester }} | {{ $j->tahun_ajaran }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-[var(--text-primary)]">{{ $j->schoolClass->name ?? '-' }}</span>
                                <span class="text-[10px] text-[var(--text-muted)] font-bold flex items-center gap-1">
                                    <i data-lucide="user" class="w-3 h-3"></i> {{ $j->guru->name ?? '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black border border-slate-200">
                                <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $j->ruangan ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $j->status == 'aktif' ? 'bg-emerald-100 text-emerald-600 border-emerald-200' : 'bg-rose-100 text-rose-600 border-rose-200' }} text-[10px] font-black border">
                                <span class="w-1.5 h-1.5 rounded-full {{ $j->status == 'aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span> {{ strtoupper($j->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.jadwal.edit', $j) }}" class="neo-btn p-2 text-blue-500 hover:bg-blue-500 hover:text-white transition-all shadow-sm" title="Edit Jadwal">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <button onclick="confirmDelete({{ $j->id }}, '{{ $j->mata_pelajaran }}')" class="neo-btn p-2 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Hapus Jadwal">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-400">
                                    <i data-lucide="calendar-x" class="w-10 h-10"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-600 uppercase tracking-widest">Data Tidak Ditemukan</p>
                                    <p class="text-xs text-slate-400 font-bold mt-1">Belum ada jadwal yang sesuai dengan filter Anda.</p>
                                </div>
                                <a href="{{ route('admin.jadwal.create') }}" class="neo-btn px-6 py-2.5 text-[10px] font-black bg-[var(--accent)] text-white uppercase tracking-widest">
                                    Tambah Jadwal Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwal->hasPages())
        <div class="px-8 py-6 border-t border-[var(--shadow-dark)]/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs font-black text-[var(--text-muted)] uppercase tracking-widest">
                Showing <span class="text-[var(--text-primary)]">{{ $jadwal->firstItem() }}</span> to <span class="text-[var(--text-primary)]">{{ $jadwal->lastItem() }}</span> of <span class="text-[var(--text-primary)]">{{ $jadwal->total() }}</span> records
            </p>
            <div class="flex items-center gap-2">
                @if($jadwal->onFirstPage())
                    <span class="neo-btn p-2.5 rounded-xl opacity-40 cursor-not-allowed text-[var(--text-muted)]">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </span>
                @else
                    <a href="{{ $jadwal->previousPageUrl() }}" class="neo-btn p-2.5 rounded-xl text-[var(--accent)] hover:bg-[var(--accent)] hover:text-white transition-all">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </a>
                @endif

                @foreach($jadwal->getUrlRange(max(1, $jadwal->currentPage()-1), min($jadwal->lastPage(), $jadwal->currentPage()+1)) as $page => $url)
                    <a href="{{ $url }}" class="neo-btn w-10 h-10 rounded-xl flex items-center justify-center text-xs font-black transition-all {{ $page == $jadwal->currentPage() ? 'bg-[var(--accent)] text-white shadow-lg shadow-blue-500/30' : 'text-[var(--text-secondary)] hover:text-[var(--accent)]' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($jadwal->hasMorePages())
                    <a href="{{ $jadwal->nextPageUrl() }}" class="neo-btn p-2.5 rounded-xl text-[var(--accent)] hover:bg-[var(--accent)] hover:text-white transition-all">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                @else
                    <span class="neo-btn p-2.5 rounded-xl opacity-40 cursor-not-allowed text-[var(--text-muted)]">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-[100] hidden flex-col items-center justify-center transition-opacity opacity-0 p-4">
    <div class="neo-flat p-8 max-w-sm w-full rounded-[2.5rem] transform scale-95 transition-transform border border-white/20 shadow-2xl text-center">
        <div class="w-20 h-20 bg-rose-100 text-rose-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
            <i data-lucide="trash-2" class="w-10 h-10"></i>
        </div>
        <h3 class="font-outfit font-black text-xl text-[var(--text-primary)] mb-2">Hapus Jadwal?</h3>
        <p class="text-xs text-[var(--text-secondary)] font-bold leading-relaxed mb-8">
            Anda akan menghapus jadwal <span id="deleteItemName" class="text-rose-500"></span>. Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex gap-4">
            <button onclick="closeModal()" class="flex-1 neo-btn py-4 text-[10px] font-black text-[var(--text-secondary)] uppercase tracking-widest">Batal</button>
            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full neo-btn py-4 text-[10px] font-black text-white bg-rose-500 uppercase tracking-widest shadow-lg shadow-rose-500/30">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        document.getElementById('deleteItemName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/jadwal/${id}`;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('show');
            modal.classList.add('opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('show');
        modal.classList.remove('opacity-100');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush