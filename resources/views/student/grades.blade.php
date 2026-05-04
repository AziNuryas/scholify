@extends('layouts.student')
@section('title', 'Rekap Nilai - Schoolify')
@section('page-title', 'Nilai & Rapor')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div>
        <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Rekapitulasi Nilai</h1>
        <p class="text-sm text-[var(--text-secondary)]">Laporan akademik dan hasil ujian selama semester berlangsung.</p>
    </div>

    <div class="neo-flat rounded-2xl p-6">
        @if($grades->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="neo-pressed">
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider rounded-l-xl">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Nilai Akhir</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Predikat</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                        @foreach($grades as $idx => $grade)
                        @php
                            $score = $grade->score ?? 0;
                            $predikat = $score >= 90 ? 'A' : ($score >= 80 ? 'B' : ($score >= 70 ? 'C' : ($score >= 60 ? 'D' : 'E')));
                            
                            $badgeClass = '';
                            $textClass = '';
                            
                            if($score >= 90) {
                                $badgeClass = 'bg-emerald-500 text-white';
                                $textClass = 'text-emerald-500';
                            } elseif($score >= 80) {
                                $badgeClass = 'bg-blue-500 text-white';
                                $textClass = 'text-blue-500';
                            } elseif($score >= 70) {
                                $badgeClass = 'bg-amber-500 text-white';
                                $textClass = 'text-amber-500';
                            } else {
                                $badgeClass = 'bg-red-500 text-white';
                                $textClass = 'text-red-500';
                            }
                        @endphp
                        <tr class="group hover:bg-white/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30">
                                        <i data-lucide="book-open" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-sm text-[var(--text-primary)]">{{ $grade->subject_name ?? '-' }}</p>
                                        <p class="text-xs font-semibold text-[var(--text-secondary)] mt-0.5">{{ $grade->type ?? 'Ulangan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-outfit font-extrabold text-lg {{ $textClass }}">{{ $score }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-sm font-bold shadow-md {{ $badgeClass }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="w-8 h-8 rounded-lg neo-btn inline-flex items-center justify-center text-[var(--text-muted)] hover:text-indigo-600 transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center">
                <div class="w-16 h-16 neo-pressed rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="file-x" class="w-8 h-8 text-[var(--text-muted)]"></i>
                </div>
                <h3 class="font-extrabold text-lg text-[var(--text-primary)]">Belum Ada Nilai</h3>
                <p class="text-sm font-medium text-[var(--text-secondary)] mt-1">Nilai ujian atau tugas belum diinput oleh guru.</p>
            </div>
        @endif
    </div>
</div>
@endsection