@extends('layouts.admin')
@section('title', 'Detail Siswa - Schoolify Admin')
@section('page-title', 'Detail Data Siswa')

@section('content')
<div class="space-y-8 animate-fadeInUp">
    
    <!-- Top Actions & Breadcrumb-like Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.students') }}" class="neo-btn p-3 rounded-2xl text-[var(--text-secondary)] hover:text-rose-500 transition-all">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ $student->name }}</h3>
                <p class="text-[10px] text-[var(--text-muted)] font-black uppercase tracking-[0.2em] italic">Profil Lengkap Siswa Terverifikasi</p>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('admin.students.edit', $student->id) }}" class="flex-1 md:flex-none neo-btn px-6 py-3 rounded-2xl bg-indigo-500 text-white font-black text-xs flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/20 hover:scale-105 transition-all">
                <i data-lucide="edit-3" class="w-4 h-4"></i> EDIT PROFIL
            </a>
        </div>
    </div>

    <!-- Hero Profile Section -->
    <div class="neo-flat rounded-[2.5rem] overflow-hidden p-8 border border-white/20">
        <div class="flex flex-col lg:flex-row gap-10 items-center lg:items-start">
            <div class="relative group">
                <div class="w-40 h-40 rounded-[2.5rem] overflow-hidden neo-flat p-2 border-4 border-white shadow-2xl transform group-hover:rotate-3 transition-transform duration-500">
                    <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=160&background=6366F1&color=fff&bold=true' }}" 
                         alt="{{ $student->name }}" class="w-full h-full object-cover rounded-[2rem]">
                </div>
                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg border-4 border-white">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
            </div>

            <div class="flex-1 space-y-6 text-center lg:text-left">
                <div>
                    <h2 class="font-outfit font-black text-4xl text-[var(--text-primary)] mb-2">{{ $student->name }}</h2>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-500/10 text-indigo-600 text-xs font-black border border-indigo-500/20">
                            <i data-lucide="hash" class="w-3.5 h-3.5"></i> NISN: {{ $student->nisn ?? '-' }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-600 text-xs font-black border border-blue-500/20">
                            <i data-lucide="school" class="w-3.5 h-3.5"></i> {{ $student->schoolClass->name ?? 'TANPA KELAS' }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 text-xs font-black border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> STATUS: AKTIF
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-[var(--shadow-dark)]/5">
                    <div class="text-center lg:text-left">
                        <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Email Sekolah</p>
                        <p class="text-xs font-black text-[var(--text-primary)] truncate">{{ $student->user->email ?? '-' }}</p>
                    </div>
                    <div class="text-center lg:text-left">
                        <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Telepon</p>
                        <p class="text-xs font-black text-[var(--text-primary)]">{{ $student->phone ?? '-' }}</p>
                    </div>
                    <div class="text-center lg:text-left">
                        <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Gender</p>
                        <p class="text-xs font-black text-[var(--text-primary)] uppercase">{{ $student->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="text-center lg:text-left">
                        <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-1">Terdaftar Sejak</p>
                        <p class="text-xs font-black text-[var(--text-primary)]">{{ $student->created_at ? $student->created_at->format('M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Personal Information Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="neo-flat rounded-[2.5rem] p-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-outfit font-black text-lg text-[var(--text-primary)] uppercase tracking-wider">Biodata Lengkap</h4>
                </div>
                
                <div class="space-y-5">
                    <div class="p-4 neo-pressed rounded-2xl flex flex-col gap-1">
                        <span class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">Tempat & Tanggal Lahir</span>
                        <span class="text-xs font-black text-[var(--text-primary)]">{{ $student->birth_place ?? '-' }}, {{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d F Y') : '-' }}</span>
                    </div>
                    <div class="p-4 neo-pressed rounded-2xl flex flex-col gap-1">
                        <span class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">Alamat Domisili</span>
                        <span class="text-xs font-black text-[var(--text-primary)] leading-relaxed">{{ $student->address ?? 'Alamat belum dilengkapi oleh siswa.' }}</span>
                    </div>
                    <div class="p-4 neo-pressed rounded-2xl flex flex-col gap-1">
                        <span class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">ID Internal (NIS)</span>
                        <span class="text-xs font-black text-[var(--text-primary)]">{{ $student->nis ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="neo-flat rounded-[2.5rem] p-8 bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                <h4 class="font-outfit font-black text-sm uppercase tracking-widest mb-6 opacity-80">Rangkuman Akademik</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/10">
                        <p class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-70">Rata-rata KKM</p>
                        <p class="text-2xl font-black">{{ $kkmData ? number_format($kkmData->avg('score'), 1) : 0 }}</p>
                    </div>
                    <div class="text-center p-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/10">
                        <p class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-70">Total Mapel</p>
                        <p class="text-2xl font-black">{{ $kkmData->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic / KKM Table -->
        <div class="lg:col-span-2">
            <div class="neo-flat rounded-[2.5rem] overflow-hidden border border-white/20">
                <div class="px-8 py-6 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="book-open" class="w-5 h-5"></i>
                        </div>
                        <h4 class="font-outfit font-black text-lg text-[var(--text-primary)] uppercase tracking-wider">Kriteria Ketuntasan Minimal (KKM)</h4>
                    </div>
                    <span class="text-[10px] font-black px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">TA 2023/2024</span>
                </div>

                <div class="p-8">
                    @if($kkmData && count($kkmData) > 0)
                    <div class="overflow-x-auto custom-scroll">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-widest border-b border-[var(--shadow-dark)]/5">
                                    <th class="px-4 py-4">Mata Pelajaran</th>
                                    <th class="px-4 py-4 text-center">KKM</th>
                                    <th class="px-4 py-4 text-center">Grade</th>
                                    <th class="px-4 py-4 text-right">Predikat</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                @foreach($kkmData as $kkm)
                                <tr class="border-b border-[var(--shadow-dark)]/5 last:border-0 hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-5 font-black text-[var(--text-primary)]">
                                        {{ $kkm->subject->name ?? 'Mapel #'.$kkm->subject_id }}
                                    </td>
                                    <td class="px-4 py-5 text-center">
                                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl font-black text-sm {{ $kkm->score >= 80 ? 'bg-emerald-100 text-emerald-600' : ($kkm->score >= 70 ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600') }} shadow-inner">
                                            {{ $kkm->score }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-5 text-center font-black text-indigo-500">
                                        {{ $kkm->grade_level ?? 'X' }}
                                    </td>
                                    <td class="px-4 py-5 text-right">
                                        @if($kkm->score >= 80)
                                            <span class="px-3 py-1 rounded-lg bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20">Sangat Baik</span>
                                        @elseif($kkm->score >= 70)
                                            <span class="px-3 py-1 rounded-lg bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-amber-500/20">Baik</span>
                                        @else
                                            <span class="px-3 py-1 rounded-lg bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-rose-500/20">Perlu Bimbingan</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-400 mx-auto mb-4">
                            <i data-lucide="database-zap" class="w-10 h-10"></i>
                        </div>
                        <p class="font-black text-slate-600 uppercase tracking-widest">Data Akademik Kosong</p>
                        <p class="text-xs text-slate-400 font-bold mt-1">Belum ada data KKM yang diinputkan untuk siswa ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection