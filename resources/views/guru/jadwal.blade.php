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

    @php
        $currentTime = date('H:i');
        
        $schedules = [
            [
                'id' => 1,
                'time_start' => '07:30',
                'time_end' => '09:00',
                'subject' => 'Matematika Aljabar',
                'class' => '10-IPA 1',
                'room' => 'Ruang 04 - Lt. 2',
                'material' => 'Bab 3: Logaritma',
                'students_count' => 32
            ],
            [
                'id' => 2,
                'time_start' => '09:15',
                'time_end' => '14:45',
                'subject' => 'Fisika Dasar',
                'class' => '11-IPA 2',
                'room' => 'Lab Fisika Utama',
                'material' => 'Hukum Newton II',
                'students_count' => 30
            ],
            [
                'id' => 3,
                'time_start' => '15:00',
                'time_end' => '16:30',
                'subject' => 'Matematika Peminatan',
                'class' => '12-IPA 1',
                'room' => 'Ruang 02 - Lt. 1',
                'material' => 'Turunan Trigonometri',
                'students_count' => 28
            ],
        ];

        function getStatus($start, $end, $current) {
            if ($current >= $start && $current <= $end) return 'ongoing';
            if ($current < $start) return 'upcoming';
            return 'completed';
        }
    @endphp

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
                        <p class="text-2xl font-bold text-[var(--text-primary)]">18 Jam</p>
                    </div>
                </div>
                <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-500"></i>
                </div>
            </div>
        </div>

        {{-- Card Kehadiran Guru --}}
        <div class="neo-card p-5 group">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="user-check" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Kehadiran Guru</p>
                        <p class="text-2xl font-bold text-[var(--text-primary)]">98%</p>
                    </div>
                </div>
                <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-500"></i>
                </div>
            </div>
            <div class="mt-3 neo-pressed h-1.5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full" style="width: 98%"></div>
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
                        <p class="text-xl font-bold text-[var(--text-primary)]">11-IPA 2</p>
                        <p class="text-[11px] text-amber-500 flex items-center gap-1 mt-0.5">
                            <i data-lucide="timer" class="w-3 h-3"></i>
                            15 Menit Lagi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Hari --}}
    <div class="neo-flat p-2 inline-flex rounded-xl">
        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
            <button class="filter-hari neo-btn px-5 py-2 rounded-lg text-xs font-semibold transition-all {{ $loop->first ? 'active' : '' }}">
                {{ $hari }}
            </button>
        @endforeach
    </div>

    {{-- Daftar Jadwal --}}
    <div class="space-y-4" id="scheduleList">
        @forelse($schedules as $item)
            @php $status = getStatus($item['time_start'], $item['time_end'], $currentTime); @endphp
            
            <div class="schedule-card neo-card p-5 transition-all duration-300 hover:neo-pressed group 
                        {{ $status == 'ongoing' ? 'border-l-4 border-l-rose-500' : '' }}"
                 data-status="{{ $status }}">
                <div class="flex flex-wrap md:flex-nowrap gap-5">
                    {{-- Time Column --}}
                    <div class="md:w-32 flex-shrink-0">
                        <div class="neo-pressed rounded-xl px-4 py-2 text-center">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-[var(--text-muted)] mx-auto mb-1"></i>
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ $item['time_start'] }}</p>
                            <p class="text-[10px] text-[var(--text-muted)]">s/d</p>
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ $item['time_end'] }}</p>
                        </div>
                    </div>

                    {{-- Content Column --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                        {{ $item['subject'] }}
                                    </h3>
                                    @if($status == 'ongoing')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-500 text-white animate-pulse">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                            LIVE
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-[var(--text-secondary)]">{{ $item['class'] }} • {{ $item['students_count'] }} Siswa</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                            <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[var(--bg)]">
                                <div class="neo-pressed w-7 h-7 rounded-lg flex items-center justify-center">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Ruangan</p>
                                    <p class="text-xs font-medium text-[var(--text-primary)]">{{ $item['room'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-2.5 rounded-lg bg-[var(--bg)]">
                                <div class="neo-pressed w-7 h-7 rounded-lg flex items-center justify-center">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-[var(--accent)]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Materi</p>
                                    <p class="text-xs font-medium text-[var(--text-primary)]">{{ $item['material'] }}</p>
                                </div>
                            </div>
                        </div>

                        @if($status == 'ongoing')
                            <div class="mt-4 pt-3 border-t border-[var(--shadow-dark)]/10 flex gap-3">
                                <a href="{{ route('guru.absensi') }}" class="neo-btn flex-1 py-2 rounded-lg text-xs font-semibold flex items-center justify-center gap-2">
                                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                                    Buka Absensi
                                </a>
                                <button class="neo-btn px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2">
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
                <p class="text-sm text-[var(--text-muted)] mt-1">Santai dulu, tidak ada jadwal untuk hari ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Tombol Unduh PDF --}}
    <div class="flex justify-center">
        <button class="neo-btn px-6 py-3 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
            <i data-lucide="printer" class="w-4 h-4"></i>
            Unduh Jadwal PDF
        </button>
    </div>
</div>

<style>
    /* Schedule card styles */
    .schedule-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Filter button styles */
    .filter-hari {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--text-secondary);
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
    
    /* Pulse animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
    
    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(var(--shadow-dark), 0.08);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(var(--shadow-dark), 0.2);
        border-radius: 10px;
    }
    
    /* Hover effects */
    .group-hover\:scale-105:hover {
        transform: scale(1.05);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Filter by day functionality (simulasi)
        const filterButtons = document.querySelectorAll('.filter-hari');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // Di sini bisa tambahkan logic filter jadwal berdasarkan hari
            });
        });
    });
</script>
@endsection