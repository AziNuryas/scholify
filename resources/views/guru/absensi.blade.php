@extends('layouts.guru')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    :root {
        --primary-indigo: #4F46E5;
    }
    .font-heading { font-family: 'Outfit', sans-serif; }
    
    /* Card putih solid tanpa blur */
    .card-white {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Custom Radio Styling agar warna muncul saat dipilih */
    .status-radio:checked + label[for^="h_"] { background-color: #10b981 !important; color: white !important; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15); }
    .status-radio:checked + label[for^="i_"] { background-color: #f59e0b !important; color: white !important; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15); }
    .status-radio:checked + label[for^="s_"] { background-color: #3b82f6 !important; color: white !important; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15); }
    .status-radio:checked + label[for^="a_"] { background-color: #f43f5e !important; color: white !important; box-shadow: 0 2px 8px rgba(244, 63, 94, 0.15); }
</style>

<div class="p-2 md:p-4">
    <div class="mb-10">
        <h2 class="text-3xl font-heading font-bold text-slate-800 tracking-tight">Absensi Harian</h2>
        <p class="text-slate-500 mt-1 flex items-center gap-2 text-sm font-medium">
            <i data-lucide="info" class="w-4 h-4 text-indigo-500"></i>
            Pilih status kehadiran siswa secara teliti.
        </p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php $stats = [['Hadir', 32, 'emerald'], ['Izin', 2, 'amber'], ['Sakit', 1, 'blue'], ['Alpha', 0, 'rose']]; @endphp
        @foreach($stats as $stat)
        <div class="bg-white rounded-[2rem] border border-slate-200 p-5 flex items-center justify-between group hover:shadow-md transition-all">
            <div>
                <p class="text-{{$stat[2]}}-600 text-[10px] font-black uppercase tracking-widest">{{$stat[0]}}</p>
                <h3 class="text-2xl font-heading font-bold text-slate-800">{{$stat[1]}}</h3>
            </div>
            <div class="w-10 h-10 bg-{{$stat[2]}}-50 rounded-xl flex items-center justify-center text-{{$stat[2]}}-500 group-hover:scale-110 transition-transform">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 p-4 md:p-6 mb-8 flex flex-wrap items-center justify-between gap-4 shadow-sm">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <select class="appearance-none pl-10 pr-10 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-400 text-sm font-bold text-slate-700 cursor-pointer transition-all">
                    <option selected>10-IPA 1 (Matematika)</option>
                    <option>11-IPA 2 (Fisika)</option>
                </select>
                <i data-lucide="door-open" class="absolute left-3.5 top-3 w-4 h-4 text-indigo-500"></i>
            </div>
            <div class="px-4 py-2.5 bg-slate-50 rounded-2xl text-sm font-bold text-slate-600 flex items-center gap-2 border border-slate-200">
                <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i>
                {{ date('d F Y') }}
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative hidden sm:block">
                <input type="text" id="searchInput" placeholder="Cari siswa..." class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-400 w-48 transition-all focus:w-64">
                <i data-lucide="search" class="absolute left-3.5 top-3 w-4 h-4 text-slate-400"></i>
            </div>
            <button class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-bold shadow-sm hover:bg-indigo-700 active:scale-95 transition-all">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Presensi
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-slate-50/80 px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h4 class="font-bold text-slate-800">Daftar Kehadiran Siswa</h4>
            <button onclick="markAllPresent()" class="text-[11px] font-black uppercase tracking-wider text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all">
                Tandai Hadir Semua
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left" id="attendanceTable">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-200">
                        <th class="px-8 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Identitas Siswa</th>
                        <th class="px-8 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @php
                        $students = [
                            ['Budi Santoso', '0012345678'],
                            ['Siti Aminah', '0012345679'],
                            ['Rian Hidayat', '0012345680'],
                            ['Dewi Lestari', '0012345681']
                        ];
                    @endphp

                    @foreach($students as $index => $student)
                    <tr class="student-row hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student[0]) }}&background=6366f1&color=fff" class="w-11 h-11 rounded-2xl shadow-sm" alt="">
                                <div>
                                    <span class="font-bold text-slate-700 block group-hover:text-indigo-600 transition-colors">{{ $student[0] }}</span>
                                    <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-tight">NISN: {{ $student[1] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center items-center gap-2.5">
                                @foreach(['h' => 'Hadir', 'i' => 'Izin', 's' => 'Sakit', 'a' => 'Alpha'] as $code => $label)
                                    <input type="radio" name="status_{{$index}}" id="{{$code}}_{{$index}}" value="{{$code}}" class="hidden status-radio" {{ $code == 'h' ? 'checked' : '' }}>
                                    <label for="{{$code}}_{{$index}}" class="cursor-pointer w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-100 text-[11px] font-black text-slate-500 hover:bg-slate-200 transition-all active:scale-90" title="{{$label}}">
                                        {{ strtoupper($code) }}
                                    </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    function markAllPresent() {
        const presentRadios = document.querySelectorAll('input[type="radio"][id^="h_"]');
        presentRadios.forEach(radio => radio.checked = true);
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('.student-row');
        
        rows.forEach(row => {
            const name = row.querySelector('.font-bold').textContent.toLowerCase();
            row.style.display = name.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection