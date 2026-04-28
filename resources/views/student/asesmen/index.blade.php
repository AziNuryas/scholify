{{-- resources/views/student/asesmen/index.blade.php --}}
@extends('layouts.student')

@section('title', 'Asesmen Mandiri')

@section('content')

<div class="mb-8">
    <h1 class="font-outfit font-extrabold text-2xl text-[#2B3674]">Asesmen Mandiri</h1>
    <p class="text-sm text-[#A3AED0] mt-1">{{ $tahunAjaran }} — Semester {{ ucfirst($semester) }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($jenisAsesmen as $jenis => $info)
    @php
        $status = $statusAsesmen[$jenis] ?? null;
        $selesai = $status && $status->status === 'selesai';
        $draft   = $status && $status->status === 'draft';

        $icons = [
            'sosiometri'       => '🤝',
            'minat_bakat'      => '⭐',
            'gaya_belajar'     => '📚',
            'kesehatan_mental' => '💚',
            'masalah_umum'     => '📋',
        ];

        $colors = [
            'sosiometri'       => ['bg' => 'bg-purple-50',  'border' => 'border-purple-200', 'btn' => 'bg-purple-600 hover:bg-purple-700', 'badge_bg' => 'bg-purple-100', 'badge_text' => 'text-purple-700'],
            'minat_bakat'      => ['bg' => 'bg-amber-50',   'border' => 'border-amber-200',  'btn' => 'bg-amber-500 hover:bg-amber-600',   'badge_bg' => 'bg-amber-100',  'badge_text' => 'text-amber-700'],
            'gaya_belajar'     => ['bg' => 'bg-blue-50',    'border' => 'border-blue-200',   'btn' => 'bg-blue-600 hover:bg-blue-700',     'badge_bg' => 'bg-blue-100',   'badge_text' => 'text-blue-700'],
            'kesehatan_mental' => ['bg' => 'bg-green-50',   'border' => 'border-green-200',  'btn' => 'bg-green-600 hover:bg-green-700',   'badge_bg' => 'bg-green-100',  'badge_text' => 'text-green-700'],
            'masalah_umum'     => ['bg' => 'bg-rose-50',    'border' => 'border-rose-200',   'btn' => 'bg-rose-500 hover:bg-rose-600',     'badge_bg' => 'bg-rose-100',   'badge_text' => 'text-rose-700'],
        ];

        $c = $colors[$jenis];
    @endphp

    <div class="bg-white rounded-2xl border {{ $c['border'] }} p-6 flex flex-col gap-4 shadow-sm hover:shadow-md transition">
        <div class="flex items-start justify-between">
            <div class="text-4xl">{{ $icons[$jenis] }}</div>
            @if($selesai)
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">✓ Selesai</span>
            @elseif($draft)
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-700">⏳ Draft</span>
            @else
                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $c['badge_bg'] }} {{ $c['badge_text'] }}">Belum diisi</span>
            @endif
        </div>

        <div>
            <h3 class="font-outfit font-bold text-lg text-[#2B3674]">{{ $info['label'] }}</h3>
            <p class="text-sm text-[#A3AED0] mt-1 leading-relaxed">{{ $info['deskripsi'] }}</p>
        </div>

        <div class="mt-auto pt-2">
            @if($selesai)
                <a href="{{ route('student.asesmen.hasil', $status->id) }}"
                    class="block w-full text-center py-2.5 text-sm font-semibold rounded-xl bg-green-600 hover:bg-green-700 text-white transition">
                    Lihat Hasil
                </a>
            @elseif($draft)
                <a href="{{ route('student.asesmen.isi', $jenis) }}"
                    class="block w-full text-center py-2.5 text-sm font-semibold rounded-xl {{ $c['btn'] }} text-white transition">
                    Lanjutkan Pengisian
                </a>
            @else
                <a href="{{ route('student.asesmen.isi', $jenis) }}"
                    class="block w-full text-center py-2.5 text-sm font-semibold rounded-xl {{ $c['btn'] }} text-white transition">
                    Mulai Asesmen
                </a>
            @endif
        </div>
    </div>
    @endforeach
</div>

@endsection