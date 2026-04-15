@extends('layouts.guru')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    .font-heading { font-family: 'Outfit', sans-serif; }
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="p-2 md:p-4">
    <div class="mb-10 flex flex-wrap justify-between items-end gap-4">
        <div>
            <h2 class="text-3xl font-heading font-bold text-slate-800 tracking-tight">Tugas & Ujian</h2>
            <p class="text-slate-500 mt-1 flex items-center gap-2 text-sm font-medium">
                <i data-lucide="edit-3" class="w-4 h-4 text-indigo-500"></i>
                Kelola materi, soal, dan koreksi hasil pekerjaan siswa.
            </p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 rounded-2xl text-sm font-bold shadow-sm border border-gray-100 hover:bg-slate-50 transition-all">
                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-500"></i> Upload Materi
            </button>
            <button class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition-all">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Tugas Baru
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 rounded-[2rem] flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                <i data-lucide="file-text" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Tugas</p>
                <h3 class="text-2xl font-heading font-bold text-slate-800">12</h3>
            </div>
        </div>
        <div class="glass-card p-6 rounded-[2rem] flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                <i data-lucide="clock" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Belum Dikoreksi</p>
                <h3 class="text-2xl font-heading font-bold text-slate-800">45</h3>
            </div>
        </div>
        <div class="glass-card p-6 rounded-[2rem] flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <i data-lucide="zap" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Ujian Aktif</p>
                <h3 class="text-2xl font-heading font-bold text-slate-800">1</h3>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-[2.5rem] overflow-hidden border border-white">
        <div class="bg-white/50 p-6 border-b border-gray-100 flex items-center justify-between">
            <h4 class="font-bold text-slate-800 tracking-tight text-lg">Daftar Tugas & Materi</h4>
            <div class="flex gap-2">
                 <button class="p-2 bg-white rounded-xl border border-gray-100 text-slate-400 hover:text-indigo-500 transition-all shadow-sm">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Judul Tugas / Materi</th>
                        <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Kelas</th>
                        <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Deadline</th>
                        <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Pengumpulan</th>
                        <th class="px-8 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white/40">
                    @php
                        $tasks = [
                            ['Logaritma Dasar', '10-IPA 1', '18 April 2026', '28/32', 'Tugas', 'bg-indigo-50 text-indigo-600'],
                            ['Persamaan Kuadrat', '10-IPA 1', '20 April 2026', '12/32', 'Tugas', 'bg-indigo-50 text-indigo-600'],
                            ['Materi Turunan PDF', '11-IPA 2', '-', '-', 'Materi', 'bg-emerald-50 text-emerald-600'],
                            ['Ujian Tengah Semester', '10-IPA 1', '22 April 2026', '0/32', 'Ujian', 'bg-rose-50 text-rose-600'],
                        ];
                    @endphp

                    @foreach($tasks as $task)
                    <tr class="hover:bg-white/80 transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-all">
                                    <i data-lucide="{{ $task[4] == 'Materi' ? 'file-text' : 'clipboard-list' }}" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-700 block group-hover:text-indigo-600 transition-colors">{{ $task[0] }}</span>
                                    <span class="status-badge {{ $task[5] }}">{{ $task[4] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-5 text-center text-sm font-bold text-slate-600">{{ $task[1] }}</td>
                        <td class="px-4 py-5 text-center text-sm font-medium text-slate-500">{{ $task[2] }}</td>
                        <td class="px-4 py-5">
                            <div class="max-w-[100px] mx-auto">
                                <div class="flex justify-between mb-1">
                                    <span class="text-[10px] font-black text-slate-400">{{ $task[3] }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 70%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-100 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-tight shadow-sm hover:bg-indigo-50 transition-all">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> Periksa
                                </button>
                                <button class="p-1.5 text-slate-400 hover:text-rose-600 transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection