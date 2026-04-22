@extends('layouts.student')

@section('title', 'Rekap Nilai - Schoolify')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Rekapitulasi Nilai</h1>
            <p class="text-[#A3AED0]">Cek pencapaian prestasimu semester ini.</p>
        </div>
    </div>

    @if($grades->count() > 0)
        <!-- Tabel Nilai -->
        <div class="neo-flat rounded-[24px] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="neo-pressed text-[var(--text-muted)] text-sm uppercase tracking-wider">
                            <th class="p-5 font-semibold w-12 text-center">#</th>
                            <th class="p-5 font-semibold">Mata Pelajaran</th>
                            <th class="p-5 font-semibold">Jenis Tugas/Ujian</th>
                            <th class="p-5 font-semibold text-center">Nilai Akhir</th>
                            <th class="p-5 font-semibold text-center">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/60">
                        @foreach($grades as $idx => $grade)
                        <tr class="hover:neo-pressed transition">
                            <td class="p-5 text-center text-[var(--text-muted)] font-medium">{{ $idx + 1 }}</td>
                            <td class="p-5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg neo-badge-blue flex items-center justify-center text-lg">
                                    <i class='bx bx-book'></i>
                                </div>
                                <span class="font-bold text-[var(--brand-secondary)]">{{ $grade->subject_name ?? '-' }}</span>
                            </td>
                            <td class="p-5 text-[var(--text-muted)] font-medium">{{ $grade->type ?? '-' }}</td>
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
                                    $color = $score >= 90 ? 'neo-badge-green' : ($score >= 80 ? 'neo-badge-blue' : ($score >= 70 ? 'neo-badge-orange' : 'neo-badge-red'));
                                @endphp
                                <span class="px-3 py-1 text-white rounded-md text-sm font-bold shadow-sm inline-block w-10 {{ $color }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination / Footer Info -->
            <div class="px-6 py-4 neo-pressed border-t border-black/5 text-sm text-[var(--text-muted)] font-medium">
                Sistem Penilaian Kurikulum Merdeka (KKM: 75)
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="neo-flat rounded-[24px] p-12 text-center mt-8">
            <div class="w-24 h-24 neo-pressed text-indigo-500 mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                📝
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[var(--brand-secondary)] mb-2">Belum Ada Riwayat Nilai</h2>
            <p class="text-[var(--text-muted)] max-w-md mx-auto">Nilai ulangan kamu belum diinput atau masa ujian belum berlangsung.</p>
        </div>
    @endif
</div>
@endsection
