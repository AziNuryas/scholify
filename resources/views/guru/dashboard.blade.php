@extends('layouts.guru')

@section('page-title', 'Dashboard Guru')
@section('title', 'Dashboard - Scholify Guru')

@section('content')
<div class="space-y-6">
    {{-- Welcome Hero dengan Neumorphism --}}
    <div class="neo-flat p-6 md:p-8 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="neo-pressed rounded-full px-3 py-1">
                        <span class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </div>
                </div>
                <h1 class="font-outfit text-3xl md:text-4xl font-bold text-[var(--text-primary)]">
                    Halo, 
                    <span class="bg-gradient-to-r from-[#4F46E5] to-[#818CF8] bg-clip-text text-transparent">
                        {{ auth()->user()->name ?? 'Guru' }}
                    </span>
                </h1>
                <p class="text-[var(--text-secondary)] mt-2 flex items-center gap-2">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                    Selamat datang kembali! Berikut ringkasan aktivitas akademik Anda hari ini.
                </p>
            </div>
            <div class="neo-flat p-4 rounded-2xl">
                <i data-lucide="graduation-cap" class="w-12 h-12 text-[var(--accent)]"></i>
            </div>
        </div>
        
        <!-- Decorative orbs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-[var(--accent)]/5 rounded-full blur-3xl -z-0"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-[var(--accent-light)]/5 rounded-full blur-2xl -z-0"></div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $stats = [
                ['icon' => 'book-open', 'label' => 'Kelas Aktif', 'value' => '3', 'unit' => 'Kelas', 'trend' => '+8%', 'trend_up' => true, 'color' => 'text-indigo-500'],
                ['icon' => 'clock', 'label' => 'Jam Mengajar', 'value' => '24', 'unit' => 'Jam/Mgg', 'trend' => '+2%', 'trend_up' => true, 'color' => 'text-emerald-500'],
                ['icon' => 'clipboard-list', 'label' => 'Perlu Dinilai', 'value' => '12', 'unit' => 'Tugas', 'trend' => '-3', 'trend_up' => false, 'color' => 'text-amber-500'],
                ['icon' => 'users', 'label' => 'Siswa Binaan', 'value' => '124', 'unit' => 'Siswa', 'trend' => '+5%', 'trend_up' => true, 'color' => 'text-purple-500'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="neo-card p-5 neo-card-hover cursor-pointer group">
            <div class="flex justify-between items-start mb-3">
                <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center group-hover:neo-flat transition-all">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 {{ $stat['color'] }}"></i>
                </div>
                <span class="text-xs font-bold {{ $stat['trend_up'] ? 'text-emerald-500' : 'text-red-500' }} bg-white/30 dark:bg-black/20 px-2 py-1 rounded-full flex items-center gap-0.5">
                    <i data-lucide="{{ $stat['trend_up'] ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>
                    {{ $stat['trend'] }}
                </span>
            </div>
            <p class="text-[var(--text-muted)] text-sm font-medium">{{ $stat['label'] }}</p>
            <div class="flex items-baseline gap-1 mt-1">
                <h3 class="text-3xl font-bold text-[var(--text-primary)]">{{ $stat['value'] }}</h3>
                <span class="text-sm text-[var(--text-muted)]">{{ $stat['unit'] }}</span>
            </div>
            <div class="mt-3 neo-pressed h-1.5 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[var(--accent)] to-[var(--accent-light)] rounded-full" style="width: {{ rand(60, 95) }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Grid 2 Kolom Utama --}}
    <div class="grid grid-cols-12 gap-6">
        
        {{-- Jadwal Mengajar --}}
        <div class="col-span-12 lg:col-span-7">
            <div class="neo-card p-6">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-3">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="calendar-range" class="w-5 h-5 text-[var(--accent)]"></i>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Jadwal Mengajar Hari Ini</h3>
                    </div>
                    <a href="{{ route('guru.jadwal') }}" class="neo-btn px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    @php
                        $schedules = [
                            ['time' => '07:30 - 09:00', 'subject' => 'Matematika', 'class' => 'X IPA 1', 'room' => 'Ruang 01', 'color' => 'indigo'],
                            ['time' => '09:15 - 10:45', 'subject' => 'Fisika', 'class' => 'XI IPA 2', 'room' => 'Lab Fisika', 'color' => 'emerald'],
                            ['time' => '11:00 - 12:30', 'subject' => 'Kalkulus', 'class' => 'XII IPA 1', 'room' => 'Ruang 03', 'color' => 'purple'],
                            ['time' => '13:30 - 15:00', 'subject' => 'Statistika', 'class' => 'XII IPS 2', 'room' => 'Ruang 05', 'color' => 'orange'],
                        ];
                    @endphp

                    @foreach($schedules as $schedule)
                    <div class="group flex items-center gap-4 p-4 rounded-2xl bg-[var(--bg)] hover:neo-flat transition-all duration-300 cursor-pointer">
                        <div class="neo-pressed rounded-xl px-4 py-2 text-center min-w-[100px]">
                            <i data-lucide="clock" class="w-3 h-3 text-[var(--text-muted)] mx-auto mb-1"></i>
                            <span class="text-xs font-bold text-[var(--text-primary)]">{{ $schedule['time'] }}</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                {{ $schedule['subject'] }}
                            </h4>
                            <p class="text-xs text-[var(--text-muted)] flex items-center gap-2 mt-0.5">
                                <span class="flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i> {{ $schedule['class'] }}</span>
                                <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $schedule['room'] }}</span>
                            </p>
                        </div>
                        <div class="neo-btn p-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Ringkasan Kehadiran --}}
        <div class="col-span-12 lg:col-span-5">
            <div class="neo-card p-6 h-full">
                <div class="flex items-center gap-3 mb-5">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Statistik Kehadiran</h3>
                </div>

                @php
                    $attendance = [
                        ['status' => 'Hadir', 'count' => 108, 'icon' => 'check-circle', 'color' => 'emerald', 'percentage' => 87],
                        ['status' => 'Izin', 'count' => 8, 'icon' => 'file-text', 'color' => 'amber', 'percentage' => 6.5],
                        ['status' => 'Sakit', 'count' => 5, 'icon' => 'activity', 'color' => 'blue', 'percentage' => 4],
                        ['status' => 'Alpha', 'count' => 3, 'icon' => 'alert-circle', 'color' => 'red', 'percentage' => 2.5],
                    ];
                @endphp

                <div class="space-y-4">
                    @foreach($attendance as $item)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="flex items-center gap-1.5 text-[var(--text-secondary)]">
                                <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 text-{{ $item['color'] }}-500"></i>
                                <span class="font-medium">{{ $item['status'] }}</span>
                            </span>
                            <span class="text-[var(--text-primary)] font-semibold">{{ $item['count'] }} Siswa</span>
                        </div>
                        <div class="neo-pressed h-2 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $item['color'] }}-500 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 neo-flat p-4 rounded-xl text-center">
                    <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <i data-lucide="trophy" class="w-6 h-6 text-amber-500"></i>
                    </div>
                    <p class="text-xs text-[var(--text-muted)] uppercase tracking-wider mb-1">Total Kehadiran</p>
                    <p class="text-2xl font-bold text-[var(--text-primary)]">92.5%</p>
                    <div class="neo-pressed h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full" style="width: 92.5%"></div>
                    </div>
                    <p class="text-xs text-[var(--text-muted)] mt-2">Dari 124 total siswa</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Grid Baris Kedua --}}
    <div class="grid grid-cols-12 gap-6">
        
        {{-- Tugas Perlu Dinilai --}}
        <div class="col-span-12 lg:col-span-6">
            <div class="neo-card p-6">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-3">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="briefcase" class="w-5 h-5 text-orange-500"></i>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Tugas Perlu Dinilai</h3>
                    </div>
                    <span class="neo-badge-orange px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i> {{ rand(5, 12) }} Tertunda
                    </span>
                </div>

                <div class="space-y-3">
                    @php
                        $assignments = [
                            ['title' => 'Kalkulus Dasar', 'deadline' => 'Besok, 23:59', 'submitted' => 28, 'total' => 32, 'color' => 'orange'],
                            ['title' => 'Eksperimen Gravitasi', 'deadline' => '22 April 2026', 'submitted' => 15, 'total' => 30, 'color' => 'blue'],
                            ['title' => 'Pemrograman Dasar', 'deadline' => '25 April 2026', 'submitted' => 20, 'total' => 28, 'color' => 'emerald'],
                            ['title' => 'Statistika Inferensial', 'deadline' => '28 April 2026', 'submitted' => 10, 'total' => 26, 'color' => 'purple'],
                        ];
                    @endphp

                    @foreach($assignments as $task)
                    <div class="group flex items-center justify-between p-4 rounded-2xl bg-[var(--bg)] hover:neo-flat transition-all cursor-pointer">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                                <i data-lucide="file-text" class="w-4 h-4 text-{{ $task['color'] }}-500"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                    {{ $task['title'] }}
                                </h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-[var(--text-muted)] flex items-center gap-0.5">
                                        <i data-lucide="calendar" class="w-3 h-3"></i> {{ $task['deadline'] }}
                                    </span>
                                    <span class="text-xs text-[var(--text-muted)] flex items-center gap-0.5">
                                        <i data-lucide="users" class="w-3 h-3"></i> {{ $task['submitted'] }}/{{ $task['total'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button class="neo-btn px-4 py-2 rounded-xl text-sm font-semibold opacity-0 group-hover:opacity-100 transition-all">
                            Nilai
                        </button>
                    </div>
                    @endforeach
                </div>

                <button class="w-full mt-5 neo-btn py-3 rounded-xl text-sm font-semibold flex items-center justify-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Buat Tugas Baru
                </button>
            </div>
        </div>

        {{-- Siswa Berprestasi & Peringatan --}}
        <div class="col-span-12 lg:col-span-6">
            <div class="space-y-6">
                {{-- Siswa Berprestasi --}}
                <div class="neo-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="crown" class="w-5 h-5 text-amber-500"></i>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Siswa Berprestasi</h3>
                    </div>

                    <div class="space-y-3">
                        @php
                            $topStudents = [
                                ['name' => 'Ahmad Fauzan', 'score' => 96, 'subject' => 'Matematika', 'avatar' => 'AF', 'trend' => 'up'],
                                ['name' => 'Siti Nurhaliza', 'score' => 94, 'subject' => 'Fisika', 'avatar' => 'SN', 'trend' => 'up'],
                                ['name' => 'Budi Santoso', 'score' => 92, 'subject' => 'Kalkulus', 'avatar' => 'BS', 'trend' => 'stable'],
                                ['name' => 'Dewi Sartika', 'score' => 91, 'subject' => 'Statistika', 'avatar' => 'DS', 'trend' => 'up'],
                            ];
                        @endphp

                        @foreach($topStudents as $student)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:neo-pressed transition-all cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 neo-flat rounded-full flex items-center justify-center font-bold text-[var(--accent)]">
                                    {{ $student['avatar'] }}
                                </div>
                                <div>
                                    <p class="font-semibold text-[var(--text-primary)]">{{ $student['name'] }}</p>
                                    <p class="text-xs text-[var(--text-muted)]">{{ $student['subject'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="neo-pressed px-3 py-1 rounded-lg">
                                    <span class="font-bold text-[var(--accent)]">{{ $student['score'] }}</span>
                                </div>
                                @if($student['trend'] == 'up')
                                <i data-lucide="trending-up" class="w-3 h-3 text-emerald-500 mt-1"></i>
                                @else
                                <i data-lucide="minus" class="w-3 h-3 text-amber-500 mt-1"></i>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pengumuman Terbaru --}}
                <div class="neo-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="megaphone" class="w-5 h-5 text-pink-500"></i>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Pengumuman Terbaru</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3 rounded-xl hover:neo-pressed transition-all cursor-pointer">
                            <div class="flex items-start gap-3">
                                <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="bell" class="w-4 h-4 text-[var(--accent)]"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[var(--text-primary)] text-sm">Rapat Guru</p>
                                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Jum'at, 17 April 2026 pukul 14:00 di Ruang Guru</p>
                                    <span class="text-[10px] text-[var(--text-muted)] mt-1 block">2 jam yang lalu</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 rounded-xl hover:neo-pressed transition-all cursor-pointer">
                            <div class="flex items-start gap-3">
                                <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="calendar" class="w-4 h-4 text-emerald-500"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[var(--text-primary)] text-sm">Ujian Tengah Semester</p>
                                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Dimulai 2 Mei 2026. Persiapkan materi ajar.</p>
                                    <span class="text-[10px] text-[var(--text-muted)] mt-1 block">Kemarin</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-4 neo-btn py-2 rounded-xl text-sm font-semibold">
                        Lihat Semua Pengumuman
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush