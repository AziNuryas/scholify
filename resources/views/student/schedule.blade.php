@extends('layouts.student')

@section('title', 'Jadwal Kelas - Schoolify')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Jadwal Kelas Mingguan</h1>
            <p class="text-[#A3AED0]">Jadwal pelajarannmu terorganisir di sini.</p>
        </div>
        <button class="bg-white border border-gray-200 text-[#4318FF] font-bold px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-gray-50 shadow-sm">
            <i class='bx bx-printer'></i> Cetak
        </button>
    </div>

    <!-- Menampilkan Tabel Jika Ada Data -->
    @if($schedulesGrouped->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                <div class="glass-card rounded-2xl p-5 border border-indigo-50 shadow-sm bg-white min-h-[400px]">
                    <h3 class="font-outfit font-bold text-center text-lg pb-3 border-b border-gray-100 mb-4 {{ date('N') == array_search($day, ['Senin','Selasa','Rabu','Kamis','Jumat'])+1 ? 'text-[#4318FF]' : 'text-[#2B3674]' }}">
                        {{ $day }}
                    </h3>

                    <div class="space-y-4">
                        @if(isset($schedulesGrouped[$day]))
                            @foreach($schedulesGrouped[$day] as $sched)
                                <div class="bg-indigo-50/50 p-3 rounded-xl border border-indigo-100/50 hover:bg-white hover:shadow-md transition cursor-pointer">
                                    <p class="text-[11px] font-bold text-[#4318FF] bg-white rounded px-2 py-0.5 inline-block mb-2 shadow-sm border border-indigo-50">
                                        {{ $sched->start_time ?? '00:00' }} - {{ $sched->end_time ?? '00:00' }}
                                    </p>
                                    <h4 class="font-bold text-[#2B3674] text-sm leading-tight mb-1">{{ $sched->subject->name ?? 'Mata Pelajaran' }}</h4>
                                    <p class="text-xs text-[#A3AED0] flex items-center gap-1 mb-1">
                                        <i class='bx bx-user'></i> {{ $sched->teacher->name ?? 'Guru Belum Ada' }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 flex items-center gap-1">
                                        <i class='bx bx-map'></i> {{ $sched->room ?? '-' }}
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="h-full flex items-center justify-center pt-8">
                                <p class="text-xs text-center text-gray-400">Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State Dinyatakan Dari DB -->
        <div class="glass-card rounded-[24px] p-12 text-center bg-white border border-gray-100">
            <div class="w-24 h-24 bg-indigo-50 text-[#4318FF] mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                🗓️
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">Jadwal Belum Disusun</h2>
            <p class="text-[#A3AED0] max-w-md mx-auto">Sistem mendeteksi bahwa admin/guru belum menginput jadwal ke dalam database untuk kelas kamu.</p>
        </div>
    @endif
</div>
@endsection
