@extends('layouts.admin')
@section('title', 'Admin Dashboard - Schoolify')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6 animate-fadeInUp">

    {{-- ====== HEADER ====== --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="font-outfit font-black text-2xl text-[var(--text-primary)]">
                Selamat Datang, <span class="text-indigo-600">{{ Str::words(auth()->user()->name, 2, '') }}</span>! 👋
            </h1>
            <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-widest mt-0.5">
                {{ now()->isoFormat('dddd, D MMMM YYYY') }} &nbsp;•&nbsp; <span id="liveClock" class="text-indigo-500">--:--:--</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="neo-flat px-4 py-2 rounded-[1rem] flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">System Online</span>
            </div>
        </div>
    </div>

    {{-- ====== STAT CARDS ====== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Siswa --}}
        <a href="{{ route('admin.students') }}"
           class="neo-flat rounded-[2rem] p-6 text-white relative overflow-hidden hover:scale-[1.02] transition-all"
           style="background:linear-gradient(135deg,#22c55e,#16a34a);">
            <div class="absolute -right-4 -bottom-4 opacity-[0.12] pointer-events-none">
                <i data-lucide="users" class="w-24 h-24"></i>
            </div>
            <div class="relative z-10">
                {{-- Neumorphic raised icon box --}}
                <div class="w-12 h-12 rounded-2xl mb-4 flex items-center justify-center"
                     style="background:rgba(255,255,255,0.18);box-shadow:3px 3px 8px rgba(0,0,0,0.2),-3px -3px 8px rgba(255,255,255,0.25);">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-75 mb-1">Total Siswa</p>
                <h2 class="font-outfit font-black text-4xl">{{ $data['totalStudents'] }}</h2>
                <p class="text-[9px] font-bold opacity-60 uppercase tracking-wider mt-2">Terdaftar Aktif</p>
            </div>
        </a>

        {{-- Guru Mapel --}}
        <a href="{{ route('admin.teachers') }}?role=guru"
           class="neo-flat rounded-[2rem] p-6 text-white relative overflow-hidden hover:scale-[1.02] transition-all"
           style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
            <div class="absolute -right-4 -bottom-4 opacity-[0.12] pointer-events-none">
                <i data-lucide="graduation-cap" class="w-24 h-24"></i>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl mb-4 flex items-center justify-center"
                     style="background:rgba(255,255,255,0.18);box-shadow:3px 3px 8px rgba(0,0,0,0.2),-3px -3px 8px rgba(255,255,255,0.25);">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-75 mb-1">Guru Mapel</p>
                <h2 class="font-outfit font-black text-4xl">{{ \App\Models\User::where('role','guru')->count() }}</h2>
                <p class="text-[9px] font-bold opacity-60 uppercase tracking-wider mt-2">Staf Pengajar Aktif</p>
            </div>
        </a>

        {{-- Agenda --}}
        <a href="{{ route('admin.agendas.index') }}"
           class="neo-flat rounded-[2rem] p-6 text-white relative overflow-hidden hover:scale-[1.02] transition-all"
           style="background:linear-gradient(135deg,#a855f7,#7c3aed);">
            <div class="absolute -right-4 -bottom-4 opacity-[0.12] pointer-events-none">
                <i data-lucide="calendar-days" class="w-24 h-24"></i>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl mb-4 flex items-center justify-center"
                     style="background:rgba(255,255,255,0.18);box-shadow:3px 3px 8px rgba(0,0,0,0.2),-3px -3px 8px rgba(255,255,255,0.25);">
                    <i data-lucide="calendar-days" class="w-6 h-6"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-75 mb-1">Total Agenda</p>
                <h2 class="font-outfit font-black text-4xl">{{ $data['upcomingAgendas']->count() }}</h2>
                <div class="mt-2 flex gap-3">
                    <div class="flex text-[9px] font-bold opacity-70 gap-1">
                        <span>Kelas:</span><span>{{ $data['totalClasses'] }}</span>
                    </div>
                </div>
            </div>
        </a>

        {{-- Guru BK --}}
        <a href="{{ route('admin.teachers') }}?role=guru_bk"
           class="neo-flat rounded-[2rem] p-6 text-white relative overflow-hidden hover:scale-[1.02] transition-all"
           style="background:linear-gradient(135deg,#f97316,#dc2626);">
            <div class="absolute -right-4 -bottom-4 opacity-[0.12] pointer-events-none">
                <i data-lucide="heart-handshake" class="w-24 h-24"></i>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl mb-4 flex items-center justify-center"
                     style="background:rgba(255,255,255,0.18);box-shadow:3px 3px 8px rgba(0,0,0,0.2),-3px -3px 8px rgba(255,255,255,0.25);">
                    <i data-lucide="heart-handshake" class="w-6 h-6"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-75 mb-1">Guru BK</p>
                <h2 class="font-outfit font-black text-4xl">{{ \App\Models\User::where('role','guru_bk')->count() }}</h2>
                <p class="text-[9px] font-bold opacity-60 uppercase tracking-wider mt-2">Layanan Konseling Aktif</p>
            </div>
        </a>
    </div>

    {{-- ====== MAIN: Table + Area Chart ====== --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Left: Recent Students --}}
        <div class="lg:col-span-3 neo-flat rounded-[2rem] p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Siswa Bergabung Terbaru</h3>
                <a href="{{ route('admin.students') }}" class="text-[9px] font-black text-indigo-600 hover:underline uppercase tracking-widest">Lihat Semua →</a>
            </div>

            {{-- Table header --}}
            <div class="grid grid-cols-12 px-4 mb-3">
                <span class="col-span-5 text-[8px] font-black text-[var(--text-muted)] uppercase tracking-widest">Nama Siswa</span>
                <span class="col-span-3 text-[8px] font-black text-[var(--text-muted)] uppercase tracking-widest">NISN</span>
                <span class="col-span-2 text-[8px] font-black text-[var(--text-muted)] uppercase tracking-widest">Kelas</span>
                <span class="col-span-2 text-[8px] font-black text-[var(--text-muted)] uppercase tracking-widest text-right">Status</span>
            </div>

            <div class="space-y-2">
                @php $avatarColors = ['4F46E5','10B981','F59E0B','EF4444','8B5CF6']; @endphp
                @forelse($data['recentStudents'] ?? [] as $i => $s)
                <div class="grid grid-cols-12 items-center px-4 py-3.5 neo-pressed rounded-2xl group hover:bg-white/60 transition-all">
                    <div class="col-span-5 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl overflow-hidden flex-shrink-0"
                             style="box-shadow:2px 2px 5px rgba(0,0,0,0.1),-1px -1px 3px rgba(255,255,255,0.8);">
                            <img src="{{ $s->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($s->name).'&background='.$avatarColors[$i%5].'&color=fff' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-black text-[var(--text-primary)] truncate group-hover:text-indigo-600 transition-colors">{{ $s->name }}</p>
                            <p class="text-[8px] font-bold text-[var(--text-muted)] truncate">{{ $s->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <p class="text-[10px] font-bold text-[var(--text-muted)] truncate font-mono">{{ $s->nisn ?? '—' }}</p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[9px] font-black text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg">{{ $s->schoolClass->name ?? '—' }}</span>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <span class="text-[8px] font-black px-2 py-1 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase">Aktif</span>
                    </div>
                </div>
                @empty
                <div class="neo-pressed rounded-2xl p-8 text-center">
                    <p class="text-xs font-bold text-[var(--text-muted)]">Belum ada data siswa</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Right: Area Chart --}}
        <div class="lg:col-span-2 neo-flat rounded-[2rem] p-6 flex flex-col">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Perkembangan</h3>
                <span class="text-[9px] font-black text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100 uppercase">Bulanan</span>
            </div>
            <div class="neo-pressed rounded-xl p-2 flex-1">
                <div id="areaChart" style="min-height:200px;"></div>
            </div>
        </div>
    </div>

    {{-- ====== BOTTOM: Agenda Tabs + Donut Chart + Calendar ====== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Agenda with tabs --}}
        <div class="lg:col-span-1 neo-flat rounded-[2rem] p-6 flex flex-col" x-data="{ tab: 'all' }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Agenda</h3>
                <a href="{{ route('admin.agendas.create') }}" class="text-[9px] font-black text-indigo-600 hover:underline uppercase tracking-widest">+ Baru</a>
            </div>
            {{-- Tabs --}}
            <div class="flex gap-1 neo-pressed rounded-xl p-1 mb-4">
                @foreach(['all'=>'Semua','upcoming'=>'Mendatang','past'=>'Selesai'] as $k=>$v)
                <button @click="tab='{{ $k }}'"
                        :class="tab==='{{ $k }}' ? 'bg-white shadow-sm text-indigo-600 font-black' : 'text-[var(--text-muted)] font-bold'"
                        class="flex-1 text-[8px] py-1.5 rounded-lg uppercase tracking-widest transition-all">{{ $v }}</button>
                @endforeach
            </div>
            <div class="space-y-2 flex-1">
                @forelse($data['upcomingAgendas']->take(5) as $ag)
                @php
                    $bar = match($ag->type??'') {
                        'exam'=>'bg-rose-500','meeting'=>'bg-amber-400',
                        'holiday'=>'bg-emerald-500',default=>'bg-indigo-500'
                    };
                @endphp
                <div class="flex items-center gap-3 p-3 neo-pressed rounded-xl group hover:bg-white/50 transition-all">
                    <div class="w-1 h-8 rounded-full {{ $bar }} flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-[var(--text-primary)] truncate group-hover:text-indigo-600">{{ $ag->title }}</p>
                        <p class="text-[9px] font-bold text-[var(--text-muted)]">{{ $ag->start_date->format('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-xs font-bold text-[var(--text-muted)] text-center py-6">Tidak ada agenda</p>
                @endforelse
            </div>
        </div>

        {{-- Donut Chart --}}
        <div class="lg:col-span-1 neo-flat rounded-[2rem] p-6 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Distribusi</h3>
            </div>
            <div class="neo-pressed rounded-xl p-3 flex-1 flex items-center justify-center">
                <div id="donutChart" style="min-height:200px;width:100%;"></div>
            </div>
        </div>

        {{-- Calendar --}}
        <div class="lg:col-span-1 neo-flat rounded-[2rem] p-6" x-data="adminCal()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest" x-text="mn + ' ' + yr"></h3>
                <div class="flex gap-1">
                    <button @click="prev()" class="w-7 h-7 neo-btn rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-indigo-600">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button @click="next()" class="w-7 h-7 neo-btn rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-indigo-600">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <div class="neo-pressed rounded-xl p-3">
                <div class="grid grid-cols-7 text-center mb-2">
                    @foreach(['S','S','R','K','J','S','M'] as $d)
                    <span class="text-[8px] font-black text-[var(--text-muted)]">{{ $d }}</span>
                    @endforeach
                </div>
                <div class="grid grid-cols-7 gap-1">
                    <template x-for="b in bl"><div class="h-8"></div></template>
                    <template x-for="d in days">
                        <div class="h-8 flex items-center justify-center text-[11px] font-black rounded-lg transition-all cursor-pointer"
                             :class="{
                                 'bg-indigo-600 text-white shadow-md': isToday(d),
                                 'text-rose-500': isHoliday(d)&&!isToday(d),
                                 'text-[var(--text-secondary)] hover:bg-white': !isToday(d)&&!isHoliday(d)
                             }" x-text="d"></div>
                    </template>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-4">
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-indigo-600"></div><span class="text-[9px] font-black text-[var(--text-muted)] uppercase">Hari Ini</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div><span class="text-[9px] font-black text-[var(--text-muted)] uppercase">Libur</span></div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Area Chart
    new ApexCharts(document.querySelector('#areaChart'), {
        series: [{ name: 'Siswa Aktif', data: [80, 95, 88, 102, 110, 98, 115] }],
        chart: { type: 'area', height: 200, toolbar: { show: false }, fontFamily: 'Inter, sans-serif',
            dropShadow: { enabled: true, top: 4, blur: 4, color: '#6366f1', opacity: 0.15 }
        },
        colors: ['#6366f1'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0,100] } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { colors: '#94a3b8', fontSize: '9px', fontWeight: 700 } }
        },
        yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '9px', fontWeight: 700 } } },
        grid: { borderColor: 'rgba(184,198,214,0.15)', strokeDashArray: 4 },
        tooltip: { theme: 'light' }
    }).render();

    // Donut Chart
    new ApexCharts(document.querySelector('#donutChart'), {
        series: [
            {{ $data['totalStudents'] }},
            {{ \App\Models\User::where('role','guru')->count() }},
            {{ \App\Models\User::where('role','guru_bk')->count() }},
            {{ $data['totalClasses'] }}
        ],
        chart: { type: 'donut', height: 200, fontFamily: 'Inter, sans-serif' },
        colors: ['#22c55e','#3b82f6','#f97316','#a855f7'],
        labels: ['Siswa','Guru Mapel','Guru BK','Kelas'],
        legend: {
            position: 'bottom',
            fontSize: '9px',
            fontWeight: 700,
            labels: { colors: '#64748b' },
            markers: { width: 8, height: 8, radius: 4 }
        },
        plotOptions: { pie: { donut: { size: '65%', labels: { show: true,
            total: { show: true, label: 'Total', fontSize: '10px', fontWeight: 700, color: '#64748b',
                formatter: (w) => w.globals.seriesTotals.reduce((a,b)=>a+b,0)
            }
        } } } },
        dataLabels: { enabled: false },
        stroke: { width: 0 },
        tooltip: { theme: 'light' }
    }).render();
});

function adminCal() {
    return {
        m: new Date().getMonth(), yr: new Date().getFullYear(),
        mn:'', days:[], bl:[],
        init() { this.upd(); },
        upd() {
            const d = new Date(this.yr, this.m, 1);
            this.mn = d.toLocaleString('id-ID',{month:'long'});
            const last = new Date(this.yr, this.m+1, 0).getDate();
            this.days = Array.from({length:last},(_,i)=>i+1);
            let f = d.getDay(); f = f===0?6:f-1;
            this.bl = Array.from({length:f});
            setTimeout(()=>lucide.createIcons(),50);
        },
        prev() { this.m===0?(this.m=11,this.yr--):this.m--; this.upd(); },
        next() { this.m===11?(this.m=0,this.yr++):this.m++; this.upd(); },
        isToday(d) { const t=new Date(); return t.getDate()==d&&t.getMonth()==this.m&&t.getFullYear()==this.yr; },
        isHoliday(d) { return new Date(this.yr,this.m,d).getDay()==0; }
    };
}

function tick() {
    const el = document.getElementById('liveClock');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID',{hour12:false});
}
setInterval(tick,1000); tick();
</script>
@endpush
@endsection