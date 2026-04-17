@extends('layouts.student')
@section('title', 'Jadwal Pelajaran - Schoolify')
@section('page_title', 'Jadwal Pelajaran')

@section('content')
@php
    $dayMeta = [
        'Senin'  => ['bg'=>'linear-gradient(135deg,#3b82f6,#2563eb)', 'pill'=>'#dbeafe', 'pillText'=>'#1d4ed8', 'hover'=>'rgba(59,130,246,0.07)', 'border'=>'rgba(59,130,246,0.15)'],
        'Selasa' => ['bg'=>'linear-gradient(135deg,#8b5cf6,#6d28d9)', 'pill'=>'#ede9fe', 'pillText'=>'#5b21b6', 'hover'=>'rgba(139,92,246,0.07)', 'border'=>'rgba(139,92,246,0.15)'],
        'Rabu'   => ['bg'=>'linear-gradient(135deg,#10b981,#059669)', 'pill'=>'#d1fae5', 'pillText'=>'#065f46', 'hover'=>'rgba(16,185,129,0.07)', 'border'=>'rgba(16,185,129,0.15)'],
        'Kamis'  => ['bg'=>'linear-gradient(135deg,#f59e0b,#d97706)', 'pill'=>'#fef3c7', 'pillText'=>'#92400e', 'hover'=>'rgba(245,158,11,0.07)', 'border'=>'rgba(245,158,11,0.15)'],
        'Jumat'  => ['bg'=>'linear-gradient(135deg,#f43f5e,#e11d48)', 'pill'=>'#ffe4e6', 'pillText'=>'#9f1239', 'hover'=>'rgba(244,63,94,0.07)', 'border'=>'rgba(244,63,94,0.15)'],
    ];
    $dayMap = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat'];
    $today = $dayMap[\Carbon\Carbon::now()->format('l')] ?? '';
@endphp

@if($schedulesGrouped->count() > 0)
<div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px;">
    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
    @php $m = $dayMeta[$day]; $isToday = $day === $today; @endphp
    <div class="glass-card" style="overflow:hidden; {{ $isToday ? 'box-shadow:0 0 0 2px #6366f1, 0 12px 40px rgba(99,102,241,0.18);' : '' }} border-radius:24px;">
        {{-- Header --}}
        <div style="padding:16px 18px; {{ $isToday ? 'background:linear-gradient(135deg,#6366f1,#818cf8);' : 'background:rgba(248,250,252,0.8); border-bottom:1px solid rgba(226,232,240,0.5);' }} display:flex; align-items:center; justify-content:space-between;">
            <span style="font-size:15px; font-weight:800; {{ $isToday ? 'color:white;' : 'color:#1e293b;' }}">{{ $day }}</span>
            @if($isToday)
            <span style="font-size:10px; font-weight:700; background:rgba(255,255,255,0.2); color:white; padding:3px 10px; border-radius:99px; letter-spacing:0.05em;">HARI INI</span>
            @endif
        </div>

        {{-- Items --}}
        <div style="padding:14px; display:flex; flex-direction:column; gap:10px; min-height:320px;">
            @if(isset($schedulesGrouped[$day]) && $schedulesGrouped[$day]->count() > 0)
                @foreach($schedulesGrouped[$day] as $sched)
                <div style="background:{{ $m['hover'] }}; border:1.5px solid {{ $m['border'] }}; border-radius:16px; padding:14px; transition:all 0.2s; cursor:default;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <span style="display:inline-block; font-size:11px; font-weight:700; background:{{ $m['pill'] }}; color:{{ $m['pillText'] }}; padding:3px 10px; border-radius:99px; margin-bottom:8px;">
                        {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($sched->end_time)->format('H:i') }}
                    </span>
                    <h4 style="font-size:14px; font-weight:700; color:#1e293b; line-height:1.3; margin-bottom:6px;">{{ $sched->subject->name ?? '-' }}</h4>
                    <p style="font-size:12px; color:#64748b; font-weight:600; display:flex; align-items:center; gap:4px;"><i class='bx bx-user' style="font-size:13px;"></i> {{ $sched->teacher->name ?? '-' }}</p>
                    <p style="font-size:11px; color:#94a3b8; font-weight:500; display:flex; align-items:center; gap:4px; margin-top:3px;"><i class='bx bx-map' style="font-size:12px;"></i> {{ $sched->room ?? '-' }}</p>
                </div>
                @endforeach
            @else
                <div style="flex:1; display:flex; align-items:center; justify-content:center; flex-direction:column; padding:40px 0; opacity:0.4;">
                    <div style="font-size:28px; margin-bottom:8px;">📚</div>
                    <p style="font-size:12px; color:#94a3b8; font-weight:600;">Tidak ada jadwal</p>
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="glass-card" style="padding:80px; text-align:center; max-width:480px; margin:60px auto;">
    <div style="width:80px; height:80px; background:rgba(99,102,241,0.1); border-radius:24px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:36px;">🗓️</div>
    <h2 style="font-size:22px; font-weight:800; color:#1e293b; margin-bottom:8px;">Jadwal Belum Tersedia</h2>
    <p style="font-size:15px; color:#94a3b8; line-height:1.6;">Jadwal pelajaran untuk kelasmu belum diinput. Silakan hubungi wali kelas atau admin sekolah.</p>
</div>
@endif
@endsection
