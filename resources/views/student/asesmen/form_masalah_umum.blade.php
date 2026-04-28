{{-- resources/views/siswa/asesmen/form_masalah_umum.blade.php --}}
@extends('layouts.student')

@section('title', 'Daftar Cek Masalah')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('student.asesmen.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-[#A3AED0] hover:text-[#4318FF] mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar asesmen
    </a>

    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-8 py-6 text-white">
            <div class="text-3xl mb-2">📋</div>
            <h1 class="font-outfit font-bold text-xl">Daftar Cek Masalah (DCM)</h1>
            <p class="text-rose-100 text-sm mt-1">Centang masalah yang kamu alami saat ini</p>
        </div>

        <div class="px-8 py-4 bg-rose-50 border-b border-rose-100">
            <p class="text-sm text-rose-800">
                Centang semua pernyataan yang sesuai dengan kondisimu. Tidak ada yang baik atau buruk — ini untuk membantumu.
            </p>
        </div>

        <form action="{{ route('student.asesmen.simpan', $asesmen->id) }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-3">
                @foreach($pertanyaan as $i => $soal)
                <label class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-rose-200 hover:bg-rose-50/30 cursor-pointer transition group">
                    <input type="checkbox"
                        name="jawaban[{{ $i }}]"
                        value="ya"
                        {{ isset($asesmen->jawaban[$i]) && $asesmen->jawaban[$i] === 'ya' ? 'checked' : '' }}
                        class="w-5 h-5 accent-rose-500 mt-0.5 flex-shrink-0">
                    <span class="text-sm text-[#2B3674] group-hover:text-rose-700 leading-relaxed">
                        {{ $soal['teks'] }}
                    </span>
                </label>
                @endforeach
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" name="selesai" value="0"
                    class="px-5 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition">
                    Simpan Draft
                </button>
                <button type="submit" name="selesai" value="1"
                    class="flex-1 py-2.5 text-sm font-semibold bg-rose-500 hover:bg-rose-600 text-white rounded-xl transition">
                    Selesai & Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection