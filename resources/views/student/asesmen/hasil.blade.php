{{-- resources/views/siswa/asesmen/hasil.blade.php --}}
@extends('layouts.student')

@section('title', 'Hasil Asesmen')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('student.asesmen.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-[#A3AED0] hover:text-[#4318FF] mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar asesmen
    </a>

    <div class="bg-white rounded-2xl border border-[#E0E5F2] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-[#4318FF] to-[#868CFF] px-8 py-6 text-white">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl">
                    @php
                        $icons = ['sosiometri'=>'🤝','minat_bakat'=>'⭐','gaya_belajar'=>'📚','kesehatan_mental'=>'💚','masalah_umum'=>'📋'];
                    @endphp
                    {{ $icons[$asesmen->jenis_asesmen] ?? '📄' }}
                </div>
                <div>
                    <h1 class="font-outfit font-bold text-xl">{{ $asesmen->label_jenis }}</h1>
                    <p class="text-indigo-200 text-sm">Selesai {{ $asesmen->selesai_at?->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">

            {{-- Gaya Belajar --}}
            @if($asesmen->jenis_asesmen === 'gaya_belajar' && $asesmen->hasil_analisis)
            @php
                $hasil = $asesmen->hasil_analisis;
                $dominan = $hasil['dominan'] ?? '-';
                $skor = $hasil['skor'] ?? [];
                $labelGaya = ['visual'=>'Visual','auditori'=>'Auditori','kinestetik'=>'Kinestetik'];
                $total = array_sum($skor) ?: 1;
            @endphp
            <div class="text-center mb-8">
                <div class="text-6xl mb-3">
                    @if($dominan === 'visual') 👁️
                    @elseif($dominan === 'auditori') 👂
                    @else 🖐️
                    @endif
                </div>
                <h2 class="font-outfit font-bold text-2xl text-[#2B3674]">Kamu adalah tipe <span class="text-[#4318FF]">{{ ucfirst($dominan) }}</span></h2>
                <p class="text-[#A3AED0] text-sm mt-2">Gaya belajar dominanmu berdasarkan jawaban kamu</p>
            </div>
            <div class="space-y-3">
                @foreach($skor as $tipe => $nilai)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-[#2B3674]">{{ $labelGaya[$tipe] ?? $tipe }}</span>
                        <span class="text-[#A3AED0]">{{ $nilai }} poin</span>
                    </div>
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#4318FF] rounded-full transition-all"
                            style="width: {{ $total > 0 ? round($nilai/$total*100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Minat Bakat --}}
            @elseif($asesmen->jenis_asesmen === 'minat_bakat' && $asesmen->hasil_analisis)
            @php
                $hasil = $asesmen->hasil_analisis;
                $kode = $hasil['kode'] ?? '-';
                $top3 = $hasil['top3'] ?? [];
            @endphp
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-100 rounded-2xl text-4xl mb-3">⭐</div>
                <h2 class="font-outfit font-bold text-2xl text-[#2B3674]">Kode Holland: <span class="text-amber-500">{{ $kode }}</span></h2>
            </div>
            @if(count($top3))
            <div class="space-y-3">
                @foreach($top3 as $idx => $label)
                <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-100">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                        {{ $idx + 1 }}
                    </div>
                    <p class="text-sm font-medium text-[#2B3674]">{{ $label }}</p>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Kesehatan Mental & Masalah Umum --}}
            @elseif(in_array($asesmen->jenis_asesmen, ['kesehatan_mental', 'masalah_umum', 'sosiometri']))
            <div class="text-center py-8">
                <div class="text-5xl mb-4">✅</div>
                <h2 class="font-outfit font-bold text-xl text-[#2B3674]">Asesmen berhasil dikirim!</h2>
                <p class="text-[#A3AED0] text-sm mt-2 max-w-sm mx-auto leading-relaxed">
                    Terima kasih sudah mengisi dengan jujur. Guru BK akan meninjau jawabanmu dan menghubungimu jika diperlukan.
                </p>
            </div>
            @endif

            {{-- Catatan BK --}}
            @if($asesmen->catatan_bk)
            <div class="mt-6 p-4 bg-green-50 border border-green-100 rounded-xl">
                <p class="text-xs font-semibold text-green-700 mb-1">💬 Catatan dari Guru BK</p>
                <p class="text-sm text-green-800">{{ $asesmen->catatan_bk }}</p>
            </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('student.asesmen.index') }}"
                    class="block w-full text-center py-2.5 text-sm font-semibold bg-[#4318FF] hover:bg-indigo-700 text-white rounded-xl transition">
                    Kembali ke Daftar Asesmen
                </a>
            </div>
        </div>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection