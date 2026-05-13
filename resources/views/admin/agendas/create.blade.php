@extends('layouts.admin')
@section('title', 'Tambah Agenda - Schoolify Admin')
@section('page-title', 'Tambah Agenda')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">Form Tambah Agenda</h2>
                <p class="text-xs text-[var(--text-secondary)] mt-0.5">Agenda yang dibuat akan muncul di kalender sesuai target yang dipilih.</p>
            </div>
        </div>
        <a href="{{ route('admin.agendas.index') }}" class="neo-btn px-4 py-2 text-sm font-bold text-[var(--text-secondary)] flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 text-red-600 rounded-2xl p-4 flex items-center gap-3 mb-6 font-bold text-sm">
        <i data-lucide="alert-circle" class="w-5 h-5"></i> Mohon periksa kembali input Anda.
    </div>
    @endif

    <div class="neo-flat rounded-3xl p-6 relative z-10">
        <form action="{{ route('admin.agendas.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="heading" class="w-4 h-4 text-[var(--accent)]"></i> Judul Agenda <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('title') }}" placeholder="Contoh: Ujian Tengah Semester" required>
                    @error('title')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-[var(--accent)]"></i> Tipe Agenda <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="type" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="uts" {{ old('type') == 'uts' ? 'selected' : '' }}>📝 UTS (Ujian Tengah Semester)</option>
                            <option value="uas" {{ old('type') == 'uas' ? 'selected' : '' }}>📚 UAS (Ujian Akhir Semester)</option>
                            <option value="ujian" {{ old('type') == 'ujian' ? 'selected' : '' }}>✏️ Ujian Sekolah</option>
                            <option value="rapat" {{ old('type') == 'rapat' ? 'selected' : '' }}>👥 Rapat</option>
                            <option value="libur" {{ old('type') == 'libur' ? 'selected' : '' }}>🎉 Libur</option>
                            <option value="kegiatan" {{ old('type') == 'kegiatan' ? 'selected' : '' }}>📌 Kegiatan</option>
                            <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>📋 Lainnya</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    @error('type')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-[var(--accent)]"></i> Target <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="target_role" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer" required>
                            <option value="semua" {{ old('target_role') == 'semua' ? 'selected' : '' }}>🌍 Semua</option>
                            <option value="admin" {{ old('target_role') == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                            <option value="guru" {{ old('target_role') == 'guru' ? 'selected' : '' }}>👨‍🏫 Guru</option>
                            <option value="siswa" {{ old('target_role') == 'siswa' ? 'selected' : '' }}>🎓 Siswa</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                    @error('target_role')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i> Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="start_date" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('start_date', $defaultDate) }}" required>
                    @error('start_date')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i> Tanggal Selesai
                    </label>
                    <input type="date" name="end_date" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('end_date') }}">
                    <p class="text-xs text-[var(--text-muted)] font-semibold mt-1">Kosongkan jika hanya 1 hari</p>
                    @error('end_date')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-[var(--accent)]"></i> Jam Mulai
                    </label>
                    <input type="time" name="start_time" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('start_time') }}">
                    @error('start_time')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-[var(--accent)]"></i> Jam Selesai
                    </label>
                    <input type="time" name="end_time" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('end_time') }}">
                    @error('end_time')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[var(--accent)]"></i> Lokasi
                    </label>
                    <input type="text" name="location" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('location') }}" placeholder="Contoh: Aula Sekolah">
                    @error('location')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="align-left" class="w-4 h-4 text-[var(--accent)]"></i> Deskripsi
                    </label>
                    <textarea name="description" class="w-full neo-input py-3 px-4 text-sm font-semibold min-h-[100px] resize-y" placeholder="Deskripsi atau catatan tambahan">{{ old('description') }}</textarea>
                    @error('description')<p class="text-xs text-red-500 font-semibold">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2 md:col-span-2 relative">
                    <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                        <i data-lucide="power" class="w-4 h-4 text-[var(--accent)]"></i> Status
                    </label>
                    <div class="relative">
                        <select name="is_active" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-[var(--shadow-dark)]/10 mt-8">
                <a href="{{ route('admin.agendas.index') }}" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-[var(--text-secondary)] bg-white hover:text-red-500 flex items-center gap-2">
                    <i data-lucide="x" class="w-4 h-4"></i> Batal
                </a>
                <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center gap-2 shadow-lg shadow-[var(--accent)]/20">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>
@endsection