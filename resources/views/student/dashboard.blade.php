@extends('layouts.student')
@section('title', 'Dashboard - Schoolify')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ===== SELAMAT DATANG CARD ===== --}}
    <div class="rounded-[28px] relative overflow-hidden" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 40%, #7c3aed 100%); padding: 40px 48px; box-shadow: 0 20px 60px rgba(99,102,241,0.35), 0 4px 16px rgba(99,102,241,0.2);">
        {{-- Decorative blobs --}}
        <div style="position:absolute; right:-40px; top:-40px; width:240px; height:240px; background:rgba(255,255,255,0.08); border-radius:50%; filter:blur(1px);"></div>
        <div style="position:absolute; right:120px; bottom:-60px; width:180px; height:180px; background:rgba(167,139,250,0.25); border-radius:50%; filter:blur(2px);"></div>
        <div style="position:absolute; left:40%; top:-20px; width:100px; height:100px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>

        <div class="relative flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-3">
                    <span style="background:rgba(255,255,255,0.15); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.2); padding:5px 14px; border-radius:99px; font-size:13px; font-weight:600; color:rgba(255,255,255,0.9);">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <h2 style="font-size:32px; font-weight:900; line-height:1.2; margin-bottom:10px; color:white;">
                    Selamat datang, <br>{{ $currentStudent['name'] ?? 'Siswa' }}! 👋
                </h2>
                <p style="color:rgba(224,231,255,0.85); font-size:16px; font-weight:500; max-width:440px; line-height:1.6;">
                    @if(count($urgentAssignments) > 0)
                        Kamu punya <strong style="color:white; background:rgba(255,255,255,0.18); padding:2px 10px; border-radius:8px;">{{ count($urgentAssignments) }} tugas</strong> yang perlu diselesaikan. Tetap semangat belajar!
                    @else
                        Semua tugasmu sudah beres. Tetap jaga semangat belajarmu hari ini! 🎉
                    @endif
                </p>
            </div>
            <div class="hidden md:block" style="font-size:100px; filter:drop-shadow(0 8px 24px rgba(0,0,0,0.15)); user-select:none;">🎓</div>
        </div>

        {{-- Stats Row --}}
        <div class="relative flex items-center gap-6 mt-8 pt-6" style="border-top:1px solid rgba(255,255,255,0.15);">
            <div style="text-align:center;">
                <p style="font-size:26px; font-weight:900; color:white; line-height:1;">{{ count($urgentAssignments) }}</p>
                <p style="font-size:12px; font-weight:600; color:rgba(224,231,255,0.8); margin-top:2px;">Tugas Aktif</p>
            </div>
            <div style="width:1px; height:36px; background:rgba(255,255,255,0.2);"></div>
            <div style="text-align:center;">
                <p style="font-size:26px; font-weight:900; color:white; line-height:1;">{{ count($todaySchedules) }}</p>
                <p style="font-size:12px; font-weight:600; color:rgba(224,231,255,0.8); margin-top:2px;">Jadwal Hari Ini</p>
            </div>
            @if($sppInfo)
            <div style="width:1px; height:36px; background:rgba(255,255,255,0.2);"></div>
            <div style="text-align:center;">
                <p style="font-size:26px; font-weight:900; color:white; line-height:1;">{{ $sppInfo->status === 'Lunas' ? '✓' : '!' }}</p>
                <p style="font-size:12px; font-weight:600; color:rgba(224,231,255,0.8); margin-top:2px;">SPP {{ $sppInfo->month }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        {{-- Left: Schedule + Chart --}}
        <div class="xl:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Today Schedule --}}
            <div class="glass-card p-7">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 style="font-size:17px; font-weight:800; color:#1e293b;">Jadwal Hari Ini</h3>
                        <p style="font-size:13px; color:#94a3b8; font-weight:500; margin-top:2px;">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                    </div>
                    <a href="{{ route('student.schedule') }}" style="font-size:13px; font-weight:700; color:#6366f1; padding:7px 14px; border-radius:10px; background:rgba(99,102,241,0.08); transition:all 0.2s;" onmouseover="this.style.background='rgba(99,102,241,0.15)'" onmouseout="this.style.background='rgba(99,102,241,0.08)'">Semua →</a>
                </div>

                <div class="space-y-3">
                    @forelse($todaySchedules as $sched)
                    <div style="display:flex; align-items:flex-start; gap:14px; padding:14px; border-radius:16px; {{ $sched['status'] == 'active' ? 'background:rgba(99,102,241,0.08); border:1.5px solid rgba(99,102,241,0.2);' : ($sched['status'] == 'past' ? 'opacity:0.45;' : 'background:rgba(248,250,252,0.8); border:1.5px solid transparent;') }} transition:all 0.2s;">
                        <div style="flex-shrink:0; width:52px; text-align:center;">
                            <span style="font-size:12px; font-weight:700; color:{{ $sched['status'] == 'active' ? '#6366f1' : '#94a3b8' }}; display:block;">{{ explode(' - ', $sched['time'])[0] }}</span>
                            <div style="width:1px; height:10px; background:#e2e8f0; margin:3px auto;"></div>
                            <span style="font-size:11px; font-weight:600; color:#94a3b8; display:block;">{{ explode(' - ', $sched['time'])[1] ?? '' }}</span>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <h4 style="font-size:14px; font-weight:700; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $sched['subject'] }}</h4>
                                @if($sched['status'] == 'active')
                                    <span style="width:8px; height:8px; border-radius:50%; background:#6366f1; display:block; animation:pulse 1.5s infinite; flex-shrink:0;"></span>
                                @endif
                            </div>
                            <p style="font-size:12px; color:#94a3b8; font-weight:500; margin-top:3px;">{{ $sched['teacher'] }} · {{ $sched['room'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; padding:40px 0;">
                        <div style="font-size:40px; margin-bottom:10px; opacity:0.5;">☀️</div>
                        <p style="font-size:14px; color:#94a3b8; font-weight:600;">Tidak ada jadwal hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Grade Chart --}}
            <div class="glass-card p-7 flex flex-col">
                <div class="flex items-center justify-between mb-1">
                    <h3 style="font-size:17px; font-weight:800; color:#1e293b;">Grafik Nilai</h3>
                    @if($gradeProgress != 0)
                    <span style="font-size:12px; font-weight:700; padding:5px 12px; border-radius:99px; background:{{ $gradeProgress >= 0 ? '#ecfdf5' : '#fff1f2' }}; color:{{ $gradeProgress >= 0 ? '#059669' : '#e11d48' }};">
                        {{ $gradeProgress >= 0 ? '↑' : '↓' }} {{ abs($gradeProgress) }}%
                    </span>
                    @endif
                </div>
                <p style="font-size:13px; color:#94a3b8; font-weight:500; margin-bottom:20px;">Performa per mata pelajaran</p>
                <div style="flex:1; min-height:200px;" id="grade-chart"></div>
            </div>
        </div>

        {{-- Right: Urgent + SPP --}}
        <div class="space-y-6">
            
            {{-- Urgent Assignments --}}
            <div class="glass-card p-7">
                <div class="flex items-center gap-3 mb-5">
                    <div style="width:44px; height:44px; border-radius:14px; background:linear-gradient(135deg,#f97316,#ef4444); display:flex; align-items:center; justify-content:center; box-shadow:0 6px 18px rgba(239,68,68,0.3); flex-shrink:0;">
                        <i class='bx bx-task' style="color:white; font-size:20px;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:800; color:#1e293b;">Deadline Terdekat</h3>
                        <p style="font-size:12px; color:#94a3b8; font-weight:600; margin-top:1px;">{{ count($urgentAssignments) }} tugas aktif</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($urgentAssignments as $assign)
                    <div style="padding:14px 16px; border-radius:16px; background:rgba(248,250,252,0.8); border:1.5px solid rgba(226,232,240,0.6); transition:all 0.2s; cursor:pointer;" onmouseover="this.style.borderColor='rgba(99,102,241,0.3)'" onmouseout="this.style.borderColor='rgba(226,232,240,0.6)'">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <span style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#6366f1; background:rgba(99,102,241,0.1); padding:3px 10px; border-radius:99px;">{{ $assign['type'] }}</span>
                            <span style="font-size:11px; font-weight:700; color:#ef4444;">{{ $assign['due_date'] }}</span>
                        </div>
                        <h4 style="font-size:14px; font-weight:700; color:#1e293b; line-height:1.4;">{{ $assign['title'] }}</h4>
                        <p style="font-size:12px; color:#94a3b8; font-weight:500; margin-top:3px;">{{ $assign['subject'] }}</p>
                    </div>
                    @empty
                    <div style="text-align:center; padding:32px 0;">
                        <div style="font-size:36px; margin-bottom:8px; opacity:0.5;">✅</div>
                        <p style="font-size:14px; font-weight:600; color:#10b981;">Tidak ada tugas mendesak</p>
                    </div>
                    @endforelse
                </div>
                @if(count($urgentAssignments) > 0)
                <a href="{{ route('student.assignments') }}" style="display:block; width:100%; margin-top:16px; text-align:center; padding:11px; background:rgba(99,102,241,0.07); border-radius:14px; font-size:13px; font-weight:700; color:#6366f1; transition:all 0.2s; text-decoration:none;" onmouseover="this.style.background='rgba(99,102,241,0.12)'" onmouseout="this.style.background='rgba(99,102,241,0.07)'">Lihat Semua Tugas →</a>
                @endif
            </div>

            {{-- SPP --}}
            <div class="glass-card p-7">
                <h3 style="font-size:16px; font-weight:800; color:#1e293b; margin-bottom:16px;">Tagihan SPP</h3>
                @if($sppInfo)
                    @if($sppInfo->status === 'Lunas')
                    <div style="display:flex; align-items:center; gap:14px; padding:16px; border-radius:18px; background:rgba(5,150,105,0.07); border:1.5px solid rgba(5,150,105,0.2);">
                        <div style="width:46px; height:46px; border-radius:14px; background:linear-gradient(135deg,#10b981,#059669); display:flex; align-items:center; justify-content:center; box-shadow:0 6px 18px rgba(5,150,105,0.3); flex-shrink:0;">
                            <i class='bx bx-check' style="color:white; font-size:24px;"></i>
                        </div>
                        <div>
                            <p style="font-size:15px; font-weight:700; color:#1e293b;">{{ $sppInfo->month }}</p>
                            <p style="font-size:13px; font-weight:700; color:#059669; margin-top:2px;">Lunas ✓</p>
                        </div>
                    </div>
                    @else
                    <div style="display:flex; align-items:center; gap:14px; padding:16px; border-radius:18px; background:rgba(239,68,68,0.07); border:1.5px solid rgba(239,68,68,0.2);">
                        <div style="width:46px; height:46px; border-radius:14px; background:linear-gradient(135deg,#f87171,#ef4444); display:flex; align-items:center; justify-content:center; box-shadow:0 6px 18px rgba(239,68,68,0.3); flex-shrink:0;">
                            <i class='bx bx-time-five' style="color:white; font-size:22px;"></i>
                        </div>
                        <div>
                            <p style="font-size:15px; font-weight:700; color:#1e293b;">{{ $sppInfo->month }}</p>
                            <p style="font-size:13px; font-weight:700; color:#ef4444; margin-top:2px;">Rp {{ number_format($sppInfo->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endif
                @else
                <div style="display:flex; align-items:center; gap:14px; padding:16px; border-radius:18px; background:rgba(248,250,252,0.8); border:1.5px solid rgba(226,232,240,0.6);">
                    <div style="width:46px; height:46px; border-radius:14px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class='bx bx-wallet' style="color:#94a3b8; font-size:22px;"></i>
                    </div>
                    <div>
                        <p style="font-size:15px; font-weight:700; color:#1e293b;">SPP</p>
                        <p style="font-size:13px; color:#94a3b8; margin-top:2px;">Belum ada data</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.6;transform:scale(0.9);} }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const labels = @json($gradeChartData['labels'] ?? []);
    const scores = @json($gradeChartData['scores'] ?? []);
    if (!labels.length) {
        document.getElementById('grade-chart').innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;"><div style="text-align:center;"><div style="font-size:40px;opacity:0.25;margin-bottom:10px;">📊</div><p style="font-size:13px;color:#94a3b8;font-weight:600;">Belum ada data nilai</p></div></div>';
        return;
    }
    new ApexCharts(document.getElementById('grade-chart'), {
        series: [{ name: 'Nilai', data: scores }],
        chart: { height: '100%', type: 'area', fontFamily: '"Plus Jakarta Sans"', toolbar: { show: false }, sparkline: { enabled: false } },
        colors: ['#6366f1'],
        fill: { type: 'gradient', gradient: { opacityFrom: 0.28, opacityTo: 0.02, stops: [0, 100] } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: { categories: labels, labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 600 }, rotate: -35 }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { min: 0, max: 100, show: false },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 5, xaxis: { lines: { show: false } } },
        tooltip: { y: { formatter: v => v + ' poin' } }
    }).render();
});
</script>
@endsection
