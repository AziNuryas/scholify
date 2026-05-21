@extends('layouts.guru')

@section('page-title', 'Dashboard Guru')
@section('title', 'Dashboard - Scholify Guru')

@section('content')
<div class="space-y-6">
    {{-- Welcome Hero --}}
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
                    <div class="neo-pressed rounded-full px-4 py-1" style="background: var(--accent); color: white;">
                        <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            <span id="jamDigital" class="font-mono tracking-wider">--:--:--</span>
                            <span class="text-[10px] opacity-80">WIB</span>
                        </span>
                    </div>
                </div>
                <h1 class="font-outfit text-3xl md:text-4xl font-bold text-[var(--text-primary)]">
                    Halo, 
                    <span class="bg-gradient-to-r from-[#4F46E5] to-[#818CF8] bg-clip-text text-transparent">
                        {{ Auth::user()->name ?? 'Guru' }}
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
        <div class="absolute top-0 right-0 w-64 h-64 bg-[var(--accent)]/5 rounded-full blur-3xl -z-0"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-[var(--accent-light)]/5 rounded-full blur-2xl -z-0"></div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Kelas Aktif --}}
        <div class="neo-card p-5 group cursor-pointer transition-all duration-300 hover:scale-105" 
             onclick="window.location.href='{{ route('guru.jadwal') }}'">
            <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <i data-lucide="book-open" class="w-5 h-5 text-indigo-500"></i>
            </div>
            <p class="text-[var(--text-muted)] text-sm font-medium">Kelas Aktif</p>
            <h3 class="text-3xl font-bold text-[var(--text-primary)]">{{ number_format($jumlahKelas ?? 0) }}</h3>
            <span class="text-sm text-[var(--text-muted)]">Kelas</span>
            @if(($jumlahKelas ?? 0) == 0)
            <p class="text-xs text-amber-500 mt-2 flex items-center gap-1">
                <i data-lucide="info" class="w-3 h-3"></i>
                Menunggu input dari admin
            </p>
            @endif
        </div>
        
        {{-- Jam Mengajar --}}
        <div class="neo-card p-5 group cursor-pointer transition-all duration-300 hover:scale-105" 
             onclick="window.location.href='{{ route('guru.jadwal') }}'">
            <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <i data-lucide="clock" class="w-5 h-5 text-emerald-500"></i>
            </div>
            <p class="text-[var(--text-muted)] text-sm font-medium">Jam Mengajar</p>
            <h3 class="text-3xl font-bold text-[var(--text-primary)]">{{ number_format($totalJam ?? 0) }}</h3>
            <span class="text-sm text-[var(--text-muted)]">Jam/Minggu</span>
            @if(($totalJam ?? 0) < 10 && ($totalJam ?? 0) > 0)
            <p class="text-xs text-amber-500 mt-2 flex items-center gap-1">
                <i data-lucide="info" class="w-3 h-3"></i>
                Jadwal masih sedikit, hubungi admin
            </p>
            @elseif(($totalJam ?? 0) == 0)
            <p class="text-xs text-red-500 mt-2 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3 h-3"></i>
                Belum ada jadwal dari admin
            </p>
            @endif
        </div>
        
        {{-- Perlu Dinilai --}}
        <div class="neo-card p-5 group cursor-pointer transition-all duration-300 hover:scale-105" 
             onclick="window.location.href='{{ route('guru.tugas') }}'">
            <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <i data-lucide="clipboard-list" class="w-5 h-5 text-amber-500"></i>
            </div>
            <p class="text-[var(--text-muted)] text-sm font-medium">Perlu Dinilai</p>
            <h3 class="text-3xl font-bold text-[var(--text-primary)]">{{ number_format($tugasPerluDinilai ?? 0) }}</h3>
            <span class="text-sm text-[var(--text-muted)]">Tugas</span>
        </div>
        
        {{-- Siswa Binaan --}}
        <div class="neo-card p-5 group cursor-pointer transition-all duration-300 hover:scale-105" 
             onclick="window.location.href='{{ route('guru.raport') }}'">
            <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                <i data-lucide="users" class="w-5 h-5 text-purple-500"></i>
            </div>
            <p class="text-[var(--text-muted)] text-sm font-medium">Siswa Binaan</p>
            <h3 class="text-3xl font-bold text-[var(--text-primary)]">{{ number_format($totalSiswa ?? 0) }}</h3>
            <span class="text-sm text-[var(--text-muted)]">Siswa</span>
            @if(($totalSiswa ?? 0) == 0)
            <p class="text-xs text-amber-500 mt-2 flex items-center gap-1">
                <i data-lucide="info" class="w-3 h-3"></i>
                Belum ada siswa di kelas ini
            </p>
            @endif
        </div>
    </div>

    {{-- Grid 2 Kolom Utama --}}
    <div class="grid grid-cols-12 gap-6">
        
        {{-- Jadwal Mengajar Hari Ini --}}
        <div class="col-span-12 lg:col-span-7">
            <div class="neo-card p-6">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-3">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="calendar-range" class="w-5 h-5 text-[var(--accent)]"></i>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Jadwal Mengajar Hari Ini</h3>
                    </div>
                    <a href="{{ route('guru.jadwal') }}" class="neo-btn px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                        <span>Lihat Semua</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse(($jadwal ?? [])->take(4) as $item)
                    <div class="group flex items-center gap-4 p-4 rounded-2xl bg-[var(--bg)] hover:neo-flat transition-all duration-300 cursor-pointer"
                         onclick="window.location.href='{{ route('guru.absensi') }}?class_id={{ $item->class_id }}'">
                        <div class="neo-pressed rounded-xl px-4 py-2 text-center min-w-[100px]">
                            <i data-lucide="clock" class="w-3 h-3 text-[var(--text-muted)] mx-auto mb-1"></i>
                            <span class="text-xs font-bold text-[var(--text-primary)]">
                                {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                {{ $item->subject->name ?? 'Mata Pelajaran' }}
                            </h4>
                            <p class="text-xs text-[var(--text-muted)] flex items-center gap-2 mt-0.5">
                                <span class="flex items-center gap-1"><i data-lucide="users" class="w-3 h-3"></i> {{ $item->schoolClass->name ?? 'Kelas' }}</span>
                                <span class="flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $item->room ?? 'Ruang ' . ($item->schoolClass->name ?? '') }}</span>
                            </p>
                        </div>
                        <div class="neo-btn p-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-[var(--text-muted)]">
                        <i data-lucide="calendar-off" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                        <p>Tidak ada jadwal mengajar hari ini.</p>
                        <p class="text-xs mt-1">Silahkan hubungi admin untuk mengisi jadwal mengajar 📅</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Ringkasan Aktivitas Mengajar --}}
        <div class="col-span-12 lg:col-span-5">
            <div class="neo-card p-6 h-full">
                <div class="flex items-center gap-3 mb-5">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="activity" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Aktivitas Hari Ini</h3>
                </div>

                <div class="space-y-4">
                    {{-- Jam Mengajar Hari Ini --}}
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--bg)]">
                        <div class="flex items-center gap-3">
                            <div class="neo-pressed w-10 h-10 rounded-lg flex items-center justify-center">
                                <i data-lucide="clock" class="w-4 h-4 text-emerald-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text-primary)]">Jam Mengajar</p>
                                <p class="text-xs text-[var(--text-muted)]">Total durasi hari ini</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-[var(--accent)]">{{ number_format($totalJamHariIni ?? 0) }}</p>
                            <p class="text-xs text-[var(--text-muted)]">Jam</p>
                        </div>
                    </div>

                    {{-- Kelas yang Diajar --}}
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--bg)]">
                        <div class="flex items-center gap-3">
                            <div class="neo-pressed w-10 h-10 rounded-lg flex items-center justify-center">
                                <i data-lucide="school" class="w-4 h-4 text-purple-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text-primary)]">Kelas yang Diajar</p>
                                <p class="text-xs text-[var(--text-muted)]">Hari ini</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-[var(--accent)]">{{ number_format($jumlahKelasHariIni ?? 0) }}</p>
                            <p class="text-xs text-[var(--text-muted)]">Kelas</p>
                        </div>
                    </div>

                    {{-- Total Pertemuan --}}
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--bg)]">
                        <div class="flex items-center gap-3">
                            <div class="neo-pressed w-10 h-10 rounded-lg flex items-center justify-center">
                                <i data-lucide="book-open" class="w-4 h-4 text-indigo-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text-primary)]">Total Pertemuan</p>
                                <p class="text-xs text-[var(--text-muted)]">Mata pelajaran hari ini</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-[var(--accent)]">{{ number_format($totalPertemuanHariIni ?? 0) }}</p>
                            <p class="text-xs text-[var(--text-muted)]">Pertemuan</p>
                        </div>
                    </div>
                </div>

                {{-- Progress Hari Ini --}}
                @if(($totalJamHariIni ?? 0) > 0)
                <div class="mt-6 neo-flat p-4 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs text-[var(--text-muted)] uppercase tracking-wider">Progress Mengajar Hari Ini</p>
                        <p class="text-xs font-bold text-[var(--accent)]">{{ $progressMengajar ?? 0 }}%</p>
                    </div>
                    <div class="neo-pressed h-2 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full" style="width: {{ $progressMengajar ?? 0 }}%"></div>
                    </div>
                    <p class="text-xs text-[var(--text-muted)] text-center mt-2">
                        @php
                            $jamSelesai = $progressMengajar ?? 0;
                            $jamSelesaiInt = ($jamSelesai * ($totalJamHariIni ?? 0)) / 100;
                        @endphp
                        {{ number_format($jamSelesaiInt, 1) }} dari {{ number_format($totalJamHariIni ?? 0, 1) }} jam selesai
                    </p>
                </div>
                @endif

                {{-- Catatan jika belum ada jadwal --}}
                @if(($totalJamHariIni ?? 0) == 0)
                <div class="mt-6 neo-flat p-4 rounded-xl text-center">
                    <i data-lucide="sun" class="w-8 h-8 mx-auto mb-2 text-amber-500"></i>
                    <p class="text-sm font-medium text-[var(--text-primary)]">Tidak Ada Jadwal Hari Ini</p>
                    <p class="text-xs text-[var(--text-muted)] mt-1">Selamat beristirahat! 🎉</p>
                </div>
                @endif
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
                        <i data-lucide="clock" class="w-3 h-3"></i> 
                        {{ number_format($tugasPerluDinilai ?? 0) }} Tertunda
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse(($tugas ?? [])->take(4) as $task)
                    <div class="group flex items-center justify-between p-4 rounded-2xl bg-[var(--bg)] hover:neo-flat transition-all cursor-pointer"
                         onclick="window.location.href='{{ route('guru.nilai') }}?assignment_id={{ $task->id }}'">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-[var(--text-primary)] group-hover:text-[var(--accent)] transition-colors">
                                    {{ $task->title }}
                                </h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-[var(--text-muted)] flex items-center gap-0.5">
                                        <i data-lucide="calendar" class="w-3 h-3"></i> 
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->locale('id')->isoFormat('D MMM YYYY') : 'Tidak ada deadline' }}
                                    </span>
                                    <span class="text-xs text-[var(--text-muted)] flex items-center gap-0.5">
                                        <i data-lucide="users" class="w-3 h-3"></i> 
                                        {{ number_format($task->submitted_count ?? 0) }}/{{ number_format($task->total_siswa ?? 0) }}
                                    </span>
                                    <span class="text-xs text-[var(--text-muted)] flex items-center gap-0.5">
                                        <i data-lucide="school" class="w-3 h-3"></i>
                                        {{ $task->class_name ?? 'Kelas' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button class="neo-btn px-4 py-2 rounded-xl text-sm font-semibold opacity-0 group-hover:opacity-100 transition-all"
                                onclick="event.stopPropagation(); window.location.href='{{ route('guru.nilai') }}?assignment_id={{ $task->id }}'">
                            Nilai
                        </button>
                    </div>
                    @empty
                    <div class="text-center py-8 text-[var(--text-muted)]">
                        <i data-lucide="check-circle" class="w-12 h-12 mx-auto mb-3 text-emerald-500"></i>
                        <p>Semua tugas sudah dinilai. Bagus!</p>
                        <p class="text-xs mt-1">Pertahankan prestasimu! ✨</p>
                    </div>
                    @endforelse
                </div>

                <a href="{{ route('guru.tugas') }}" class="w-full mt-5 neo-btn py-3 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-all hover:gap-3">
                    Buat Tugas Baru
                </a>
            </div>
        </div>

        {{-- Pengumuman Terbaru (Siswa Berprestasi telah dihapus) --}}
        <div class="col-span-12 lg:col-span-6">
            <div class="neo-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="megaphone" class="w-5 h-5 text-pink-500"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-[var(--text-primary)]">Pengumuman Terbaru</h3>
                </div>

                <div class="space-y-3">
                    @forelse(($pengumumanTerbaru ?? [])->take(5) as $pengumuman)
                    <div class="p-3 rounded-xl hover:neo-pressed transition-all cursor-pointer"
                         onclick="window.location.href='{{ route('guru.pengumuman') }}'">
                        <div class="flex items-start gap-3">
                            <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bell" class="w-4 h-4 text-[var(--accent)]"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-[var(--text-primary)] text-sm">{{ $pengumuman->title }}</p>
                                <p class="text-xs text-[var(--text-muted)] mt-0.5">{{ Str::limit($pengumuman->content, 80) }}</p>
                                <span class="text-[10px] text-[var(--text-muted)] mt-1 block">
                                    {{ \Carbon\Carbon::parse($pengumuman->created_at)->locale('id')->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-[var(--text-muted)]">
                        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                        <p>Tidak ada pengumuman terbaru.</p>
                        <p class="text-xs mt-1">Pengumuman akan muncul di sini 📢</p>
                    </div>
                    @endforelse
                </div>

                <a href="{{ route('guru.pengumuman') }}" class="w-full mt-4 neo-btn py-2 rounded-xl text-sm font-semibold text-center block transition-all hover:gap-2">
                    Lihat Semua Pengumuman
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    // Real Time Clock - Simple and Clean
    (function() {
        function updateDigitalClock() {
            var now = new Date();
            var jam = now.getHours();
            var menit = now.getMinutes();
            var detik = now.getSeconds();
            
            // Format dengan leading zero
            jam = jam < 10 ? '0' + jam : jam;
            menit = menit < 10 ? '0' + menit : menit;
            detik = detik < 10 ? '0' + detik : detik;
            
            var waktu = jam + ':' + menit + ':' + detik;
            
            var element = document.getElementById('jamDigital');
            if (element) {
                element.textContent = waktu;
            }
        }
        
        // Jalankan setiap 1 detik
        updateDigitalClock();
        setInterval(updateDigitalClock, 1000);
    })();
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush