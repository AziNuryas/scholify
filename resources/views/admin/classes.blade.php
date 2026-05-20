@extends('layouts.admin')
@section('title', 'Manajemen Kelas - Schoolify Admin')
@section('page-title', 'Daftar Kelas & Ruangan')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Stats Row (Small & Elegant) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="neo-flat rounded-2xl p-4 flex items-center gap-4 neo-card-hover transition-all">
            <div class="w-10 h-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <i data-lucide="layers" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">Total Kelas</p>
                <p class="font-outfit font-black text-xl text-[var(--text-primary)]">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>
        @foreach(['X', 'XI', 'XII'] as $grade)
        <div class="neo-flat rounded-2xl p-4 flex items-center gap-4 neo-card-hover transition-all">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center border border-slate-200">
                <span class="font-black text-sm">{{ $grade }}</span>
            </div>
            <div>
                <p class="text-[9px] font-black text-[var(--text-muted)] uppercase tracking-widest">Kelas {{ $grade }}</p>
                <p class="font-outfit font-black text-xl text-[var(--text-primary)]">{{ $stats['grade'.$grade] ?? 0 }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Toolbar -->
    <div class="neo-flat rounded-[2rem] p-4">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.classes') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..." class="w-full neo-input py-2 text-xs font-bold">
                </div>
                <div class="relative w-full sm:w-40">
                    <select name="grade" class="w-full neo-input appearance-none py-2 text-xs font-bold cursor-pointer" onchange="this.form.submit()">
                        <option value="">Tingkat</option>
                        <option value="X" {{ request('grade') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ request('grade') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ request('grade') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                    <i data-lucide="chevron-down" class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                </div>
                <button type="submit" class="w-full sm:w-auto neo-btn px-6 py-2 bg-indigo-500 text-white font-black text-[10px] uppercase tracking-widest">Filter</button>
            </form>
            
            <a href="{{ route('admin.classes.create') }}" class="w-full lg:w-auto neo-btn flex items-center justify-center gap-2 px-6 py-2.5 text-[10px] font-black bg-[var(--accent)] text-white shadow-lg shadow-blue-500/20 hover:scale-105 transition-all uppercase tracking-widest">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> TAMBAH KELAS
            </a>
        </div>
    </div>

    <!-- Main Content: Compact Rows -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @php $displayGrades = request('grade') ? [request('grade')] : ['X', 'XI', 'XII']; @endphp

        @foreach($displayGrades as $grade)
            @php
                $classes = $classesByGrade[$grade] ?? collect();
                if(request('search')) {
                    $search = strtolower(request('search'));
                    $classes = $classes->filter(function($c) use ($search) {
                        return str_contains(strtolower($c->name), $search) || 
                               ($c->homeroomTeacher && str_contains(strtolower($c->homeroomTeacher->name), $search));
                    });
                }
            @endphp

            <div class="space-y-4">
                <div class="flex items-center justify-between px-2 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-indigo-500 rounded-full"></span>
                        <h3 class="font-outfit font-black text-sm text-[var(--text-primary)] uppercase tracking-widest">Tingkat {{ $grade }}</h3>
                    </div>
                    <span class="text-[9px] font-black text-[var(--text-muted)]">{{ $classes->count() }} Data</span>
                </div>

                <div class="space-y-3">
                    @forelse($classes as $class)
                    <div class="neo-flat rounded-2xl p-4 neo-card-hover group border border-white/10 transition-all">
                        <div class="flex items-center gap-4">
                            <!-- Small Identifier -->
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 text-indigo-600 flex items-center justify-center border border-indigo-100 font-black text-xs">
                                {{ $class->grade_level }}
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-outfit font-black text-base text-[var(--text-primary)] truncate">{{ $class->name }}</h4>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                </div>
                                <p class="text-[10px] text-[var(--text-muted)] font-bold truncate">Wali: {{ $class->homeroomTeacher->name ?? '-' }}</p>
                            </div>

                            <!-- Count -->
                            <div class="text-right">
                                <p class="text-[10px] font-black text-indigo-500">{{ $class->students_count }}</p>
                                <p class="text-[8px] font-bold text-[var(--text-muted)] uppercase tracking-tighter">Siswa</p>
                            </div>
                        </div>

                        <!-- Compact Actions -->
                        <div class="mt-4 pt-3 border-t border-[var(--shadow-dark)]/5 flex gap-2 transition-opacity">
                            <a href="{{ route('admin.classes.edit', $class->id) }}" class="flex-1 neo-btn py-1.5 rounded-lg text-[9px] font-black text-indigo-600 text-center uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">
                                Edit
                            </a>
                            <form action="{{ route('admin.classes.delete', $class->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full neo-btn py-1.5 rounded-lg text-[9px] font-black text-rose-500 text-center uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="neo-pressed rounded-2xl p-6 text-center text-[var(--text-muted)]">
                        <p class="font-black text-[9px] uppercase tracking-widest">Kosong</p>
                    </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection