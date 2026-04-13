@extends('layouts.student')

@section('title', 'Dashboard Siswa - Schoolify')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Bagian Utama (Kiri 2 Kolom) -->
    <div class="xl:col-span-2 space-y-8">
        
        <!-- Welcome Banner -->
        <div class="glass-card rounded-[24px] p-8 bg-gradient-to-r from-blue-600 via-indigo-600 to-[#1e1b4b] overflow-hidden relative shadow-2xl shadow-indigo-200">
            <!-- Decorative circle -->
            <div class="absolute -right-16 -bottom-24 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-32 -top-16 w-32 h-32 bg-white/20 rounded-full blur-xl"></div>
            
            <div class="relative z-10 flex items-center justify-between">
                <div class="text-white">
                    <p class="font-medium text-white/80 mb-1">September 14, 2026</p>
                    <h1 class="font-outfit font-bold text-3xl mb-4">Siap untuk belajar hari ini? 🚀</h1>
                    <p class="text-sm text-indigo-100 max-w-md leading-relaxed">
                        Kamu punya <strong class="text-white bg-white/20 px-2 py-0.5 rounded-md">{{ count($urgentAssignments) }} tugas</strong> yang harus diselesaikan dalam waktu dekat. Terus pertahankan semangat belajarmu!
                    </p>
                </div>
                <!-- Illustration (Optional if you have svg, we use emoji for now) -->
                <div class="hidden md:flex text-8xl opacity-90 drop-shadow-lg">
                    👨‍💻
                </div>
            </div>
        </div>

        <!-- Section: Jadwal Hari Ini & Nilai -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Jadwal Hari Ini (Vertical Timeline) -->
            <div class="glass-card rounded-[24px] p-6 bg-white shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-outfit font-bold text-xl text-[#2B3674]">Jadwal Hari Ini</h3>
                    <button class="text-[#4318FF] text-sm font-semibold hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition">Lihat Semua</button>
                </div>
                
                <div class="relative border-l-2 border-indigo-100 ml-4 space-y-6">
                    @forelse($todaySchedules as $schedule)
                        <div class="relative pl-6">
                            <!-- Timeline Dot -->
                            <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white shadow-sm
                                @if($schedule['status'] == 'past') bg-gray-300
                                @elseif($schedule['status'] == 'active') bg-[#4318FF] ring-4 ring-indigo-100
                                @else bg-indigo-200 @endif
                            "></span>
                            
                            <p class="text-xs font-bold @if($schedule['status'] == 'active') text-[#4318FF] @else text-[#A3AED0] @endif mb-1">
                                {{ $schedule['time'] }} 
                                @if($schedule['status'] == 'active') 
                                    <span class="ml-2 bg-[#4318FF]/10 text-[#4318FF] px-2 py-0.5 rounded text-[10px]">Sedang Berlangsung</span> 
                                @endif
                            </p>
                            <div class="@if($schedule['status'] == 'active') bg-[#F4F7FE] @endif p-3 rounded-xl transition hover:bg-gray-50 group cursor-pointer">
                                <h4 class="font-outfit font-bold text-[#2B3674] group-hover:text-[#4318FF] transition">{{ $schedule['subject'] }}</h4>
                                <div class="flex items-center gap-4 mt-2 text-sm text-[#A3AED0] font-medium">
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
            <div class="glass-card rounded-[24px] p-6 bg-white shadow-sm border border-gray-100 flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-outfit font-bold text-xl text-[#2B3674]">Perkembangan Nilai</h3>
                    <div class="bg-green-100 text-green-600 px-2 py-1 rounded-md text-xs font-bold">+2.4%</div>
                </div>
                <p class="text-[#A3AED0] text-sm font-medium mb-6">Rata-rata 3 bulan terakhir</p>
                
                <!-- Chart Container -->
                <div class="flex-1 w-full min-h-[200px]" id="performance-chart"></div>
            </div>
            
        </div>
    </div>

    <!-- Bagian Kanan (Sidebar/1 Kolom) -->
    <div class="space-y-8">
        
        <!-- Needs Your Attention (Urgent Assignments) -->
        <div class="glass-card rounded-[24px] p-6 bg-[#FFF9F2] shadow-sm border border-orange-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                    <i class='bx bx-alarm-exclamation text-2xl'></i>
                </div>
                <div>
                    <h3 class="font-outfit font-bold text-[#2B3674]">Perlu Perhatian</h3>
                    <p class="text-xs font-medium text-[#A3AED0]">Tugas deadline terdekat</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($urgentAssignments as $assignment)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-orange-50 hover:-translate-y-1 transition-transform duration-300 cursor-pointer">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-indigo-50 text-[#4318FF] px-2 py-1 rounded text-[10px] font-bold">{{ $assignment['type'] }}</span>
                            <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded">{{ $assignment['due_date'] }}</span>
                        </div>
                        <h4 class="font-outfit font-bold text-[#2B3674] mb-1 leading-snug">{{ $assignment['title'] }}</h4>
                        <p class="text-sm font-medium text-[#A3AED0]">{{ $assignment['subject'] }}</p>
                    </div>
                @empty
                    <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                        <p class="text-green-500 font-bold text-sm">Hore! Tidak ada tugas mendesak.</p>
                    </div>
                @endforelse
            </div>
            
            <button class="w-full mt-6 py-2.5 bg-white border border-gray-200 text-[#2B3674] font-bold text-sm rounded-xl hover:bg-gray-50 transition">
                Lihat Semua Tugas
            </button>
        </div>

        <!-- Quick Info / Storage / SPP -->
        <div class="glass-card rounded-[24px] p-6 bg-white shadow-sm border border-gray-100">
            <h3 class="font-outfit font-bold text-[#2B3674] mb-4">Informasi Tagihan</h3>
            
            <div class="flex items-center justify-between p-4 bg-[#F4F7FE] rounded-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                        <i class='bx bx-check-shield text-xl'></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#2B3674] text-sm">SPP Bulan Ini</h4>
                        <p class="text-xs text-[#A3AED0]">Lunas (September)</p>
                    </div>
                </div>
                <button class="text-[#4318FF] text-xl rounded-full hover:bg-indigo-100 p-2 transition"><i class='bx bx-chevron-right'></i></button>
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
                data: [75, 78, 85, 82, 90, 88, 92]
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
