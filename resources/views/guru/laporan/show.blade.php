{{-- resources/views/guru/laporan/show.blade.php --}}
@extends('layouts.guru')

@section('page_title', 'Detail Laporan')
@section('page_subtitle', 'Informasi lengkap laporan siswa yang telah dikirim ke BK.')

@section('content')

<div class="max-w-2xl">

    <a href="{{ route('guru.laporan.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar laporan
    </a>

    @php
        $urgColor = match($laporan->tingkat_urgensi) {
            'kritis' => 'red',
            'tinggi' => 'amber',
            'sedang' => 'blue',
            default  => 'slate',
        };
        $statusColor = match($laporan->status) {
            'selesai'  => 'green',
            'diproses' => 'blue',
            'ditutup'  => 'slate',
            default    => 'amber',
        };
        $statusLabel = match($laporan->status) {
            'baru'     => 'Menunggu Ditangani',
            'diproses' => 'Sedang Diproses BK',
            'selesai'  => 'Selesai Ditangani',
            'ditutup'  => 'Ditutup',
            default    => $laporan->status,
        };
    @endphp

    <div class="bg-white/70 backdrop-blur-sm border border-white/40 rounded-2xl shadow-lg overflow-hidden">

        {{-- Header status --}}
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 mb-1">Dikirim {{ $laporan->created_at->format('d M Y, H:i') }}</p>
                <h2 class="text-base font-semibold text-slate-800">{{ $laporan->judul }}</h2>
            </div>
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700 flex-shrink-0">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="p-8 space-y-6">

            {{-- Siswa --}}
            <div class="flex items-center gap-4 p-4 bg-indigo-50/50 rounded-xl border border-indigo-100">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($laporan->siswa->name ?? '?', 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs text-slate-400">Siswa yang dilaporkan</p>
                    <p class="font-semibold text-slate-800">{{ $laporan->siswa->name ?? '-' }}</p>
                    <p class="text-xs text-slate-500">{{ $laporan->siswa->kelas ?? '-' }}</p>
                </div>
            </div>

            {{-- Detail --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Kategori</p>
                    <p class="text-sm font-medium text-slate-700 capitalize">{{ $laporan->kategori }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Tingkat Urgensi</p>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700">
                        {{ $laporan->label_urgensi }}
                    </span>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-2">Deskripsi Lengkap</p>
                <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-xl p-4 border border-slate-100">
                    {{ $laporan->deskripsi }}
                </div>
            </div>

            {{-- Bukti --}}
            @if($laporan->bukti_pendukung && count($laporan->bukti_pendukung) > 0)
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-2">Bukti Pendukung</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($laporan->bukti_pendukung as $bukti)
                    <a href="{{ asset('storage/' . $bukti) }}" target="_blank"
                        class="flex items-center gap-2 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs text-indigo-600 hover:bg-indigo-50 transition">
                        <i data-lucide="paperclip" class="w-3.5 h-3.5"></i>
                        Lihat Berkas
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tindak lanjut BK --}}
            @if($laporan->tindak_lanjut)
            <div class="p-4 bg-green-50 border border-green-100 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                    <p class="text-xs font-semibold text-green-700">Tindak Lanjut dari BK</p>
                    @if($laporan->penanggungjawab)
                        <span class="text-xs text-green-600">— {{ $laporan->penanggungjawab->name }}</span>
                    @endif
                </div>
                <p class="text-sm text-green-800 leading-relaxed">{{ $laporan->tindak_lanjut }}</p>
                @if($laporan->ditangani_at)
                    <p class="text-xs text-green-500 mt-2">{{ $laporan->ditangani_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
            @else
            <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-3">
                <i data-lucide="clock" class="w-4 h-4 text-amber-500 flex-shrink-0"></i>
                <p class="text-xs text-amber-700">Laporan sedang menunggu tindak lanjut dari Guru BK.</p>
            </div>
            @endif

        </div>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection