@extends('layouts.gurubk')

@section('title', 'Catatan Disiplin - Schoolify')

@section('content')
<div class="space-y-6 pt-2">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#1E293B] mb-1">Catatan Disiplin</h1>
            <p class="text-gray-500 text-sm">Kelola riwayat pelanggaran dan poin kedisiplinan siswa.</p>
        </div>
        <button onclick="document.getElementById('modal-add-discipline').classList.remove('hidden')" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md shadow-teal-200 transition flex items-center gap-2">
            <i class='bx bx-plus'></i> Tambah Catatan
        </button>
    </div>

    @if(session('success'))
    <div class="bg-teal-50 border border-teal-200 text-teal-700 px-4 py-3 rounded-xl flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <div class="glass-card bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="font-outfit font-bold text-[#1E293B] text-lg">Riwayat Pelanggaran Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Jenis Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                    <tr class="border-b border-gray-50 hover:bg-teal-50/30 transition">
                        <td class="px-6 py-4 font-medium text-gray-700">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $record->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($record->student->name) }}" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold text-[#1E293B]">{{ $record->student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $record->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-red-500">{{ $record->violation_type }}</td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $record->description }}">
                            {{ $record->description }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg font-bold">+{{ $record->points }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada catatan pelanggaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add Discipline -->
    <div id="modal-add-discipline" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-outfit font-bold text-xl text-[#1E293B]">Catat Pelanggaran Baru</h3>
                <button onclick="document.getElementById('modal-add-discipline').classList.add('hidden')" class="text-gray-400 hover:text-red-500"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="{{ route('gurubk.discipline.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Siswa</label>
                    <select name="student_id" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 transition outline-none">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->schoolClass->name ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Pelanggaran</label>
                    <select name="violation_type" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 transition outline-none">
                        <option value="Terlambat Masuk">Terlambat Masuk</option>
                        <option value="Bolos Sekolah">Bolos Sekolah</option>
                        <option value="Atribut Tidak Lengkap">Atribut Tidak Lengkap</option>
                        <option value="Berkelahi">Berkelahi</option>
                        <option value="Merokok">Merokok</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Poin Hukuman</label>
                    <input type="number" name="points" required placeholder="0" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan / Kronologi Singkat</label>
                    <textarea name="description" rows="3" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white rounded-xl py-3 font-bold shadow-md shadow-teal-200 transition">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
