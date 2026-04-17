@extends('layouts.student')
@section('title', 'Kedisiplinan - Schoolify')
@section('page_title', 'Kedisiplinan')

@section('content')
<div class="space-y-6">
    @php $total = $records->sum('points'); @endphp
    
    {{-- Summary --}}
    <div style="border-radius:28px; padding:36px 44px; display:flex; align-items:center; justify-content:space-between; position:relative; overflow:hidden; background:{{ $total > 0 ? 'linear-gradient(135deg,#f43f5e,#ef4444,#dc2626)' : 'linear-gradient(135deg,#10b981,#059669,#047857)' }}; box-shadow:{{ $total > 0 ? '0 16px 48px rgba(244,63,94,0.35)' : '0 16px 48px rgba(16,185,129,0.3)' }};">
        <div style="position:absolute; right:-30px; bottom:-30px; width:160px; height:160px; background:rgba(255,255,255,0.08); border-radius:50%; filter:blur(2px);"></div>
        <div class="relative" style="z-index:1;">
            <p style="color:rgba(255,255,255,0.7); font-size:15px; font-weight:600; margin-bottom:6px;">Total Poin Pelanggaran</p>
            <h2 style="font-size:52px; font-weight:900; color:white; line-height:1; margin-bottom:0;">{{ $total }} <span style="font-size:20px; font-weight:600; opacity:0.7;">poin</span></h2>
        </div>
        <div style="width:72px; height:72px; background:rgba(255,255,255,0.15); border-radius:22px; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.2); position:relative; z-index:1;">
            <i class='bx {{ $total > 0 ? "bx-shield-x" : "bx-shield" }}' style="font-size:32px; color:white;"></i>
        </div>
    </div>

    {{-- Table --}}
    <div class="glass-card" style="overflow:hidden;">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggaran</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Poin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $rec)
                <tr>
                    <td style="font-weight:600; color:#1e293b; white-space:nowrap;">{{ \Carbon\Carbon::parse($rec->date)->format('d M Y') }}</td>
                    <td style="font-weight:700; color:#1e293b;">{{ $rec->violation_type }}</td>
                    <td style="color:#64748b; font-weight:500;">{{ $rec->description }}</td>
                    <td style="text-align:center;">
                        <span style="display:inline-block; padding:5px 14px; border-radius:99px; background:#ffe4e6; color:#9f1239; font-size:13px; font-weight:800;">+{{ $rec->points }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:80px;">
                        <div style="font-size:52px; margin-bottom:16px; opacity:0.4;">🏆</div>
                        <h3 style="font-size:18px; font-weight:800; color:#1e293b; margin-bottom:6px;">Tidak ada catatan pelanggaran</h3>
                        <p style="font-size:14px; color:#94a3b8;">Pertahankan kedisiplinanmu!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
