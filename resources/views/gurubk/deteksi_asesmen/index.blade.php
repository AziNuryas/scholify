{{-- resources/views/gurubk/deteksi_asesmen/index.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Deteksi Dini & Asesmen')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Deteksi Dini & Asesmen</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $tahunAjaran }} — Semester {{ ucfirst($semester) }}</p>
        </div>
        <a href="{{ route('gurubk.laporan.index') }}"
            class="px-4 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
            📋 Kelola Semua Laporan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-teal-50 border border-teal-200 text-teal-800 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Kartu Statistik --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-red-500">{{ $statistik['kritis'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Siswa Kritis</div>
        <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-50 text-red-700 mt-2 inline-block">⚠ Prioritas</span>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-amber-500">{{ $statistik['berisiko'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Siswa Berisiko</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-blue-500">{{ $statistik['perhatian'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Perlu Perhatian</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <a href="{{ route('gurubk.laporan.index') }}?status=baru" class="block hover:opacity-75 transition">
            <div class="text-3xl font-bold text-amber-400">{{ $statistik['laporan_baru'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Laporan Belum Ditangani</div>
            <span class="text-xs text-teal-600 mt-1 inline-block">Tangani →</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

    {{-- Kolom Kiri: Siswa Berisiko --}}
    <div class="lg:col-span-4 bg-white border border-gray-200 rounded-xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">🚨 Siswa Berisiko & Kritis</h2>
        </div>

        @forelse ($siswaBerisiko as $item)
            @php
                $color = match($item->kategori_risiko) {
                    'kritis'    => 'red',
                    'berisiko'  => 'amber',
                    'perhatian' => 'blue',
                    default     => 'gray',
                };
            @endphp
            <div class="flex items-center px-6 py-3 border-b border-gray-50 hover:bg-gray-50 transition">
                <div class="w-9 h-9 rounded-full bg-{{ $color }}-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 me-3">
                    {{ strtoupper(substr($item->siswa->name ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 truncate">{{ $item->siswa->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400 truncate">
                        {{ $item->siswa->kelas ?? '-' }} •
                        {{ $item->total_laporan_guru }} laporan •
                        {{ $item->asesmen_selesai ? 'Asesmen ✓' : 'Belum asesmen' }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0 mx-3">
                    <div class="text-lg font-bold text-{{ $color }}-500">{{ $item->skor_risiko }}</div>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-{{ $color }}-50 text-{{ $color }}-700">
                        {{ ucfirst($item->kategori_risiko) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-sm text-gray-400">
                <div class="text-3xl mb-2">✅</div>
                Tidak ada siswa dengan kategori berisiko atau kritis saat ini.
            </div>
        @endforelse

        @if($siswaBerisiko->hasPages())
            <div class="px-6 py-3">{{ $siswaBerisiko->links() }}</div>
        @endif
    </div>

    {{-- Kolom Kanan: Laporan Terbaru --}}
    <div class="lg:col-span-3 bg-white border border-gray-200 rounded-xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">📋 Laporan Baru dari Guru</h2>
            <a href="{{ route('gurubk.laporan.index') }}" class="text-xs text-teal-600 hover:underline">Semua →</a>
        </div>

        @forelse ($laporanBaru as $laporan)
            @php
                $urgColor = match($laporan->tingkat_urgensi) {
                    'kritis' => 'red',
                    'tinggi' => 'amber',
                    'sedang' => 'blue',
                    default  => 'gray',
                };
            @endphp
            <div class="px-6 py-3 border-b border-gray-50 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between mb-1">
                    <span class="font-medium text-gray-800 text-sm truncate me-2">
                        {{ $laporan->siswa->name ?? '-' }}
                    </span>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700 flex-shrink-0">
                        {{ $laporan->label_urgensi }}
                    </span>
                </div>
                <p class="text-xs text-gray-400 mb-1">
                    {{ $laporan->guru->name ?? '-' }} • {{ $laporan->created_at->diffForHumans() }}
                </p>
                <p class="text-xs text-gray-600 truncate mb-2">{{ $laporan->judul }}</p>
                <a href="{{ route('gurubk.laporan.index') }}#laporan-{{ $laporan->id }}"
                    class="text-xs text-teal-600 hover:underline">Tangani →</a>
            </div>
        @empty
            <div class="py-12 text-center text-sm text-gray-400">
                <div class="text-3xl mb-2">📭</div>
                Tidak ada laporan baru.
            </div>
        @endforelse
    </div>

</div>

@endsection