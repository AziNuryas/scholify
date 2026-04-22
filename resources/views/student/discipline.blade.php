@extends('layouts.student')

@section('title', 'Catatan Disiplin - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Catatan Kedisiplinan</h1>
        <p class="text-[#A3AED0]">Lihat riwayat pelanggaran dan poin kedisiplinan kamu selama di sekolah.</p>
    </div>

    <!-- Poin Keseluruhan -->
    <div class="neo-badge-red rounded-[24px] p-8 text-white flex items-center justify-between">
        <div>
            <p class="text-rose-100 font-medium mb-1">Total Poin Pelanggaran Kamu</p>
            <h2 class="font-outfit font-extrabold text-5xl">{{ $records->sum('points') }} <span class="text-xl font-medium">poin</span></h2>
        </div>
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur text-3xl">
            <i class='bx bx-pie-chart-alt-2'></i>
        </div>
    </div>

    <div class="neo-flat rounded-3xl overflow-hidden mt-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="neo-pressed border-b border-black/5 text-xs uppercase text-[var(--text-muted)] font-bold tracking-wider">
                        <th class="px-6 py-5">Tanggal</th>
                        <th class="px-6 py-4">Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                    <tr class="hover:neo-pressed transition">
                        <td class="px-6 py-4 font-medium text-[var(--brand-secondary)]">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-[var(--brand-secondary)]">{{ $record->violation_type }}</td>
                        <td class="px-6 py-4 text-[var(--text-muted)]">{{ $record->description }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 neo-badge-red rounded-lg font-bold">+{{ $record->points }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 neo-pressed text-green-500 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl">
                                <i class='bx bx-check-shield'></i>
                            </div>
                            <p class="font-bold text-[var(--brand-secondary)]">Bagus! Tidak ada catatan pelanggaran.</p>
                            <p class="text-sm text-[var(--text-muted)] mt-1">Pertahankan terus kedisiplinanmu ya!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
