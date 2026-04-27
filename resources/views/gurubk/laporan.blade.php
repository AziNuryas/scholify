{{-- resources/views/gurubk/laporan.blade.php --}}
@extends('layouts.gurubk')

@section('title', 'Laporan dari Guru')

@section('content')

<div class="mb-6">
    <h1 class="text-xl font-semibold text-gray-800">Laporan dari Guru</h1>
    <p class="text-sm text-gray-500 mt-1">Tinjau dan tindak lanjuti laporan siswa bermasalah dari guru mapel.</p>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-teal-50 border border-teal-200 text-teal-800 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Filter --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
    <form method="GET" action="{{ route('gurubk.laporan.index') }}" class="flex flex-wrap gap-3">
        <select name="status" class="text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            <option value="">Semua status</option>
            <option value="baru"     {{ request('status') === 'baru'     ? 'selected' : '' }}>Baru</option>
            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai"  {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
            <option value="ditutup"  {{ request('status') === 'ditutup'  ? 'selected' : '' }}>Ditutup</option>
        </select>
        <select name="urgensi" class="text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
            <option value="">Semua urgensi</option>
            <option value="kritis" {{ request('urgensi') === 'kritis' ? 'selected' : '' }}>🔴 Kritis</option>
            <option value="tinggi" {{ request('urgensi') === 'tinggi' ? 'selected' : '' }}>🟠 Tinggi</option>
            <option value="sedang" {{ request('urgensi') === 'sedang' ? 'selected' : '' }}>🔵 Sedang</option>
            <option value="rendah" {{ request('urgensi') === 'rendah' ? 'selected' : '' }}>🟢 Rendah</option>
        </select>
        <button class="px-4 py-2 text-xs bg-teal-600 text-white rounded-lg hover:bg-teal-700">Filter</button>
        @if(request()->hasAny(['status','urgensi']))
            <a href="{{ route('gurubk.laporan.index') }}"
                class="px-4 py-2 text-xs border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50">Reset</a>
        @endif
    </form>
</div>

{{-- Tabel --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Siswa</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Guru</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Judul</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Urgensi</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Status</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Tanggal</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wide py-3 px-5">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                @php
                    $urgColor = match($item->tingkat_urgensi) {
                        'kritis' => 'red',
                        'tinggi' => 'amber',
                        'sedang' => 'blue',
                        default  => 'gray',
                    };
                    $statusColor = match($item->status) {
                        'selesai'  => 'blue',
                        'diproses' => 'teal',
                        'ditutup'  => 'gray',
                        default    => 'amber',
                    };
                    $statusLabel = match($item->status) {
                        'baru'     => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai'  => 'Selesai',
                        'ditutup'  => 'Ditutup',
                        default    => $item->status,
                    };
                @endphp
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition" id="laporan-{{ $item->id }}">
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($item->siswa->name ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->siswa->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $item->siswa->schoolClass->name ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-5 text-gray-600 text-xs">{{ $item->guru->name ?? '-' }}</td>
                    <td class="py-3 px-5 text-gray-700 truncate max-w-xs">{{ $item->judul }}</td>
                    <td class="py-3 px-5">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-{{ $urgColor }}-50 text-{{ $urgColor }}-700">
                            {{ $item->label_urgensi }}
                        </span>
                    </td>
                    <td class="py-3 px-5">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td class="py-3 px-5 text-gray-400 text-xs">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-5">
                        <button onclick="toggleForm('form-{{ $item->id }}')"
                            class="text-xs text-teal-600 hover:underline font-medium">Tangani</button>
                    </td>
                </tr>

                {{-- Form tindak lanjut inline --}}
                <tr id="form-{{ $item->id }}" class="hidden">
                    <td colspan="7" class="px-5 py-5 bg-teal-50 border-b border-teal-100">
                        <div class="max-w-2xl">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                Tindak Lanjut —
                                <span class="text-teal-700">{{ $item->judul }}</span>
                            </h3>

                            {{-- Detail laporan --}}
                            <div class="bg-white rounded-lg p-4 mb-4 border border-gray-100 text-sm text-gray-600 space-y-1">
                                <p><span class="font-medium text-gray-700">Siswa:</span>
                                    {{ $item->siswa->name ?? '-' }}
                                    ({{ $item->siswa->schoolClass->name ?? '-' }})
                                </p>
                                <p><span class="font-medium text-gray-700">Dilaporkan oleh:</span>
                                    {{ $item->guru->name ?? '-' }}
                                </p>
                                <p class="pt-1 text-gray-600">{{ $item->deskripsi }}</p>

                                @if($item->tindak_lanjut)
                                    <div class="pt-2 mt-2 border-t border-gray-100">
                                        <p class="text-xs font-medium text-gray-500">Tindak lanjut sebelumnya:</p>
                                        <p class="text-sm text-gray-700 mt-0.5">{{ $item->tindak_lanjut }}</p>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('gurubk.laporan.proses', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Ubah Status</label>
                                    <select name="status"
                                        class="w-48 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                        <option value="baru"     {{ $item->status === 'baru'     ? 'selected' : '' }}>Baru</option>
                                        <option value="diproses" {{ $item->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai"  {{ $item->status === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditutup"  {{ $item->status === 'ditutup'  ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">
                                        Catatan Tindak Lanjut <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="tindak_lanjut" rows="3"
                                        placeholder="Tuliskan tindakan yang sudah atau akan dilakukan BK..."
                                        class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">{{ $item->tindak_lanjut }}</textarea>
                                </div>

                                <div class="flex items-center gap-3">
                                    <button type="submit"
                                        class="px-5 py-2 text-sm bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium transition">
                                        Simpan Tindak Lanjut
                                    </button>
                                    <button type="button" onclick="toggleForm('form-{{ $item->id }}')"
                                        class="px-4 py-2 text-sm border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-sm text-gray-400">
                        Belum ada laporan dari guru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporan->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $laporan->links() }}
        </div>
    @endif
</div>

<script>
function toggleForm(id) {
    document.getElementById(id).classList.toggle('hidden');
}
</script>

@endsection