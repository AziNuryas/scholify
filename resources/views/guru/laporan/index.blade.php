{{-- resources/views/guru/laporan/index.blade.php --}}
@extends('layouts.guru')

@section('title', 'Laporan Siswa - Scholify Guru')
@section('page-title', 'Laporan Siswa')
@section('page-subtitle', 'Riwayat laporan siswa bermasalah yang telah Anda kirim ke BK')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="neo-pressed w-9 h-9 rounded-xl flex items-center justify-center">
                        <i data-lucide="flag" class="w-4.5 h-4.5 text-rose-500"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-rose-600">Laporan Siswa</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm">Riwayat laporan siswa bermasalah yang telah Anda kirim ke BK</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl flex items-center gap-2">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-rose-400"></i>
                <span class="text-xs font-semibold text-[var(--text-primary)]">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="neo-pressed p-4 rounded-xl bg-emerald-50/50 border-l-4 border-emerald-500">
            <div class="flex items-center gap-3 text-emerald-600 text-sm">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Header + Tombol Buat --}}
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div class="group">
            <div class="flex items-center gap-3">
                <div class="neo-pressed w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                    <i data-lucide="list" class="w-4.5 h-4.5 text-rose-500"></i>
                </div>
                <div>
                    <h2 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Riwayat Laporan</h2>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="text-xs text-[var(--text-muted)]">Total</span>
                        <span class="text-sm font-bold text-rose-500">{{ $laporan->total() }}</span>
                        <span class="text-xs text-[var(--text-muted)]">laporan dikirim</span>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('guru.laporan.create') }}"
            class="neo-btn px-5 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105 bg-rose-500 text-white hover:bg-rose-600">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Buat Laporan Baru
        </a>
    </div>

    {{-- Tabel Laporan --}}
    <div class="neo-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Siswa</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Kategori</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Judul</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Urgensi</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Status</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Tanggal</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    @php
                        $urgColor = match($item->tingkat_urgensi) {
                            'kritis' => 'rose',
                            'tinggi' => 'amber',
                            'sedang' => 'blue',
                            default  => 'slate',
                        };
                        $urgLabel = match($item->tingkat_urgensi) {
                            'kritis' => 'Kritis',
                            'tinggi' => 'Tinggi',
                            'sedang' => 'Sedang',
                            default  => 'Rendah',
                        };
                        $statusColor = match($item->status) {
                            'selesai'   => 'emerald',
                            'diproses'  => 'blue',
                            'ditutup'   => 'slate',
                            default     => 'amber',
                        };
                        $statusLabel = match($item->status) {
                            'baru'      => 'Baru',
                            'diproses'  => 'Diproses',
                            'selesai'   => 'Selesai',
                            'ditutup'   => 'Ditutup',
                            default     => $item->status,
                        };
                    @endphp
                    <tr class="border-b border-[var(--shadow-dark)]/5 hover:bg-[var(--bg)] transition-all duration-200 group">
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-3">
                                <div class="neo-pressed w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-rose-500 flex-shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-[var(--text-primary)] text-sm group-hover:text-rose-500 transition-colors">
                                        {{ $item->siswa->name ?? '-' }}
                                    </p>
                                    <p class="text-[11px] text-[var(--text-muted)]">{{ $item->siswa->kelas ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-100 text-slate-600">
                                <i data-lucide="folder" class="w-2.5 h-2.5"></i>
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            <p class="text-[var(--text-primary)] font-medium max-w-xs text-sm line-clamp-1">{{ $item->judul }}</p>
                        </td>
                        <td class="py-3 px-5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold 
                                @if($urgColor == 'rose') bg-rose-50 text-rose-600 border-l-2 border-rose-500
                                @elseif($urgColor == 'amber') bg-amber-50 text-amber-600 border-l-2 border-amber-500
                                @elseif($urgColor == 'blue') bg-blue-50 text-blue-600 border-l-2 border-blue-500
                                @else bg-slate-100 text-slate-600 border-l-2 border-slate-400 @endif">
                                @if($urgColor == 'rose') <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                @elseif($urgColor == 'amber') <i data-lucide="clock" class="w-3 h-3"></i>
                                @elseif($urgColor == 'blue') <i data-lucide="info" class="w-3 h-3"></i>
                                @else <i data-lucide="minus" class="w-3 h-3"></i> @endif
                                {{ $urgLabel }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold
                                @if($statusColor == 'emerald') bg-emerald-50 text-emerald-600
                                @elseif($statusColor == 'blue') bg-blue-50 text-blue-600
                                @elseif($statusColor == 'amber') bg-amber-50 text-amber-600
                                @else bg-slate-100 text-slate-600 @endif">
                                @if($statusColor == 'emerald') <i data-lucide="check-circle" class="w-3 h-3"></i>
                                @elseif($statusColor == 'blue') <i data-lucide="loader-2" class="w-3 h-3"></i>
                                @elseif($statusColor == 'amber') <i data-lucide="clock" class="w-3 h-3"></i>
                                @else <i data-lucide="archive" class="w-3 h-3"></i> @endif
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            <div class="flex flex-col">
                                <span class="text-[11px] text-[var(--text-muted)]">{{ $item->created_at->locale('id')->isoFormat('D MMM Y') }}</span>
                                <span class="text-[10px] text-[var(--text-muted)]/70">{{ $item->created_at->locale('id')->isoFormat('H:i') }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-5">
                            <a href="{{ route('guru.laporan.show', $item) }}"
                                class="neo-btn px-3 py-1.5 rounded-lg text-[11px] font-semibold inline-flex items-center gap-1.5 transition-all hover:scale-105">
                                <i data-lucide="eye" class="w-3 h-3"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="neo-flat p-10 text-center max-w-md mx-auto">
                                <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="file-x" class="w-10 h-10 text-[var(--text-muted)]"></i>
                                </div>
                                <p class="text-[var(--text-primary)] font-semibold text-base">Belum ada laporan</p>
                                <p class="text-sm text-[var(--text-muted)] mt-1">Belum ada laporan yang dikirim.</p>
                                <a href="{{ route('guru.laporan.create') }}"
                                    class="neo-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold mt-5 bg-rose-500 text-white hover:bg-rose-600">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    Buat Laporan Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($laporan->hasPages())
            <div class="px-5 py-4 border-t border-[var(--shadow-dark)]/10 bg-[var(--bg)]/30">
                {{ $laporan->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Custom pagination styling */
    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .pagination .page-item .page-link {
        @apply neo-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all;
    }
    
    .pagination .active .page-link {
        background: var(--accent) !important;
        color: white !important;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                    inset -2px -2px 5px rgba(255, 255, 255, 0.1);
    }
    
    /* Animations */
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.4s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.4s ease-out forwards;
    }
    
    /* Line clamp */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Icon size */
    .w-4\.5 {
        width: 1.125rem;
    }
    .h-4\.5 {
        height: 1.125rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection