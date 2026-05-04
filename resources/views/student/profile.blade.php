@extends('layouts.student')
@section('title', 'Profil - Schoolify')
@section('page-title', 'Profil Siswa')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div>
        <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Informasi Profil Siswa</h1>
        <p class="text-sm text-[var(--text-secondary)]">Lengkapi dan perbarui data diri Anda di bawah ini.</p>
    </div>

    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Kiri: Profil Singkat -->
            <div class="lg:col-span-1">
                <div class="neo-flat rounded-2xl p-8 text-center h-full flex flex-col justify-center">
                    <div class="relative inline-block mx-auto mb-6">
                        <div class="w-32 h-32 rounded-2xl neo-pressed p-2 overflow-hidden bg-[var(--bg)]">
                            @if(isset($studentData) && $studentData->avatar)
                                <img id="profile-preview" src="{{ asset('storage/' . str_replace('/storage/', '', $studentData->avatar)) }}" alt="Foto Profil" class="w-full h-full rounded-xl object-cover">
                            @else
                                <img id="profile-preview" src="" alt="" class="w-full h-full rounded-xl object-cover hidden">
                                <div id="profile-placeholder" class="w-full h-full rounded-xl bg-[var(--bg)] flex items-center justify-center">
                                    <i data-lucide="user" class="w-12 h-12 text-[var(--text-muted)]"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Tombol Edit Foto -->
                        <label for="avatar_upload" class="absolute -bottom-2 -right-2 w-10 h-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 hover:scale-105 transition-transform cursor-pointer">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                            <input type="file" id="avatar_upload" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>
                    
                    <h2 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $studentData->name ?? $studentData->first_name ?? 'Siswa' }}</h2>
                    <p class="text-sm font-bold text-[var(--text-muted)] uppercase tracking-wider mt-1">{{ $studentData->schoolClass->name ?? $studentData->class_id ?? 'Siswa' }}</p>
                    
                    <div class="mt-6 flex flex-col gap-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-[var(--shadow-dark)]/5">
                            <span class="text-[var(--text-secondary)] font-semibold">NISN</span>
                            <span class="font-bold text-[var(--text-primary)]">{{ $studentData->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[var(--shadow-dark)]/5">
                            <span class="text-[var(--text-secondary)] font-semibold">Status</span>
                            <span class="font-bold text-emerald-500 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Data Pribadi Lengkap -->
            <div class="lg:col-span-2">
                <div class="neo-flat rounded-2xl p-6">
                    <div class="mb-6">
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Data Pribadi Lengkap</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)] mt-1">Formulir informasi data diri</p>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-[9px] text-red-500">(Tidak dapat diubah)</span>
                            </label>
                            <input type="text" value="{{ $studentData->name ?? $studentData->first_name ?? '' }}" class="w-full neo-pressed rounded-xl px-4 py-3 text-sm font-semibold text-[var(--text-muted)] cursor-not-allowed" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">
                                Nomor Induk (NISN)
                            </label>
                            <input type="text" value="{{ $studentData->nisn ?? '' }}" class="w-full neo-pressed rounded-xl px-4 py-3 text-sm font-semibold text-[var(--text-muted)] cursor-not-allowed" readonly>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">
                                Email <span class="text-[9px] text-red-500">(Tidak dapat diubah)</span>
                            </label>
                            <input type="email" value="{{ auth()->user()->email ?? '' }}" class="w-full neo-pressed rounded-xl px-4 py-3 text-sm font-semibold text-[var(--text-muted)] cursor-not-allowed" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">
                                Nomor Telepon <span class="text-[9px] text-indigo-500">(Dapat diubah)</span>
                            </label>
                            <input type="text" name="phone" value="{{ $studentData->phone ?? '' }}" class="w-full neo-input rounded-xl px-4 py-3 text-sm font-semibold text-[var(--text-primary)] transition-all" placeholder="Contoh: 08123456789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">
                            Alamat Lengkap <span class="text-[9px] text-indigo-500">(Dapat diubah)</span>
                        </label>
                        <textarea name="address" rows="3" class="w-full neo-input rounded-xl px-4 py-3 text-sm font-semibold text-[var(--text-primary)] transition-all resize-none" placeholder="Masukkan alamat lengkap Anda">{{ $studentData->address ?? '' }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/30 transition-all flex items-center gap-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                const placeholder = document.getElementById('profile-placeholder');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        alert('{{ session('success') }}');
    });
</script>
@endif
@endsection