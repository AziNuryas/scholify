@extends('layouts.admin')
@section('title', 'Edit Kelas - Schoolify Admin')
@section('page-title', 'Edit Kelas')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                <i data-lucide="edit" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">Edit Kelas</h2>
                <p class="text-xs text-[var(--text-secondary)] mt-0.5">Perbarui data kelas dan kelola siswa</p>
            </div>
        </div>
        <a href="{{ route('admin.classes') }}" class="neo-btn px-4 py-2 text-sm font-bold text-[var(--text-secondary)] flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 text-red-600 rounded-2xl p-4 flex items-center gap-3 mb-6 font-bold text-sm">
        <i data-lucide="alert-circle" class="w-5 h-5"></i> Mohon periksa kembali input Anda.
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-600 rounded-2xl p-4 flex items-center gap-3 mb-6 font-bold text-sm">
        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kolom Kiri: Form Edit Kelas -->
        <div class="neo-flat rounded-3xl p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                <div class="p-2 rounded-lg bg-[var(--accent)]/10 text-[var(--accent)]">
                    <i data-lucide="door-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Informasi Kelas</h3>
                    <p class="text-xs text-[var(--text-secondary)]">Perbarui data kelas</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 mb-6">
                <div class="flex items-center gap-2 text-sm font-semibold text-[var(--text-primary)] bg-[var(--accent)]/10 border border-[var(--accent)]/20 px-4 py-2 rounded-xl">
                    <i data-lucide="hash" class="w-4 h-4 text-[var(--accent)]"></i> ID: {{ $class->id }}
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-[var(--text-primary)] bg-[var(--accent)]/10 border border-[var(--accent)]/20 px-4 py-2 rounded-xl">
                    <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i> {{ $class->created_at->format('d/m/Y') }}
                </div>
                <div class="flex items-center gap-2 text-sm font-semibold text-[var(--text-primary)] bg-[var(--accent)]/10 border border-[var(--accent)]/20 px-4 py-2 rounded-xl">
                    <i data-lucide="users" class="w-4 h-4 text-[var(--accent)]"></i> {{ $classStudents->count() }} Siswa
                </div>
            </div>

            <form action="{{ route('admin.classes.update', $class->id) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-[var(--accent)]"></i> Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('name', $class->name) }}" required>
                    @error('name')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-[var(--accent)]"></i> Tingkat <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="grade" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer" required>
                            @foreach($grades as $grade)
                            <option value="{{ $grade }}" {{ old('grade', $class->grade_level) == $grade ? 'selected' : '' }}>Kelas {{ $grade }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    @error('grade')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4 text-[var(--accent)]"></i> Wali Kelas
                    </label>
                    <div class="relative">
                        <select name="homeroom_teacher_id" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-[var(--shadow-dark)]/10 mt-8">
                    <button type="button" onclick="document.getElementById('deleteForm').submit();" class="neo-btn px-4 py-2.5 rounded-xl text-sm font-bold text-red-500 border border-red-500/20 hover:bg-red-500/10 flex items-center gap-2 transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                    </button>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.classes') }}" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-[var(--text-secondary)] bg-white hover:text-red-500 flex items-center gap-2">
                            <i data-lucide="x" class="w-4 h-4"></i> Batal
                        </a>
                        <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center gap-2 shadow-lg shadow-[var(--accent)]/20">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
            <form id="deleteForm" action="{{ route('admin.classes.delete', $class->id) }}" method="POST" class="hidden" onsubmit="return confirm('Hapus kelas {{ $class->name }}?')">@csrf @method('DELETE')</form>
        </div>

        <!-- Kolom Kanan: Kelola Siswa -->
        <div class="neo-flat rounded-3xl p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                <div class="p-2 rounded-lg bg-[var(--accent)]/10 text-[var(--accent)]">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Kelola Siswa</h3>
                    <p class="text-xs text-[var(--text-secondary)]">Siswa di kelas {{ $class->name }}</p>
                </div>
            </div>

            <!-- Form Tambah Siswa -->
            <div class="neo-pressed p-5 rounded-2xl mb-6">
                <div class="font-bold text-sm text-[var(--text-primary)] mb-3 flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4 text-[var(--accent)]"></i> Tambah Siswa ke Kelas
                </div>
                <form action="{{ route('admin.classes.add-student', $class->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <select name="student_id" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nisn ?? '-' }})</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    <button type="submit" class="neo-btn px-5 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center justify-center gap-2 whitespace-nowrap shadow-md shadow-[var(--accent)]/20">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah
                    </button>
                </form>
            </div>

            <!-- Daftar Siswa -->
            <div class="font-bold text-sm text-[var(--text-primary)] mb-3 flex items-center gap-2">
                <i data-lucide="list" class="w-4 h-4 text-[var(--accent)]"></i> 
                Daftar Siswa ({{ $classStudents->count() }})
            </div>
            
            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($classStudents as $student)
                <div class="flex items-center justify-between p-3 bg-white border border-[var(--shadow-dark)]/10 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random&color=fff&bold=true" class="w-10 h-10 rounded-xl border-2 border-white shadow-sm object-cover">
                        <div>
                            <h4 class="font-bold text-sm text-[var(--text-primary)]">{{ $student->name }}</h4>
                            <p class="text-[11px] text-[var(--text-muted)] font-semibold">{{ $student->nisn ?? 'NISN: -' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.classes.remove-student', [$class->id, $student->id]) }}" method="POST" onsubmit="return confirm('Keluarkan {{ $student->name }} dari kelas ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-500/10 border border-transparent hover:border-red-500/20 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 rounded-full bg-[var(--shadow-dark)]/5 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="users" class="w-8 h-8 text-[var(--text-muted)]/50"></i>
                    </div>
                    <p class="text-sm font-semibold text-[var(--text-secondary)]">Belum ada siswa.</p>
                    <p class="text-[11px] text-[var(--text-muted)] mt-1">Tambahkan siswa melalui form di atas.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--shadow-dark); border-radius: 10px; opacity: 0.1; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
</style>
@endsection