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
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @php 
            $stats = [
                ['label' => 'Hadir', 'count' => 32, 'color' => 'emerald', 'icon' => 'check-circle'],
                ['label' => 'Izin', 'count' => 2, 'color' => 'amber', 'icon' => 'file-text'],
                ['label' => 'Sakit', 'count' => 1, 'color' => 'blue', 'icon' => 'activity'],
                ['label' => 'Alpha', 'count' => 0, 'color' => 'rose', 'icon' => 'alert-circle'],
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
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                {{-- Pilih Kelas --}}
                <div class="relative">
                    <select class="neo-input appearance-none pl-10 pr-8 py-2.5 text-sm cursor-pointer">
                        <option selected>10-IPA 1 (Matematika)</option>
                        <option>11-IPA 2 (Fisika)</option>
                        <option>12-IPA 1 (Matematika)</option>
                    </select>
                    <i data-lucide="door-open" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
                
                {{-- Tanggal --}}
                <div class="neo-pressed px-4 py-2.5 rounded-xl text-sm font-semibold text-[var(--text-primary)] flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('d MMMM Y') }}
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
                <button onclick="saveAttendance()" 
                        class="neo-btn px-6 py-2.5 rounded-xl text-sm font-semibold flex items-center gap-2 transition-all hover:scale-105">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Presensi
                </button>
            </div>
        </div>
    </div>

    {{-- Tabel Absensi --}}
    <div class="neo-card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--shadow-dark)]/10">
            <div class="flex items-center gap-2">
                <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4 text-[var(--accent)]"></i>
                </div>
                <h4 class="font-outfit font-bold text-base text-[var(--text-primary)]">Daftar Kehadiran Siswa</h4>
            </div>
            <button onclick="markAllPresent()" 
                    class="neo-btn px-4 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                Tandai Hadir Semua
            </button>
        </div>

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
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                    @php
                        $students = [
                            ['name' => 'Budi Santoso', 'nisn' => '0012345678'],
                            ['name' => 'Siti Aminah', 'nisn' => '0012345679'],
                            ['name' => 'Rian Hidayat', 'nisn' => '0012345680'],
                            ['name' => 'Dewi Lestari', 'nisn' => '0012345681'],
                            ['name' => 'Ahmad Fauzan', 'nisn' => '0012345682'],
                            ['name' => 'Nadia Putri', 'nisn' => '0012345683'],
                        ];
                    @endphp

                    @foreach($students as $index => $student)
                    <tr class="student-row hover:bg-[var(--bg)] transition-all duration-200 group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-[var(--accent)] flex-shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($student['name'], 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-[var(--text-primary)] text-sm group-hover:text-[var(--accent)] transition-colors">
                                        {{ $student['name'] }}
                                    </span>
                                    <p class="text-[11px] text-[var(--text-muted)] font-medium flex items-center gap-1 mt-0.5">
                                        <i data-lucide="id-card" class="w-2.5 h-2.5"></i>
                                        NISN: {{ $student['nisn'] }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex justify-center items-center gap-2">
                                @php
                                    $statuses = [
                                        ['code' => 'h', 'label' => 'Hadir', 'color' => 'emerald', 'icon' => 'check'],
                                        ['code' => 'i', 'label' => 'Izin', 'color' => 'amber', 'icon' => 'file-text'],
                                        ['code' => 's', 'label' => 'Sakit', 'color' => 'blue', 'icon' => 'activity'],
                                        ['code' => 'a', 'label' => 'Alpha', 'color' => 'rose', 'icon' => 'x'],
                                    ];
                                @endphp
                                @foreach($statuses as $status)
                                    <input type="radio" name="status_{{$index}}" id="{{$status['code']}}_{{$index}}" 
                                           value="{{$status['code']}}" class="hidden status-radio"
                                           {{ $status['code'] == 'h' ? 'checked' : '' }}>
                                    <label for="{{$status['code']}}_{{$index}}" 
                                           class="status-label cursor-pointer w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200
                                                  bg-[var(--bg)] text-[var(--text-muted)] hover:bg-[var(--accent)]/10 hover:text-[var(--accent)]"
                                           data-status="{{$status['code']}}" data-color="{{$status['color']}}"
                                           title="{{$status['label']}}">
                                        <i data-lucide="{{$status['icon']}}" class="w-4 h-4"></i>
                                    </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Hover effects */
    .group-hover\:scale-105:hover {
        transform: scale(1.05);
    }
    
    /* Status label hover */
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
        const presentRadios = document.querySelectorAll('input[type="radio"][id^="h_"]');
        presentRadios.forEach(radio => {
            radio.checked = true;
            // Trigger change event to update UI
            const event = new Event('change', { bubbles: true });
            radio.dispatchEvent(event);
        });
        
        // Show notification (optional)
        showToast('Semua siswa ditandai hadir', 'success');
    }
    
    // Save attendance function
    function saveAttendance() {
        // Get all selected statuses
        const selectedStatuses = [];
        const radioGroups = document.querySelectorAll('input[type="radio"]:checked');
        radioGroups.forEach(radio => {
            selectedStatuses.push({
                name: radio.name,
                status: radio.value
            });
        });
        
        // Show success notification
        showToast('Presensi berhasil disimpan!', 'success');
        
        // Here you can add AJAX call to save to database
        console.log('Saved attendance:', selectedStatuses);
    }
    
    // Toast notification function
    function showToast(message, type = 'success') {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed bottom-6 right-6 neo-card px-5 py-3 rounded-xl flex items-center gap-2 z-50 animate-fadeIn`;
        toast.innerHTML = `
            <i data-lucide="${type === 'success' ? 'check-circle' : 'info'}" class="w-4 h-4 text-emerald-500"></i>
            <span class="text-sm font-medium text-[var(--text-primary)]">${message}</span>
        `;
        document.body.appendChild(toast);
        
        // Re-initialize icon
        if (typeof lucide !== 'undefined') lucide.createIcons();
        
        // Auto remove after 3 seconds
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
    
    // Add animation to radio labels when clicked
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