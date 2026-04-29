@extends('layouts.student')

@section('title', 'Jadwal Kelas - Schoolify')

@section('content')
<style>
    /* Font & Base - SAMA DENGAN HALAMAN TUGAS */
    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
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
        background: #F1F5F9;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #DDD6FE;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #A78BFA;
    }
    
    /* Glass card effect */
    .glass-card {
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
    }
    
    /* Schedule item hover */
    .schedule-item {
        transition: all 0.2s ease;
    }
    
    .schedule-item:hover {
        transform: translateX(4px);
        background: linear-gradient(135deg, #EEF2FF 0%, #FFFFFF 100%);
    }
</style>

<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    <div class="space-y-5">
        
        <!-- Header Section Premium -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">SCHEDULE DASHBOARD</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Jadwal <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Kelas Mingguan</span></h1>
                <p class="text-[#A3AED0] text-base">Jadwal pelajarannmu terorganisir di sini.</p>
            </div>
            
            <!-- Tombol Cetak Premium -->
            <button class="group relative bg-white border border-gray-200 text-[#4318FF] font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-gray-50 hover:border-[#4318FF]/30 transition-all duration-300 shadow-sm overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-[#4318FF]/0 to-[#9F7AEA]/0 group-hover:from-[#4318FF]/5 group-hover:to-[#9F7AEA]/5 transition-all duration-500"></div>
                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span class="relative z-10">Cetak Jadwal</span>
            </button>
        </div>

        <!-- Menampilkan Tabel Jika Ada Data -->
        @if($schedulesGrouped->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 mt-2">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                    @php
                        $isToday = (date('N') == array_search($day, ['Senin','Selasa','Rabu','Kamis','Jumat'])+1);
                    @endphp
                    <div class="glass-card rounded-2xl border {{ $isToday ? 'border-[#4318FF]/30 shadow-lg shadow-[#4318FF]/5' : 'border-gray-100' }} bg-white overflow-hidden transition-all duration-300 hover:shadow-xl">
                        <!-- Header Hari -->
                        <div class="px-4 py-3 border-b {{ $isToday ? 'bg-gradient-to-r from-[#4318FF]/5 to-[#9F7AEA]/5 border-[#4318FF]/20' : 'bg-gray-50/50 border-gray-100' }}">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-lg {{ $isToday ? 'text-[#4318FF]' : 'text-[#2B3674]' }}">
                                    {{ $day }}
                                </h3>
                                @if($isToday)
                                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-[#4318FF] text-white shadow-sm">
                                        Hari Ini
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-[#A3AED0] mt-0.5">
                                {{ isset($schedulesGrouped[$day]) ? $schedulesGrouped[$day]->count() : 0 }} Mata Pelajaran
                            </p>
                        </div>

                        <!-- Daftar Jadwal -->
                        <div class="p-3 space-y-3 max-h-[500px] overflow-y-auto custom-scroll">
                            @if(isset($schedulesGrouped[$day]) && $schedulesGrouped[$day]->count() > 0)
                                @foreach($schedulesGrouped[$day] as $sched)
                                    <div class="schedule-item bg-gray-50/50 p-3 rounded-xl border border-gray-100 hover:border-[#4318FF]/20 transition-all duration-200 cursor-pointer">
                                        <!-- Waktu -->
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-[#4318FF]/10 to-[#9F7AEA]/10 flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-bold text-[#4318FF] bg-white px-2 py-0.5 rounded-md shadow-sm border border-indigo-50">
                                                {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}
                                            </span>
                                        </div>
                                        
                                        <!-- Mata Pelajaran -->
                                        <h4 class="font-bold text-sm text-[#2B3674] leading-tight mb-1 line-clamp-1">
                                            {{ $sched->subject->name ?? 'Mata Pelajaran' }}
                                        </h4>
                                        
                                        <!-- Guru -->
                                        <p class="text-xs text-[#A3AED0] flex items-center gap-1 mb-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $sched->teacher->name ?? 'Guru Belum Ada' }}
                                        </p>
                                        
                                        <!-- Ruangan -->
                                        @if($sched->room)
                                        <p class="text-[10px] text-gray-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $sched->room }}
                                        </p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs text-gray-400">Tidak ada jadwal</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Info jumlah jadwal -->
            <div class="mt-6 pt-4 text-center text-sm text-slate-400 border-t border-slate-100">
                <span class="inline-flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Total {{ $schedulesGrouped->sum(function($day) { return $day->count(); }) }} jadwal pelajaran
                </span>
            </div>
        @else
            <!-- Empty State Premium -->
            <div class="relative rounded-2xl p-16 text-center bg-white border border-gray-100 mt-6 overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#4318FF]/5 to-[#9F7AEA]/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="relative w-24 h-24 mx-auto mb-6">
                        <div class="absolute inset-0 bg-[#4318FF]/10 rounded-full blur-xl opacity-60"></div>
                        <div class="relative w-24 h-24 bg-gradient-to-br from-[#4318FF] to-[#9F7AEA] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="font-bold text-2xl text-[#2B3674] mb-2">Jadwal Belum Disusun</h2>
                    <p class="text-[#A3AED0] max-w-md mx-auto">Sistem mendeteksi bahwa admin/guru belum menginput jadwal ke dalam database untuk kelas kamu.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Fungsi untuk cetak jadwal (optional)
    document.querySelectorAll('.group.relative.bg-white').forEach(btn => {
        if(btn.querySelector('span')?.innerText === 'Cetak Jadwal') {
            btn.addEventListener('click', function() {
                window.print();
            });
        }
    });
</script>
@endsection