@extends('layouts.student')
@section('title', 'Nilai & Rapor - Schoolify')
@section('page_title', 'Nilai & Rapor')

@section('content')
<div class="space-y-6">
    <div style="display:flex; justify-content:flex-end;">
        <form method="GET" action="{{ route('student.grades') }}">
            <select name="semester" onchange="this.form.submit()" style="background:rgba(255,255,255,0.8); backdrop-filter:blur(12px); border:1.5px solid rgba(255,255,255,0.9); border-radius:14px; padding:11px 20px; font-size:14px; font-weight:700; color:#1e293b; cursor:pointer; outline:none; box-shadow:0 2px 12px rgba(99,102,241,0.07); font-family:'Plus Jakarta Sans',sans-serif;">
                @if($availableSemesters->count() > 0)
                    @foreach($availableSemesters as $sem)
                        <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>Semester {{ $sem }}</option>
                    @endforeach
                @else
                    <option value="Ganjil" {{ $semester === 'Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                    <option value="Genap" {{ $semester === 'Genap' ? 'selected' : '' }}>Semester Genap</option>
                @endif
            </select>
        </form>
    </div>

    @if($grades->count() > 0)
    <div class="glass-card" style="overflow:hidden;">
        <table class="premium-table">
            <thead>
                <tr>
                    <th style="text-align:center; width:56px;">#</th>
                    <th>Mata Pelajaran</th>
                    <th>Jenis Ujian</th>
                    <th style="text-align:center;">Nilai</th>
                    <th style="text-align:center;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $i => $grade)
                @php
                    $s = $grade->score ?? 0;
                    $pred = $s >= 90 ? 'A' : ($s >= 80 ? 'B' : ($s >= 70 ? 'C' : 'D'));
                    $scoreColor = $s >= 85 ? '#059669' : ($s >= 70 ? '#d97706' : '#ef4444');
                    $badgeBg = $s >= 90 ? '#d1fae5' : ($s >= 80 ? '#dbeafe' : ($s >= 70 ? '#fef3c7' : '#ffe4e6'));
                    $badgeColor = $s >= 90 ? '#065f46' : ($s >= 80 ? '#1e40af' : ($s >= 70 ? '#92400e' : '#9f1239'));
                @endphp
                <tr>
                    <td style="text-align:center; color:#94a3b8; font-weight:600; font-size:13px;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; border-radius:13px; background:rgba(99,102,241,0.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class='bx bx-book-alt' style="font-size:18px; color:#6366f1;"></i>
                            </div>
                            <span style="font-weight:700; color:#1e293b; font-size:15px;">{{ $grade->subject->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td style="color:#64748b; font-weight:500; font-size:14px;">{{ $grade->type ?? '-' }}</td>
                    <td style="text-align:center;">
                        <span style="font-size:24px; font-weight:900; color:{{ $scoreColor }};">{{ $s }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span style="display:inline-block; padding:6px 16px; border-radius:99px; background:{{ $badgeBg }}; color:{{ $badgeColor }}; font-size:13px; font-weight:800;">{{ $pred }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Footer --}}
        <div style="padding:16px 28px; border-top:1px solid rgba(226,232,240,0.5); display:flex; justify-content:space-between; align-items:center; background:rgba(248,250,252,0.5);">
            <span style="font-size:13px; color:#94a3b8; font-weight:600;">KKM: <strong style="color:#1e293b;">75</strong></span>
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:13px; color:#94a3b8; font-weight:600;">Rata-rata Kelas</span>
                <span style="font-size:26px; font-weight:900; color:{{ $averageScore >= 75 ? '#059669' : '#ef4444' }};">{{ $averageScore }}</span>
            </div>
        </div>
    </div>
    @else
    <div class="glass-card" style="padding:80px; text-align:center; max-width:440px; margin:40px auto;">
        <div style="width:80px; height:80px; background:rgba(99,102,241,0.1); border-radius:24px; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:36px; color:#6366f1;">
            <i class='bx bx-bar-chart-alt-2'></i>
        </div>
        <h2 style="font-size:22px; font-weight:800; color:#1e293b; margin-bottom:8px;">Belum Ada Nilai</h2>
        <p style="font-size:15px; color:#94a3b8; line-height:1.6;">Nilai untuk semester <strong style="color:#1e293b;">{{ $semester }}</strong> belum diinput oleh guru.</p>
    </div>
    @endif
</div>
@endsection
