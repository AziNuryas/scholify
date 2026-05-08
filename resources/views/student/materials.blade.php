@extends('layouts.student')

@section('title', 'Materi Pembelajaran - Schoolify')
@section('page-title', 'Materi Pembelajaran')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fadeInUp">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 shadow-lg shadow-cyan-500/30 flex items-center justify-center flex-shrink-0">
                <i data-lucide="folder-open" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <h1 class="font-outfit font-bold text-3xl text-[var(--text-primary)] mb-1">Materi & Modul</h1>
                <p class="text-[var(--text-muted)] text-sm">Unduh materi pembelajaran yang dibagikan oleh Bapak/Ibu Guru.</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="neo-flat rounded-3xl p-4 flex flex-wrap gap-4 items-center animate-fadeInUp" style="animation-delay: 0.1s">
        <div class="flex-1 min-w-[200px] relative">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[var(--text-muted)]"></i>
            <input type="text" placeholder="Cari judul materi atau mapel..." 
                   class="w-full neo-pressed rounded-2xl pl-11 pr-4 py-3 text-sm font-medium text-[var(--text-primary)] focus:outline-none">
        </div>
        <select class="neo-btn px-4 py-3 text-xs font-bold rounded-2xl outline-none">
            <option value="">Semua Mapel</option>
            <option value="">Matematika</option>
            <option value="">Bahasa Indonesia</option>
        </select>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materials as $material)
        <div class="neo-flat rounded-3xl p-5 neo-card-hover group animate-fadeInUp" style="animation-delay: {{ 0.1 + ($loop->index * 0.05) }}s">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl neo-pressed flex items-center justify-center text-cyan-600 group-hover:bg-cyan-50 transition-colors">
                    @php
                        $icon = 'file-text';
                        if(str_contains($material->file_type, 'pdf')) $icon = 'file-text';
                        elseif(str_contains($material->file_type, 'doc')) $icon = 'file-edit';
                        elseif(str_contains($material->file_type, 'ppt')) $icon = 'presentation';
                        elseif(str_contains($material->file_type, 'xls')) $icon = 'file-spreadsheet';
                    @endphp
                    <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
                </div>
                <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-600 text-[9px] font-bold uppercase tracking-wider">
                    {{ $material->file_type ?? 'FILE' }}
                </span>
            </div>

            <h3 class="font-outfit font-bold text-base text-[var(--text-primary)] line-clamp-1 mb-1">{{ $material->title }}</h3>
            <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-3">{{ $material->subject->name ?? 'Mata Pelajaran' }}</p>
            
            <p class="text-[11px] text-[var(--text-muted)] line-clamp-2 mb-4 h-8">
                {{ $material->description ?: 'Tidak ada deskripsi tambahan untuk materi ini.' }}
            </p>

            <div class="w-full h-px bg-[var(--shadow-dark)]/10 mb-4"></div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-[var(--shadow-dark)]/20 flex items-center justify-center overflow-hidden">
                        <i data-lucide="user" class="w-3 h-3 text-[var(--text-muted)]"></i>
                    </div>
                    <span class="text-[10px] font-bold text-[var(--text-muted)]">{{ $material->teacher->name ?? 'Guru' }}</span>
                </div>
                <a href="{{ asset('storage/' . $material->file_path) }}" download class="neo-btn p-2 rounded-xl text-cyan-600 hover:text-white group/btn">
                    <i data-lucide="download" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 flex flex-col items-center justify-center text-center opacity-50">
            <div class="w-20 h-20 neo-pressed rounded-full flex items-center justify-center mb-4">
                <i data-lucide="folder-x" class="w-10 h-10 text-[var(--text-muted)]"></i>
            </div>
            <h3 class="font-bold text-[var(--text-primary)]">Materi Belum Tersedia</h3>
            <p class="text-xs text-[var(--text-muted)] mt-1">Bapak/Ibu Guru belum mengunggah materi untuk kelasmu.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
