@extends('layouts.guru')

@section('content')
<div class="p-2 md:p-4">
    <div class="mb-10">
        <h2 class="text-3xl font-heading font-bold text-slate-800 tracking-tight">Input Nilai Siswa</h2>
        <p class="text-slate-500 mt-1 flex items-center gap-2 text-sm font-medium">
            <i data-lucide="edit-3" class="w-4 h-4 text-indigo-500"></i>
            Kelola nilai tugas dan ujian siswa.
        </p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 p-6 mb-8 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kelas</label>
                <select class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                    <option>10 - IPA 1</option>
                    <option>10 - IPA 2</option>
                    <option>11 - IPA 1</option>
                    <option>11 - IPA 2</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                <select class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                    <option>Matematika</option>
                    <option>Fisika</option>
                    <option>Kimia</option>
                    <option>Biologi</option>
                    <option>Bahasa Indonesia</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Penilaian</label>
                <select class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                    <option>UTS</option>
                    <option>UAS</option>
                    <option>Tugas Harian</option>
                    <option>Praktikum</option>
                    <option>Quiz</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">
                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i> Tampilkan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">NISN</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Nilai</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Keterangan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $siswa = [
                            ['0012345678', 'Budi Santoso', ''],
                            ['0012345679', 'Siti Aminah', ''],
                            ['0012345680', 'Rian Hidayat', ''],
                            ['0012345681', 'Dewi Lestari', ''],
                        ];
                    @endphp
                    @foreach($siswa as $index => $s)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-slate-500">{{ $s[0] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($s[1]) }}&background=4F46E5&color=fff" class="w-8 h-8 rounded-full">
                                <span class="font-medium text-slate-700">{{ $s[1] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <input type="number" class="w-20 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-center text-sm" placeholder="0-100">
                        </td>
                        <td class="px-6 py-4">
                            <select class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                                <option>- Pilih -</option>
                                <option>Tuntas</option>
                                <option>Remedial</option>
                                <option>Tidak Tuntas</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <button class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition-colors">
                                <i data-lucide="save" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-between items-center">
            <div class="text-sm text-slate-500">
                Menampilkan 4 dari 4 data
            </div>
            <button class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all">
                <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i> Simpan Semua
            </button>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection