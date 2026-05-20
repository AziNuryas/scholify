@extends('layouts.admin')
@section('title', 'Tambah Kelas - Schoolify Admin')
@section('page-title', 'Tambah Kelas')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                <i data-lucide="door-open" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">Form Tambah Kelas</h2>
                <p class="text-xs text-[var(--text-secondary)] mt-0.5">Buat kelas baru untuk tahun ajaran 2024/2025</p>
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

    <div class="neo-flat rounded-3xl p-6 relative z-10">
        <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl p-4 flex items-start gap-3 mb-6">
            <i data-lucide="info" class="w-5 h-5 text-blue-500 shrink-0 mt-0.5"></i>
            <p class="text-xs font-semibold text-[var(--text-secondary)]">Kelas yang dibuat akan langsung aktif dan siap digunakan.</p>
        </div>

        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-[var(--accent)]"></i> Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" class="w-full neo-input py-3 px-4 text-sm font-semibold" placeholder="Contoh: X-A, XI-B, XII-C" value="{{ old('name') }}" required>
                    <p class="text-xs text-[var(--text-muted)] font-semibold mt-1">Format: [Tingkat]-[Kode Kelas], contoh: X-A</p>
                    @error('name')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-[var(--accent)]"></i> Tingkat Kelas <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="grade" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer" required>
                            <option value="">-- Pilih Tingkat --</option>
                            @foreach($grades as $grade)
                            <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>Kelas {{ $grade }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    @error('grade')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 md:col-span-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4 text-[var(--accent)]"></i> Wali Kelas
                    </label>
                    <div class="relative">
                        <select name="homeroom_teacher_id" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer">
                            <option value="">-- Pilih Wali Kelas (Opsional) --</option>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    @error('homeroom_teacher_id')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-[var(--shadow-dark)]/10 mt-8">
                <a href="{{ route('admin.classes') }}" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-[var(--text-secondary)] bg-white hover:text-red-500 flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i> Batal
                </a>
                <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center gap-2 shadow-lg shadow-[var(--accent)]/20">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection