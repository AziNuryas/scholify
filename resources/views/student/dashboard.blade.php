@extends('layouts.student')
@section('title', 'Dashboard - Schoolify')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fadeInUp">
    
    <!-- Kolom Kiri (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Welcome Banner -->
        <div class="neo-flat rounded-2xl p-6 relative overflow-hidden flex items-center justify-between">
            <div class="z-10 relative">
                <p class="text-xs text-[var(--text-muted)] font-bold mb-1 uppercase tracking-wide">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-2">Halo {{ explode(' ', auth()->user()->name)[0] }}, siap belajar hari ini! 👋</h1>
                <p class="text-sm text-[var(--text-secondary)] max-w-md leading-relaxed">
                    Mari tingkatkan prestasi dan jangan lupa kerjakan tugasmu hari ini. Tetap semangat dan pantang menyerah!
                </p>
            </div>
            <!-- Illustration Placeholder (like the student with laptop in SS) -->
            <div class="hidden sm:flex items-center justify-center w-32 h-32 neo-pressed rounded-full bg-[var(--bg)]/50 z-10">
                <i data-lucide="laptop" class="w-12 h-12 text-indigo-500"></i>
            </div>
            
            <!-- Decorative background elements -->
            <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/4"></div>
        </div>

        <!-- Jadwal dan Grafik (Side by Side) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Jadwal Kelas Hari Ini -->
            <div class="neo-flat rounded-2xl p-6 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 neo-pressed rounded-lg flex items-center justify-center">
                            <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i>
                        </div>
                        <h3 class="font-outfit font-extrabold text-base lg:text-lg text-[var(--text-primary)]">Jadwal Hari Ini</h3>
                    </div>
                </div>
                
                <div class="space-y-4 flex-1">
                    @php
                        $bgColors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-blue-500', 'bg-purple-500'];
                    @endphp
                    @forelse($todaySchedules ?? [] as $index => $schedule)
                        @php
                            $color = $bgColors[$index % count($bgColors)];
                        @endphp
                        <div class="neo-pressed rounded-xl p-3 flex items-center gap-3 group hover:bg-white/40 transition-colors">
                            <div class="text-center min-w-[60px]">
                                <p class="font-extrabold text-xs text-[var(--text-primary)]">{{ $schedule['time'] ?? '-' }}</p>
                            </div>
                            <div class="w-1 h-8 rounded-full {{ $color }} shadow-sm"></div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[var(--text-primary)] truncate group-hover:text-indigo-600 transition-colors">{{ $schedule['subject'] ?? '-' }}</h4>
                                <p class="text-[10px] font-semibold text-[var(--text-secondary)] mt-0.5 truncate">
                                    {{ $schedule['teacher'] ?? '-' }} • R.{{ $schedule['room'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="neo-pressed rounded-xl p-6 text-center h-full flex flex-col justify-center">
                            <div class="w-10 h-10 neo-flat rounded-full flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="coffee" class="w-4 h-4 text-[var(--text-muted)]"></i>
                            </div>
                            <p class="font-bold text-[var(--text-primary)] text-xs">Kosong</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('student.schedule') }}" class="mt-4 block text-center text-xs font-bold text-indigo-500 hover:text-indigo-600 transition-colors neo-btn py-2 rounded-lg">Lihat Semua</a>
            </div>

            <!-- Perkembangan Nilai -->
            <div class="neo-flat rounded-2xl p-6 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 neo-pressed rounded-lg flex items-center justify-center">
                            <i data-lucide="bar-chart-2" class="w-4 h-4 text-emerald-500"></i>
                        </div>
                        <h3 class="font-outfit font-extrabold text-base lg:text-lg text-[var(--text-primary)]">Statistik Belajar</h3>
                    </div>
                </div>
                
                <div class="neo-pressed rounded-xl p-2 flex-1 flex items-center justify-center">
                    <div id="performance-chart" class="w-full" style="min-height: 180px;"></div>
                </div>
            </div>
        </div>

        <!-- Info Card / Pengumuman Bawah -->
        <div class="neo-flat rounded-2xl p-6 flex items-center justify-between overflow-hidden relative">
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
                    <i data-lucide="bell-ring" class="w-6 h-6 animate-pulse"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-extrabold text-base text-[var(--text-primary)]">Ujian Tengah Semester Semakin Dekat!</h4>
                    <p class="text-xs text-[var(--text-secondary)] mt-0.5">Persiapkan dirimu dan periksa jadwal ujian di mading online.</p>
                </div>
            </div>
            <button class="relative z-10 neo-btn px-4 py-2 rounded-lg text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                Selengkapnya
            </button>
            <div class="absolute right-0 top-0 w-32 h-32 bg-purple-100 rounded-full blur-2xl opacity-40 -translate-y-1/2 translate-x-1/4"></div>
        </div>

    </div>

    <!-- Kolom Kanan (1/3) -->
    <div class="space-y-6">
        
        <!-- Profil Singkat -->
        <div class="neo-flat rounded-2xl p-6">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-8 h-8 neo-pressed rounded-lg flex items-center justify-center">
                    <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
                </div>
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Profil Singkat</h3>
            </div>
            
            <div class="space-y-4">
                <div class="neo-pressed rounded-xl p-4 flex items-center gap-4">
                    <div class="w-10 h-10 neo-flat rounded-full flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-4 h-4 text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[var(--text-muted)]">Peringkat Kelas</p>
                        <p class="font-extrabold text-lg text-[var(--text-primary)]">{{ $rank ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="neo-pressed rounded-xl p-4 flex items-center gap-4">
                    <div class="w-10 h-10 neo-flat rounded-full flex items-center justify-center">
                        <i data-lucide="check-square" class="w-4 h-4 text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[var(--text-muted)]">Kehadiran</p>
                        <p class="font-extrabold text-lg text-[var(--text-primary)]">{{ $attendancePercentage ?? '100%' }}</p>
                    </div>
                </div>
                
                <a href="{{ route('student.profile') }}" class="block w-full neo-btn text-center py-2.5 rounded-xl text-xs font-bold text-[var(--text-secondary)] hover:text-indigo-600 transition-colors">
                    Lihat Profil Lengkap
                </a>
            </div>
        </div>

        <!-- Tugas Mendesak -->
        <div class="neo-flat rounded-2xl p-6">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 neo-pressed rounded-lg flex items-center justify-center">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-orange-500"></i>
                    </div>
                    <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Tugas Mendesak</h3>
                </div>
            </div>
            
            <div class="space-y-3">
                @forelse($urgentAssignments ?? [] as $assignment)
                    <div class="neo-pressed rounded-xl p-4 group">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ ($assignment['is_today'] ?? false) ? 'bg-red-500 animate-pulse' : 'bg-orange-400' }}"></div>
                                <h4 class="font-bold text-sm text-[var(--text-primary)] line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $assignment['subject'] ?? '-' }}</h4>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-[var(--text-secondary)] mb-2 line-clamp-1">{{ $assignment['title'] ?? 'Tugas' }}</p>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-[var(--shadow-dark)]/5">
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md neo-flat text-[var(--text-muted)] uppercase tracking-wider">
                                {{ ucfirst($assignment['type'] ?? 'Tugas') }}
                            </span>
                            <span class="text-[10px] font-extrabold flex items-center gap-1 {{ ($assignment['is_today'] ?? false) ? 'text-red-500' : 'text-orange-500' }}">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ $assignment['due_date'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="neo-pressed rounded-xl p-6 text-center">
                        <i data-lucide="check-circle" class="w-8 h-8 text-emerald-400 mx-auto mb-2"></i>
                        <p class="text-sm font-bold text-[var(--text-primary)]">Semua Selesai!</p>
                        <p class="text-xs font-medium text-[var(--text-muted)] mt-1">Tidak ada tugas yang mendesak.</p>
                    </div>
                @endforelse
            </div>
            @if(count($urgentAssignments ?? []) > 0)
                <div class="mt-4">
                    <a href="{{ route('student.assignments') }}" class="block w-full neo-btn text-center py-2.5 rounded-xl text-xs font-bold text-[var(--text-secondary)] hover:text-indigo-600 transition-colors">
                        Lihat Semua Tugas
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{
                name: 'Nilai Rata-rata',
                data: [78, 82, 80, 85, 88, 86, 90] // Dummy data for chart
            }],
            chart: {
                height: 250,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                dropShadow: {
                    enabled: true,
                    top: 4,
                    left: 0,
                    blur: 4,
                    color: '#10b981',
                    opacity: 0.2
                }
            },
            colors: ['#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 600 }
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                labels: {
                    style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 600 }
                }
            },
            grid: {
                borderColor: 'rgba(184, 198, 214, 0.15)',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return val + " Point" } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#performance-chart"), options);
        chart.render();
    });
</script>
@endsection