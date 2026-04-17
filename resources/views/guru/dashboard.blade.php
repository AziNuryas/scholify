@extends('layouts.guru')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang kembali! Berikut ringkasan aktivitas akademik Anda hari ini.')

@section('content')

{{-- Hero Section --}}
<div class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 rounded-3xl p-8 text-white mb-8 shadow-lg">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="max-w-xl text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-medium uppercase tracking-wider border border-white/20 mb-4">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                <span>Thursday, 16 April 2026</span>
            </div>
            <h2 class="text-4xl font-bold mt-4 leading-tight">
                Halo, 
                <span class="bg-gradient-to-r from-purple-200 to-indigo-200 bg-clip-text text-transparent">
                    Bapak Guru Budi
                </span>
            </h2>
            <p class="mt-3 text-purple-100 text-lg">
                <i data-lucide="book-open" class="inline w-5 h-5 mr-1"></i>
                Anda memiliki <span class="text-white font-semibold">2 jadwal mengajar</span> dan 
                <span class="text-white font-semibold">5 tugas</span> yang perlu dinilai hari ini.
            </p>
        </div>
        <div class="hidden lg:block">
            <div class="bg-white/10 p-5 rounded-2xl backdrop-blur-md border border-white/20">
                <i data-lucide="graduation-cap" class="w-14 h-14 text-purple-200"></i>
            </div>
        </div>
    </div>
    <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-purple-400/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-50%] left-[-5%] w-64 h-64 bg-indigo-400/10 rounded-full blur-3xl"></div>
</div>

{{-- Statistik Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
        $stats = [
            ['book-open', 'Kelas Aktif', '3', 'Kelas', '+8%', 'trending-up', 'bg-blue-50', 'text-blue-600', 'from-blue-400 to-blue-500'],
            ['clock', 'Jam Mengajar', '4', 'Jam', '-2%', 'trending-down', 'bg-amber-50', 'text-amber-600', 'from-amber-400 to-amber-500'],
            ['clipboard-list', 'Perlu Dinilai', '5', 'Tugas', '+12%', 'trending-up', 'bg-emerald-50', 'text-emerald-600', 'from-emerald-400 to-emerald-500'],
            ['users', 'Siswa Binaan', '120', 'Siswa', '+15%', 'trending-up', 'bg-indigo-50', 'text-indigo-600', 'from-indigo-400 to-indigo-500'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
        <div class="flex justify-between items-start mb-3">
            <div class="w-12 h-12 rounded-xl {{ $stat[6] }} flex items-center justify-center">
                <i data-lucide="{{ $stat[0] }}" class="w-6 h-6 {{ $stat[7] }}"></i>
            </div>
            <span class="text-xs font-medium {{ $stat[7] }} {{ $stat[6] }} px-2 py-1 rounded-full flex items-center gap-1">
                <i data-lucide="{{ $stat[5] }}" class="w-3 h-3"></i> {{ $stat[4] }}
            </span>
        </div>
        <p class="text-slate-500 text-sm font-medium">{{ $stat[1] }}</p>
        <div class="flex items-baseline gap-1 mt-1">
            <h3 class="text-3xl font-bold text-slate-800">
                {{ $stat[2] }}
            </h3>
            <span class="text-sm text-slate-400">{{ $stat[3] }}</span>
        </div>
        <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r {{ $stat[8] }} rounded-full" style="width: {{ rand(65, 95) }}%"></div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-12 gap-6">
    
    {{-- Jadwal Mengajar --}}
    <div class="col-span-12 lg:col-span-8 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <i data-lucide="calendar-range" class="w-5 h-5 text-indigo-500"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700">Jadwal Mengajar</h3>
            </div>
            <a href="{{ route('guru.jadwal') }}" class="text-sm font-medium text-indigo-500 hover:text-indigo-600 flex items-center gap-1">
                Selengkapnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="group relative p-5 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:from-purple-500 hover:to-indigo-500 transition-all duration-300 cursor-pointer overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 bg-white/80 rounded-full text-xs font-medium text-indigo-600 group-hover:bg-white/20 group-hover:text-white transition-colors flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i> 07:30 - 09:00
                        </span>
                        <i data-lucide="map-pin" class="w-4 h-4 text-indigo-400 group-hover:text-white/80"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-700 group-hover:text-white mb-1 transition-colors">Matematika</h4>
                    <p class="text-sm text-slate-500 group-hover:text-indigo-100 transition-colors flex items-center gap-1">
                        <i data-lucide="building" class="w-3.5 h-3.5"></i> Kelas 10-IPA 1 • Ruang 01
                    </p>
                </div>
            </div>

            <div class="group relative p-5 rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100 hover:from-purple-500 hover:to-pink-500 transition-all duration-300 cursor-pointer overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 bg-white/80 rounded-full text-xs font-medium text-purple-600 group-hover:bg-white/20 group-hover:text-white transition-colors flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i> 09:15 - 10:45
                        </span>
                        <i data-lucide="map-pin" class="w-4 h-4 text-purple-400 group-hover:text-white/80"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-700 group-hover:text-white mb-1 transition-colors">Fisika Terapan</h4>
                    <p class="text-sm text-slate-500 group-hover:text-purple-100 transition-colors flex items-center gap-1">
                        <i data-lucide="flask-conical" class="w-3.5 h-3.5"></i> Kelas 11-IPA 2 • Lab Fisika
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Kehadiran --}}
    <div class="col-span-12 lg:col-span-4 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <i data-lucide="clipboard-check" class="w-5 h-5 text-emerald-500"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Status Kehadiran</h3>
        </div>
        
        <div class="space-y-5">
            @php
                $absensi = [
                    ['check-circle', 'Hadir', 28, 'bg-emerald-400', 'text-emerald-600'],
                    ['file-text', 'Izin', 5, 'bg-amber-400', 'text-amber-600'],
                    ['activity', 'Sakit', 2, 'bg-blue-400', 'text-blue-600'],
                    ['alert-circle', 'Alpha', 1, 'bg-rose-400', 'text-rose-600'],
                ];
            @endphp

            @foreach($absensi as $item)
            <div>
                <div class="flex justify-between text-sm font-medium mb-2">
                    <span class="flex items-center gap-1.5 {{ $item[4] }}">
                        <i data-lucide="{{ $item[0] }}" class="w-4 h-4"></i>
                        <span>{{ $item[1] }}</span>
                    </span>
                    <span class="text-slate-400">{{ $item[2] }} Siswa</span>
                </div>
                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="{{ $item[3] }} h-full rounded-full transition-all" style="width: {{ ($item[2]/36)*100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6 p-4 rounded-xl bg-purple-50/50 border border-purple-100 text-center">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="trophy" class="w-5 h-5 text-purple-500"></i>
            </div>
            <p class="text-xs text-purple-500 font-medium uppercase tracking-wider mb-1">Total Kapasitas</p>
            <p class="text-xl font-bold text-slate-700">36 Siswa / Kelas</p>
            <p class="text-xs text-slate-400 mt-1 flex items-center justify-center gap-1">
                <i data-lucide="star" class="w-3 h-3 text-amber-400"></i> Tingkat kehadiran 97%
            </p>
        </div>
    </div>

    {{-- Tugas Aktif --}}
    <div class="col-span-12 lg:col-span-6 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i data-lucide="briefcase" class="w-5 h-5 text-orange-500"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700">Tugas Aktif</h3>
            </div>
            <span class="px-3 py-1 bg-rose-50 text-rose-500 text-xs font-medium rounded-full border border-rose-100 flex items-center gap-1">
                <i data-lucide="clock" class="w-3 h-3"></i> 5 Tertunda
            </span>
        </div>
        
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-orange-50/50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-orange-600 transition-colors">Kalkulus Dasar</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="clock" class="w-3 h-3"></i> Target: Besok, 23:59 WIB
                        </p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-orange-400 transition-colors"></i>
            </div>
            
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-blue-50/50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="flask-conical" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">Eksperimen Gravitasi</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="calendar" class="w-3 h-3"></i> Target: 22 April 2026
                        </p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-blue-400 transition-colors"></i>
            </div>

            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-emerald-50/50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i data-lucide="code" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-emerald-600 transition-colors">Pemrograman Dasar</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="calendar" class="w-3 h-3"></i> Target: 25 April 2026
                        </p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-emerald-400 transition-colors"></i>
            </div>
        </div>

        <button class="w-full mt-5 py-3 border-2 border-dashed border-gray-200 rounded-xl text-sm font-medium text-slate-500 hover:bg-gray-50 hover:border-purple-200 hover:text-purple-500 transition-all flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Tugas Baru
        </button>
    </div>

    {{-- Nilai Siswa Terbaru --}}
    <div class="col-span-12 lg:col-span-6 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <i data-lucide="star" class="w-5 h-5 text-amber-500"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Nilai Siswa Terbaru</h3>
        </div>
        
        <div class="divide-y divide-gray-100">
            <div class="py-3 flex items-center justify-between group cursor-pointer hover:bg-gray-50 rounded-lg px-2 transition-all">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=8B5CF6&color=fff&bold=true&length=2&font-size=0.33" class="w-11 h-11 rounded-full border-2 border-white shadow-sm" />
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full border-2 border-white flex items-center justify-center">
                            <i data-lucide="check" class="w-2.5 h-2.5 text-white"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-purple-600 transition-colors">Budi Santoso</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="book-open" class="w-3 h-3"></i> Matematika
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-purple-50 text-purple-600 font-bold px-4 py-1.5 rounded-lg text-lg">
                        85
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-0.5 justify-end">
                        <i data-lucide="star" class="w-3 h-3 text-amber-400"></i> B+
                    </div>
                </div>
            </div>

            <div class="py-3 flex items-center justify-between group cursor-pointer hover:bg-gray-50 rounded-lg px-2 transition-all">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=A855F7&color=fff&bold=true&length=2&font-size=0.33" class="w-11 h-11 rounded-full border-2 border-white shadow-sm" />
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-amber-400 rounded-full border-2 border-white flex items-center justify-center">
                            <i data-lucide="star" class="w-2.5 h-2.5 text-white"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-purple-600 transition-colors">Siti Aminah</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="flask-conical" class="w-3 h-3"></i> Fisika
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-purple-50 text-purple-600 font-bold px-4 py-1.5 rounded-lg text-lg">
                        92
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-0.5 justify-end">
                        <i data-lucide="star" class="w-3 h-3 text-amber-400"></i> A-
                    </div>
                </div>
            </div>

            <div class="py-3 flex items-center justify-between group cursor-pointer hover:bg-gray-50 rounded-lg px-2 transition-all">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Chandra+Wijaya&background=10B981&color=fff&bold=true&length=2&font-size=0.33" class="w-11 h-11 rounded-full border-2 border-white shadow-sm" />
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-400 rounded-full border-2 border-white flex items-center justify-center">
                            <i data-lucide="trending-up" class="w-2.5 h-2.5 text-white"></i>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 group-hover:text-purple-600 transition-colors">Chandra Wijaya</p>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                            <i data-lucide="code" class="w-3 h-3"></i> Pemrograman
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-purple-50 text-purple-600 font-bold px-4 py-1.5 rounded-lg text-lg">
                        78
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-0.5 justify-end">
                        <i data-lucide="star" class="w-3 h-3 text-amber-400"></i> C+
                    </div>
                </div>
            </div>
        </div>

        <button class="w-full mt-5 py-3 bg-purple-500 text-white rounded-xl font-medium hover:bg-purple-600 transition-all flex items-center justify-center gap-2 shadow-sm">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Input Nilai Lainnya
        </button>
    </div>

</div>

@endsection