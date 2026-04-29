@extends('layouts.student')
@section('title', 'Jadwal Kelas - Schoolify')
@section('page-title', 'Jadwal Mingguan')

@section('content')
<div class="space-y-6 animate-fadeInUp">

    <div>
        <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Jadwal Kelas Mingguan</h1>
        <p class="text-sm text-[var(--text-secondary)]">Pantau jadwal belajarmu setiap hari agar tidak ketinggalan mata pelajaran penting.</p>
    </div>

    @if($schedulesGrouped->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                @php $isToday = (date('N') == array_search($day, ['Senin','Selasa','Rabu','Kamis','Jumat'])+1); @endphp
                
                <div class="neo-flat rounded-2xl overflow-hidden {{ $isToday ? 'ring-2 ring-indigo-500/50' : '' }}">
                    <div class="px-5 py-3 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center bg-[var(--bg)]">
                        <h3 class="font-outfit font-extrabold text-lg {{ $isToday ? 'text-indigo-600' : 'text-[var(--text-primary)]' }}">{{ $day }}</h3>
                        @if($isToday)
                            <span class="text-[9px] font-bold px-2 py-0.5 bg-indigo-100 text-indigo-600 rounded uppercase tracking-wider">Hari Ini</span>
                        @endif
                    </div>
                    
                    <div class="p-4 space-y-4">
                        @php
                            $textColors = ['text-indigo-500', 'text-emerald-500', 'text-amber-500', 'text-rose-500', 'text-blue-500', 'text-purple-500'];
                        @endphp
                        @if(isset($schedulesGrouped[$day]) && $schedulesGrouped[$day]->count() > 0)
                            @foreach($schedulesGrouped[$day] as $index => $sched)
                                @php
                                    $color = $textColors[$index % count($textColors)];
                                @endphp
                                <div class="neo-pressed p-4 rounded-xl relative overflow-hidden group">
                                    <!-- Aksen garis warna -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1 {{ str_replace('text', 'bg', $color) }} opacity-70 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <p class="text-[10px] font-bold {{ $color }} mb-1 flex items-center gap-1.5 pl-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}
                                    </p>
                                    <h4 class="font-bold text-sm text-[var(--text-primary)] mb-1.5 pl-1 group-hover:{{ $color }} transition-colors">{{ $sched->subject->name ?? '-' }}</h4>
                                    
                                    <div class="space-y-1 text-xs font-medium text-[var(--text-secondary)] pl-1">
                                        <p class="flex items-center gap-1.5 truncate"><i data-lucide="user" class="w-3 h-3 text-[var(--text-muted)]"></i> {{ $sched->teacher->name ?? '-' }}</p>
                                        @if($sched->room)
                                            <p class="flex items-center gap-1.5 truncate"><i data-lucide="map-pin" class="w-3 h-3 text-[var(--text-muted)]"></i> Ruang {{ $sched->room }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-8 text-center">
                                <div class="w-10 h-10 neo-pressed rounded-full flex items-center justify-center mx-auto mb-2 text-[var(--text-muted)]">
                                    <i data-lucide="coffee" class="w-4 h-4"></i>
                                </div>
                                <p class="text-xs font-bold text-[var(--text-secondary)]">Kosong</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="neo-flat rounded-2xl p-12 text-center">
            <div class="w-16 h-16 neo-pressed rounded-full flex items-center justify-center mx-auto mb-4 text-[var(--text-muted)]">
                <i data-lucide="calendar-x" class="w-8 h-8"></i>
            </div>
            <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)] mb-1">Belum Ada Jadwal</h2>
            <p class="text-sm text-[var(--text-secondary)] max-w-sm mx-auto">Jadwal kelas belum diatur oleh admin. Silakan periksa kembali nanti.</p>
        </div>
    @endif
</div>
@endsection