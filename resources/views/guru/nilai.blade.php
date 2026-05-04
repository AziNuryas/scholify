@extends('layouts.guru')

@section('title', 'Nilai Siswa - Scholify Guru')
@section('page-title', 'Input Nilai Siswa')
@section('page-subtitle', 'Kelola nilai tugas dan ujian siswa')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="edit-3" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Input Nilai Siswa</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Kelola nilai tugas dan ujian siswa</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl">
                <span class="text-xs font-bold text-[var(--text-muted)] flex items-center gap-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="neo-pressed p-4 rounded-xl bg-emerald-50/50">
            <div class="flex items-center gap-2 text-emerald-600 text-sm">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="neo-pressed p-4 rounded-xl bg-rose-50/50">
            <div class="flex items-center gap-2 text-rose-600 text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span class="font-semibold">Terjadi kesalahan!</span>
            </div>
            <ul class="text-xs text-rose-500 mt-2 ml-6">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Filter --}}
    <form method="GET" action="{{ route('guru.nilai') }}" class="neo-card p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Kelas
                </label>
                <select name="class_id" class="neo-input w-full text-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Mata Pelajaran
                </label>
                <select name="subject_id" class="neo-input w-full text-sm">
                    <option value="">Pilih Mapel</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Jenis Penilaian
                </label>
                <select name="type" class="neo-input w-full text-sm">
                    <option value="">Pilih Jenis</option>
                    <option value="tugas" {{ request('type') == 'tugas' ? 'selected' : '' }}>📝 Tugas Harian</option>
                    <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>📋 Quiz</option>
                    <option value="uts" {{ request('type') == 'uts' ? 'selected' : '' }}>📖 UTS</option>
                    <option value="uas" {{ request('type') == 'uas' ? 'selected' : '' }}>📚 UAS</option>
                    <option value="praktikum" {{ request('type') == 'praktikum' ? 'selected' : '' }}>🔬 Praktikum</option>
                </select>
            </div>
        </div>
        <div class="mt-5 flex justify-end">
            <button type="submit" class="neo-btn px-6 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
                <i data-lucide="search" class="w-4 h-4"></i>
                Tampilkan
            </button>
        </div>
    </form>

    {{-- Form Input Nilai --}}
    @if($students->isNotEmpty())
    <form method="POST" action="{{ route('guru.nilai.store') }}" class="neo-card overflow-hidden">
        @csrf
        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
        <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
        <input type="hidden" name="type" value="{{ request('type') }}">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4 w-16">
                            <div class="flex items-center justify-center gap-1">
                                <i data-lucide="hash" class="w-3 h-3"></i>
                                No
                            </div>
                        </th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4">
                            <div class="flex items-center gap-1">
                                <i data-lucide="id-card" class="w-3 h-3"></i>
                                NISN
                            </div>
                        </th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4">
                            <div class="flex items-center gap-1">
                                <i data-lucide="user" class="w-3 h-3"></i>
                                Nama Siswa
                            </div>
                        </th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4 w-32">
                            <div class="flex items-center justify-center gap-1">
                                <i data-lucide="star" class="w-3 h-3"></i>
                                Nilai
                            </div>
                        </th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4 w-40">
                            <div class="flex items-center gap-1">
                                <i data-lucide="flag" class="w-3 h-3"></i>
                                Keterangan
                            </div>
                        </th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-4 w-24">
                            <div class="flex items-center justify-center gap-1">
                                <i data-lucide="more-horizontal" class="w-3 h-3"></i>
                                Aksi
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                    @foreach($students as $index => $s)
                    <tr class="hover:bg-[var(--bg)] transition-all duration-200 group">
                        <td class="py-4 px-4 text-center">
                            <span class="text-sm font-medium text-[var(--text-secondary)]">{{ $index + 1 }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-xs font-mono text-[var(--text-muted)]">{{ $s->nisn }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="neo-pressed w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-[var(--accent)] flex-shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($s->name, 0, 2)) }}
                                </div>
                                <span class="font-semibold text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">
                                    {{ $s->name }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <input type="number" 
                                   name="grades[{{ $s->id }}][score]" 
                                   value="{{ old('grades.' . $s->id . '.score', $s->grade->score ?? '') }}"
                                   class="neo-input w-full text-center text-sm py-2"
                                   placeholder="0-100"
                                   min="0"
                                   max="100"
                                   step="1">
                        </td>
                        <td class="py-4 px-4">
                            <select name="grades[{{ $s->id }}][status]" class="neo-input text-sm py-2 w-full">
                                <option value="">- Pilih -</option>
                                <option value="tuntas" {{ ($s->grade->status ?? '') == 'tuntas' ? 'selected' : '' }}>✅ Tuntas</option>
                                <option value="remedial" {{ ($s->grade->status ?? '') == 'remedial' ? 'selected' : '' }}>🔄 Remedial</option>
                                <option value="tidak_tuntas" {{ ($s->grade->status ?? '') == 'tidak_tuntas' ? 'selected' : '' }}>❌ Tidak Tuntas</option>
                            </select>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <button type="button" onclick="saveSingle({{ $s->id }})" 
                                    class="neo-btn w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:scale-105 mx-auto"
                                    title="Simpan nilai siswa ini">
                                <i data-lucide="save" class="w-3.5 h-3.5"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap justify-between items-center gap-4 px-6 py-4 border-t border-[var(--shadow-dark)]/10 bg-[var(--bg)]/30">
            <div class="text-sm text-[var(--text-muted)]">
                <i data-lucide="users" class="w-3.5 h-3.5 inline mr-1"></i>
                Menampilkan {{ $students->count() }} siswa
            </div>
            <button type="submit" class="neo-btn px-6 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Simpan Semua Nilai
            </button>
        </div>
    </form>
    @else
    <div class="neo-flat p-12 text-center">
        <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i data-lucide="inbox" class="w-10 h-10 text-[var(--text-muted)]"></i>
        </div>
        <p class="text-[var(--text-primary)] font-semibold text-base">Belum ada data siswa</p>
        <p class="text-sm text-[var(--text-muted)] mt-1">Silakan pilih kelas, mata pelajaran, dan jenis penilaian terlebih dahulu</p>
    </div>
    @endif
</div>

<style>
    /* Hide number input spinners */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 0.5;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Select arrow */
    select.neo-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    /* Hover effects */
    .group-hover\:scale-105:hover {
        transform: scale(1.05);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    function saveSingle(studentId) {
        // Get the main form
        const form = document.querySelector('form[action="{{ route('guru.nilai.store') }}"]');
        
        // Create FormData to submit only this student's data
        const formData = new FormData(form);
        
        // Keep only data for this specific student
        const filteredData = new FormData();
        for (let [key, value] of formData.entries()) {
            if (key.includes(`grades[${studentId}]`) || key === '_token') {
                filteredData.append(key, value);
            }
        }
        
        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: filteredData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Nilai berhasil disimpan!', 'success');
            } else {
                showToast('Gagal menyimpan nilai', 'error');
            }
        })
        .catch(error => {
            // Fallback: submit the whole form
            form.submit();
        });
    }
    
    function showToast(message, type = 'success') {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed bottom-6 right-6 neo-card px-5 py-3 rounded-xl flex items-center gap-2 z-50 animate-fadeIn`;
        toast.innerHTML = `
            <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-4 h-4 text-emerald-500"></i>
            <span class="text-sm font-medium text-[var(--text-primary)]">${message}</span>
        `;
        document.body.appendChild(toast);
        
        // Re-initialize icon
        if (typeof lucide !== 'undefined') lucide.createIcons();
        
        // Auto remove after 2.5 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    .toast-notification {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection