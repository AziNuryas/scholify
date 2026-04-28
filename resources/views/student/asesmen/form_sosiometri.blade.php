{{-- resources/views/siswa/asesmen/form_sosiometri.blade.php --}}
@extends('layouts.student')

@section('title', 'Sosiometri')

@section('content')

<div class="max-w-2xl mx-auto">

    <a href="{{ route('student.asesmen.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-[#A3AED0] hover:text-[#4318FF] mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar asesmen
    </a>

    <div class="bg-white rounded-2xl border border-purple-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-violet-600 px-8 py-6 text-white">
            <div class="text-3xl mb-2">🤝</div>
            <h1 class="font-outfit font-bold text-xl">Sosiometri</h1>
            <p class="text-purple-100 text-sm mt-1">Pemetaan hubungan pertemanan di kelasmu</p>
        </div>

        <div class="px-8 py-4 bg-purple-50 border-b border-purple-100">
            <p class="text-sm text-purple-800">
                Jawaban kamu hanya digunakan untuk keperluan bimbingan. Tidak ada yang akan dihakimi.
            </p>
        </div>

        <form action="{{ route('student.asesmen.simpan', $asesmen->id) }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-8">
                @foreach($pertanyaan as $i => $soal)
                <div class="border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                    <p class="font-semibold text-[#2B3674] mb-4 leading-relaxed">
                        <span class="text-purple-600 font-bold me-2">{{ $i + 1 }}.</span>
                        {{ $soal['teks'] }}
                    </p>

                    @if($soal['tipe'] === 'teman_picker')
                        @for($j = 1; $j <= $soal['maks']; $j++)
                        <div class="mb-2">
                            <input type="text"
                                name="jawaban[{{ $i }}][{{ $j - 1 }}]"
                                value="{{ $asesmen->jawaban[$i][$j - 1] ?? '' }}"
                                placeholder="Nama teman ke-{{ $j }}"
                                class="w-full text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>
                        @endfor

                    @elseif($soal['tipe'] === 'radio')
                        <div class="space-y-2">
                            @foreach($soal['opsi'] as $val => $label)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 cursor-pointer transition group">
                                <input type="radio"
                                    name="jawaban[{{ $i }}]"
                                    value="{{ $val }}"
                                    {{ isset($asesmen->jawaban[$i]) && $asesmen->jawaban[$i] === $val ? 'checked' : '' }}
                                    class="w-4 h-4 accent-purple-600">
                                <span class="text-sm text-[#2B3674] group-hover:text-purple-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" name="selesai" value="0"
                    class="px-5 py-2.5 text-sm border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition">
                    Simpan Draft
                </button>
                <button type="submit" name="selesai" value="1"
                    class="flex-1 py-2.5 text-sm font-semibold bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition">
                    Selesai & Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<script>lucide.createIcons();</script>
@endsection