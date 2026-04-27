{{-- resources/views/guru/laporan/create.blade.php --}}
@extends('layouts.guru')

@section('page_title', 'Buat Laporan Siswa')
@section('page_subtitle', 'Laporkan siswa bermasalah kepada Guru BK secara terstruktur.')

@section('content')

<div class="max-w-2xl">

    {{-- Kembali --}}
    <a href="{{ route('guru.laporan.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Kembali ke daftar laporan
    </a>

    <div class="bg-white/70 backdrop-blur-sm border border-white/40 rounded-2xl shadow-lg p-8">
        <h2 class="text-base font-semibold text-slate-700 mb-6 pb-4 border-b border-slate-100">
            Formulir Laporan Siswa ke BK
        </h2>

        <form action="{{ route('guru.laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Siswa --}}
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Siswa <span class="text-red-500">*</span></label>
                <select id="siswa-select" name="siswa_id"
                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('siswa_id') border-red-400 @enderror">
                    <option value="">Pilih siswa...</option>
                    @foreach($siswaDiajar as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->name }} — {{ $siswa->kelas }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kategori Masalah <span class="text-red-500">*</span></label>
                    <select name="kategori"
                        class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('kategori') border-red-400 @enderror">
                        <option value="">Pilih kategori...</option>
                        @foreach($kategori as $val => $label)
                            <option value="{{ $val }}" {{ old('kategori') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Urgensi --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tingkat Urgensi <span class="text-red-500">*</span></label>
                    <select name="tingkat_urgensi"
                        class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('tingkat_urgensi') border-red-400 @enderror">
                        <option value="">Pilih urgensi...</option>
                        <option value="rendah"  {{ old('tingkat_urgensi') === 'rendah'  ? 'selected' : '' }}>🟢 Rendah</option>
                        <option value="sedang"  {{ old('tingkat_urgensi') === 'sedang'  ? 'selected' : '' }}>🔵 Sedang</option>
                        <option value="tinggi"  {{ old('tingkat_urgensi') === 'tinggi'  ? 'selected' : '' }}>🟠 Tinggi</option>
                        <option value="kritis"  {{ old('tingkat_urgensi') === 'kritis'  ? 'selected' : '' }}>🔴 Kritis</option>
                    </select>
                    @error('tingkat_urgensi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Judul --}}
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    placeholder="Contoh: Siswa sering tidak hadir tanpa keterangan"
                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('judul') border-red-400 @enderror"/>
                @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                    Deskripsi Lengkap <span class="text-red-500">*</span>
                    <span class="text-slate-400 font-normal">(min. 20 karakter)</span>
                </label>
                <textarea name="deskripsi" rows="5"
                    placeholder="Jelaskan situasi, kronologi, atau perilaku siswa secara rinci agar BK dapat menindaklanjuti dengan tepat..."
                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Bukti --}}
            <div class="mb-7">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                    Bukti Pendukung
                    <span class="text-slate-400 font-normal">(opsional, jpg/png/pdf maks 2MB)</span>
                </label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl px-4 py-5 text-center hover:border-indigo-300 transition">
                    <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-xs text-slate-400 mb-2">Drag & drop atau klik untuk memilih file</p>
                    <input type="file" name="bukti[]" multiple accept=".jpg,.jpeg,.png,.pdf"
                        class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer"/>
                </div>
            </div>

            {{-- Info box --}}
            <div class="mb-7 px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-xl flex items-start gap-3">
                <i data-lucide="info" class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-indigo-700">
                    Laporan ini akan diterima langsung oleh Guru BK dan dijaga kerahasiaannya.
                    Skor risiko siswa akan diperbarui otomatis setelah laporan dikirim.
                </p>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('guru.laporan.index') }}"
                    class="px-5 py-2.5 text-sm border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Kirim Laporan ke BK
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tom Select untuk siswa --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css"/>
<style>
    .ts-wrapper.single .ts-control { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; font-size: 0.875rem !important; padding: 0.5rem 0.75rem !important; }
    .ts-wrapper.single.focus .ts-control { border-color: #818cf8 !important; box-shadow: 0 0 0 2px rgba(129,140,248,0.25) !important; }
    .ts-dropdown { border-radius: 0.75rem !important; border-color: #e2e8f0 !important; box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important; font-size: 0.875rem !important; }
    .ts-dropdown .option:hover, .ts-dropdown .option.active { background: #eef2ff !important; color: #4338ca !important; }
</style>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    lucide.createIcons();
    new TomSelect('#siswa-select', {
        placeholder: 'Ketik nama atau kelas...',
        searchField: ['text'],
        maxOptions: 200,
        create: false,
        allowEmptyOption: true,
        render: {
            no_results: () => '<div style="padding:0.5rem 0.75rem;color:#94a3b8;font-size:0.875rem;">Siswa tidak ditemukan</div>'
        }
    });
</script>
@endsection