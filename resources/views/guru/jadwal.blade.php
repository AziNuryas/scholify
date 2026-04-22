@extends('layouts.guru')

@section('page_title', 'Jadwal Mengajar')
@section('page_subtitle', 'Pusat kendali agenda harian Anda.')

@section('content')

@php
    $currentTime = date('H:i');
    
    // Simulasi Data (Bisa ditarik dari DB)
    // Karena masih belum ada di DB, kita kosongkan saja agar tidak membingungkan
    $schedules = [];

    function getStatus($start, $end, $current) {
        if ($current >= $start && $current <= $end) return 'ongoing';
        if ($current < $start) return 'upcoming';
        return 'completed';
    }
@endphp

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="lg:col-span-3 bg-white rounded-2xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center text-white shadow-sm">
                <i data-lucide="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-[10px] font-medium uppercase tracking-widest text-purple-500 mb-1">Agenda Hari Ini</p>
                <h2 class="text-2xl font-bold text-slate-800">{{ date('l, d F Y') }}</h2>
            </div>
        </div>
        
        <div class="flex bg-slate-100 p-1.5 rounded-xl overflow-x-auto max-w-full">
            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum'] as $hari)
                <button class="px-5 py-2.5 rounded-lg text-xs font-medium transition-all {{ $loop->first ? 'bg-white shadow-sm text-purple-600' : 'text-slate-500 hover:text-purple-600' }}">
                    {{ $hari }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-900 to-indigo-900 rounded-2xl p-8 text-white relative overflow-hidden group shadow-sm">
        <div class="relative z-10">
            <p class="text-[9px] font-medium uppercase tracking-[0.2em] text-purple-300 mb-2">Kelas Berikutnya</p>
            <h4 class="text-xl font-bold mb-1">11-IPA 2</h4>
            <div class="flex items-center gap-2 text-purple-300">
                <i data-lucide="timer" class="w-4 h-4 animate-pulse"></i>
                <span class="text-sm font-medium">15 Menit Lagi</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-400/20 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
    
    <div class="xl:col-span-8 space-y-6">
        @forelse($schedules as $item)
            @php $status = getStatus($item['time_start'], $item['time_end'], $currentTime); @endphp
            
            <div class="group relative flex gap-6 items-start">
                <div class="hidden md:flex flex-col items-center pt-2">
                    <span class="text-sm font-medium text-slate-700">{{ $item['time_start'] }}</span>
                    <div class="w-[2px] h-24 my-2 bg-slate-200 rounded-full group-last:hidden relative">
                        @if($status == 'ongoing')
                            <div class="absolute top-0 left-[-1px] w-[4px] h-full bg-purple-500 rounded-full shadow-[0_0_10px_rgba(139,92,246,0.5)]"></div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 bg-white rounded-2xl p-6 shadow-sm border transition-all duration-500 {{ $status == 'ongoing' ? 'border-purple-400 shadow-md ring-1 ring-purple-200' : 'border-gray-100 hover:border-purple-200 hover:shadow-md hover:translate-x-1' }}">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $status == 'ongoing' ? 'bg-purple-500 text-white shadow-sm' : 'bg-slate-50 text-slate-400 border border-slate-100' }}">
                                <i data-lucide="{{ $status == 'completed' ? 'check' : 'book-open' }}" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 group-hover:text-purple-600 transition-colors">{{ $item['subject'] }}</h3>
                                <p class="text-xs font-medium text-slate-400">{{ $item['class'] }} • {{ $item['students_count'] }} Siswa</p>
                            </div>
                        </div>

                        @if($status == 'ongoing')
                            <span class="flex items-center gap-2 px-4 py-1.5 bg-rose-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-full animate-pulse shadow-sm">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span> Live Now
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-rose-500">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-medium text-slate-400 uppercase">Ruangan</p>
                                <p class="text-xs font-medium text-slate-700">{{ $item['room'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-purple-500">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-medium text-slate-400 uppercase">Materi Pokok</p>
                                <p class="text-xs font-medium text-slate-700 truncate">{{ $item['material'] }}</p>
                            </div>
                        </div>
                    </div>

                    @if($status == 'ongoing')
                    <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between gap-4">
                        <a href="{{ route('guru.absensi') }}" class="flex-1 py-3.5 bg-purple-500 hover:bg-purple-600 text-white rounded-xl font-medium text-sm flex items-center justify-center gap-2 transition-all shadow-sm">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Buka Absensi Kelas
                        </a>
                        <button class="p-3.5 bg-slate-800 text-white rounded-xl hover:bg-purple-600 transition-all shadow-sm">
                            <i data-lucide="folder-open" class="w-5 h-5"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <img src="https://illustrations.popsy.co/slate/calendar.svg" class="w-48 mx-auto mb-6 opacity-50" alt="Empty">
                <p class="font-medium text-slate-400">Santai dulu, tidak ada jadwal untuk hari ini.</p>
            </div>
        @endforelse
    </div>

    <div class="xl:col-span-4 space-y-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h4 class="font-medium text-slate-800 mb-6 flex items-center gap-2 uppercase tracking-widest text-[11px]">
                <i data-lucide="info" class="w-4 h-4 text-purple-500"></i> Informasi Mengajar
            </h4>
            <div class="space-y-6">
                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-purple-500">
                            <i data-lucide="hourglass" class="w-5 h-5"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-700">Total Jam</span>
                    </div>
                    <span class="text-lg font-bold text-purple-500">18 Jam</span>
                </div>
                
                <div class="p-6 rounded-xl bg-gradient-to-br from-purple-900 to-indigo-900 text-white relative overflow-hidden shadow-sm">
                    <p class="text-xs text-purple-300 mb-3">Tingkat Kehadiran Guru</p>
                    <div class="flex items-end gap-2 mb-4">
                        <h5 class="text-3xl font-bold">98%</h5>
                        <span class="text-[10px] text-emerald-400 font-medium mb-1">+2% Bulan ini</span>
                    </div>
                    <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="w-[98%] h-full bg-purple-400 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></div>
                    </div>
                </div>
            </div>
        </div>

        <button class="w-full group p-6 rounded-xl border-2 border-dashed border-slate-200 hover:border-purple-300 hover:bg-purple-50/30 transition-all flex flex-col items-center gap-4 text-slate-400 hover:text-purple-500">
            <div class="w-14 h-14 rounded-xl bg-slate-100 group-hover:bg-purple-100 flex items-center justify-center transition-colors">
                <i data-lucide="printer" class="w-7 h-7"></i>
            </div>
            <p class="font-medium text-sm">Unduh Jadwal PDF</p>
        </button>
    </div>
</div>

@endsection