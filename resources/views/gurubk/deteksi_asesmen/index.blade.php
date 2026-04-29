{{-- resources/views/gurubk/deteksi_asesmen/index.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Deteksi Dini & Asesmen')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Deteksi Dini & Asesmen</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $tahunAjaran }} — Semester {{ ucfirst($semester) }}</p>
        </div>
        <a href="{{ route('gurubk.laporan.index') }}"
            class="px-4 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
            📋 Kelola Semua Laporan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-teal-50 border border-teal-200 text-teal-800 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Kartu Statistik --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-red-500">{{ $statistik['kritis'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Siswa Kritis</div>
        <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-50 text-red-700 mt-2 inline-block">⚠ Prioritas</span>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-amber-500">{{ $statistik['berisiko'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Siswa Berisiko</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-3xl font-bold text-blue-500">{{ $statistik['perhatian'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Perlu Perhatian</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <a href="{{ route('gurubk.laporan.index') }}?status=baru" class="block hover:opacity-75 transition">
            <div class="text-3xl font-bold text-amber-400">{{ $statistik['laporan_baru'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Laporan Belum Ditangani</div>
            <span class="text-xs text-teal-600 mt-1 inline-block">Tangani →</span>
        </a>
    </div>
</div>

{{-- TAB NAVIGATION --}}
<div x-data="{ tab: 'overview' }">

    <div class="flex gap-1 bg-gray-100 p-1 rounded-xl mb-6 w-fit">
        <button @click="tab = 'overview'"
            :class="tab === 'overview' ? 'bg-white shadow text-teal-700 font-semibold' : 'text-gray-500 hover:text-gray-700'"
            class="px-4 py-2 text-sm rounded-lg transition">
            📊 Overview
        </button>
        <button @click="tab = 'asesmen'"
            :class="tab === 'asesmen' ? 'bg-white shadow text-teal-700 font-semibold' : 'text-gray-500 hover:text-gray-700'"
            class="px-4 py-2 text-sm rounded-lg transition">
            📝 Asesmen Siswa
            <span class="ml-1 text-xs bg-teal-100 text-teal-700 px-1.5 py-0.5 rounded-full">{{ $statistik['asesmen_selesai'] }}</span>
        </button>
    </div>

    {{-- TAB: OVERVIEW --}}
    <div x-show="tab === 'overview'">
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

            {{-- Kolom Kiri: Siswa Berisiko --}}
            <div class="lg:col-span-4 bg-white border border-gray-200 rounded-xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">🚨 Siswa Berisiko & Kritis</h2>
                </div>

                @forelse ($siswaBerisiko as $item)
                    @php
                        $color = match($item->kategori_risiko) {
                            'kritis'    => 'red',
                            'berisiko'  => 'amber',
                            'perhatian' => 'blue',
                            default     => 'gray',
                        };
                    @endphp
                    <div class="flex items-center px-6 py-3 border-b border-gray-50 hover:bg-gray-50 transition">
                        <div class="w-9 h-9 rounded-full bg-{{ $color }}-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 me-3">
                            {{ strtoupper(substr($item->siswa->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $item->siswa->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ $item->siswa->kelas ?? '-' }} •
                                {{ $item->total_laporan_guru }} laporan •
                                {{ $item->asesmen_selesai ? 'Asesmen ✓' : 'Belum asesmen' }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0 mx-3">
                            <div class="text-lg font-bold text-{{ $color }}-500">{{ $item->skor_risiko }}</div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-{{ $color }}-50 text-{{ $color }}-700">
                                {{ ucfirst($item->kategori_risiko) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-sm text-gray-400">
                        <div class="text-3xl mb-2">✅</div>
                        Tidak ada siswa dengan kategori berisiko atau kritis saat ini.
                    </div>
                @endforelse

                @if($siswaBerisiko->hasPages())
                    <div class="px-6 py-3">{{ $siswaBerisiko->links() }}</div>
                @endif
            </div>

            {{-- Kolom Kanan: Laporan Terbaru --}}
            <div class="lg:col-span-3 bg-white border border-gray-200 rounded-xl">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">📋 Laporan Baru dari Guru</h2>
                    <a href="{{ route('gurubk.laporan.index') }}" class="text-xs text-teal-600 hover:underline">Semua →</a>
                </div>

                @forelse ($laporanBaru as $laporan)
                    @php
                        $urgColor = match($laporan->tingkat_urgensi) {
                            'kritis' => 'red',
                            'tinggi' => 'amber',
                            'sedang' => 'blue',
                            default  => 'gray',
                        };
                    @endphp
                    <div class="px-6 py-3 border-b border-gray-50 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between mb-1">
                            <span class="font-medium text-gray-800 text-sm truncate me-2">
                                {{ $laporan->siswa->name ?? '-' }}
                            </span>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700 flex-shrink-0">
                                {{ $laporan->label_urgensi }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-1">
                            {{ $laporan->guru->name ?? '-' }} • {{ $laporan->created_at->diffForHumans() }}
                        </p>
                        <p class="text-xs text-gray-600 truncate mb-2">{{ $laporan->judul }}</p>
                        <a href="{{ route('gurubk.laporan.index') }}#laporan-{{ $laporan->id }}"
                            class="text-xs text-teal-600 hover:underline">Tangani →</a>
                    </div>
                @empty
                    <div class="py-12 text-center text-sm text-gray-400">
                        <div class="text-3xl mb-2">📭</div>
                        Tidak ada laporan baru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- TAB: ASESMEN SISWA --}}
    <div x-show="tab === 'asesmen'">

        {{-- Filter --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
            <form method="GET" action="{{ route('gurubk.deteksi-asesmen.index') }}" class="flex flex-wrap gap-3">
                <input type="hidden" name="tab" value="asesmen">
                <select name="jenis" class="text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <option value="">Semua jenis</option>
                    <option value="gaya_belajar"     {{ request('jenis') === 'gaya_belajar'     ? 'selected' : '' }}>📚 Gaya Belajar</option>
                    <option value="minat_bakat"      {{ request('jenis') === 'minat_bakat'      ? 'selected' : '' }}>⭐ Minat & Bakat</option>
                    <option value="kesehatan_mental" {{ request('jenis') === 'kesehatan_mental' ? 'selected' : '' }}>💚 Kesehatan Mental</option>
                    <option value="masalah_umum"     {{ request('jenis') === 'masalah_umum'     ? 'selected' : '' }}>📋 Daftar Cek Masalah</option>
                    <option value="sosiometri"       {{ request('jenis') === 'sosiometri'       ? 'selected' : '' }}>🤝 Sosiometri</option>
                </select>
                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Cari nama siswa..."
                    class="text-xs border border-gray-200 rounded-lg px-3 py-2 w-44 focus:outline-none focus:ring-2 focus:ring-teal-400"/>
                <button class="px-4 py-2 text-xs bg-teal-600 text-white rounded-lg hover:bg-teal-700">Filter</button>
                @if(request()->hasAny(['jenis','cari']))
                    <a href="{{ route('gurubk.deteksi-asesmen.index') }}?tab=asesmen"
                        class="px-4 py-2 text-xs border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50">Reset</a>
                @endif
            </form>
        </div>

        {{-- Tabel Asesmen --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Siswa</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Jenis Asesmen</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Selesai</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Catatan BK</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asesmenList as $item)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                                    </div>
                                    <p class="font-medium text-gray-800">{{ $item->siswa->name ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-gray-700">{{ $item->label_jenis }}</td>
                            <td class="py-3 px-5 text-gray-400 text-xs">
                                {{ $item->selesai_at?->format('d M Y, H:i') ?? '-' }}
                            </td>
                            <td class="py-3 px-5">
                                @if($item->catatan_bk)
                                    <span class="text-xs text-teal-600">✓ Sudah dicatat</span>
                                @else
                                    <span class="text-xs text-gray-300">Belum ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-5">
                                <button onclick="toggleAsesmen('detail-{{ $item->id }}')"
                                    class="text-xs text-teal-600 hover:underline font-medium">Tinjau</button>
                            </td>
                        </tr>

                        {{-- Detail asesmen inline --}}
                        <tr id="detail-{{ $item->id }}" class="hidden">
                            <td colspan="5" class="px-5 py-5 bg-teal-50 border-b border-teal-100">
                                <div class="max-w-2xl">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-4">
                                        Detail Asesmen — <span class="text-teal-700">{{ $item->siswa->name ?? '-' }}</span>
                                        ({{ $item->label_jenis }})
                                    </h3>

                                    @php
                                        $jawaban = $item->jawaban ?? [];
                                        $hasil   = $item->hasil_analisis ?? [];
                                    @endphp

                                    {{-- Gaya Belajar --}}
                                    @if($item->jenis_asesmen === 'gaya_belajar' && $hasil)
                                    @php
                                        $dominan = $hasil['dominan'] ?? '-';
                                        $skor    = $hasil['skor'] ?? [];
                                        $total   = array_sum($skor) ?: 1;
                                        $label   = ['visual'=>'Visual','auditori'=>'Auditori','kinestetik'=>'Kinestetik'];
                                    @endphp
                                    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">HASIL GAYA BELAJAR</p>
                                        <p class="font-bold text-lg text-blue-700 mb-3">Tipe Dominan: {{ ucfirst($dominan) }}</p>
                                        @foreach($skor as $tipe => $nilai)
                                        <div class="mb-2">
                                            <div class="flex justify-between text-xs mb-1">
                                                <span>{{ $label[$tipe] ?? $tipe }}</span>
                                                <span class="text-gray-400">{{ $nilai }} poin</span>
                                            </div>
                                            <div class="h-2 bg-gray-100 rounded-full">
                                                <div class="h-full bg-blue-500 rounded-full" style="width:{{ round($nilai/$total*100) }}%"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- Minat Bakat --}}
                                    @elseif($item->jenis_asesmen === 'minat_bakat' && $hasil)
                                    @php
                                        $kode = $hasil['kode'] ?? '-';
                                        $top3 = $hasil['top3'] ?? [];
                                    @endphp
                                    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">HASIL MINAT & BAKAT (HOLLAND RIASEC)</p>
                                        <p class="font-bold text-xl text-amber-600 mb-3">Kode: {{ $kode }}</p>
                                        @foreach($top3 as $idx => $namaKat)
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold">{{ $idx+1 }}</div>
                                            <p class="text-sm text-gray-700">{{ $namaKat }}</p>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- Kesehatan Mental --}}
                                    @elseif($item->jenis_asesmen === 'kesehatan_mental')
                                    @php
                                        $pertanyaan = config('bk.pertanyaan.kesehatan_mental', []);
                                        $indikator  = collect($jawaban)->filter(fn($j) => in_array($j, ['ya','sering','selalu']))->count();
                                        $levelColor = $indikator >= 7 ? 'red' : ($indikator >= 4 ? 'amber' : 'green');
                                        $levelLabel = $indikator >= 7 ? 'Indikator Tinggi' : ($indikator >= 4 ? 'Indikator Sedang' : 'Kondisi Baik');
                                    @endphp
                                    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">HASIL SKRINING KESEHATAN MENTAL</p>
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="text-2xl font-bold text-{{ $levelColor }}-600">{{ $indikator }}/{{ count($pertanyaan) }}</span>
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-{{ $levelColor }}-50 text-{{ $levelColor }}-700">{{ $levelLabel }}</span>
                                        </div>
                                        <div class="space-y-1">
                                            @foreach($pertanyaan as $i => $soal)
                                            @if(in_array($jawaban[$i] ?? '', ['ya','sering','selalu']))
                                            <div class="flex items-start gap-2 p-2 bg-red-50 rounded-lg">
                                                <span class="text-red-400 text-xs mt-0.5">⚠</span>
                                                <p class="text-xs text-gray-600">{{ $soal['teks'] }}
                                                    <span class="font-semibold text-red-600"> — {{ $soal['opsi'][$jawaban[$i]] ?? $jawaban[$i] }}</span>
                                                </p>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- DCM --}}
                                    @elseif($item->jenis_asesmen === 'masalah_umum')
                                    @php
                                        $pertanyaan = config('bk.pertanyaan.masalah_umum', []);
                                        $tercentang = collect($jawaban)->filter(fn($j) => $j === 'ya')->count();
                                    @endphp
                                    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4">
                                        <p class="text-xs font-semibold text-gray-400 mb-2">DAFTAR CEK MASALAH (DCM)</p>
                                        <p class="font-bold text-lg text-rose-600 mb-3">{{ $tercentang }} masalah dicentang dari {{ count($pertanyaan) }}</p>
                                        <div class="space-y-1">
                                            @foreach($pertanyaan as $i => $soal)
                                            @if(($jawaban[$i] ?? '') === 'ya')
                                            <div class="flex items-center gap-2 p-2 bg-rose-50 rounded-lg">
                                                <span class="text-rose-500">✓</span>
                                                <p class="text-xs text-gray-700">{{ $soal['teks'] }}</p>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Sosiometri --}}
                                    @elseif($item->jenis_asesmen === 'sosiometri')
                                    @php $pertanyaan = config('bk.pertanyaan.sosiometri', []); @endphp
                                    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4">
                                        <p class="text-xs font-semibold text-gray-400 mb-3">HASIL SOSIOMETRI</p>
                                        @foreach($pertanyaan as $i => $soal)
                                        <div class="mb-3">
                                            <p class="text-xs font-medium text-gray-600 mb-1">{{ $soal['teks'] }}</p>
                                            @if(is_array($jawaban[$i] ?? null))
                                                @foreach($jawaban[$i] as $nama)
                                                    @if($nama)
                                                    <span class="inline-block text-xs bg-purple-50 border border-purple-200 text-purple-700 px-2 py-0.5 rounded-full me-1">{{ $nama }}</span>
                                                    @endif
                                                @endforeach
                                            @else
                                                @php $opsi = $soal['opsi'] ?? []; @endphp
                                                <p class="text-sm text-gray-700">{{ $opsi[$jawaban[$i] ?? ''] ?? ($jawaban[$i] ?? '-') }}</p>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif

                                    {{-- Form Catatan BK --}}
                                    <form action="{{ route('bk.deteksi.asesmen.catatan', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Catatan Guru BK</label>
                                        <textarea name="catatan_bk" rows="3"
                                            placeholder="Tuliskan catatan atau rekomendasi tindak lanjut..."
                                            class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 mb-3">{{ $item->catatan_bk }}</textarea>
                                        <div class="flex gap-3">
                                            <button type="submit"
                                                class="px-5 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium transition">
                                                Simpan Catatan
                                            </button>
                                            <button type="button" onclick="toggleAsesmen('detail-{{ $item->id }}')"
                                                class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
                                                Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm text-gray-400">
                                Belum ada asesmen yang selesai diisi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($asesmenList) && $asesmenList->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $asesmenList->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<script>
function toggleAsesmen(id) {
    document.getElementById(id).classList.toggle('hidden');
}

// Buka tab asesmen otomatis jika ada parameter tab=asesmen di URL
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'asesmen') {
        // Alpine.js belum tentu ready, pakai timeout kecil
        setTimeout(() => {
            const btn = document.querySelector('[\\@click="tab = \'asesmen\'"]');
            if (btn) btn.click();
        }, 50);
    }
});
</script>

@endsection