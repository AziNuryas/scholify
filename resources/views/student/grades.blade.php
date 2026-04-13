@extends('layouts.student')

@section('title', 'Rekap Nilai - Schoolify')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Rekapitulasi Nilai</h1>
            <p class="text-[#A3AED0]">Cek pencapaian prestasimu semester ini.</p>
        </div>
        <!-- Filter Semester Dropdown (Mockup) -->
        <select class="bg-white border border-gray-200 text-[#2B3674] font-bold px-4 py-2 rounded-xl outline-none cursor-pointer hover:bg-gray-50 shadow-sm">
            <option>Semester Ganjil 2026/2027</option>
            <option>Semester Genap 2025/2026</option>
        </select>
    </div>

    @if($grades->count() > 0)
        <!-- Tabel Nilai -->
        <div class="glass-card bg-white rounded-[24px] overflow-hidden border border-gray-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[#A3AED0] text-sm uppercase tracking-wider">
                            <th class="p-5 font-semibold w-12 text-center">#</th>
                            <th class="p-5 font-semibold">Mata Pelajaran</th>
                            <th class="p-5 font-semibold">Jenis Tugas/Ujian</th>
                            <th class="p-5 font-semibold text-center">Nilai Akhir</th>
                            <th class="p-5 font-semibold text-center">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/60">
                        @foreach($grades as $idx => $grade)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-5 text-center text-[#A3AED0] font-medium">{{ $idx + 1 }}</td>
                            <td class="p-5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-[#4318FF] flex items-center justify-center text-lg">
                                    <i class='bx bx-book'></i>
                                </div>
                                <span class="font-bold text-[#2B3674]">{{ $grade->subject_name ?? 'Mata Pelajaran' }}</span>
                            </td>
                            <td class="p-5 text-[#A3AED0] font-medium">{{ $grade->type ?? 'Ulangan Harian' }}</td>
                            <td class="p-5">
                                <div class="flex items-center justify-center">
                                    <span class="font-outfit font-black text-xl 
                                        {{ ($grade->score ?? 0) >= 85 ? 'text-green-500' : (($grade->score ?? 0) >= 70 ? 'text-orange-500' : 'text-red-500') }}">
                                        {{ $grade->score ?? 0 }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                @php
                                    $score = $grade->score ?? 0;
                                    $predikat = $score >= 90 ? 'A' : ($score >= 80 ? 'B' : ($score >= 70 ? 'C' : 'D'));
                                    $color = $score >= 90 ? 'bg-green-100 text-green-700' : ($score >= 80 ? 'bg-blue-100 text-blue-700' : ($score >= 70 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700'));
                                @endphp
                                <span class="px-3 py-1 rounded-md text-sm font-bold shadow-sm inline-block w-10 {{ $color }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination / Footer Info -->
            <div class="px-6 py-4 border-t border-gray-100 text-sm text-[#A3AED0] font-medium">
                Sistem Penilaian Kurikulum Merdeka (KKM: 75)
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-[24px] p-12 text-center bg-white border border-gray-100 mt-8">
            <div class="w-24 h-24 bg-indigo-50 text-indigo-500 mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                📝
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">Belum Ada Riwayat Nilai</h2>
            <p class="text-[#A3AED0] max-w-md mx-auto">Nilai ulangan kamu belum diinput atau masa ujian belum berlangsung.</p>
        </div>
    @endif
</div>
@endsection
