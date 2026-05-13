@extends('layouts.admin')
@section('title', 'Data Guru - Schoolify Admin')
@section('page-title', 'Manajemen Data Guru')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Stats Grid (Vibrant) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <a href="{{ route('admin.teachers') }}" class="neo-flat rounded-3xl p-5 flex items-center gap-4 neo-card-hover group border border-white/20">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="contact" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-1">Total Guru</p>
                <p class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ \App\Models\User::whereIn('role', ['guru', 'guru_bk'])->count() }}</p>
            </div>
        </a>

        <a href="{{ route('admin.teachers') }}?role=guru_bk" class="neo-flat rounded-3xl p-5 flex items-center gap-4 neo-card-hover group border border-white/20">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg shadow-emerald-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="message-square" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-1">Guru BK</p>
                <p class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ \App\Models\User::where('role', 'guru_bk')->count() }}</p>
            </div>
        </a>

        <a href="{{ route('admin.teachers') }}?role=guru" class="neo-flat rounded-3xl p-5 flex items-center gap-4 neo-card-hover group border border-white/20">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="book-open" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-1">Guru Mapel</p>
                <p class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ \App\Models\User::where('role', 'guru')->count() }}</p>
            </div>
        </a>

        <a href="{{ route('admin.classes') }}" class="neo-flat rounded-3xl p-5 flex items-center gap-4 neo-card-hover group border border-white/20">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 shadow-lg shadow-rose-500/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="award" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-1">Wali Kelas</p>
                <p class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ \App\Models\User::where('role', 'guru')->has('homeroomClass')->count() }}</p>
            </div>
        </a>
    </div>

    <!-- Main Section -->
    <div class="neo-flat rounded-[2.5rem] p-8 border border-white/20">
        <!-- Toolbar & Filter -->
        <div class="flex flex-col xl:flex-row justify-between items-center gap-6 mb-8">
            <div class="flex items-center gap-4 w-full xl:w-auto">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center border border-indigo-200 shadow-inner">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="font-outfit font-black text-2xl text-[var(--text-primary)] leading-none">Database Guru</h2>
                    <p class="text-[10px] text-[var(--text-muted)] font-black uppercase tracking-[0.2em] mt-1.5 italic">Kelola izin dan data akademik staf pengajar</p>
                </div>
            </div>

            <form action="{{ route('admin.teachers') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3 w-full xl:w-auto flex-1 max-w-4xl">
                <div class="relative flex-1 w-full">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau email..." class="w-full neo-input py-3.5 pl-11 pr-4 text-xs font-black uppercase tracking-wider">
                </div>
                <div class="relative w-full md:w-48">
                    <select name="role" class="w-full neo-input appearance-none py-3.5 px-4 text-xs font-black uppercase tracking-wider cursor-pointer" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru Mapel</option>
                        <option value="guru_bk" {{ request('role') == 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    </select>
                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                </div>
                <button type="submit" class="w-full md:w-auto neo-btn px-8 py-3.5 bg-indigo-500 text-white font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-indigo-500/20">Filter</button>
            </form>

            <a href="{{ route('admin.teachers.create') }}" class="w-full xl:w-auto neo-btn flex items-center justify-center gap-2 px-8 py-4 text-xs font-black bg-[var(--accent)] text-white shadow-lg shadow-blue-500/30 hover:scale-105 transition-all uppercase tracking-widest">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Guru
            </a>
        </div>

        <!-- Table View -->
        <div class="neo-pressed rounded-[2rem] overflow-hidden border border-white/10">
            <div class="overflow-x-auto custom-scroll">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] border-b border-[var(--shadow-dark)]/10">
                            <th class="px-8 py-6">Informasi Guru</th>
                            <th class="px-8 py-6">Kategori & Wali</th>
                            <th class="px-8 py-6">Kontak Staf</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($teachers as $teacher)
                        <tr class="group hover:bg-white/40 dark:hover:bg-black/10 transition-all duration-300 border-b border-[var(--shadow-dark)]/5 last:border-0">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl overflow-hidden neo-flat p-1 border-2 border-white shadow-lg group-hover:rotate-3 transition-transform duration-500">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background={{ $teacher->role == 'guru_bk' ? '10B981' : '3B82F6' }}&color=fff&bold=true" class="w-full h-full object-cover rounded-xl">
                                    </div>
                                    <div>
                                        <p class="font-black text-[var(--text-primary)] text-base group-hover:text-indigo-600 transition-colors">{{ $teacher->name }}</p>
                                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">NIP: {{ $teacher->nip ?? 'BELUM DIISI' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-1.5">
                                    @if($teacher->role === 'guru_bk')
                                        <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-600 text-[9px] font-black border border-emerald-200 uppercase tracking-widest w-max">GURU BK / KONSELOR</span>
                                    @else
                                        <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-600 text-[9px] font-black border border-blue-200 uppercase tracking-widest w-max">GURU MATA PELAJARAN</span>
                                    @endif
                                    
                                    @if($teacher->role !== 'guru_bk' && $teacher->homeroomClass)
                                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-amber-600 italic mt-1">
                                            <i data-lucide="award" class="w-3.5 h-3.5"></i> Wali Kelas {{ $teacher->homeroomClass->name }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-1.5">
                                    <span class="text-xs font-black text-[var(--text-primary)] flex items-center gap-2">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 text-indigo-500"></i> {{ $teacher->email }}
                                    </span>
                                    @if($teacher->phone)
                                    <span class="text-[10px] font-bold text-[var(--text-muted)] flex items-center gap-2">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-500"></i> {{ $teacher->phone }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black border border-emerald-200 uppercase tracking-widest">
                                    AKTIF
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="neo-btn p-3 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all shadow-sm" title="Edit Data">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" onsubmit="return confirm('Hapus data guru ini?')" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="neo-btn p-3 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Hapus Permanen">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center text-slate-400">
                                        <i data-lucide="contact-2" class="w-12 h-12"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-600 uppercase tracking-widest">Guru Tidak Ditemukan</p>
                                        <p class="text-xs text-slate-400 font-bold mt-1">Coba gunakan filter atau kata kunci pencarian lain.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($teachers->hasPages())
        <div class="mt-10 px-4">
            {{ $teachers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection