{{-- resources/views/guru/laporan/index.blade.php --}}
@extends('layouts.guru')

@section('page_title', 'Laporan Siswa')
@section('page_subtitle', 'Riwayat laporan siswa bermasalah yang telah Anda kirim ke BK.')

@section('content')

@if(session('success'))
    <div class="mb-6 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Header + Tombol Buat --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Riwayat Laporan</h2>
        <p class="text-sm text-slate-500">Total {{ $laporan->total() }} laporan dikirim</p>
    </div>
    <a href="{{ route('guru.laporan.create') }}"
        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Buat Laporan Baru
    </a>
</div>

{{-- Tabel --}}
<div class="bg-white/70 backdrop-blur-sm border border-white/40 rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Siswa</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Kategori</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Judul</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Urgensi</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Status</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Tanggal</th>
                    <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-wide py-3 px-5">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                @php
                    $urgColor = match($item->tingkat_urgensi) {
                        'kritis' => 'red',
                        'tinggi' => 'amber',
                        'sedang' => 'blue',
                        default  => 'slate',
                    };
                    $statusColor = match($item->status) {
                        'selesai'   => 'green',
                        'diproses'  => 'blue',
                        'ditutup'   => 'slate',
                        default     => 'amber',
                    };
                    $statusLabel = match($item->status) {
                        'baru'      => 'Baru',
                        'diproses'  => 'Diproses',
                        'selesai'   => 'Selesai',
                        'ditutup'   => 'Ditutup',
                        default     => $item->status,
                    };
                @endphp
                <tr class="border-b border-slate-50 hover:bg-indigo-50/30 transition">
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $item->siswa->name ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $item->siswa->kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-5 text-slate-600 capitalize">{{ $item->kategori }}</td>
                    <td class="py-3 px-5">
                        <p class="text-slate-700 font-medium truncate max-w-xs">{{ $item->judul }}</p>
                    </td>
                    <td class="py-3 px-5">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700">
                            {{ $item->label_urgensi }}
                        </span>
                    </td>
                    <td class="py-3 px-5">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="py-3 px-5 text-slate-500 text-xs">
                        {{ $item->created_at->format('d M Y') }}
                    </td>
                    <td class="py-3 px-5">
                        <a href="{{ route('guru.laporan.show', $item) }}"
                            class="text-xs text-indigo-600 hover:underline font-medium">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <i data-lucide="file-x" class="w-10 h-10"></i>
                            <p class="text-sm">Belum ada laporan yang dikirim.</p>
                            <a href="{{ route('guru.laporan.create') }}"
                                class="text-sm text-indigo-600 hover:underline font-medium">Buat laporan pertama →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporan->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $laporan->links() }}
        </div>
    @endif
</div>

<script>lucide.createIcons();</script>
@endsection