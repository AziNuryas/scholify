@extends('layouts.student')

@section('title', 'Absensi Siswa - Schoolify')

@section('content')
<style>
    /* Font & Base - SAMA DENGAN HALAMAN LAIN */
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
    
    /* Table row hover */
    .attendance-row {
        transition: all 0.2s ease;
    }
    
    .attendance-row:hover {
        background: linear-gradient(90deg, rgba(67, 24, 255, 0.02) 0%, rgba(159, 122, 234, 0.02) 100%);
    }
</style>

<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    <div class="space-y-5">
        
        <!-- Header Section Premium - DIPERBAIKI font size sama dengan halaman tugas -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">ATTENDANCE DASHBOARD</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Kehadiran <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Siswa</span></h1>
                <p class="text-[#A3AED0] text-base">Rekam dan pantau kehadiran Anda setiap hari</p>
            </div>
            
            <!-- Semester Info -->
            <div class="relative flex-shrink-0">
                <div class="bg-white border border-gray-200 px-5 py-2.5 rounded-xl shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-[#2B3674]">Semester Ganjil 2025/2026</span>
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        @if($studentData ?? false)
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#4318FF] to-[#9F7AEA] flex items-center justify-center text-white font-bold text-xl shadow-md">
                    {{ substr($studentData->name ?? $studentData->first_name ?? 'S', 0, 1) }}
                </div>
                <div>
                    <h2 class="font-bold text-lg text-[#2B3674]">{{ $studentData->name ?? $studentData->first_name ?? 'Siswa' }}</h2>
                    <div class="flex flex-wrap gap-3 mt-1 text-sm text-[#A3AED0]">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            {{ $studentData->schoolClass->name ?? $studentData->class_id ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0h4"></path>
                            </svg>
                            NIS: {{ $studentData->nisn ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Statistics Cards Premium -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[#A3AED0] text-xs font-semibold uppercase tracking-wide">Hadir</p>
                        <p class="text-3xl font-bold text-[#2B3674] mt-1">{{ $statistik['hadir'] ?? 0 }}</p>
                    </div>
                    <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-amber-200 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[#A3AED0] text-xs font-semibold uppercase tracking-wide">Izin</p>
                        <p class="text-3xl font-bold text-[#2B3674] mt-1">{{ $statistik['izin'] ?? 0 }}</p>
                    </div>
                    <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[#A3AED0] text-xs font-semibold uppercase tracking-wide">Sakit</p>
                        <p class="text-3xl font-bold text-[#2B3674] mt-1">{{ $statistik['sakit'] ?? 0 }}</p>
                    </div>
                    <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="group bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-rose-200 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[#A3AED0] text-xs font-semibold uppercase tracking-wide">Alpha</p>
                        <p class="text-3xl font-bold text-[#2B3674] mt-1">{{ $statistik['alpha'] ?? 0 }}</p>
                    </div>
                    <div class="w-11 h-11 bg-rose-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Attendance Premium -->
        @if($studentData ?? false)
            @if($todayAbsen)
                <div class="bg-gradient-to-r from-emerald-50 to-white border border-emerald-100 rounded-2xl p-4 animate-slideInRight">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-emerald-800 text-base">Sudah Absen Hari Ini</p>
                                <p class="text-sm text-emerald-700 mt-0.5">
                                    Status: <span class="font-semibold">{{ ucfirst($todayAbsen->status) }}</span>
                                    @if($todayAbsen->keterangan) 
                                        • {{ $todayAbsen->keterangan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right text-sm text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ now()->locale('id')->isoFormat('dddd, D MMM') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] rounded-2xl p-5 shadow-lg animate-slideInRight">
                    <div class="flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                                </svg>
                            </div>
                            <div class="text-white">
                                <h3 class="text-base font-bold">Absensi Hari Ini</h3>
                                <p class="text-white/80 text-sm mt-0.5">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                            </div>
                        </div>
                        
                        <button onclick="openAbsensiModal()" class="bg-white text-[#4318FF] px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Rekam Kehadiran</span>
                        </button>
                    </div>
                </div>
            @endif
        @endif

        <!-- History Table Premium -->
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
            <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3">
                <div>
                    <h3 class="font-outfit font-bold text-lg text-[#2B3674]">Riwayat Kehadiran</h3>
                    <p class="text-sm text-[#A3AED0] mt-0.5">Data absensi selama periode belajar</p>
                </div>
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchAttendance" placeholder="Cari tanggal..." class="pl-9 pr-3 py-2 border border-gray-100 rounded-lg text-sm focus:outline-none focus:border-[#4318FF] focus:ring-1 focus:ring-[#4318FF]/20 w-48">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase tracking-wider">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase tracking-wider">Hari</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($absensi as $item)
                        @php
                            $statusConfig = [
                                'hadir' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'M9 12l2 2 4-4'],
                                'izin' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                'sakit' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                'alpha' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'icon' => 'M6 18L18 6M6 6l12 12'],
                            ];
                            $config = $statusConfig[$item->status] ?? $statusConfig['alpha'];
                        @endphp
                        <tr class="attendance-row transition-all duration-200">
                            <td class="px-5 py-3 text-sm font-semibold text-[#2B3674]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-5 py-3 text-sm text-[#A3AED0]">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                    </svg>
                                    <span>{{ ucfirst($item->status) }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-[#A3AED0]">{{ $item->keterangan ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center mb-3">
                                        <svg class="w-7 h-7 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-[#A3AED0] font-medium">Belum Ada Data Absensi</p>
                                    <p class="text-sm text-[#A3AED0] mt-1">Lakukan absensi hari ini untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($absensi, 'links') && $absensi->hasPages())
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/30">
                {{ $absensi->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Absensi Premium -->
<div id="absensiModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md transform transition-all scale-95 opacity-0 animate-modal-in shadow-2xl overflow-hidden">
        <form action="{{ route('student.absensi.store') }}" method="POST">
            @csrf
            <div class="relative bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] px-5 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-white">Rekam Kehadiran</h3>
                        <p class="text-white/80 text-sm mt-0.5">Isi form di bawah ini</p>
                    </div>
                    <button type="button" onclick="closeAbsensiModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-white/80 hover:text-white hover:bg-white/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <svg class="w-4 h-4 inline mr-2 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#4318FF] focus:ring-1 focus:ring-[#4318FF]/20 bg-gray-50" readonly>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <svg class="w-4 h-4 inline mr-2 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status Kehadiran
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-emerald-50 transition-all duration-200 text-sm has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="status" value="hadir" required class="accent-emerald-500"> 
                            <span><span class="text-emerald-600">✓</span> Hadir</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition-all duration-200 text-sm has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                            <input type="radio" name="status" value="izin" class="accent-amber-500"> 
                            <span><span class="text-amber-600">📋</span> Izin</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 transition-all duration-200 text-sm has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="status" value="sakit" class="accent-blue-500"> 
                            <span><span class="text-blue-600">🤒</span> Sakit</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-rose-50 transition-all duration-200 text-sm has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                            <input type="radio" name="status" value="alpha" class="accent-rose-500"> 
                            <span><span class="text-rose-600">✗</span> Alpha</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <svg class="w-4 h-4 inline mr-2 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Keterangan
                        <span class="text-xs text-[#A3AED0] font-normal ml-1">(Opsional)</span>
                    </label>
                    <textarea name="keterangan" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#4318FF] focus:ring-1 focus:ring-[#4318FF]/20 resize-none" placeholder="Contoh: Terlambat 15 menit, ada keperluan keluarga, sakit dengan surat dokter..."></textarea>
                </div>
            </div>
            
            <div class="p-5 border-t border-gray-100 bg-gray-50/30 flex gap-3">
                <button type="button" onclick="closeAbsensiModal()" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-[#A3AED0] font-semibold hover:bg-gray-100 transition-all duration-200">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] text-white rounded-xl text-sm font-semibold hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-modal-in {
        animation: modal-in 0.2s ease-out forwards;
    }
</style>

<script>
function openAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        const modalContent = document.querySelector('#absensiModal .bg-white');
        if(modalContent) modalContent.classList.add('animate-modal-in');
    }, 10);
}

function closeAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    const modalContent = document.querySelector('#absensiModal .bg-white');
    if(modalContent) modalContent.classList.remove('animate-modal-in');
}

document.getElementById('absensiModal')?.addEventListener('click', function(e) {
    if(e.target === this) closeAbsensiModal();
});

document.getElementById('searchAttendance')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const dateCell = row.querySelector('td:first-child');
        if(dateCell && dateCell.textContent.toLowerCase().includes(searchTerm)) {
            row.style.display = '';
        } else if(dateCell && searchTerm === '') {
            row.style.display = '';
        } else if(dateCell) {
            row.style.display = 'none';
        }
    });
});

document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape' && document.getElementById('absensiModal').style.display === 'flex') {
        closeAbsensiModal();
    }
});
</script>

@if(session('success'))
<script>
    setTimeout(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-white animate-fadeIn bg-emerald-500';
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm">Berhasil!</p>
                <p class="text-xs opacity-90">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-3 text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }, 100);
</script>
@endif

@if(session('error'))
<script>
    setTimeout(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-white animate-fadeIn bg-rose-500';
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm">Gagal!</p>
                <p class="text-xs opacity-90">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-3 text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }, 100);
</script>
@endif
@endsection