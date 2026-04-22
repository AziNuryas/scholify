@extends('layouts.student')

@section('title', 'Dashboard Siswa - Schoolify')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Bagian Utama (Kiri 2 Kolom) -->
    <div class="xl:col-span-2 space-y-8">
        
        <!-- Welcome Banner -->
        <div class="neo-flat-blue rounded-[24px] p-8 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -right-16 -bottom-24 w-64 h-64 neo-pressed rounded-full opacity-50"></div>
            <div class="absolute right-32 -top-16 w-32 h-32 neo-pressed rounded-full opacity-50"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="font-medium text-[var(--text-muted)] mb-1">September 14, 2026</p>
                    <h1 class="font-outfit font-bold text-3xl mb-4 text-[var(--brand-secondary)]">Halo {{ explode(' ', $student['name'] ?? 'Siswa')[0] }}, siap belajar hari ini? 🚀</h1>
                    <p class="text-sm text-[var(--text-muted)] max-w-md leading-relaxed">
                        Kamu punya <strong class="text-[#4318FF] neo-pressed px-3 py-1 rounded-lg">{{ count($urgentAssignments) }} tugas</strong> yang harus diselesaikan dalam waktu dekat. Terus pertahankan semangat belajarmu!
                    </p>
                </div>
                <!-- Illustration -->
                <div class="hidden md:flex text-8xl opacity-90 drop-shadow-lg">
                    👨‍💻
                </div>
            </div>
        </div>

        <!-- Section: Jadwal Hari Ini & Nilai -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Jadwal Hari Ini (Vertical Timeline) -->
            <div class="neo-flat rounded-[24px] p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-outfit font-bold text-xl text-[var(--brand-secondary)]">Jadwal Hari Ini</h3>
                    <button class="text-[#4318FF] text-sm font-semibold neo-btn px-4 py-2 rounded-xl">Lihat Semua</button>
                </div>
                
                <div class="relative border-l-2 border-indigo-100 ml-4 space-y-6">
                    @forelse($todaySchedules as $schedule)
                        <div class="relative pl-6">
                            <!-- Timeline Dot -->
                            <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-[var(--bg-main)]
                                @if($schedule['status'] == 'past') bg-gray-300
                                @elseif($schedule['status'] == 'active') neo-badge-blue
                                @else bg-indigo-200 @endif
                            "></span>
                            
                            <p class="text-xs font-bold @if($schedule['status'] == 'active') text-[#4318FF] @else text-[var(--text-muted)] @endif mb-1">
                                {{ $schedule['time'] }} 
                                @if($schedule['status'] == 'active') 
                                    <span class="ml-2 neo-pressed text-[#4318FF] px-2 py-0.5 rounded text-[10px]">Sedang Berlangsung</span> 
                                @endif
                            </p>
                            <div class="@if($schedule['status'] == 'active') neo-pressed @else hover:neo-pressed @endif p-3 rounded-xl transition group cursor-pointer">
                                <h4 class="font-outfit font-bold text-[var(--brand-secondary)] group-hover:text-[#4318FF] transition">{{ $schedule['subject'] }}</h4>
                                <div class="flex items-center gap-4 mt-2 text-sm text-[var(--text-muted)] font-medium">
                                    <span class="flex items-center gap-1"><i class='bx bx-user'></i> {{ $schedule['teacher'] }}</span>
                                    <span class="flex items-center gap-1"><i class='bx bx-map'></i> {{ $schedule['room'] }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-[#A3AED0]">Tidak ada jadwal kelas hari ini 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Perkembangan Nilai -->
            <div class="neo-flat rounded-[24px] p-6 flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-outfit font-bold text-xl text-[var(--brand-secondary)]">Perkembangan Nilai</h3>
                    <div class="neo-pressed text-[#4318FF] px-3 py-1.5 rounded-lg text-xs font-bold">+2.4%</div>
                </div>
                <p class="text-[var(--text-muted)] text-sm font-medium mb-6">Rata-rata 3 bulan terakhir</p>
                
                <!-- Chart Container -->
                <div class="flex-1 w-full min-h-[200px]" id="performance-chart"></div>
            </div>
            
        </div>
    </div>

    <!-- Bagian Kanan (Sidebar/1 Kolom) -->
    <div class="space-y-8">
        
        <!-- Needs Your Attention (Urgent Assignments) -->
        <div class="neo-flat-orange rounded-[24px] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 neo-badge-orange flex items-center justify-center text-white">
                    <i class='bx bx-alarm-exclamation text-2xl'></i>
                </div>
                <div>
                    <h3 class="font-outfit font-bold text-[var(--brand-secondary)]">Perlu Perhatian</h3>
                    <p class="text-xs font-medium text-[var(--text-muted)]">Tugas deadline terdekat</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($urgentAssignments as $assignment)
                    <div class="neo-btn p-4 rounded-xl hover:neo-pressed transition-all duration-300 cursor-pointer">
                        <div class="flex justify-between items-start mb-2">
                            <span class="neo-pressed text-[#4318FF] px-2 py-1 rounded text-[10px] font-bold">{{ $assignment['type'] }}</span>
                            <span class="text-xs font-bold text-red-500 neo-pressed px-2 py-1 rounded">{{ $assignment['due_date'] }}</span>
                        </div>
                        <h4 class="font-outfit font-bold text-[var(--brand-secondary)] mb-1 leading-snug">{{ $assignment['title'] }}</h4>
                        <p class="text-sm font-medium text-[var(--text-muted)]">{{ $assignment['subject'] }}</p>
                    </div>
                @empty
                    <div class="neo-pressed p-4 rounded-xl text-center">
                        <p class="text-green-500 font-bold text-sm">Hore! Tidak ada tugas mendesak.</p>
                    </div>
                @endforelse
            </div>
            
            <button class="w-full mt-6 py-3 neo-btn text-[var(--brand-secondary)] font-bold text-sm transition text-center">
                Lihat Semua Tugas
            </button>
        </div>

        <!-- Pengumuman Terbaru -->
        <div class="neo-flat-purple rounded-[24px] p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 neo-badge-blue flex items-center justify-center text-white">
                    <i class='bx bx-bell text-xl'></i>
                </div>
                <div>
                    <h3 class="font-outfit font-bold text-[var(--brand-secondary)]">Pengumuman Sekolah</h3>
                    <p class="text-xs font-medium text-[var(--text-muted)]">Informasi terbaru untukmu</p>
                </div>
            </div>
            
            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                @if(isset($announcements) && count($announcements) > 0)
                    @foreach($announcements as $ann)
                        <div class="neo-btn p-4 rounded-xl hover:neo-pressed transition-all duration-300 cursor-pointer">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-[var(--brand-secondary)] text-sm leading-tight">{{ $ann->title }}</h4>
                            </div>
                            <p class="text-xs text-[var(--text-muted)] line-clamp-2 mb-2">{{ $ann->content }}</p>
                            <span class="text-[10px] font-bold text-[#4318FF] neo-pressed px-2 py-1 rounded">{{ $ann->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="neo-pressed p-4 rounded-xl text-center">
                        <p class="text-[var(--text-muted)] font-bold text-sm">Tidak ada pengumuman.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Tambahkan ApexCharts JS dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            series: [{
                name: 'Rata-rata Nilai',
                data: [0, 0, 0, 0, 0, 0, 0] // Dummy removed, waiting for real data
            }],
            chart: {
                height: '100%',
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                sparkline: { enabled: false }
            },
            colors: ['#4318FF'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [50, 100, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep'],
                labels: {
                    style: { colors: '#A3AED0', fontSize: '12px' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                show: false
            },
            grid: {
                show: true,
                borderColor: '#E2E8F0',
                strokeDashArray: 4,
                position: 'back',
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#performance-chart"), options);
        chart.render();
    });
</script>
@endsection
