@extends('layouts.student')

@section('title', 'Dashboard Siswa - Schoolify')

@section('content')
<style>
    /* Custom animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
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
    
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.5s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    /* Card hover effects */
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -12px rgba(67, 24, 255, 0.15);
    }
    
    /* Task item hover */
    .task-item {
        transition: all 0.25s ease;
    }
    
    .task-item:hover {
        transform: translateX(4px);
        background: linear-gradient(135deg, rgba(67, 24, 255, 0.05), rgba(139, 92, 246, 0.05));
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
        background: #C7D2FE;
        border-radius: 10px;
    }
    
    /* Badge styles */
    .badge {
        font-size: 0.6875rem;
        font-weight: 500;
        padding: 0.25rem 0.625rem;
        border-radius: 0.5rem;
        letter-spacing: -0.01em;
    }
</style>

<div class="space-y-6">
    
    <!-- Welcome Banner Premium -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-2xl p-6 text-white shadow-xl animate-fadeInUp">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-6 bg-white/40 rounded-full"></div>
                    <p class="text-sm font-semibold text-white/80">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
                <h1 class="font-outfit font-bold text-2xl md:text-3xl mb-2">Halo, <span class="text-yellow-300">{{ $student['name'] ?? 'Siswa' }}!</span></h1>
                <p class="text-white/80 text-sm max-w-md">
                    Kamu punya <strong class="text-yellow-300 bg-white/20 px-2 py-0.5 rounded-md">{{ count($urgentAssignments ?? []) }} tugas</strong> yang harus diselesaikan dalam waktu dekat. Semangat belajarnya!
                </p>
            </div>
            <div class="hidden md:block">
                <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KIRI: Jadwal Hari Ini & Perkembangan Nilai -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Stat Cards Ringkas -->
            <div class="grid grid-cols-3 gap-4 animate-fadeInUp">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Tugas</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $totalAssignments ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Selesai</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ $completedAssignments ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Rata-rata Nilai</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $averageGrade ?? 85 }}<span class="text-sm">/100</span></p>
                        </div>
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Jadwal Hari Ini -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden animate-slideInLeft">
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-outfit font-bold text-slate-800">Jadwal Hari Ini</h3>
                    </div>
                    <button class="text-indigo-600 text-xs font-semibold hover:text-indigo-700 transition-colors">Lihat Semua</button>
                </div>
                
                <div class="divide-y divide-slate-100 max-h-[320px] overflow-y-auto custom-scroll">
                    @forelse($todaySchedules ?? [] as $schedule)
                        <div class="p-4 hover:bg-slate-50 transition-all {{ ($schedule['status'] ?? '') == 'active' ? 'bg-indigo-50/30' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="min-w-[80px]">
                                    <p class="font-bold text-slate-700 text-sm">{{ $schedule['time'] ?? '-' }}</p>
                                    @if(($schedule['status'] ?? '') == 'active')
                                        <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded-full">Sedang Berlangsung</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-slate-800">{{ $schedule['subject'] ?? '-' }}</h4>
                                    <div class="flex items-center gap-3 text-xs text-slate-500 mt-1">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $schedule['teacher'] ?? '-' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $schedule['room'] ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                @if(($schedule['status'] ?? '') == 'active')
                                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all">Masuk Kelas</button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-slate-500 text-sm">Tidak ada jadwal kelas hari ini</p>
                            <p class="text-slate-400 text-xs mt-1">Selamat beristirahat!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Perkembangan Nilai -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden animate-slideInLeft">
                <div class="px-5 py-4 border-b border-slate-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="font-outfit font-bold text-slate-800">Perkembangan Nilai</h3>
                        </div>
                        <div class="bg-emerald-100 text-emerald-600 px-2 py-1 rounded-md text-xs font-bold">+2.4%</div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 ml-10">Rata-rata 3 bulan terakhir</p>
                </div>
                <div class="p-4">
                    <div id="performance-chart" class="w-full h-[280px]"></div>
                </div>
            </div>
        </div>

        <!-- KANAN: Perlu Perhatian & Informasi Lainnya -->
        <div class="space-y-6">
            
            <!-- Perlu Perhatian - Tugas Deadline Terdekat -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl shadow-sm border border-orange-100 overflow-hidden animate-slideInRight">
                <div class="px-5 py-4 border-b border-orange-100 bg-orange-100/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-slate-800 text-lg">Perlu Perhatian</h3>
                            <p class="text-xs text-orange-600 font-medium">Tugas dengan deadline terdekat</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 space-y-3 max-h-[400px] overflow-y-auto custom-scroll">
                    @forelse($urgentAssignments ?? [] as $assignment)
                        <div class="task-item bg-white rounded-xl p-4 shadow-sm border-l-4 
                            @if(($assignment['is_today'] ?? false)) border-red-500 
                            @elseif(($assignment['is_urgent'] ?? false)) border-orange-500 
                            @else border-transparent @endif
                            hover:shadow-md transition-all cursor-pointer">
                            
                            <div class="flex justify-between items-start mb-2">
                                <span class="badge 
                                    @if(($assignment['type'] ?? '') == 'tugas') bg-sky-100 text-sky-700
                                    @elseif(($assignment['type'] ?? '') == 'ujian') bg-rose-100 text-rose-600
                                    @else bg-purple-100 text-purple-600 @endif">
                                    {{ ucfirst($assignment['type'] ?? 'tugas') }}
                                </span>
                                <div class="text-right">
                                    <span class="text-xs font-bold 
                                        @if(($assignment['is_today'] ?? false)) text-red-600 
                                        @elseif(($assignment['is_urgent'] ?? false)) text-orange-600 
                                        @else text-slate-500 @endif">
                                        {{ $assignment['due_date'] ?? 'Tidak ada deadline' }}
                                    </span>
                                    @if(($assignment['is_today'] ?? false))
                                        <span class="block text-[10px] text-red-500 font-semibold mt-0.5">Deadline Hari Ini!</span>
                                    @elseif(($assignment['is_urgent'] ?? false))
                                        <span class="block text-[10px] text-orange-500 font-semibold mt-0.5">Segera!</span>
                                    @endif
                                </div>
                            </div>
                            
                            <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $assignment['title'] ?? 'Tugas Baru' }}</h4>
                            
                            <div class="flex items-center gap-3 text-xs text-slate-500 mt-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $assignment['subject'] ?? 'Mata Pelajaran' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $assignment['teacher'] ?? 'Guru Mapel' }}
                                </span>
                            </div>
                            
                            <div class="mt-3 pt-2 border-t border-slate-100">
                                <button class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Kumpulkan Sekarang
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl p-6 text-center">
                            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-emerald-600 font-bold text-sm">Hore! Tidak ada tugas mendesak.</p>
                            <p class="text-slate-400 text-xs mt-1">Semua tugas sudah selesai tepat waktu</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="px-5 py-3 border-t border-orange-100 bg-orange-50/50">
                    <button class="w-full bg-white border border-orange-200 text-slate-700 font-semibold text-sm py-2 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Lihat Semua Tugas
                    </button>
                </div>
            </div>

            <!-- Informasi Tagihan -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden dashboard-card">
                <div class="px-5 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-outfit font-bold text-slate-800">Informasi Tagihan</h3>
                    </div>
                </div>
                
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">SPP Bulan Ini</h4>
                                <p class="text-xs text-emerald-600 font-medium">Lunas (September 2026)</p>
                            </div>
                        </div>
                        <button class="text-indigo-500 hover:text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Tagihan Lainnya</h4>
                                <p class="text-xs text-amber-600 font-medium">Belum ada tagihan</p>
                            </div>
                        </div>
                        <button class="text-indigo-500 hover:text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Motivasi Quote -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl p-4 text-white shadow-md dashboard-card">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <div>
                        <p class="text-xs font-semibold text-white/80">Motivasi Hari Ini</p>
                        <p class="text-sm font-medium">"Jangan menunggu sempurna untuk memulai, mulailah dari sekarang!"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            series: [{
                name: 'Rata-rata Nilai',
                data: [75, 78, 85, 82, 90, 88, 92]
            }],
            chart: {
                height: 280,
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                sparkline: { enabled: false }
            },
            colors: ['#6366F1'],
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
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: ['Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep'],
                labels: {
                    style: { colors: '#A3AED0', fontSize: '11px' }
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
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(value) {
                        return value + ' poin';
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#performance-chart"), options);
        chart.render();
    });
</script>
@endsection