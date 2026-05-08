@extends('layouts.gurubk')

@section('title', 'Catatan Disiplin - Schoolify')
@section('page-title', 'Catatan Disiplin')

@section('content')
<div class="space-y-6 pt-2 animate-fadeInUp">

    <div class="flex justify-between items-end mb-2">
        <div>
            <h1 class="font-outfit font-bold text-3xl mb-1" style="color: var(--text-primary)">Catatan Disiplin</h1>
            <p class="text-sm" style="color: var(--text-secondary)">Kelola riwayat pelanggaran dan poin kedisiplinan siswa.</p>
        </div>
        <button onclick="document.getElementById('modal-add-discipline').classList.remove('hidden')"
                class="text-white px-5 py-2.5 rounded-xl font-bold transition flex items-center gap-2"
                style="background: var(--accent); box-shadow: 0 4px 14px rgba(124,58,237,.3)"
                onmouseover="this.style.background='var(--accent-hover)'"
                onmouseout="this.style.background='var(--accent)'">
            <i class='bx bx-plus'></i> Tambah Catatan
        </button>
    </div>

    @if(session('success'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid var(--border)">
            <h2 class="font-outfit font-bold text-lg" style="color: var(--text-primary)">Riwayat Pelanggaran Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs uppercase font-bold tracking-wider" style="border-bottom: 1px solid var(--border); color: var(--text-muted)">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Jenis Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.06)'" onmouseout="this.style.background=''">
                        <td class="px-6 py-4 font-medium" style="color: var(--text-secondary)">
                            {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $record->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($record->student->name) }}"
                                     class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold" style="color: var(--text-primary)">{{ $record->student->name }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $record->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-red-400">{{ $record->violation_type }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" style="color: var(--text-secondary)" title="{{ $record->description }}">
                            {{ $record->description }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg font-bold">+{{ $record->points }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center" style="color: var(--text-muted)">
                            Belum ada catatan pelanggaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add Discipline -->
    <div id="modal-add-discipline" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="rounded-3xl w-full max-w-lg shadow-2xl relative overflow-hidden" style="background: var(--bg-card)">
            <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid var(--border)">
                <h3 class="font-outfit font-bold text-xl" style="color: var(--text-primary)">Catat Pelanggaran Baru</h3>
                <button onclick="document.getElementById('modal-add-discipline').classList.add('hidden')"
                        style="color: var(--text-muted)" class="hover:text-red-400 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <form action="{{ route('gurubk.discipline.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1" style="color: var(--text-secondary)">Pilih Siswa</label>
                    <select name="student_id" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->schoolClass->name ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1" style="color: var(--text-secondary)">Tanggal</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1" style="color: var(--text-secondary)">Pilih Pelanggaran</label>
                    <select name="violation_type" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                        <option value="Terlambat Masuk">Terlambat Masuk</option>
                        <option value="Bolos Sekolah">Bolos Sekolah</option>
                        <option value="Atribut Tidak Lengkap">Atribut Tidak Lengkap</option>
                        <option value="Berkelahi">Berkelahi</option>
                        <option value="Merokok">Merokok</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1" style="color: var(--text-secondary)">Poin Hukuman</label>
                    <input type="number" name="points" required placeholder="0"
                           class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                           style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1" style="color: var(--text-secondary)">Keterangan / Kronologi Singkat</label>
                    <textarea name="description" rows="3" required
                              class="w-full rounded-xl px-4 py-2 text-sm outline-none"
                              style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full text-white rounded-xl py-3 font-bold transition"
                            style="background: var(--accent); box-shadow: 0 4px 14px rgba(124,58,237,.3)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection