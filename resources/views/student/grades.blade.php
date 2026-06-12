@extends('layouts.student')
@section('title', 'Rekap Nilai - Scholify')
@section('page-title', 'Nilai & Rapor')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div class="flex items-center gap-4 mb-6">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg shadow-blue-500/30 flex items-center justify-center flex-shrink-0">
            <i data-lucide="bar-chart-2" class="w-7 h-7 text-white"></i>
        </div>
        <div>
            <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Rekapitulasi Nilai</h1>
            <p class="text-sm text-[var(--text-secondary)]">Laporan akademik dan hasil ujian selama semester berlangsung.</p>
        </div>
    </div>

    {{-- Statistik Ringkasan --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="neo-flat rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-emerald-500">{{ $grades->where('assessment_type', 'tugas')->count() }}</p>
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">Tugas</p>
        </div>
        <div class="neo-flat rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $grades->where('assessment_type', 'quiz')->count() }}</p>
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">Quiz</p>
        </div>
        <div class="neo-flat rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-amber-500">{{ $grades->where('assessment_type', 'uts')->count() }}</p>
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">UTS</p>
        </div>
        <div class="neo-flat rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-purple-500">{{ $grades->where('assessment_type', 'uas')->count() }}</p>
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">UAS</p>
        </div>
        <div class="neo-flat rounded-2xl p-4 text-center">
            <p class="text-2xl font-bold text-pink-500">{{ $grades->where('assessment_type', 'praktikum')->count() }}</p>
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">Praktikum</p>
        </div>
    </div>

    <div class="neo-flat rounded-2xl p-6">
        @if($grades->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="neo-pressed">
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider rounded-l-xl">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Jenis Penilaian</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Nilai</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Predikat</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center rounded-r-xl">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                        @foreach($grades as $idx => $grade)
                        @php
                            $score = $grade->score ?? 0;
                            
                            // Penentuan predikat berdasarkan nilai
                            if($score >= 90) {
                                $predikat = 'A';
                                $predikatText = 'Sangat Baik';
                                $badgeClass = 'bg-emerald-100 text-emerald-700';
                                $scoreClass = 'text-emerald-600';
                            } elseif($score >= 80) {
                                $predikat = 'B';
                                $predikatText = 'Baik';
                                $badgeClass = 'bg-blue-100 text-blue-700';
                                $scoreClass = 'text-blue-600';
                            } elseif($score >= 70) {
                                $predikat = 'C';
                                $predikatText = 'Cukup';
                                $badgeClass = 'bg-amber-100 text-amber-700';
                                $scoreClass = 'text-amber-600';
                            } elseif($score >= 60) {
                                $predikat = 'D';
                                $predikatText = 'Kurang';
                                $badgeClass = 'bg-orange-100 text-orange-700';
                                $scoreClass = 'text-orange-600';
                            } else {
                                $predikat = 'E';
                                $predikatText = 'Sangat Kurang';
                                $badgeClass = 'bg-red-100 text-red-700';
                                $scoreClass = 'text-red-600';
                            }
                            
                            // Label jenis penilaian
                            $assessmentLabels = [
                                'tugas' => 'Tugas Harian',
                                'quiz' => 'Quiz',
                                'uts' => 'UTS',
                                'uas' => 'UAS',
                                'praktikum' => 'Praktikum',
                            ];
                            $assessmentLabel = $assessmentLabels[$grade->assessment_type] ?? ucfirst($grade->assessment_type);
                            
                            // Warna badge jenis penilaian
                            $assessmentColors = [
                                'tugas' => 'bg-emerald-100 text-emerald-700',
                                'quiz' => 'bg-blue-100 text-blue-700',
                                'uts' => 'bg-amber-100 text-amber-700',
                                'uas' => 'bg-purple-100 text-purple-700',
                                'praktikum' => 'bg-pink-100 text-pink-700',
                            ];
                            $assessmentColor = $assessmentColors[$grade->assessment_type] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <tr class="group hover:bg-white/40 transition-colors">
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-medium text-[var(--text-muted)]">{{ $idx + 1 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/30">
                                        {{ strtoupper(substr($grade->subject_name ?? $grade->subject->name ?? '-', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-sm text-[var(--text-primary)]">{{ $grade->subject_name ?? $grade->subject->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $assessmentColor }}">
                                    {{ $assessmentLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-outfit font-extrabold text-xl {{ $scoreClass }}">{{ $score }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="inline-flex w-10 h-10 items-center justify-center rounded-xl text-sm font-bold shadow-md {{ $badgeClass }}">
                                        {{ $predikat }}
                                    </span>
                                    <span class="text-[10px] text-[var(--text-muted)] mt-1">{{ $predikatText }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($grade->notes)
                                <span class="text-xs text-[var(--text-muted)]">{{ $grade->notes }}</span>
                                @else
                                <span class="text-xs text-[var(--text-muted)]">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Rata-rata Nilai --}}
            <div class="mt-6 pt-4 border-t border-[var(--shadow-dark)]/10">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4 text-[var(--accent)]"></i>
                        <span class="text-sm font-semibold text-[var(--text-primary)]">Rata-rata Nilai</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @php
                            $avgScore = $grades->avg('score');
                            if($avgScore >= 90) {
                                $avgColor = 'text-emerald-600';
                                $avgPredikat = 'A (Sangat Baik)';
                            } elseif($avgScore >= 80) {
                                $avgColor = 'text-blue-600';
                                $avgPredikat = 'B (Baik)';
                            } elseif($avgScore >= 70) {
                                $avgColor = 'text-amber-600';
                                $avgPredikat = 'C (Cukup)';
                            } elseif($avgScore >= 60) {
                                $avgColor = 'text-orange-600';
                                $avgPredikat = 'D (Kurang)';
                            } else {
                                $avgColor = 'text-red-600';
                                $avgPredikat = 'E (Sangat Kurang)';
                            }
                        @endphp
                        <span class="font-outfit font-extrabold text-2xl {{ $avgColor }}">{{ round($avgScore, 2) }}</span>
                        <span class="text-sm font-semibold text-[var(--text-muted)]">{{ $avgPredikat }}</span>
                    </div>
                </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush