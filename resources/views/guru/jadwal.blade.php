@extends('layouts.guru')

@section('page_title', 'Jadwal Mengajar')
@section('page_subtitle', 'Pusat kendali agenda harian Anda.')

@section('content')

@php
    $currentTime = date('H:i');
    
    // Simulasi Data (Bisa ditarik dari DB)
    $schedules = [
        [
            'id' => 1,
            'time_start' => '07:30',
            'time_end' => '09:00',
            'subject' => 'Matematika Aljabar',
            'class' => '10-IPA 1',
            'room' => 'Ruang 04 - Lt. 2',
            'material' => 'Bab 3: Logaritma',
            'students_count' => 32
        ],
        [
            'id' => 2,
            'time_start' => '09:15',
            'time_end' => '14:45', // Contoh sedang berlangsung
            'subject' => 'Fisika Dasar',
            'class' => '11-IPA 2',
            'room' => 'Lab Fisika Utama',
            'material' => 'Hukum Newton II',
            'students_count' => 30
        ],
        [
            'id' => 3,
            'time_start' => '15:00',
            'time_end' => '16:30',
            'subject' => 'Matematika Peminatan',
            'class' => '12-IPA 1',
            'room' => 'Ruang 02 - Lt. 1',
            'material' => 'Turunan Trigonometri',
            'students_count' => 28
        ],
    ];

    function getStatus($start, $end, $current) {
        if ($current >= $start && $current <= $end) return 'ongoing';
        if ($current < $start) return 'upcoming';
        return 'completed';
    }
@endphp

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="lg:col-span-3 glass-card p-8 rounded-[2.5rem] border border-white/50 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-indigo-200">
                <i data-lucide="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-1">Agenda Hari Ini</p>
                <h2 class="text-2xl font-heading font-extrabold text-slate-800">{{ date('l, d F Y') }}</h2>
            </div>
        </div>
        
        <div class="flex bg-slate-100 p-1.5 rounded-2xl overflow-x-auto max-w-full">
            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum'] as $hari)
                <button class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all {{ $loop->first ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-indigo-600' }}">
                    {{ $hari }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-2">Kelas Berikutnya</p>
            <h4 class="text-xl font-bold mb-1">11-IPA 2</h4>
            <div class="flex items-center gap-2 text-indigo-300">
                <i data-lucide="timer" class="w-4 h-4 animate-pulse"></i>
                <span class="text-sm font-medium">15 Menit Lagi</span>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-600/20 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
    
    <div class="xl:col-span-8 space-y-6">
        @forelse($schedules as $item)
            @php $status = getStatus($item['time_start'], $item['time_end'], $currentTime); @endphp
            
            <div class="group relative flex gap-6 items-start">
                <div class="hidden md:flex flex-col items-center pt-2">
                    <span class="text-sm font-black text-slate-700">{{ $item['time_start'] }}</span>
                    <div class="w-[2px] h-24 my-2 bg-slate-200 rounded-full group-last:hidden relative">
                        @if($status == 'ongoing')
                            <div class="absolute top-0 left-[-1px] w-[4px] h-full bg-indigo-500 rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 glass-card p-6 rounded-[2.5rem] border transition-all duration-500 {{ $status == 'ongoing' ? 'border-indigo-500 shadow-2xl shadow-indigo-100 ring-1 ring-indigo-500/20' : 'border-white hover:border-indigo-200 hover:translate-x-2' }}">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $status == 'ongoing' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-50 text-slate-400 border border-slate-100' }}">
                                <i data-lucide="{{ $status == 'completed' ? 'check' : 'book-open' }}" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h3 class="font-heading font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $item['subject'] }}</h3>
                                <p class="text-xs font-bold text-slate-400">{{ $item['class'] }} • {{ $item['students_count'] }} Siswa</p>
                            </div>
                        </div>

                        @if($status == 'ongoing')
                            <span class="flex items-center gap-2 px-4 py-1.5 bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full animate-pulse shadow-lg">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span> Live Now
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-rose-500">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Ruangan</p>
                                <p class="text-xs font-bold text-slate-700">{{ $item['room'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-slate-50/50 rounded-2xl border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-indigo-500">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Materi Pokok</p>
                                <p class="text-xs font-bold text-slate-700 truncate">{{ $item['material'] }}</p>
                            </div>
                        </div>
                    </div>

                    @if($status == 'ongoing')
                    <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between gap-4">
                        <a href="{{ route('guru.absensi') }}" class="flex-1 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-100">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Buka Absensi Kelas
                        </a>
                        <button class="p-3.5 bg-slate-900 text-white rounded-2xl hover:bg-indigo-700 transition-all shadow-lg">
                            <i data-lucide="folder-open" class="w-5 h-5"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <img src="https://illustrations.popsy.co/slate/calendar.svg" class="w-48 mx-auto mb-6 opacity-50" alt="Empty">
                <p class="font-bold text-slate-400">Santai dulu, tidak ada jadwal untuk hari ini.</p>
            </div>
        @endforelse
    </div>

    <div class="xl:col-span-4 space-y-8">
        <div class="glass-card p-6 rounded-[2.5rem] border border-white">
            <h4 class="font-black text-slate-800 mb-6 flex items-center gap-2 uppercase tracking-widest text-[11px]">
                <i data-lucide="info" class="w-4 h-4 text-indigo-500"></i> Informasi Mengajar
            </h4>
            <div class="space-y-6">
                <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-3xl border border-indigo-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600">
                            <i data-lucide="hourglass" class="w-5 h-5"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-700">Total Jam</span>
                    </div>
                    <span class="text-lg font-black text-indigo-600">18 Jam</span>
                </div>
                
                <div class="p-6 rounded-[2rem] bg-slate-900 text-white relative overflow-hidden">
                    <p class="text-xs text-slate-400 mb-3">Tingkat Kehadiran Guru</p>
                    <div class="flex items-end gap-2 mb-4">
                        <h5 class="text-3xl font-black italic">98%</h5>
                        <span class="text-[10px] text-emerald-400 font-bold mb-1">+2% Bulan ini</span>
                    </div>
                    <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                        <div class="w-[98%] h-full bg-indigo-500 shadow-[0_0_10px_#6366f1]"></div>
                    </div>
                </div>
            </div>
        </div>

        <button class="w-full group p-6 rounded-[2.5rem] border-2 border-dashed border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/30 transition-all flex flex-col items-center gap-4 text-slate-400 hover:text-indigo-600">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center transition-colors">
                <i data-lucide="printer" class="w-7 h-7"></i>
            </div>
            <p class="font-bold text-sm">Unduh Jadwal PDF</p>
        </button>
    </div>
</div>

@endsection