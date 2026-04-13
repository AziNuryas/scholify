@extends('layouts.student')

@section('title', 'Catatan Disiplin - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Catatan Kedisiplinan</h1>
        <p class="text-[#A3AED0]">Lihat riwayat pelanggaran dan poin kedisiplinan kamu selama di sekolah.</p>
    </div>

    <!-- Poin Keseluruhan -->
    <div class="bg-gradient-to-r from-red-500 to-rose-600 rounded-3xl p-8 text-white flex items-center justify-between shadow-lg shadow-red-200">
        <div>
            <p class="text-rose-100 font-medium mb-1">Total Poin Pelanggaran Kamu</p>
            <h2 class="font-outfit font-extrabold text-5xl">{{ $records->sum('points') }} <span class="text-xl font-medium">poin</span></h2>
        </div>
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur text-3xl">
            <i class='bx bx-pie-chart-alt-2'></i>
        </div>
    </div>

    <div class="glass-card bg-white rounded-3xl border border-indigo-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-[#A3AED0] font-bold tracking-wider">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-medium text-[#2B3674]">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-[#2B3674]">{{ $record->violation_type }}</td>
                        <td class="px-6 py-4 text-[#A3AED0]">{{ $record->description }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-lg font-bold">+{{ $record->points }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl">
                                <i class='bx bx-check-shield'></i>
                            </div>
                            <p class="font-bold text-[#2B3674]">Bagus! Tidak ada catatan pelanggaran.</p>
                            <p class="text-sm text-[#A3AED0] mt-1">Pertahankan terus kedisiplinanmu ya!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
