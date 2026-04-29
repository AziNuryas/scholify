{{-- resources/views/gurubk/catatan_konseling/show.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Detail Catatan Konseling')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Detail Catatan Konseling</h1>
        <p class="text-sm text-gray-500 mt-1">
            {{ $catatanKonseling->siswa->name }} &mdash; {{ $catatanKonseling->tanggal_sesi->format('d M Y') }}
        </p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('gurubk.catatan-konseling.edit', $catatanKonseling) }}"
            class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
            Edit
        </a>
        <a href="{{ route('gurubk.catatan-konseling.index') }}"
            class="px-4 py-2 text-sm bg-teal-600 text-white rounded-lg hover:bg-teal-700">
            Kembali
        </a>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">

    {{-- Header siswa --}}
    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
        <div class="w-12 h-12 rounded-full bg-teal-600 flex items-center justify-center text-white font-medium text-sm">
            {{ strtoupper(substr($catatanKonseling->siswa->name, 0, 2)) }}
        </div>
        <div>
            <p class="font-semibold text-gray-800">{{ $catatanKonseling->siswa->name }}</p>
            <p class="text-sm text-gray-500">{{ $catatanKonseling->siswa->kelas }}</p>
        </div>
        <div class="ml-auto">
            @php
                $badge = match($catatanKonseling->status) {
                    'selesai'       => 'bg-blue-50 text-blue-800',
                    'tindak_lanjut' => 'bg-amber-50 text-amber-800',
                    default         => 'bg-teal-50 text-teal-800',
                };
            @endphp
            <span class="text-xs font-medium px-3 py-1 rounded-full {{ $badge }}">
                {{ $catatanKonseling->status_label }}
            </span>
        </div>
    </div>

    {{-- Info --}}
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Tanggal sesi</p>
            <p class="text-gray-800">{{ $catatanKonseling->tanggal_sesi->format('d M Y') }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 mb-1">Jenis konseling</p>
            <p class="text-gray-800">{{ $catatanKonseling->jenis_label }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 mb-1">Dicatat oleh</p>
            <p class="text-gray-800">{{ $catatanKonseling->guruBk->name }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 mb-1">Waktu input</p>
            <p class="text-gray-800">{{ $catatanKonseling->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <div class="border-t border-gray-100 pt-4 space-y-4 text-sm">
        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Masalah / topik yang dibahas</p>
            <p class="text-gray-800 leading-relaxed">{{ $catatanKonseling->masalah }}</p>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Tindakan / intervensi guru BK</p>
            <p class="text-gray-800 leading-relaxed">{{ $catatanKonseling->tindakan }}</p>
        </div>
        @if($catatanKonseling->rencana_tindak_lanjut)
        <div>
            <p class="text-xs font-medium text-gray-400 mb-1">Rencana tindak lanjut</p>
            <p class="text-gray-800 leading-relaxed">{{ $catatanKonseling->rencana_tindak_lanjut }}</p>
        </div>
        @endif
    </div>

</div>
@endsection