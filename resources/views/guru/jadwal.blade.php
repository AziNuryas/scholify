@extends('layouts.guru')

@section('title', 'Jadwal Mengajar - Scholify Guru')
@section('page-title', 'Jadwal Mengajar')
@section('page-subtitle', 'Pusat kendali agenda harian Anda')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Jadwal Mengajar</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Pusat kendali agenda harian Anda</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl">
                <span class="text-xs font-bold text-[var(--text-muted)] flex items-center gap-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        {{-- Card Total Jam --}}
        <div class="neo-card p-5 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="hourglass" class="w-5 h-5 text-[var(--accent)]"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Total Jam</p>
                        <p class="text-2xl font-bold text-[var(--text-primary)]">{{ $totalJam }} Jam</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Total Kelas --}}
        <div class="neo-card p-5 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="book-open" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Total Kelas</p>
                        <p class="text-2xl font-bold text-[var(--text-primary)]">{{ $totalKelas }} Kelas</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Kelas Berikutnya --}}
        <div class="neo-card p-5 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[var(--accent)]/5 rounded-full blur-2xl"></div>
            <div class="flex items-center justify-between relative z-10">
                <div class="flex items-center gap-3">
                    <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Kelas Berikutnya</p>
                        @if($nextSchedule)
                            <p class="text-xl font-bold text-[var(--text-primary)]">{{ $nextSchedule->schoolClass->name ?? 'Kelas' }}</p>
                            <p class="text-[11px] text-amber-500 flex items-center gap-1 mt-0.5">
                                <i data-lucide="timer" class="w-3 h-3"></i>
                                {{ $nextClassTime }}
                            </p>
                        @else
                            <p class="text-sm text-[var(--text-muted)]">Tidak ada jadwal</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Hari --}}
    <div class="neo-flat p-2 inline-flex rounded-xl flex-wrap gap-1">
        @foreach($hariList as $hari)
            <button class="filter-hari neo-btn px-5 py-2 rounded-lg text-xs font-semibold transition-all {{ $selectedDay == $hari ? 'active' : '' }}"
                    data-day="{{ $hari }}">
                {{ $hari }}
            </button>
        @endforeach
    </div>

    {{-- Daftar Jadwal --}}
    <div class="space-y-4" id="scheduleList">
        @forelse($jadwalPerHari[$selectedDay] ?? [] as $item)
            @php 
                $now = \Carbon\Carbon::now();
                
                // Parse waktu mulai dan selesai
                $startTime = \Carbon\Carbon::parse($item->start_time);
                $endTime = \Carbon\Carbon::parse($item->end_time);
                
                // Buat datetime lengkap untuk hari ini dengan jam dari jadwal
                $todayStart = \Carbon\Carbon::today()->setTime($startTime->hour, $startTime->minute, $startTime->second);
                $todayEnd = \Carbon\Carbon::today()->setTime($endTime->hour, $endTime->minute, $endTime->second);
                
                // Tentukan status
                if ($now->between($todayStart, $todayEnd)) {
                    $status = 'ongoing';
                } elseif ($now->lt($todayStart)) {
                    $status = 'upcoming';
                } else {
                    $status = 'completed';
                }
            @endphp
            
            <div class="schedule-card neo-card p-5 transition-all duration-300 hover:neo-pressed group 
                        {{ $status == 'ongoing' ? 'border-l-4 border-l-rose-500' : '' }}">
                <div class="flex flex-wrap md:flex-nowrap gap-5">
                    {{-- Time Column --}}
                    <div class="md:w-32 flex-shrink-0">
                        <div class="neo-pressed rounded-xl px-4 py-2 text-center">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-[var(--text-muted)] mx-auto mb-1"></i>
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                            <p class="text-[10px] text-[var(--text-muted)]">s/d</p>
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    {{-- Content Column --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                        {{ $item->subject->name ?? 'Mata Pelajaran' }}
                                    </h3>
                                    @if($status == 'ongoing')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-500 text-white animate-pulse">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                            LIVE
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-[var(--text-secondary)]">
                                    {{ $item->schoolClass->name ?? 'Kelas' }} • 
                                    {{ $item->schoolClass->students->count() ?? 0 }} Siswa
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                            <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[var(--bg)]">
                                <div class="neo-pressed w-7 h-7 rounded-lg flex items-center justify-center">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Ruangan</p>
                                    <p class="text-xs font-medium text-[var(--text-primary)]">{{ $item->room ?? 'Ruang ' . ($item->schoolClass->name ?? '') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[var(--bg)]">
                                <div class="neo-pressed w-7 h-7 rounded-lg flex items-center justify-center">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-[var(--accent)]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Materi</p>
                                    <p class="text-xs font-medium text-[var(--text-primary)]">{{ $item->material ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($status == 'ongoing')
                            <div class="mt-4 pt-3 border-t border-[var(--shadow-dark)]/10 flex gap-3">
                                <a href="{{ route('guru.absensi') }}?class_id={{ $item->class_id }}&schedule_id={{ $item->id }}" 
                                   class="neo-btn flex-1 py-2 rounded-lg text-xs font-semibold flex items-center justify-center gap-2">
                                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                                    Buka Absensi
                                </a>
                                <button onclick="showMaterial({{ $item->id }})" 
                                        class="neo-btn px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2">
                                    <i data-lucide="folder-open" class="w-3.5 h-3.5"></i>
                                    Materi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="neo-flat p-12 text-center">
                <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="calendar-x" class="w-10 h-10 text-[var(--text-muted)]"></i>
                </div>
                <p class="text-[var(--text-primary)] font-semibold text-base">Tidak ada jadwal</p>
                <p class="text-sm text-[var(--text-muted)] mt-1">Tidak ada jadwal mengajar untuk hari {{ $selectedDay }}.</p>
            </div>
        @endforelse
    </div>

    {{-- Tombol Unduh PDF --}}
    <div class="flex justify-center">
        <button onclick="downloadPDF()" class="neo-btn px-6 py-3 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
            <i data-lucide="printer" class="w-4 h-4"></i>
            Unduh Jadwal PDF
        </button>
    </div>
</div>

<style>
    .schedule-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-hari {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--text-secondary);
        cursor: pointer;
    }
    
    .filter-hari.active {
        background: var(--accent) !important;
        color: white !important;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                    inset -2px -2px 5px rgba(255, 255, 255, 0.1);
    }
    
    .filter-hari:not(.active):hover {
        transform: translateY(-1px);
        box-shadow: 6px 6px 12px rgba(var(--shadow-dark), 0.5),
                    -6px -6px 12px rgba(var(--shadow-light), 0.9);
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Filter by day functionality
        const filterButtons = document.querySelectorAll('.filter-hari');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const selectedDay = this.getAttribute('data-day');
                window.location.href = '{{ route("guru.jadwal") }}?day=' + selectedDay;
            });
        });
    });
    
    function showMaterial(scheduleId) {
        alert('Fitur materi untuk jadwal ID: ' + scheduleId);
    }
    
    function downloadPDF() {
        alert('Fitur unduh PDF akan segera hadir');
    }
</script>
@endsection