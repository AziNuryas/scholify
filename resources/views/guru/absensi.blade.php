@extends('layouts.guru')

@section('title', 'Absensi - Scholify Guru')
@section('page-title', 'Absensi Harian')
@section('page-subtitle', 'Pilih status kehadiran siswa secara teliti')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="user-check" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Absensi Harian</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Pilih status kehadiran siswa secara teliti</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl">
                <span class="text-xs font-bold text-[var(--text-muted)] flex items-center gap-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i>
                    {{ \Carbon\Carbon::parse($date ?? now())->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistik Cards (Data Real) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @php 
            $hadirCount = $students->where('attendance_status', 'hadir')->count();
            $izinCount = $students->where('attendance_status', 'izin')->count();
            $sakitCount = $students->where('attendance_status', 'sakit')->count();
            $alphaCount = $students->where('attendance_status', 'alpha')->count();
            
            $stats = [
                ['label' => 'Hadir', 'count' => $hadirCount, 'color' => 'emerald', 'icon' => 'check-circle'],
                ['label' => 'Izin', 'count' => $izinCount, 'color' => 'amber', 'icon' => 'file-text'],
                ['label' => 'Sakit', 'count' => $sakitCount, 'color' => 'blue', 'icon' => 'activity'],
                ['label' => 'Alpha', 'count' => $alphaCount, 'color' => 'rose', 'icon' => 'alert-circle'],
            ]; 
        @endphp
        @foreach($stats as $stat)
        <div class="neo-card p-5 group hover:neo-pressed transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-{{$stat['color']}}-500 uppercase tracking-wider">{{$stat['label']}}</p>
                    <h3 class="text-3xl font-bold text-[var(--text-primary)] mt-1">{{$stat['count']}}</h3>
                </div>
                <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="{{$stat['icon']}}" class="w-5 h-5 text-{{$stat['color']}}-500"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="neo-card p-4">
        <form method="GET" action="{{ route('guru.absensi') }}" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Pilih Kelas --}}
                <div class="relative">
                    <select name="class_id" class="neo-input appearance-none pl-10 pr-8 py-2.5 text-sm cursor-pointer" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ ($classId ?? '') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="door-open" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
                
                {{-- Pilih Mata Pelajaran / Jadwal --}}
                <div class="relative">
                    <select name="schedule_id" class="neo-input appearance-none pl-10 pr-8 py-2.5 text-sm cursor-pointer" onchange="this.form.submit()">
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($schedules ?? [] as $schedule)
                            <option value="{{ $schedule->id }}" {{ ($scheduleId ?? '') == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->subject->name ?? 'Mata Pelajaran' }} ({{ $schedule->start_time ?? '' }} - {{ $schedule->end_time ?? '' }})
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="book-open" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
                
                {{-- Pilih Tanggal --}}
                <div class="relative">
                    <input type="date" name="date" value="{{ $date ?? date('Y-m-d') }}" 
                           class="neo-input pl-10 pr-4 py-2.5 text-sm cursor-pointer" onchange="this.form.submit()">
                    <i data-lucide="calendar" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari siswa..." 
                           class="neo-input pl-10 pr-4 py-2.5 text-sm w-48 focus:w-64 transition-all duration-300">
                    <i data-lucide="search" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--text-muted)]"></i>
                </div>
                
                {{-- Tombol Simpan --}}
                <button type="button" onclick="saveAttendance()" 
                        class="neo-btn px-6 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Presensi
                </button>
            </div>
        </form>
    </div>

    {{-- Form Absensi --}}
    <form id="attendanceForm" action="{{ route('guru.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="class_id" value="{{ $classId ?? '' }}">
        <input type="hidden" name="schedule_id" value="{{ $scheduleId ?? '' }}">
        <input type="hidden" name="date" value="{{ $date ?? date('Y-m-d') }}">
        
        <div class="neo-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--shadow-dark)]/10">
                <div class="flex items-center gap-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h4 class="font-outfit font-bold text-base text-[var(--text-primary)]">Daftar Kehadiran Siswa</h4>
                    <span class="text-xs text-[var(--text-muted)] ml-2">Total: {{ $students->count() }} siswa</span>
                </div>
                <button type="button" onclick="markAllPresent()" 
                        class="neo-btn px-4 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                    Tandai Hadir Semua
                </button>
            </div>

            @if(empty($classId))
                <div class="text-center py-12 text-[var(--text-muted)]">
                    <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                    <p class="text-base font-medium">Belum ada kelas dipilih</p>
                    <p class="text-sm mt-1">Silakan pilih kelas terlebih dahulu untuk memulai absensi</p>
                </div>
            @elseif($students->isEmpty())
                <div class="text-center py-12 text-[var(--text-muted)]">
                    <i data-lucide="users" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                    <p class="text-base font-medium">Belum ada siswa di kelas ini</p>
                    <p class="text-sm mt-1">Silakan tambahkan siswa terlebih dahulu</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="attendanceTable">
                        <thead>
                            <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                                <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-6">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="user" class="w-3 h-3"></i>
                                        Identitas Siswa
                                    </div>
                                </th>
                                <th class="text-center text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-6">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <i data-lucide="clipboard-list" class="w-3 h-3"></i>
                                        Status Kehadiran
                                    </div>
                                </th>
                                <th class="text-left text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider py-4 px-6">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="file-text" class="w-3 h-3"></i>
                                        Keterangan
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                            @foreach($students as $index => $student)
                            <tr class="student-row hover:bg-[var(--bg)] transition-all duration-200 group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-[var(--accent)] flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($student->name ?? 'Siswa', 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">
                                                {{ $student->name ?? 'Siswa' }}
                                            </span>
                                            <p class="text-[11px] text-[var(--text-muted)] font-medium flex items-center gap-1 mt-0.5">
                                                <i data-lucide="id-card" class="w-2.5 h-2.5"></i>
                                                NIS: {{ $student->nis ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-center items-center gap-2">
                                        @php
                                            $statuses = [
                                                'hadir' => ['label' => 'Hadir', 'color' => 'emerald', 'icon' => 'check'],
                                                'izin' => ['label' => 'Izin', 'color' => 'amber', 'icon' => 'file-text'],
                                                'sakit' => ['label' => 'Sakit', 'color' => 'blue', 'icon' => 'activity'],
                                                'alpha' => ['label' => 'Alpha', 'color' => 'rose', 'icon' => 'x'],
                                            ];
                                            $currentStatus = $student->attendance_status ?? 'hadir';
                                        @endphp
                                        @foreach($statuses as $key => $status)
                                            <input type="radio" name="attendance[{{ $student->id }}]" 
                                                   id="{{ $key }}_{{ $student->id }}" 
                                                   value="{{ $key }}" 
                                                   class="hidden status-radio"
                                                   {{ $currentStatus == $key ? 'checked' : '' }}>
                                            <label for="{{ $key }}_{{ $student->id }}" 
                                                   class="status-label cursor-pointer w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200
                                                          bg-[var(--bg)] text-[var(--text-muted)] hover:bg-{{ $status['color'] }}-500/10 hover:text-{{ $status['color'] }}-500"
                                                   title="{{ $status['label'] }}">
                                                <i data-lucide="{{ $status['icon'] }}" class="w-4 h-4"></i>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <input type="text" name="notes[{{ $student->id }}]" 
                                           value="{{ $student->attendance_notes ?? '' }}"
                                           placeholder="Keterangan (opsional)"
                                           class="neo-input w-48 px-3 py-2 text-sm rounded-xl">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </form>
</div>

<style>
    /* Status Radio styling */
    .status-radio:checked + .status-label {
        background: var(--accent) !important;
        color: white !important;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                    inset -2px -2px 5px rgba(255, 255, 255, 0.1);
        transform: scale(1.05);
    }
    
    /* Neumorphism untuk select */
    select.neo-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    .status-label:hover {
        transform: translateY(-2px);
    }
</style>

<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    // Mark all students as present
    function markAllPresent() {
        const presentRadios = document.querySelectorAll('input[type="radio"][value="hadir"]');
        presentRadios.forEach(radio => {
            radio.checked = true;
            const event = new Event('change', { bubbles: true });
            radio.dispatchEvent(event);
        });
        
        showToast('Semua siswa ditandai hadir', 'success');
    }
    
    // Save attendance function
    function saveAttendance() {
        const form = document.getElementById('attendanceForm');
        
        // Validasi minimal pilih kelas dan jadwal
        const classId = document.querySelector('input[name="class_id"]')?.value;
        const scheduleId = document.querySelector('input[name="schedule_id"]')?.value;
        
        if (!classId || !scheduleId) {
            showToast('Silakan pilih kelas dan jadwal terlebih dahulu!', 'error');
            return;
        }
        
        // Submit form
        form.submit();
    }
    
    // Toast notification function
    function showToast(message, type = 'success') {
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();
        
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed bottom-6 right-6 neo-card px-5 py-3 rounded-xl flex items-center gap-2 z-50`;
        toast.innerHTML = `
            <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-4 h-4 text-${type === 'success' ? 'emerald' : 'rose'}-500"></i>
            <span class="text-sm font-medium text-[var(--text-primary)]">${message}</span>
        `;
        document.body.appendChild(toast);
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('.student-row');
        
        rows.forEach(row => {
            const name = row.querySelector('.font-semibold')?.textContent.toLowerCase() || '';
            row.style.display = name.includes(value) ? '' : 'none';
        });
    });
    
    // Animation for radio labels
    document.querySelectorAll('.status-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const label = document.querySelector(`label[for="${this.id}"]`);
                if (label) {
                    label.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                }
            }
        });
    });
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