@extends('layouts.gurubk')

@section('title', 'Jadwal Temu - Schoolify')
@section('page-title', 'Jadwal Temu')

@section('content')
<div class="space-y-6 pt-2 animate-fadeInUp">

    <div class="mb-2">
        <h1 class="font-outfit font-bold text-3xl mb-1" style="color: var(--text-primary)">Jadwal Temu Siswa</h1>
        <p class="text-sm" style="color: var(--text-secondary)">Kelola permintaan antrian konsultasi langsung dari siswa.</p>
    </div>

    @if(session('success'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(239,68,68,.1); border-color: rgba(239,68,68,.3); color: #f87171">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid var(--border)">
            <h2 class="font-outfit font-bold text-lg" style="color: var(--text-primary)">Daftar Permintaan Jadwal</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs uppercase font-bold tracking-wider" style="border-bottom: 1px solid var(--border); color: var(--text-muted)">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Tanggal &amp; Waktu</th>
                        <th class="px-6 py-4">Catatan/Alasan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.06)'" onmouseout="this.style.background=''">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $appt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($appt->student->name) }}"
                                     class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold" style="color: var(--text-primary)">{{ $appt->student->name }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $appt->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium" style="color: var(--text-secondary)">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                            <p class="text-xs font-bold" style="color: var(--accent-light)">
                                <i class='bx bx-time-five'></i> {{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}
                            </p>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate" style="color: var(--text-secondary)" title="{{ $appt->notes }}">
                            {{ $appt->notes ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                            @elseif($appt->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">Disetujui</span>
                            @elseif($appt->status === 'completed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($appt->status === 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="w-8 h-8 rounded-xl flex items-center justify-center transition"
                                            style="background: rgba(168,85,247,.15); color: var(--accent-light)"
                                            onmouseover="this.style.background='var(--accent)';this.style.color='#fff'"
                                            onmouseout="this.style.background='rgba(168,85,247,.15)';this.style.color='var(--accent-light)'"
                                            title="Setujui"><i class='bx bx-check'></i></button>
                                </form>
                                <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="w-8 h-8 rounded-xl bg-red-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition"
                                            title="Tolak"><i class='bx bx-x'></i></button>
                                </form>
                            </div>
                            @elseif($appt->status === 'approved')
                            <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center gap-1 text-xs font-bold transition">
                                    <i class='bx bx-check-double'></i> Tandai Selesai
                                </button>
                            </form>
                            @else
                            <span class="text-xs font-medium" style="color: var(--text-muted)">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center" style="color: var(--text-muted)">
                            Belum ada permintaan jadwal temu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection