@extends('layouts.student')
@section('title', 'Dashboard - Schoolify')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fadeInUp">
    
    <!-- Kolom Kiri (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Welcome Banner -->
        <div class="neo-flat rounded-2xl p-6 sm:p-8 relative overflow-hidden flex items-center justify-between text-white neo-card-hover" style="background: linear-gradient(135deg, #4f46e5, #7e22ce);">
            <div class="z-10 relative">
                <!-- Date Pill (Pressed Neumorphism) -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-3" 
                     style="background: rgba(0, 0, 0, 0.05); box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.2), inset -3px -3px 6px rgba(255, 255, 255, 0.15);">
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-indigo-200"></i>
                    <p class="text-[10px] text-indigo-100 font-bold uppercase tracking-wider">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                
                <h1 class="font-outfit font-extrabold text-2xl sm:text-3xl text-white mb-4">Halo {{ auth()->user()->name }}, siap belajar! 👋</h1>
                
                <!-- Motivation Card (Extruded Neumorphism) -->
                <div class="p-3.5 rounded-xl max-w-md" 
                     style="background: rgba(255, 255, 255, 0.03); box-shadow: 4px 4px 8px rgba(0,0,0,0.15), -4px -4px 8px rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.05);">
                    <p class="text-sm text-indigo-100 leading-relaxed flex items-start gap-2">
                        <span>Mari tingkatkan prestasi dan selesaikan tugasmu hari ini. Tetap semangat dan pantang menyerah!</span>
                    </p>
                </div>
            </div>
            <!-- Illustration Placeholder (Pressed Neumorphism) -->
            <div class="hidden sm:flex items-center justify-center w-28 h-28 rounded-full z-10 relative" 
                 style="background: rgba(0, 0, 0, 0.05); box-shadow: inset 6px 6px 12px rgba(0, 0, 0, 0.25), inset -6px -6px 12px rgba(255, 255, 255, 0.2);">
                <i data-lucide="laptop" class="w-12 h-12 text-white/90 drop-shadow-md"></i>
            </div>
            
            <!-- Decorative background elements -->
            <!-- Large Blurred Glows -->
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute left-0 bottom-0 w-48 h-48 bg-purple-500/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
            
            <!-- Floating Neumorphic Shapes -->
            <div class="absolute right-[20%] top-[-10%] w-24 h-24 rounded-full pointer-events-none opacity-60" 
                 style="background: transparent; box-shadow: 6px 6px 12px rgba(0,0,0,0.2), -6px -6px 12px rgba(255,255,255,0.15);"></div>
            <div class="absolute left-[35%] bottom-[-15%] w-32 h-32 rounded-full pointer-events-none opacity-50" 
                 style="background: transparent; box-shadow: inset 8px 8px 16px rgba(0,0,0,0.2), inset -8px -8px 16px rgba(255,255,255,0.15);"></div>
        </div>

        <!-- Jadwal dan Grafik (Side by Side) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Jadwal Kelas Hari Ini -->
            <div class="neo-flat rounded-2xl p-6 flex flex-col neo-card-hover">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-5 h-5 text-white"></i>
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
                        <div class="neo-pressed rounded-xl p-3 flex items-center gap-3 group hover-glow transition-all">
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
                <a href="{{ route('student.schedule') }}" class="mt-4 block text-center text-xs font-bold text-indigo-600 neo-btn py-2.5 transition-all duration-300">Lihat Semua Jadwal</a>
            </div>

            <!-- Perkembangan Nilai -->
            <div class="neo-flat rounded-2xl p-6 flex flex-col neo-card-hover">
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center">
                            <i data-lucide="bar-chart-2" class="w-5 h-5 text-white"></i>
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
        <div class="neo-flat rounded-2xl p-6 flex flex-col md:flex-row items-start md:items-center justify-between overflow-hidden relative gap-4 neo-card-hover">
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/30 flex-shrink-0">
                    <i data-lucide="bell-ring" class="w-6 h-6 animate-pulse"></i>
                </div>
                <div>
                    <h4 class="font-outfit font-extrabold text-base text-[var(--text-primary)]">Ujian Tengah Semester Semakin Dekat!</h4>
                    <p class="text-xs text-[var(--text-secondary)] mt-0.5">Persiapkan dirimu dan periksa jadwal ujian di mading online.</p>
                </div>
            </div>
            <button class="relative z-10 neo-btn px-5 py-2.5 rounded-xl text-xs font-bold text-indigo-600 transition-all whitespace-nowrap">
                Selengkapnya
            </button>
            <div class="absolute right-0 top-0 w-32 h-32 bg-purple-100 rounded-full blur-2xl opacity-40 -translate-y-1/2 translate-x-1/4"></div>
        </div>

    </div>

    <!-- Kolom Kanan (1/3) -->
    <div class="space-y-6">
        
        <!-- Profil Singkat -->
        <div class="neo-flat rounded-2xl p-6 neo-card-hover">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-500/30 flex items-center justify-center">
                    <i data-lucide="award" class="w-5 h-5 text-white"></i>
                </div>
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Profil Singkat</h3>
            </div>
            
            <div class="space-y-4">
                <div class="neo-pressed rounded-xl p-4 flex items-center gap-4 border border-transparent hover-glow transition-all">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center border border-emerald-200 shadow-sm">
                        <i data-lucide="trending-up" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[var(--text-muted)]">Peringkat Kelas</p>
                        <p class="font-extrabold text-lg text-[var(--text-primary)]">{{ $rank ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="neo-pressed rounded-xl p-4 flex items-center gap-4 border border-transparent hover-glow transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center border border-blue-200 shadow-sm">
                        <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[var(--text-muted)]">Kehadiran</p>
                        <p class="font-extrabold text-lg text-[var(--text-primary)]">{{ $attendancePercentage ?? '100%' }}</p>
                    </div>
                </div>
                
                <a href="{{ route('student.profile') }}" class="block w-full text-indigo-600 neo-btn transition-all duration-300 text-center py-2.5 text-xs font-bold">
                    Lihat Profil Lengkap
                </a>
            </div>
        </div>

        <!-- Tugas Mendesak -->
        <div class="neo-flat rounded-2xl p-6 neo-card-hover">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-red-500 shadow-lg shadow-red-500/30 flex items-center justify-center">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Tugas Mendesak</h3>
                </div>
            </div>
            
            <div class="space-y-3">
                @forelse($urgentAssignments ?? [] as $assignment)
                    <div class="neo-pressed rounded-xl p-4 group border border-transparent hover-glow transition-all">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full shadow-sm {{ ($assignment['is_today'] ?? false) ? 'bg-red-500 shadow-red-500/50 animate-pulse' : 'bg-orange-500 shadow-orange-500/50' }}"></div>
                                <h4 class="font-bold text-sm text-[var(--text-primary)] line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $assignment['subject'] ?? '-' }}</h4>
                            </div>
                        </div>
                        <p class="text-xs font-semibold text-[var(--text-secondary)] mb-3 line-clamp-1">{{ $assignment['title'] ?? 'Tugas' }}</p>
                        <div class="flex items-center justify-between mt-2 pt-3 border-t border-[var(--shadow-dark)]/10">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-indigo-100 text-indigo-700 uppercase tracking-wider border border-indigo-200">
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
                <div class="mt-5">
                    <a href="{{ route('student.assignments') }}" class="block w-full text-indigo-600 neo-btn transition-all duration-300 text-center py-2.5 text-xs font-bold">
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