{{-- resources/views/gurubk/laporan.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Laporan dari Guru')
@section('page-title', 'Laporan dari Guru')

@section('content')
<div class="animate-fadeInUp">

    <div class="mb-6">
        <a href="{{ route('gurubk.deteksi-asesmen.index') }}"
           class="inline-flex items-center gap-1.5 text-sm mb-4 transition hover:opacity-80"
           style="color: var(--text-muted)">
            ← Kembali ke Deteksi Dini & Asesmen
        </a>
        <h1 class="text-xl font-semibold" style="color: var(--text-primary)">Laporan dari Guru</h1>
        <p class="text-sm mt-1" style="color: var(--text-secondary)">Tinjau dan tindak lanjuti laporan siswa bermasalah dari guru mapel.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm border"
             style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="neo-flat rounded-2xl p-4 mb-6">
        <form method="GET" action="{{ route('gurubk.laporan.index') }}" class="flex flex-wrap gap-3">
            <select name="status"
                    class="text-xs rounded-lg px-3 py-2 outline-none"
                    style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                <option value="">Semua status</option>
                <option value="baru"     {{ request('status') === 'baru'     ? 'selected' : '' }}>Baru</option>
                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai"  {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                <option value="ditutup"  {{ request('status') === 'ditutup'  ? 'selected' : '' }}>Ditutup</option>
            </select>
            <select name="urgensi"
                    class="text-xs rounded-lg px-3 py-2 outline-none"
                    style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                <option value="">Semua urgensi</option>
                <option value="kritis" {{ request('urgensi') === 'kritis' ? 'selected' : '' }}>🔴 Kritis</option>
                <option value="tinggi" {{ request('urgensi') === 'tinggi' ? 'selected' : '' }}>🟠 Tinggi</option>
                <option value="sedang" {{ request('urgensi') === 'sedang' ? 'selected' : '' }}>🔵 Sedang</option>
                <option value="rendah" {{ request('urgensi') === 'rendah' ? 'selected' : '' }}>🟢 Rendah</option>
            </select>
            <button class="px-4 py-2 text-xs text-white rounded-lg transition"
                    style="background: var(--accent)"
                    onmouseover="this.style.background='var(--accent-hover)'"
                    onmouseout="this.style.background='var(--accent)'">Filter</button>
            @if(request()->hasAny(['status','urgensi']))
                <a href="{{ route('gurubk.laporan.index') }}"
                   class="px-4 py-2 text-xs rounded-lg transition"
                   style="border: 1px solid var(--border); color: var(--text-secondary)">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border)">
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Siswa</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Guru</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Judul</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Urgensi</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Status</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Tanggal</th>
                        <th class="text-left text-xs font-medium uppercase tracking-wide py-3 px-5" style="color: var(--text-muted)">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    @php
                        $urgColor = match($item->tingkat_urgensi) {
                            'kritis' => 'red', 'tinggi' => 'amber', 'sedang' => 'blue', default => 'gray',
                        };
                        $statusColor = match($item->status) {
                            'selesai' => 'blue', 'diproses' => 'purple', 'ditutup' => 'gray', default => 'amber',
                        };
                        $statusLabel = match($item->status) {
                            'baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditutup' => 'Ditutup', default => $item->status,
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.04)'" onmouseout="this.style.background=''"
                        id="laporan-{{ $item->id }}">
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                     style="background: var(--accent)">
                                    {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium" style="color: var(--text-primary)">{{ $item->siswa->name ?? '-' }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $item->siswa->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-5 text-xs" style="color: var(--text-secondary)">{{ $item->guru->name ?? '-' }}</td>
                        <td class="py-3 px-5 truncate max-w-xs" style="color: var(--text-primary)">{{ $item->judul }}</td>
                        <td class="py-3 px-5">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700">
                                {{ $item->label_urgensi }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            @if($item->status === 'diproses')
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                                    {{ $statusLabel }}
                                </span>
                            @else
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700">
                                    {{ $statusLabel }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-xs" style="color: var(--text-muted)">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-5">
                            <button onclick="toggleForm('form-{{ $item->id }}')"
                                    class="text-xs font-medium hover:opacity-70 transition"
                                    style="color: var(--accent-light)">Tangani</button>
                        </td>
                    </tr>

                    {{-- Form tindak lanjut inline --}}
                    <tr id="form-{{ $item->id }}" class="hidden">
                        <td colspan="7" class="px-5 py-5" style="background: rgba(168,85,247,.06); border-bottom: 1px solid var(--border)">
                            <div class="max-w-2xl">
                                <h3 class="text-sm font-semibold mb-3" style="color: var(--text-primary)">
                                    Tindak Lanjut — <span style="color: var(--accent-light)">{{ $item->judul }}</span>
                                </h3>

                                <div class="rounded-lg p-4 mb-4 text-sm space-y-1"
                                     style="background: var(--bg-card); border: 1px solid var(--border); color: var(--text-secondary)">
                                    <p><span class="font-medium" style="color: var(--text-primary)">Siswa:</span>
                                        {{ $item->siswa->name ?? '-' }} ({{ $item->siswa->schoolClass->name ?? '-' }})
                                    </p>
                                    <p><span class="font-medium" style="color: var(--text-primary)">Dilaporkan oleh:</span>
                                        {{ $item->guru->name ?? '-' }}
                                    </p>
                                    <p class="pt-1">{{ $item->deskripsi }}</p>
                                    @if($item->tindak_lanjut)
                                        <div class="pt-2 mt-2" style="border-top: 1px solid var(--border)">
                                            <p class="text-xs font-medium" style="color: var(--text-muted)">Tindak lanjut sebelumnya:</p>
                                            <p class="text-sm mt-0.5" style="color: var(--text-primary)">{{ $item->tindak_lanjut }}</p>
                                        </div>
                                    @endif
                                </div>

                                <form action="{{ route('gurubk.laporan.proses', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">Ubah Status</label>
                                        <select name="status"
                                                class="w-48 text-sm rounded-lg px-3 py-2 outline-none"
                                                style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                                            <option value="baru"     {{ $item->status === 'baru'     ? 'selected' : '' }}>Baru</option>
                                            <option value="diproses" {{ $item->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai"  {{ $item->status === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditutup"  {{ $item->status === 'ditutup'  ? 'selected' : '' }}>Ditutup</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-xs font-medium mb-1" style="color: var(--text-muted)">
                                            Catatan Tindak Lanjut <span class="text-red-400">*</span>
                                        </label>
                                        <textarea name="tindak_lanjut" rows="3"
                                                  placeholder="Tuliskan tindakan yang sudah atau akan dilakukan BK..."
                                                  class="w-full text-sm rounded-lg px-3 py-2 outline-none"
                                                  style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">{{ $item->tindak_lanjut }}</textarea>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button type="submit"
                                                class="px-5 py-2 text-sm text-white rounded-lg font-medium transition"
                                                style="background: var(--accent)"
                                                onmouseover="this.style.background='var(--accent-hover)'"
                                                onmouseout="this.style.background='var(--accent)'">
                                            Simpan Tindak Lanjut
                                        </button>
                                        <button type="button" onclick="toggleForm('form-{{ $item->id }}')"
                                                class="px-4 py-2 text-sm rounded-lg transition"
                                                style="border: 1px solid var(--border); color: var(--text-secondary)">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-sm" style="color: var(--text-muted)">
                            Belum ada laporan dari guru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporan->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid var(--border)">
                {{ $laporan->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleForm(id) { document.getElementById(id).classList.toggle('hidden'); }
</script>
@endsection