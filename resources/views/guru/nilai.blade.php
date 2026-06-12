@extends('layouts.guru')

@section('title', 'Nilai Siswa - Scholify Guru')
@section('page-title', 'Input Nilai Siswa')
@section('page-subtitle', 'Kelola nilai tugas dan ujian siswa')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
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

    @if(session('error'))
        <div class="neo-pressed p-4 rounded-xl bg-rose-50/50">
            <div class="flex items-center gap-2 text-rose-600 text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span class="font-semibold">{{ session('error') }}</span>
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
    <form method="GET" action="{{ route('guru.nilai') }}" class="neo-card p-6" id="filterForm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Kelas
                </label>
                <select name="class_id" class="neo-input w-full text-sm" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ ($classId ?? '') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Mata Pelajaran
                </label>
                <select name="subject_id" class="neo-input w-full text-sm" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ ($subjectId ?? '') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                    Filter Jenis Penilaian
                </label>
                <select name="assessment_type" class="neo-input w-full text-sm" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Semua Jenis --</option>
                    <option value="tugas" {{ ($assessmentType ?? '') == 'tugas' ? 'selected' : '' }}>Tugas Harian</option>
                    <option value="quiz" {{ ($assessmentType ?? '') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="uts" {{ ($assessmentType ?? '') == 'uts' ? 'selected' : '' }}>UTS</option>
                    <option value="uas" {{ ($assessmentType ?? '') == 'uas' ? 'selected' : '' }}>UAS</option>
                    <option value="praktikum" {{ ($assessmentType ?? '') == 'praktikum' ? 'selected' : '' }}>Praktikum</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="neo-btn w-full px-6 py-2.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-all hover:scale-105">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Tampilkan
                </button>
            </div>
        </div>
    </form>

    {{-- Form Input Nilai --}}
    @if($students->isNotEmpty())
    <form method="POST" action="{{ route('guru.nilai.store') }}" class="neo-card overflow-hidden" id="nilaiForm">
        @csrf
        <input type="hidden" name="class_id" value="{{ $classId ?? '' }}">
        <input type="hidden" name="subject_id" value="{{ $subjectId ?? '' }}">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3 w-12">No</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3">NISN</th>
                        <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3">Nama Siswa</th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3 w-36">Jenis Penilaian</th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3 w-28">Nilai (0-100)</th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3 w-32">Predikat</th>
                        <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-3 w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                    @foreach($students as $index => $s)
                    <tr class="hover:bg-[var(--bg)] transition-all duration-200 group" data-student-id="{{ $s->id }}">
                        <td class="py-4 px-3 text-center">
                            <span class="text-sm font-medium text-[var(--text-secondary)]">{{ $index + 1 }}</span>
                        </td>
                        <td class="py-4 px-3">
                            <span class="text-xs font-mono text-[var(--text-muted)]">{{ $s->nisn ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-3">
                            <div class="flex items-center gap-3">
                                <div class="neo-pressed w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold text-[var(--accent)] flex-shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($s->name, 0, 2)) }}
                                </div>
                                <span class="font-semibold text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">
                                    {{ $s->name }}
                                </span>
                            </div>
                        </td>
                        {{-- JENIS PENILAIAN PER SISWA --}}
                        <td class="py-4 px-3">
                            <select name="grades[{{ $s->id }}][assessment_type]" 
                                    class="neo-input text-sm py-2 w-full assessment-type-select"
                                    data-student="{{ $s->id }}">
                                <option value="tugas" {{ ($s->grade->assessment_type ?? 'tugas') == 'tugas' ? 'selected' : '' }}>Tugas Harian</option>
                                <option value="quiz" {{ ($s->grade->assessment_type ?? '') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="uts" {{ ($s->grade->assessment_type ?? '') == 'uts' ? 'selected' : '' }}>UTS</option>
                                <option value="uas" {{ ($s->grade->assessment_type ?? '') == 'uas' ? 'selected' : '' }}>UAS</option>
                                <option value="praktikum" {{ ($s->grade->assessment_type ?? '') == 'praktikum' ? 'selected' : '' }}>Praktikum</option>
                            </select>
                        </td>
                        {{-- NILAI --}}
                        <td class="py-4 px-3">
                            <input type="number" 
                                   name="grades[{{ $s->id }}][score]" 
                                   value="{{ old('grades.' . $s->id . '.score', $s->grade->score ?? '') }}"
                                   class="neo-input w-full text-center text-sm py-2 score-input"
                                   placeholder="0-100"
                                   min="0"
                                   max="100"
                                   step="1"
                                   data-student="{{ $s->id }}">
                        </td>
                        {{-- PREDIKAT OTOMATIS --}}
                        <td class="py-4 px-3 text-center">
                            <span class="predikat-badge px-2 py-1 rounded-full text-xs font-bold
                                @php
                                    $score = $s->grade->score ?? null;
                                    if($score !== null && $score !== '') {
                                        if($score >= 90) echo 'bg-emerald-100 text-emerald-700';
                                        elseif($score >= 80) echo 'bg-green-100 text-green-700';
                                        elseif($score >= 70) echo 'bg-blue-100 text-blue-700';
                                        elseif($score >= 60) echo 'bg-amber-100 text-amber-700';
                                        else echo 'bg-red-100 text-red-700';
                                    } else {
                                        echo 'bg-gray-100 text-gray-500';
                                    }
                                @endphp"
                                data-predikat="{{ $s->id }}">
                                @php
                                    $score = $s->grade->score ?? null;
                                    if($score !== null && $score !== '') {
                                        if($score >= 90) echo 'A (Sangat Baik)';
                                        elseif($score >= 80) echo 'B (Baik)';
                                        elseif($score >= 70) echo 'C (Cukup)';
                                        elseif($score >= 60) echo 'D (Kurang)';
                                        else echo 'E (Sangat Kurang)';
                                    } else {
                                        echo 'Belum diisi';
                                    }
                                @endphp
                            </span>
                        </td>
                        {{-- TOMBOL SIMPAN PER SISWA --}}
                        <td class="py-4 px-3 text-center">
                            <button type="button" onclick="saveSingle({{ $s->id }})" 
                                    class="neo-btn w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:scale-105 mx-auto save-single-btn"
                                    title="Simpan nilai siswa ini"
                                    data-student="{{ $s->id }}">
                                <i data-lucide="save" class="w-4 h-4"></i>
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
                <i data-lucide="save-all" class="w-4 h-4"></i>
                Simpan Semua Nilai
            </button>
        </div>
    </form>
    @elseif(isset($classId) && isset($subjectId))
    <div class="neo-flat p-12 text-center">
        <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i data-lucide="users" class="w-10 h-10 text-[var(--text-muted)]"></i>
        </div>
        <p class="text-[var(--text-primary)] font-semibold text-base">Tidak ada siswa di kelas ini</p>
        <p class="text-sm text-[var(--text-muted)] mt-1">Silakan pilih kelas lain</p>
    </div>
    @else
    <div class="neo-flat p-12 text-center">
        <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i data-lucide="filter" class="w-10 h-10 text-[var(--text-muted)]"></i>
        </div>
        <p class="text-[var(--text-primary)] font-semibold text-base">Belum ada filter</p>
        <p class="text-sm text-[var(--text-muted)] mt-1">Silakan pilih kelas dan mata pelajaran terlebih dahulu</p>
    </div>
    @endif
</div>

<style>
    select.neo-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 0.5;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    .toast-notification {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .btn-loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Auto update predikat ketika nilai berubah
        document.querySelectorAll('.score-input').forEach(input => {
            input.addEventListener('input', function() {
                const studentId = this.getAttribute('data-student');
                const score = parseInt(this.value);
                updatePredikat(studentId, score);
            });
        });
    });
    
    function updatePredikat(studentId, score) {
        const predikatSpan = document.querySelector(`[data-predikat="${studentId}"]`);
        if (!predikatSpan) return;
        
        let text = '';
        let colorClass = '';
        
        if (isNaN(score) || score === '' || score === null) {
            text = 'Belum diisi';
            colorClass = 'bg-gray-100 text-gray-500';
        } else if (score >= 90) {
            text = 'A (Sangat Baik)';
            colorClass = 'bg-emerald-100 text-emerald-700';
        } else if (score >= 80) {
            text = 'B (Baik)';
            colorClass = 'bg-green-100 text-green-700';
        } else if (score >= 70) {
            text = 'C (Cukup)';
            colorClass = 'bg-blue-100 text-blue-700';
        } else if (score >= 60) {
            text = 'D (Kurang)';
            colorClass = 'bg-amber-100 text-amber-700';
        } else {
            text = 'E (Sangat Kurang)';
            colorClass = 'bg-red-100 text-red-700';
        }
        
        predikatSpan.textContent = text;
        predikatSpan.className = `predikat-badge px-2 py-1 rounded-full text-xs font-bold ${colorClass}`;
    }
    
    function saveSingle(studentId) {
        // Ambil form utama
        const form = document.getElementById('nilaiForm');
        const formData = new FormData(form);
        
        // Filter hanya data untuk student ini
        const filteredData = new FormData();
        filteredData.append('_token', formData.get('_token'));
        filteredData.append('class_id', formData.get('class_id'));
        filteredData.append('subject_id', formData.get('subject_id'));
        
        for (let [key, value] of formData.entries()) {
            if (key.includes(`grades[${studentId}]`)) {
                filteredData.append(key, value);
            }
        }
        
        // Tambahkan flag untuk AJAX
        filteredData.append('_ajax', '1');
        
        // Animasi loading pada tombol
        const btn = document.querySelector(`.save-single-btn[data-student="${studentId}"]`);
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
        btn.classList.add('btn-loading');
        
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
                showToast(data.message || 'Gagal menyimpan nilai', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan jaringan', 'error');
            // Fallback: submit semua form
            form.submit();
        })
        .finally(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-loading');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    }
    
    function showToast(message, type = 'success') {
        // Hapus toast lama
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();
        
        // Buat toast baru
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed bottom-6 right-6 neo-card px-5 py-3 rounded-xl flex items-center gap-2 z-50 animate-fadeIn`;
        toast.innerHTML = `
            <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-4 h-4 ${type === 'success' ? 'text-emerald-500' : 'text-red-500'}"></i>
            <span class="text-sm font-medium text-[var(--text-primary)]">${message}</span>
        `;
        document.body.appendChild(toast);
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
</script>
@endsection