@extends('layouts.gurubk')

@section('title', 'Jadwal Temu - Schoolify')

@section('content')
<div class="space-y-6 pt-2">
    <div class="mb-6">
        <h1 class="font-outfit font-bold text-3xl text-[#1E293B] mb-1">Jadwal Temu Siswa</h1>
        <p class="text-gray-500 text-sm">Kelola permintaan antrian konsultasi langsung dari siswa.</p>
    </div>

    @if(session('success'))
    <div class="bg-teal-50 border border-teal-200 text-teal-700 px-4 py-3 rounded-xl flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2 font-medium">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    <div class="glass-card bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="font-outfit font-bold text-[#1E293B] text-lg">Daftar Permintaan Jadwal</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Catatan/Alasan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr class="border-b border-gray-50 hover:bg-teal-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $appt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($appt->student->name) }}" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold text-[#1E293B]">{{ $appt->student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $appt->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                            <p class="text-xs text-teal-600 font-bold"><i class='bx bx-time-five'></i> {{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $appt->notes }}">
                            {{ $appt->notes ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                            @elseif($appt->status === 'approved')
                                <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs font-bold">Disetujui</span>
                            @elseif($appt->status === 'completed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($appt->status === 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('gurubk.appointment.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="w-8 h-8 rounded-xl bg-teal-100 text-teal-600 hover:bg-teal-600 hover:text-white flex items-center justify-center transition" title="Setujui"><i class='bx bx-check'></i></button>
                                </form>
                                <form action="{{ route('gurubk.appointment.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="w-8 h-8 rounded-xl bg-red-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="Tolak"><i class='bx bx-x'></i></button>
                                </form>
                            </div>
                            @elseif($appt->status === 'approved')
                            <form action="{{ route('gurubk.appointment.status', $appt->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center gap-1 text-xs font-bold transition"><i class='bx bx-check-double'></i> Tandai Selesai</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada permintaan jadwal temu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
