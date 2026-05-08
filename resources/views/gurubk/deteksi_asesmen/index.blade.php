{{-- resources/views/gurubk/deteksi_asesmen/index.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Deteksi Dini & Asesmen')
@section('page-title', 'Deteksi Dini & Asesmen')

@section('content')
<div class="animate-fadeInUp space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Deteksi Dini & Asesmen</h1>
            <p class="text-sm mt-1" style="color: var(--text-secondary)">{{ $tahunAjaran }} — Semester {{ ucfirst($semester) }}</p>
        </div>
        <a href="{{ route('gurubk.laporan.index') }}"
           class="px-4 py-2 text-sm text-white rounded-lg transition"
           style="background: var(--accent)"
           onmouseover="this.style.background='var(--accent-hover)'"
           onmouseout="this.style.background='var(--accent)'">
            📋 Kelola Semua Laporan
        </a>
    </div>

    @if(session('success'))
        <div class="px-4 py-3 rounded-lg text-sm border"
             style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="neo-flat rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-red-500">{{ $statistik['kritis'] }}</div>
            <div class="text-xs mt-1" style="color: var(--text-muted)">Siswa Kritis</div>
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-50 text-red-700 mt-2 inline-block">⚠ Prioritas</span>
        </div>
        <div class="neo-flat rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-amber-500">{{ $statistik['berisiko'] }}</div>
            <div class="text-xs mt-1" style="color: var(--text-muted)">Siswa Berisiko</div>
        </div>
        <div class="neo-flat rounded-xl p-4 text-center">
            <div class="text-3xl font-bold text-blue-500">{{ $statistik['perhatian'] }}</div>
            <div class="text-xs mt-1" style="color: var(--text-muted)">Perlu Perhatian</div>
        </div>
        <div class="neo-flat rounded-xl p-4 text-center">
            <a href="{{ route('gurubk.laporan.index') }}?status=baru" class="block hover:opacity-75 transition">
                <div class="text-3xl font-bold text-amber-400">{{ $statistik['laporan_baru'] }}</div>
                <div class="text-xs mt-1" style="color: var(--text-muted)">Laporan Belum Ditangani</div>
                <span class="text-xs mt-1 inline-block" style="color: var(--accent-light)">Tangani →</span>
            </a>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <div x-data="{ tab: 'overview' }">

        <div class="neo-pressed flex gap-1 p-1 rounded-xl mb-6 w-fit">
            <button @click="tab = 'overview'"
                    :class="tab === 'overview' ? 'neo-flat font-semibold' : ''"
                    class="px-4 py-2 text-sm rounded-lg transition"
                    :style="tab === 'overview' ? 'color: var(--accent)' : 'color: var(--text-muted)'">
                📊 Overview
            </button>
            <button @click="tab = 'asesmen'"
                    :class="tab === 'asesmen' ? 'neo-flat font-semibold' : ''"
                    class="px-4 py-2 text-sm rounded-lg transition"
                    :style="tab === 'asesmen' ? 'color: var(--accent)' : 'color: var(--text-muted)'">
                📝 Asesmen Siswa
                <span class="ml-1 text-xs px-1.5 py-0.5 rounded-full"
                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                    {{ $statistik['asesmen_selesai'] }}
                </span>
            </button>
        </div>

        {{-- TAB: OVERVIEW --}}
        <div x-show="tab === 'overview'">
            <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

                {{-- Siswa Berisiko --}}
                <div class="lg:col-span-4 neo-flat rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border)">
                        <h2 class="text-sm font-semibold" style="color: var(--text-primary)">🚨 Siswa Berisiko & Kritis</h2>
                    </div>

                    @forelse ($siswaBerisiko as $item)
                        @php
                            $color = match($item->kategori_risiko) {
                                'kritis' => 'red', 'berisiko' => 'amber', 'perhatian' => 'blue', default => 'gray',
                            };
                        @endphp
                        <div class="flex items-center px-6 py-3 transition" style="border-bottom: 1px solid var(--border)"
                             onmouseover="this.style.background='rgba(168,85,247,.04)'" onmouseout="this.style.background=''">
                            <div class="w-9 h-9 rounded-full bg-{{ $color }}-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 me-3">
                                {{ strtoupper(substr($item->siswa->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium truncate" style="color: var(--text-primary)">{{ $item->siswa->name ?? '-' }}</p>
                                <p class="text-xs truncate" style="color: var(--text-muted)">
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
                        <div class="py-12 text-center text-sm" style="color: var(--text-muted)">
                            <div class="text-3xl mb-2">✅</div>
                            Tidak ada siswa dengan kategori berisiko atau kritis saat ini.
                        </div>
                    @endforelse

                    @if(method_exists($siswaBerisiko, 'hasPages') && $siswaBerisiko->hasPages())
                        <div class="px-6 py-3">{{ $siswaBerisiko->links() }}</div>
                    @endif
                </div>

                {{-- Laporan Terbaru --}}
                <div class="lg:col-span-3 neo-flat rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border)">
                        <h2 class="text-sm font-semibold" style="color: var(--text-primary)">📋 Laporan Baru dari Guru</h2>
                        <a href="{{ route('gurubk.laporan.index') }}" class="text-xs hover:opacity-70 transition"
                           style="color: var(--accent-light)">Semua →</a>
                    </div>

                    @forelse ($laporanBaru as $laporan)
                        @php
                            $urgColor = match($laporan->tingkat_urgensi) {
                                'kritis' => 'red', 'tinggi' => 'amber', 'sedang' => 'blue', default => 'gray',
                            };
                        @endphp
                        <div class="px-6 py-3 transition" style="border-bottom: 1px solid var(--border)"
                             onmouseover="this.style.background='rgba(168,85,247,.04)'" onmouseout="this.style.background=''">
                            <div class="flex items-start justify-between mb-1">
                                <span class="font-medium text-sm truncate me-2" style="color: var(--text-primary)">
                                    {{ $laporan->siswa->name ?? '-' }}
                                </span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700 flex-shrink-0">
                                    {{ $laporan->label_urgensi }}
                                </span>
                            </div>
                            <p class="text-xs mb-1" style="color: var(--text-muted)">
                                {{ $laporan->guru->name ?? '-' }} • {{ $laporan->created_at->diffForHumans() }}
                            </p>
                            <p class="text-xs truncate mb-2" style="color: var(--text-secondary)">{{ $laporan->judul }}</p>
                            <a href="{{ route('gurubk.laporan.index') }}#laporan-{{ $laporan->id }}"
                               class="text-xs hover:opacity-70 transition" style="color: var(--accent-light)">Tangani →</a>
                        </div>
                    @empty
                        <div class="py-12 text-center text-sm" style="color: var(--text-muted)">
                            <div class="text-3xl mb-2">📭</div>
                            Tidak ada laporan baru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- TAB: ASESMEN --}}
        <div x-show="tab === 'asesmen'">
            <div class="neo-flat rounded-2xl p-4 mb-4">
                <form method="GET" action="{{ route('gurubk.deteksi-asesmen.index') }}" class="flex flex-wrap gap-3">
                    <input type="hidden" name="tab" value="asesmen">
                    <select name="jenis"
                            class="text-xs rounded-lg px-3 py-2 outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="">Semua jenis</option>
                        <option value="gaya_belajar"     {{ request('jenis') === 'gaya_belajar'     ? 'selected' : '' }}>📚 Gaya Belajar</option>
                        <option value="minat_bakat"      {{ request('jenis') === 'minat_bakat'      ? 'selected' : '' }}>⭐ Minat & Bakat</option>
                        <option value="kesehatan_mental" {{ request('jenis') === 'kesehatan_mental' ? 'selected' : '' }}>💚 Kesehatan Mental</option>
                        <option value="masalah_umum"     {{ request('jenis') === 'masalah_umum'     ? 'selected' : '' }}>📋 Daftar Cek Masalah</option>
                        <option value="sosiometri"       {{ request('jenis') === 'sosiometri'       ? 'selected' : '' }}>🤝 Sosiometri</option>
                    </select>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama siswa..."
                           class="text-xs rounded-lg px-3 py-2 w-44 outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"/>
                    <button class="px-4 py-2 text-xs text-white rounded-lg transition"
                            style="background: var(--accent)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">Filter</button>
                    @if(request()->hasAny(['jenis','cari']))
                        <a href="{{ route('gurubk.deteksi-asesmen.index') }}?tab=asesmen"
                           class="px-4 py-2 text-xs rounded-lg transition"
                           style="border: 1px solid var(--border); color: var(--text-secondary)">Reset</a>
                    @endif
                </form>
            </div>

            <div class="neo-flat rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border)">
                                <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Siswa</th>
                                <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Jenis Asesmen</th>
                                <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Selesai</th>
                                <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Catatan BK</th>
                                <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asesmenList as $item)
                            <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                                onmouseover="this.style.background='rgba(168,85,247,.04)'" onmouseout="this.style.background=''">
                                <td class="py-3 px-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                             style="background: var(--accent)">
                                            {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                                        </div>
                                        <p class="font-medium" style="color: var(--text-primary)">{{ $item->siswa->name ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="py-3 px-5" style="color: var(--text-secondary)">{{ $item->label_jenis }}</td>
                                <td class="py-3 px-5 text-xs" style="color: var(--text-muted)">
                                    {{ $item->selesai_at?->format('d M Y, H:i') ?? '-' }}
                                </td>
                                <td class="py-3 px-5">
                                    @if($item->catatan_bk)
                                        <span class="text-xs" style="color: var(--accent-light)">✓ Sudah dicatat</span>
                                    @else
                                        <span class="text-xs" style="color: var(--text-muted)">Belum ada</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5">
                                    <button onclick="toggleAsesmen('detail-{{ $item->id }}')"
                                            class="text-xs font-medium hover:opacity-70 transition"
                                            style="color: var(--accent-light)">Tinjau</button>
                                </td>
                            </tr>

                            {{-- Detail inline --}}
                            <tr id="detail-{{ $item->id }}" class="hidden">
                                <td colspan="5" class="px-5 py-5" style="background: rgba(168,85,247,.06); border-bottom: 1px solid var(--border)">
                                    <div class="max-w-2xl">
                                        <h3 class="text-sm font-semibold mb-4" style="color: var(--text-primary)">
                                            Detail Asesmen — <span style="color: var(--accent-light)">{{ $item->siswa->name ?? '-' }}</span>
                                            ({{ $item->label_jenis }})
                                        </h3>

                                        @php $jawaban = $item->jawaban ?? []; $hasil = $item->hasil_analisis ?? []; @endphp

                                        @if($item->jenis_asesmen === 'gaya_belajar' && $hasil)
                                        @php $dominan = $hasil['dominan'] ?? '-'; $skor = $hasil['skor'] ?? []; $total = array_sum($skor) ?: 1; $label = ['visual'=>'Visual','auditori'=>'Auditori','kinestetik'=>'Kinestetik']; @endphp
                                        <div class="rounded-xl p-4 mb-4" style="background: var(--bg-card); border: 1px solid var(--border)">
                                            <p class="text-xs font-semibold mb-2" style="color: var(--text-muted)">HASIL GAYA BELAJAR</p>
                                            <p class="font-bold text-lg text-blue-500 mb-3">Tipe Dominan: {{ ucfirst($dominan) }}</p>
                                            @foreach($skor as $tipe => $nilai)
                                            <div class="mb-2">
                                                <div class="flex justify-between text-xs mb-1">
                                                    <span style="color: var(--text-secondary)">{{ $label[$tipe] ?? $tipe }}</span>
                                                    <span style="color: var(--text-muted)">{{ $nilai }} poin</span>
                                                </div>
                                                <div class="h-2 rounded-full" style="background: var(--border)">
                                                    <div class="h-full bg-blue-500 rounded-full" style="width:{{ round($nilai/$total*100) }}%"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        @elseif($item->jenis_asesmen === 'minat_bakat' && $hasil)
                                        @php $kode = $hasil['kode'] ?? '-'; $top3 = $hasil['top3'] ?? []; @endphp
                                        <div class="rounded-xl p-4 mb-4" style="background: var(--bg-card); border: 1px solid var(--border)">
                                            <p class="text-xs font-semibold mb-2" style="color: var(--text-muted)">HASIL MINAT & BAKAT (HOLLAND RIASEC)</p>
                                            <p class="font-bold text-xl text-amber-500 mb-3">Kode: {{ $kode }}</p>
                                            @foreach($top3 as $idx => $namaKat)
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold">{{ $idx+1 }}</div>
                                                <p class="text-sm" style="color: var(--text-primary)">{{ $namaKat }}</p>
                                            </div>
                                            @endforeach
                                        </div>

                                        @elseif($item->jenis_asesmen === 'kesehatan_mental')
                                        @php
                                            $pertanyaan = config('bk.pertanyaan.kesehatan_mental', []);
                                            $indikator  = collect($jawaban)->filter(fn($j) => in_array($j, ['ya','sering','selalu']))->count();
                                            $levelColor = $indikator >= 7 ? 'red' : ($indikator >= 4 ? 'amber' : 'green');
                                            $levelLabel = $indikator >= 7 ? 'Indikator Tinggi' : ($indikator >= 4 ? 'Indikator Sedang' : 'Kondisi Baik');
                                        @endphp
                                        <div class="rounded-xl p-4 mb-4" style="background: var(--bg-card); border: 1px solid var(--border)">
                                            <p class="text-xs font-semibold mb-2" style="color: var(--text-muted)">HASIL SKRINING KESEHATAN MENTAL</p>
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="text-2xl font-bold text-{{ $levelColor }}-500">{{ $indikator }}/{{ count($pertanyaan) }}</span>
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

                                        @elseif($item->jenis_asesmen === 'masalah_umum')
                                        @php $pertanyaan = config('bk.pertanyaan.masalah_umum', []); $tercentang = collect($jawaban)->filter(fn($j) => $j === 'ya')->count(); @endphp
                                        <div class="rounded-xl p-4 mb-4" style="background: var(--bg-card); border: 1px solid var(--border)">
                                            <p class="text-xs font-semibold mb-2" style="color: var(--text-muted)">DAFTAR CEK MASALAH (DCM)</p>
                                            <p class="font-bold text-lg text-rose-500 mb-3">{{ $tercentang }} masalah dicentang dari {{ count($pertanyaan) }}</p>
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

                                        @elseif($item->jenis_asesmen === 'sosiometri')
                                        @php $pertanyaan = config('bk.pertanyaan.sosiometri', []); @endphp
                                        <div class="rounded-xl p-4 mb-4" style="background: var(--bg-card); border: 1px solid var(--border)">
                                            <p class="text-xs font-semibold mb-3" style="color: var(--text-muted)">HASIL SOSIOMETRI</p>
                                            @foreach($pertanyaan as $i => $soal)
                                            <div class="mb-3">
                                                <p class="text-xs font-medium mb-1" style="color: var(--text-secondary)">{{ $soal['teks'] }}</p>
                                                @if(is_array($jawaban[$i] ?? null))
                                                    @foreach($jawaban[$i] as $nama)
                                                        @if($nama)
                                                        <span class="inline-block text-xs px-2 py-0.5 rounded-full me-1"
                                                              style="background: rgba(168,85,247,.15); border: 1px solid rgba(168,85,247,.3); color: var(--accent-light)">{{ $nama }}</span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @php $opsi = $soal['opsi'] ?? []; @endphp
                                                    <p class="text-sm" style="color: var(--text-primary)">{{ $opsi[$jawaban[$i] ?? ''] ?? ($jawaban[$i] ?? '-') }}</p>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                        {{-- Form Catatan BK --}}
                                        <form action="{{ route('bk.deteksi.asesmen.catatan', $item) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Catatan Guru BK</label>
                                            <textarea name="catatan_bk" rows="3"
                                                      placeholder="Tuliskan catatan atau rekomendasi tindak lanjut..."
                                                      class="w-full text-sm rounded-lg px-3 py-2 outline-none mb-3"
                                                      style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ $item->catatan_bk }}</textarea>
                                            <div class="flex gap-3">
                                                <button type="submit"
                                                        class="px-5 py-2 text-sm text-white rounded-lg font-medium transition"
                                                        style="background: var(--accent)"
                                                        onmouseover="this.style.background='var(--accent-hover)'"
                                                        onmouseout="this.style.background='var(--accent)'">
                                                    Simpan Catatan
                                                </button>
                                                <button type="button" onclick="toggleAsesmen('detail-{{ $item->id }}')"
                                                        class="px-4 py-2 text-sm rounded-lg transition"
                                                        style="border: 1px solid var(--border); color: var(--text-secondary)">
                                                    Tutup
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm" style="color: var(--text-muted)">
                                    Belum ada asesmen yang selesai diisi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($asesmenList) && $asesmenList->hasPages())
                    <div class="px-5 py-4" style="border-top: 1px solid var(--border)">{{ $asesmenList->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function toggleAsesmen(id) { document.getElementById(id).classList.toggle('hidden'); }
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'asesmen') {
        setTimeout(() => { document.querySelector('[\\@click="tab = \'asesmen\'"]')?.click(); }, 50);
    }
});
</script>
@endsection