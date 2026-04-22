@extends('layouts.student')

@section('title', 'Jadwal Kelas - Schoolify')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Jadwal Kelas Mingguan</h1>
            <p class="text-[#A3AED0]">Jadwal pelajarannmu terorganisir di sini.</p>
        </div>
        <button class="neo-btn text-[var(--brand-secondary)] font-bold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:text-[#4318FF]">
            <i class='bx bx-printer'></i> Cetak
        </button>
    </div>

    <!-- Menampilkan Tabel Jika Ada Data -->
    @if($schedulesGrouped->count() > 0)
        @php
            $colors = [
                'Senin' => 'neo-flat-blue', 
                'Selasa' => 'neo-flat-green', 
                'Rabu' => 'neo-flat-orange', 
                'Kamis' => 'neo-flat-purple', 
                'Jumat' => 'neo-flat-blue'
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                <div class="{{ $colors[$day] ?? 'neo-flat' }} rounded-2xl p-5 min-h-[400px]">
                    <h3 class="font-outfit font-bold text-center text-lg pb-3 border-b border-black/5 mb-4 {{ date('N') == array_search($day, ['Senin','Selasa','Rabu','Kamis','Jumat'])+1 ? 'text-[#4318FF]' : 'text-[var(--brand-secondary)]' }}">
                        {{ $day }}
                    </h3>

                    <div class="space-y-4">
                        @if(isset($schedulesGrouped[$day]))
                            @foreach($schedulesGrouped[$day] as $sched)
                                <div class="neo-pressed p-3 rounded-xl transition cursor-pointer hover:neo-flat">
                                    <p class="text-[11px] font-bold text-white neo-badge-blue rounded px-2 py-0.5 inline-block mb-2">
                                        {{ $sched->start_time ?? '00:00' }} - {{ $sched->end_time ?? '00:00' }}
                                    </p>
                                    <h4 class="font-bold text-[var(--brand-secondary)] text-sm leading-tight mb-1">{{ $sched->subject->name ?? '-' }}</h4>
                                    <p class="text-xs text-[var(--text-muted)] flex items-center gap-1 mb-1">
                                        <i class='bx bx-user'></i> {{ $sched->teacher->name ?? '-' }}
                                    </p>
                                    <p class="text-[10px] text-[var(--text-muted)] flex items-center gap-1">
                                        <i class='bx bx-map'></i> {{ $sched->room ?? '-' }}
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="h-full flex items-center justify-center pt-8">
                                <p class="text-xs text-center text-[var(--text-muted)] font-medium">Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State Dinyatakan Dari DB -->
        <div class="neo-flat rounded-[24px] p-12 text-center">
            <div class="w-24 h-24 neo-pressed text-blue-500 mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                🗓️
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[var(--brand-secondary)] mb-2">Jadwal Belum Disusun</h2>
            <p class="text-[var(--text-muted)] max-w-md mx-auto">Sistem mendeteksi bahwa admin/guru belum menginput jadwal ke dalam database untuk kelas kamu.</p>
        </div>
    @endif
</div>
@endsection
