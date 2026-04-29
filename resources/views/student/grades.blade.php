@extends('layouts.student')

@section('title', 'Rekap Nilai - Schoolify')

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
    
    /* Table row hover */
    .grade-row {
        transition: all 0.2s ease;
    }
    
    .grade-row:hover {
        background: linear-gradient(90deg, rgba(67, 24, 255, 0.02) 0%, rgba(159, 122, 234, 0.02) 100%);
    }
</style>

<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    <div class="space-y-5">
        
        <!-- Header Section Premium - DIPERBAIKI sama dengan halaman tugas -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">GRADE DASHBOARD</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Rekapitulasi <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Nilai</span></h1>
                <p class="text-[#A3AED0] text-base">Cek pencapaian prestasimu semester ini.</p>
            </div>
            
            <!-- Filter Semester Dropdown Premium -->
            <div class="relative flex-shrink-0">
                <select class="appearance-none bg-white border border-gray-200 text-[#2B3674] font-semibold px-5 py-2.5 pr-10 rounded-xl outline-none cursor-pointer hover:border-[#4318FF]/30 hover:shadow-sm transition-all duration-300">
                    <option>Semester Ganjil 2026/2027</option>
                    <option>Semester Genap 2025/2026</option>
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-4 h-4 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        @if($grades->count() > 0)
            <!-- Tabel Nilai Premium -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <th class="px-4 py-4 font-semibold text-sm text-[#A3AED0] uppercase tracking-wider w-12 text-center">#</th>
                                <th class="px-4 py-4 font-semibold text-sm text-[#A3AED0] uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-4 py-4 font-semibold text-sm text-[#A3AED0] uppercase tracking-wider">Jenis Tugas/Ujian</th>
                                <th class="px-4 py-4 font-semibold text-sm text-[#A3AED0] uppercase tracking-wider text-center">Nilai Akhir</th>
                                <th class="px-4 py-4 font-semibold text-sm text-[#A3AED0] uppercase tracking-wider text-center">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($grades as $idx => $grade)
                            @php
                                $score = $grade->score ?? 0;
                                $predikat = $score >= 90 ? 'A' : ($score >= 80 ? 'B' : ($score >= 70 ? 'C' : ($score >= 60 ? 'D' : 'E')));
                                $scoreColor = $score >= 85 ? 'text-emerald-600' : ($score >= 70 ? 'text-amber-600' : 'text-rose-600');
                                $predikatColor = $score >= 90 ? 'bg-emerald-100 text-emerald-700' : ($score >= 80 ? 'bg-blue-100 text-blue-700' : ($score >= 70 ? 'bg-amber-100 text-amber-700' : ($score >= 60 ? 'bg-orange-100 text-orange-700' : 'bg-rose-100 text-rose-700')));
                            @endphp
                            <tr class="grade-row transition-all duration-200">
                                <td class="px-4 py-4 text-center text-[#A3AED0] font-medium text-sm">{{ $idx + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#4318FF]/10 to-[#9F7AEA]/10 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-[#2B3674]">{{ $grade->subject_name ?? 'Mata Pelajaran' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-[#A3AED0] font-medium">{{ $grade->type ?? 'Ulangan Harian' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center">
                                        <span class="font-outfit font-bold text-2xl {{ $scoreColor }}">
                                            {{ $score }}
                                        </span>
                                        <span class="text-xs text-[#A3AED0] ml-0.5">/100</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold shadow-sm min-w-[50px] {{ $predikatColor }}">
                                        {{ $predikat }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Footer Info -->
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/30">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            <span class="text-xs text-[#A3AED0] font-medium">≥85 (A/B)</span>
                            <div class="w-2 h-2 rounded-full bg-amber-500 ml-2"></div>
                            <span class="text-xs text-[#A3AED0] font-medium">70-84 (C)</span>
                            <div class="w-2 h-2 rounded-full bg-rose-500 ml-2"></div>
                            <span class="text-xs text-[#A3AED0] font-medium">&lt;70 (D/E)</span>
                        </div>
                        <div class="text-xs text-[#A3AED0] font-medium">
                            Sistem Penilaian Kurikulum Merdeka (KKM: 75)
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ringkasan Nilai -->
            @php
                $totalScore = $grades->sum('score');
                $averageScore = $grades->count() > 0 ? round($totalScore / $grades->count(), 1) : 0;
                $highestScore = $grades->max('score');
                $lowestScore = $grades->min('score');
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wide">Rata-rata</p>
                            <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $averageScore }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-blue-600 font-semibold uppercase tracking-wide">Tertinggi</p>
                            <p class="text-2xl font-bold text-blue-700 mt-1">{{ $highestScore }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl p-4 border border-amber-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-amber-600 font-semibold uppercase tracking-wide">Terendah</p>
                            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $lowestScore }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State Premium -->
            <div class="relative rounded-2xl p-16 text-center bg-white border border-gray-100 mt-2 overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#4318FF]/5 to-[#9F7AEA]/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="relative w-24 h-24 mx-auto mb-6">
                        <div class="absolute inset-0 bg-[#4318FF]/10 rounded-full blur-xl opacity-60"></div>
                        <div class="relative w-24 h-24 bg-gradient-to-br from-[#4318FF] to-[#9F7AEA] rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="font-bold text-2xl text-[#2B3674] mb-2">Belum Ada Riwayat Nilai</h2>
                    <p class="text-[#A3AED0] max-w-md mx-auto">Nilai ulangan kamu belum diinput atau masa ujian belum berlangsung.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection