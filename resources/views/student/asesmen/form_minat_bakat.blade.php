{{-- resources/views/siswa/asesmen/form_minat_bakat.blade.php --}}
@extends('layouts.student')

@section('title', 'Asesmen Minat & Bakat')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('student.asesmen.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-[#A3AED0] hover:text-[#4318FF] mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar asesmen
    </a>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6 text-white">
            <div class="text-3xl mb-2">⭐</div>
            <h1 class="font-outfit font-bold text-xl">Inventori Minat & Bakat</h1>
            <p class="text-amber-100 text-sm mt-1">Temukan tipe Holland RIASEC kamu</p>
        </div>

        <div class="px-8 py-4 bg-amber-50 border-b border-amber-100">
            <p class="text-sm text-amber-800">
                Jawab setiap pernyataan dengan jujur sesuai dirimu. Tidak ada jawaban benar atau salah.
            </p>
        </div>

        <form action="{{ route('student.asesmen.simpan', $asesmen->id) }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-5">
                @foreach($pertanyaan as $i => $soal)
                <div class="flex items-start justify-between gap-4 p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/30 transition">
                    <p class="text-sm text-[#2B3674] font-medium leading-relaxed flex-1">
                        <span class="text-amber-500 font-bold me-2">{{ $i + 1 }}.</span>
                        {{ $soal['teks'] }}
                    </p>
                    <div class="flex gap-3 flex-shrink-0">
                        @foreach($soal['opsi'] as $val => $label)
                        <label class="flex flex-col items-center gap-1 cursor-pointer">
                            <input type="radio"
                                name="jawaban[{{ $i }}]"
                                value="{{ $val === 'X' ? 'tidak' : $val }}"
                                {{ isset($asesmen->jawaban[$i]) && $asesmen->jawaban[$i] === ($val === 'X' ? 'tidak' : $val) ? 'checked' : '' }}
                                class="w-4 h-4 accent-amber-500">
                            <span class="text-xs text-[#A3AED0]">{{ $label }}</span>
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
                    class="flex-1 py-2.5 text-sm font-semibold bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition">
                    Selesai & Lihat Hasil
                </button>
            </div>
        </form>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection