{{-- resources/views/siswa/asesmen/form_gaya_belajar.blade.php --}}
@extends('layouts.student')

@section('title', 'Asesmen Gaya Belajar')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('student.asesmen.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-[#A3AED0] hover:text-[#4318FF] mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar asesmen
    </a>

    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
            <div class="text-3xl mb-2">📚</div>
            <h1 class="font-outfit font-bold text-xl">Gaya Belajar (VAK)</h1>
            <p class="text-blue-100 text-sm mt-1">Temukan apakah kamu Visual, Auditori, atau Kinestetik</p>
        </div>

        <form action="{{ route('student.asesmen.simpan', $asesmen->id) }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-8">
                @foreach($pertanyaan as $i => $soal)
                <div class="border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                    <p class="font-semibold text-[#2B3674] mb-4 leading-relaxed">
                        <span class="text-blue-600 font-bold me-2">{{ $i + 1 }}.</span>
                        {{ $soal['teks'] }}
                    </p>
                    <div class="space-y-2">
                        @foreach($soal['opsi'] as $val => $label)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 cursor-pointer transition group">
                            <input type="radio"
                                name="jawaban[{{ $i }}]"
                                value="{{ $val }}"
                                {{ isset($asesmen->jawaban[$i]) && $asesmen->jawaban[$i] === $val ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 accent-blue-600">
                            <span class="text-sm text-[#2B3674] group-hover:text-blue-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" name="selesai" value="0"
                    class="px-5 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition">
                    Simpan Draft
                </button>
                <button type="submit" name="selesai" value="1"
                    class="flex-1 py-2.5 text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">
                    Selesai & Lihat Hasil
                </button>
            </div>
        </form>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection