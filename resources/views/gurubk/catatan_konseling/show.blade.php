{{-- resources/views/gurubk/catatan_konseling/show.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Detail Catatan Konseling')
@section('page-title', 'Detail Catatan Konseling')

@section('content')
<div class="animate-fadeInUp max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Detail Catatan Konseling</h1>
            <p class="text-sm mt-1" style="color: var(--text-secondary)">
                {{ $catatanKonseling->siswa->name }} &mdash; {{ $catatanKonseling->tanggal_sesi->format('d M Y') }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('gurubk.catatan-konseling.edit', $catatanKonseling) }}"
               class="px-4 py-2 text-sm rounded-lg transition"
               style="border: 1px solid var(--border); color: var(--text-secondary)">Edit</a>
            <a href="{{ route('gurubk.catatan-konseling.index') }}"
               class="px-4 py-2 text-sm text-white rounded-lg transition"
               style="background: var(--accent)"
               onmouseover="this.style.background='var(--accent-hover)'"
               onmouseout="this.style.background='var(--accent)'">Kembali</a>
        </div>
    </div>

    <div class="neo-flat rounded-2xl p-6 space-y-5">

        {{-- Header siswa --}}
        <div class="flex items-center gap-3 pb-4" style="border-bottom: 1px solid var(--border)">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-medium text-sm"
                 style="background: var(--accent)">
                {{ strtoupper(substr($catatanKonseling->siswa->name, 0, 2)) }}
            </div>
            <div>
                <p class="font-semibold" style="color: var(--text-primary)">{{ $catatanKonseling->siswa->name }}</p>
                <p class="text-sm" style="color: var(--text-secondary)">{{ $catatanKonseling->siswa->kelas }}</p>
            </div>
            <div class="ml-auto">
                @php
                    $isActive = $catatanKonseling->status === 'berjalan';
                @endphp
                @if($isActive)
                    <span class="text-xs font-medium px-3 py-1 rounded-full"
                          style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                        {{ $catatanKonseling->status_label }}
                    </span>
                @elseif($catatanKonseling->status === 'selesai')
                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-blue-50 text-blue-800">
                        {{ $catatanKonseling->status_label }}
                    </span>
                @else
                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-amber-50 text-amber-800">
                        {{ $catatanKonseling->status_label }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs mb-1" style="color: var(--text-muted)">Tanggal sesi</p>
                <p style="color: var(--text-primary)">{{ $catatanKonseling->tanggal_sesi->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs mb-1" style="color: var(--text-muted)">Jenis konseling</p>
                <p style="color: var(--text-primary)">{{ $catatanKonseling->jenis_label }}</p>
            </div>
            <div>
                <p class="text-xs mb-1" style="color: var(--text-muted)">Dicatat oleh</p>
                <p style="color: var(--text-primary)">{{ $catatanKonseling->guruBk->name }}</p>
            </div>
            <div>
                <p class="text-xs mb-1" style="color: var(--text-muted)">Waktu input</p>
                <p style="color: var(--text-primary)">{{ $catatanKonseling->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="pt-4 space-y-4 text-sm" style="border-top: 1px solid var(--border)">
            <div>
                <p class="text-xs font-medium mb-1" style="color: var(--text-muted)">Masalah / topik yang dibahas</p>
                <p class="leading-relaxed" style="color: var(--text-primary)">{{ $catatanKonseling->masalah }}</p>
            </div>
            <div>
                <p class="text-xs font-medium mb-1" style="color: var(--text-muted)">Tindakan / intervensi guru BK</p>
                <p class="leading-relaxed" style="color: var(--text-primary)">{{ $catatanKonseling->tindakan }}</p>
            </div>
            @if($catatanKonseling->rencana_tindak_lanjut)
            <div>
                <p class="text-xs font-medium mb-1" style="color: var(--text-muted)">Rencana tindak lanjut</p>
                <p class="leading-relaxed" style="color: var(--text-primary)">{{ $catatanKonseling->rencana_tindak_lanjut }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection