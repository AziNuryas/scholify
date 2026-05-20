@extends('layouts.admin')
@section('title', 'Agenda Sekolah - Schoolify Admin')
@section('page-title', 'Manajemen Agenda Sekolah')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg shadow-blue-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Total Agenda</h3>
            <div class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $stats['total'] }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="check-circle-2" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Aktif</h3>
            <div class="font-outfit font-extrabold text-2xl text-emerald-500">{{ $stats['active'] }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 shadow-lg shadow-amber-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="clock" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Upcoming</h3>
            <div class="font-outfit font-extrabold text-2xl text-amber-500">{{ $stats['upcoming'] }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 shadow-lg shadow-rose-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="play-circle" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Berlangsung</h3>
            <div class="font-outfit font-extrabold text-2xl text-rose-500">{{ $stats['ongoing'] }}</div>
        </div>
    </div>

    <!-- Filter & Actions Bar -->
    <div class="neo-flat rounded-3xl p-6">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <form action="{{ route('admin.agendas.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full lg:flex-1">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari agenda..." class="w-full neo-input py-2.5 pl-9 pr-3 text-xs font-bold">
                </div>
                
                <div class="relative">
                    <select name="type" class="w-full neo-input appearance-none py-2.5 px-4 text-xs font-bold cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Tipe</option>
                        <option value="ujian" {{ request('type') == 'ujian' ? 'selected' : '' }}>Ujian</option>
                        <option value="rapat" {{ request('type') == 'rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="libur" {{ request('type') == 'libur' ? 'selected' : '' }}>Libur</option>
                        <option value="kegiatan" {{ request('type') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    </select>
                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                </div>

                <div class="relative">
                    <select name="status" class="w-full neo-input appearance-none py-2.5 px-4 text-xs font-bold cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 neo-btn py-2.5 bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20">
                        Filter
                    </button>
                    <a href="{{ route('admin.agendas.index') }}" class="neo-btn p-2.5 text-rose-500" title="Reset Filter">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                </div>
            </form>

            <a href="{{ route('admin.agendas.create') }}" class="w-full lg:w-auto neo-btn flex items-center justify-center gap-2 px-8 py-3 text-xs font-black bg-[var(--accent)] text-white shadow-lg shadow-blue-500/30 hover:scale-105 transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> TAMBAH AGENDA
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="neo-flat rounded-[2rem] overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] border-b border-[var(--shadow-dark)]/10">
                        <th class="px-6 py-5">Agenda & Tipe</th>
                        <th class="px-6 py-5">Waktu Pelaksanaan</th>
                        <th class="px-6 py-5">Target & Lokasi</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($agendas as $agenda)
                    <tr class="group hover:bg-white/40 dark:hover:bg-black/10 transition-all duration-300 border-b border-[var(--shadow-dark)]/5 last:border-0">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @php
                                    $typeIcon = match($agenda->type) {
                                        'ujian' => 'book-text',
                                        'rapat' => 'users',
                                        'libur' => 'palmtree',
                                        'kegiatan' => 'sparkles',
                                        default => 'calendar'
                                    };
                                    $typeColor = match($agenda->type) {
                                        'ujian' => 'text-rose-600 bg-rose-100',
                                        'rapat' => 'text-amber-600 bg-amber-100',
                                        'libur' => 'text-emerald-600 bg-emerald-100',
                                        'kegiatan' => 'text-indigo-600 bg-indigo-100',
                                        default => 'text-slate-600 bg-slate-100'
                                    };
                                @endphp
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $typeColor }} shadow-inner">
                                    <i data-lucide="{{ $typeIcon }}" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="font-black text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">{{ $agenda->title }}</p>
                                    <p class="text-[10px] text-[var(--text-muted)] font-black uppercase tracking-widest">{{ $agenda->type_label }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-[var(--text-primary)] flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-indigo-500"></i> {{ $agenda->formatted_date }}
                                </span>
                                <span class="text-[10px] text-[var(--text-muted)] font-bold flex items-center gap-1.5 mt-1 italic">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $agenda->formatted_time }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[9px] font-black border border-slate-200 uppercase tracking-widest w-max">
                                    <i data-lucide="users" class="w-3 h-3"></i> {{ $agenda->target_role }}
                                </span>
                                @if($agenda->location)
                                <span class="text-[10px] text-[var(--text-muted)] font-bold flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $agenda->location }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(!$agenda->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-400 text-[9px] font-black border border-slate-200 uppercase tracking-widest">
                                    NONAKTIF
                                </span>
                            @elseif($agenda->is_ongoing)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-600 text-[9px] font-black border border-rose-200 animate-pulse uppercase tracking-widest">
                                    BERLANGSUNG
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black border border-emerald-200 uppercase tracking-widest">
                                    AKTIF
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="neo-btn p-2 text-indigo-500 hover:bg-indigo-500 hover:text-white transition-all shadow-sm" title="Edit Agenda">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.agendas.delete', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="neo-btn p-2 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Hapus Agenda">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-400">
                                    <i data-lucide="calendar-x" class="w-10 h-10"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-600 uppercase tracking-widest">Tidak Ada Agenda</p>
                                    <p class="text-xs text-slate-400 font-bold mt-1">Belum ada agenda yang terdaftar atau sesuai filter.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agendas->hasPages())
        <div class="px-8 py-6 border-t border-[var(--shadow-dark)]/5">
            {{ $agendas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection