@extends('layouts.guru')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang kembali! Berikut ringkasan aktivitas akademik Anda hari ini.')

@section('content')

<div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-10 text-white mb-10 shadow-2xl shadow-indigo-100">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="max-w-xl text-center md:text-left">
            <span class="bg-indigo-500/20 text-indigo-300 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest border border-indigo-500/30">
                {{ date('l, d F Y') }}
            </span>
            <h2 class="text-4xl font-heading font-bold mt-6 leading-tight">
                Halo, <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-300 to-purple-300">Guru {{ auth()->user()->name }}!</span>
            </h2>
            <p class="mt-3 text-slate-400">
                Anda memiliki <span class="text-white font-bold">2 jadwal mengajar</span> dan <span class="text-white font-bold">5 tugas</span> yang perlu dinilai hari ini.
            </p>
        </div>
        <div class="hidden lg:block">
            <div class="bg-white/10 p-4 rounded-3xl backdrop-blur-md border border-white/10">
                <i data-lucide="sparkles" class="w-12 h-12 text-indigo-400 animate-pulse"></i>
            </div>
        </div>
    </div>
    <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-[-50%] left-[-5%] w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    @php
        $stats = [
            ['Kelas Aktif', '3', 'book-open', 'from-blue-500 to-indigo-500', 'Kelas'],
            ['Jam Mengajar', '4', 'clock', 'from-indigo-500 to-purple-500', 'Jam'],
            ['Perlu Dinilai', '5', 'alert-circle', 'from-orange-500 to-red-500', 'Tugas'],
            ['Siswa Binaan', '120', 'users', 'from-emerald-500 to-teal-500', 'Siswa'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="glass-card p-6 rounded-[2rem] border border-white/50">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-2xl bg-indigo-50/50">
                <i data-lucide="{{ $stat[2] }}" class="w-6 h-6 text-indigo-600"></i>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Trend</span>
                <span class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> +12%
                </span>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-medium">{{ $stat[0] }}</p>
        <h3 class="text-3xl font-heading font-bold mt-1 bg-clip-text text-transparent bg-gradient-to-br {{ $stat[3] }}">
            {{ $stat[1] }} <span class="text-sm font-bold text-slate-400">{{ $stat[4] }}</span>
        </h3>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-12 gap-8">
    
    <div class="col-span-12 lg:col-span-8 glass-card p-8 rounded-[2.5rem]">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar-range" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-heading font-bold text-slate-800">Jadwal Mengajar</h3>
            </div>
            <a href="{{ route('guru.jadwal') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-2">
                Selengkapnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="group relative p-6 rounded-3xl bg-indigo-50/40 border border-indigo-100/50 hover:bg-indigo-600 transition-all duration-500 overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-white rounded-full text-[10px] font-bold text-indigo-600 uppercase group-hover:bg-indigo-500 group-hover:text-white transition-colors">07:30 - 09:00</span>
                        <div class="w-8 h-8 rounded-full bg-white/50 flex items-center justify-center group-hover:bg-indigo-500 transition-colors">
                            <i data-lucide="map-pin" class="w-4 h-4 text-indigo-600 group-hover:text-white"></i>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 group-hover:text-white mb-1 transition-colors">Matematika</h4>
                    <p class="text-sm text-slate-500 group-hover:text-indigo-100 transition-colors">Kelas 10-IPA 1 • Ruang 01</p>
                </div>
            </div>

            <div class="group relative p-6 rounded-3xl bg-purple-50/40 border border-purple-100/50 hover:bg-purple-600 transition-all duration-500 overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-white rounded-full text-[10px] font-bold text-purple-600 uppercase group-hover:bg-purple-500 group-hover:text-white transition-colors">09:15 - 10:45</span>
                        <div class="w-8 h-8 rounded-full bg-white/50 flex items-center justify-center group-hover:bg-purple-500 transition-colors">
                            <i data-lucide="map-pin" class="w-4 h-4 text-purple-600 group-hover:text-white"></i>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 group-hover:text-white mb-1 transition-colors">Fisika Terapan</h4>
                    <p class="text-sm text-slate-500 group-hover:text-purple-100 transition-colors">Kelas 11-IPA 2 • Lab Fisika</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 glass-card p-8 rounded-[2.5rem]">
        <h3 class="text-xl font-heading font-bold mb-8 text-slate-800">Status Kehadiran</h3>
        <div class="space-y-6">
            @php
                $absensi = [
                    ['Hadir', 28, 'bg-emerald-500', 'text-emerald-600'],
                    ['Izin', 5, 'bg-amber-500', 'text-amber-600'],
                    ['Sakit', 2, 'bg-blue-500', 'text-blue-600'],
                    ['Alpha', 1, 'bg-rose-500', 'text-rose-600'],
                ];
            @endphp

            @foreach($absensi as $item)
            <div>
                <div class="flex justify-between text-sm font-bold mb-2">
                    <span class="{{ $item[3] }}">{{ $item[0] }}</span>
                    <span class="text-slate-400">{{ $item[1] }} Siswa</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="{{ $item[2] }} h-full transition-all duration-1000" style="width: {{ ($item[1]/36)*100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100 text-center">
            <p class="text-xs text-indigo-600 font-bold uppercase tracking-widest mb-1">Total Kapasitas</p>
            <p class="text-lg font-bold text-slate-800">36 Siswa / Kelas</p>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-6 glass-card p-8 rounded-[2.5rem]">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <i data-lucide="briefcase" class="text-indigo-600 w-5 h-5"></i>
                <h3 class="text-xl font-heading font-bold text-slate-800">Tugas Aktif</h3>
            </div>
            <span class="px-3 py-1 bg-rose-50 text-rose-600 text-xs font-bold rounded-full border border-rose-100">5 Tertunda</span>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-all cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 flex items-center justify-center rounded-xl group-hover:rotate-6 transition-transform">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">Kalkulus Dasar</p>
                        <p class="text-xs text-slate-400">Target: Besok, 23:59 WIB</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors"></i>
            </div>
            
            <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-all cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 flex items-center justify-center rounded-xl group-hover:rotate-6 transition-transform">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">Eksperimen Gravitasi</p>
                        <p class="text-xs text-slate-400">Target: 22 April 2026</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors"></i>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-6 glass-card p-8 rounded-[2.5rem]">
        <div class="flex items-center gap-3 mb-6">
            <i data-lucide="star" class="text-amber-500 w-5 h-5"></i>
            <h3 class="text-xl font-heading font-bold text-slate-800">Nilai Siswa Terbaru</h3>
        </div>
        <div class="divide-y divide-gray-100">
            <div class="py-4 flex items-center justify-between group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=4F46E5&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" />
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Budi Santoso</p>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Matematika</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-indigo-50 text-indigo-600 font-bold px-4 py-1 rounded-lg text-lg">85</div>
                </div>
            </div>

            <div class="py-4 flex items-center justify-between group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=A855F7&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" />
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Siti Aminah</p>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Fisika</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-purple-50 text-purple-600 font-bold px-4 py-1 rounded-lg text-lg">92</div>
                </div>
            </div>
        </div>
        <button class="w-full mt-4 py-3 border-2 border-dashed border-gray-100 rounded-2xl text-sm font-bold text-slate-400 hover:bg-gray-50 hover:border-indigo-200 hover:text-indigo-500 transition-all">
            Input Nilai Lainnya
        </button>
    </div>

</div>

@endsection