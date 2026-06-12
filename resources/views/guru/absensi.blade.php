@extends('layouts.guru')

@section('title', 'Absensi - Scholify Guru')
@section('page-title', 'Absensi Harian')
@section('page-subtitle', 'Pilih status kehadiran siswa secara teliti')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
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

    {{-- Statistik Cards dengan Animasi Counter --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5" id="statsContainer">
        @php 
            $hadirCount = $students->where('attendance_status', 'hadir')->count();
            $izinCount = $students->where('attendance_status', 'izin')->count();
            $sakitCount = $students->where('attendance_status', 'sakit')->count();
            $alphaCount = $students->where('attendance_status', 'alpha')->count();
            
            $stats = [
                ['id' => 'stat-hadir', 'label' => 'Hadir', 'count' => $hadirCount, 'color' => '#10b981', 'icon' => 'check-circle', 'bg' => 'emerald'],
                ['id' => 'stat-izin', 'label' => 'Izin', 'count' => $izinCount, 'color' => '#f59e0b', 'icon' => 'file-text', 'bg' => 'amber'],
                ['id' => 'stat-sakit', 'label' => 'Sakit', 'count' => $sakitCount, 'color' => '#3b82f6', 'icon' => 'activity', 'bg' => 'blue'],
                ['id' => 'stat-alpha', 'label' => 'Alpha', 'count' => $alphaCount, 'color' => '#ef4444', 'icon' => 'alert-circle', 'bg' => 'rose'],
            ]; 
        @endphp
        @foreach($stats as $stat)
        <div class="neo-card p-5 group hover:neo-pressed transition-all duration-300" data-stat="{{ $stat['id'] }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-{{$stat['bg']}}-500 uppercase tracking-wider">{{$stat['label']}}</p>
                    <h3 class="stat-number text-3xl font-bold text-[var(--text-primary)] mt-1" data-count="{{ $stat['count'] }}">{{ $stat['count'] }}</h3>
                </div>
                <div class="neo-pressed w-11 h-11 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="{{$stat['icon']}}" class="w-5 h-5 text-{{$stat['bg']}}-500"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="neo-card p-4">
        <form method="GET" action="{{ route('guru.absensi') }}" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
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
                
                <div class="relative">
                    <select name="schedule_id" class="neo-input appearance-none pl-10 pr-8 py-2.5 text-sm cursor-pointer" onchange="this.form.submit()">
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($schedules ?? [] as $schedule)
                            <option value="{{ $schedule->id }}" {{ ($scheduleId ?? '') == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->subject->name ?? 'Mata Pelajaran' }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="book-open" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
                
                <div class="relative">
                    <input type="date" name="date" value="{{ $date ?? date('Y-m-d') }}" 
                           class="neo-input pl-10 pr-4 py-2.5 text-sm cursor-pointer" onchange="this.form.submit()">
                    <i data-lucide="calendar" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--accent)]"></i>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari siswa..." 
                           class="neo-input pl-10 pr-4 py-2.5 text-sm w-48 focus:w-64 transition-all duration-300">
                    <i data-lucide="search" class="absolute left-3.5 top-3 w-4 h-4 text-[var(--text-muted)]"></i>
                </div>
                
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
                <div class="flex gap-2">
                    <button type="button" onclick="markAllPresent()" 
                            class="neo-btn px-4 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                        ✅ Semua Hadir
                    </button>
                    <button type="button" onclick="resetAttendance()" 
                            class="neo-btn px-4 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                        🔄 Reset
                    </button>
                </div>
            </div>

            @if(empty($classId))
                <div class="text-center py-12 text-[var(--text-muted)]">
                    <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                    <p class="text-base font-medium">Belum ada kelas dipilih</p>
                </div>
            @elseif($students->isEmpty())
                <div class="text-center py-12 text-[var(--text-muted)]">
                    <i data-lucide="users" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                    <p class="text-base font-medium">Belum ada siswa</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                                <th class="text-left py-4 px-6">Siswa</th>
                                <th class="text-center py-4 px-6">Status</th>
                                <th class="text-left py-4 px-6">Keterangan</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="student-row border-b border-[var(--shadow-dark)]/5 hover:bg-[var(--bg)] transition" data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="student-avatar w-10 h-10 rounded-xl bg-[var(--accent)]/10 flex items-center justify-center font-bold text-[var(--accent)]">
                                            {{ strtoupper(substr($student->name ?? 'S', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $student->name }}</div>
                                            <div class="text-xs text-[var(--text-muted)]">NIS: {{ $student->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                 </td>
                                <td class="py-4 px-6">
                                    <div class="flex justify-center gap-2">
                                        @php $currentStatus = $student->attendance_status ?? 'hadir'; @endphp
                                        
                                        <button type="button" 
                                                class="status-btn status-hadir w-12 h-12 rounded-xl flex flex-col items-center justify-center gap-0.5 transition-all duration-200
                                                       {{ $currentStatus == 'hadir' ? 'active-status' : '' }}"
                                                data-student-id="{{ $student->id }}"
                                                data-status="hadir"
                                                data-color="#10b981">
                                            <i data-lucide="check" class="w-5 h-5"></i>
                                            <span class="text-[9px] font-medium">Hadir</span>
                                        </button>
                                        
                                        <button type="button" 
                                                class="status-btn status-izin w-12 h-12 rounded-xl flex flex-col items-center justify-center gap-0.5 transition-all duration-200
                                                       {{ $currentStatus == 'izin' ? 'active-status' : '' }}"
                                                data-student-id="{{ $student->id }}"
                                                data-status="izin"
                                                data-color="#f59e0b">
                                            <i data-lucide="file-text" class="w-5 h-5"></i>
                                            <span class="text-[9px] font-medium">Izin</span>
                                        </button>
                                        
                                        <button type="button" 
                                                class="status-btn status-sakit w-12 h-12 rounded-xl flex flex-col items-center justify-center gap-0.5 transition-all duration-200
                                                       {{ $currentStatus == 'sakit' ? 'active-status' : '' }}"
                                                data-student-id="{{ $student->id }}"
                                                data-status="sakit"
                                                data-color="#3b82f6">
                                            <i data-lucide="activity" class="w-5 h-5"></i>
                                            <span class="text-[9px] font-medium">Sakit</span>
                                        </button>
                                        
                                        <button type="button" 
                                                class="status-btn status-alpha w-12 h-12 rounded-xl flex flex-col items-center justify-center gap-0.5 transition-all duration-200
                                                       {{ $currentStatus == 'alpha' ? 'active-status' : '' }}"
                                                data-student-id="{{ $student->id }}"
                                                data-status="alpha"
                                                data-color="#ef4444">
                                            <i data-lucide="x" class="w-5 h-5"></i>
                                            <span class="text-[9px] font-medium">Alpha</span>
                                        </button>
                                        
                                        <input type="hidden" name="attendance[{{ $student->id }}]" class="attendance-input" value="{{ $currentStatus }}">
                                    </div>
                                 </td>
                                <td class="py-4 px-6">
                                    <input type="text" name="notes[{{ $student->id }}]" 
                                           value="{{ $student->attendance_notes ?? '' }}"
                                           placeholder="Keterangan"
                                           class="neo-input px-3 py-2 text-sm rounded-lg w-40">
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
    select.neo-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    /* Status Button Styles */
    .status-btn {
        background: var(--bg);
        color: var(--text-muted);
        border: 1px solid var(--shadow-dark)/10;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .status-btn:hover {
        transform: translateY(-3px);
        filter: brightness(0.95);
    }
    
    .status-btn.active-status {
        background: var(--active-color, var(--accent)) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: scale(1.05);
    }
    
    /* Ripple effect */
    .ripple {
        position: relative;
        overflow: hidden;
    }
    
    .ripple:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }
    
    .ripple:active:after {
        width: 200%;
        height: 200%;
    }
    
    /* Pulse animation untuk card statistik */
    @keyframes statPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    
    .stat-update {
        animation: statPulse 0.3s ease-out;
    }
    
    /* Shake animation untuk error */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .shake-effect {
        animation: shake 0.3s ease-out;
    }
    
    /* Confetti container */
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background: var(--color);
        position: fixed;
        top: -10px;
        animation: confettiFall 0.8s ease-out forwards;
        z-index: 9999;
        pointer-events: none;
    }
    
    @keyframes confettiFall {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }
</style>

<script>
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
        
        // Set active color for each status button
        document.querySelectorAll('.status-btn').forEach(btn => {
            const color = btn.getAttribute('data-color');
            if (color && btn.classList.contains('active-status')) {
                btn.style.setProperty('--active-color', color);
            }
        });
        
        // Auto-submit filter
        document.querySelectorAll('select[name="class_id"], select[name="schedule_id"], input[name="date"]').forEach(el => {
            el.addEventListener('change', () => el.closest('form')?.submit());
        });
    });
    
    // Update counter statistik dengan animasi
    function updateStatCounter(statId, increment) {
        const statCard = document.querySelector(`[data-stat="${statId}"]`);
        if (!statCard) return;
        
        const numberElement = statCard.querySelector('.stat-number');
        let currentCount = parseInt(numberElement.getAttribute('data-count')) || 0;
        let newCount = currentCount + increment;
        if (newCount < 0) newCount = 0;
        
        numberElement.setAttribute('data-count', newCount);
        numberElement.textContent = newCount;
        
        // Animasi pulse
        statCard.classList.add('stat-update');
        setTimeout(() => statCard.classList.remove('stat-update'), 300);
    }
    
    // Get stat ID from status
    function getStatIdFromStatus(status) {
        const map = {
            'hadir': 'stat-hadir',
            'izin': 'stat-izin',
            'sakit': 'stat-sakit',
            'alpha': 'stat-alpha'
        };
        return map[status];
    }
    
    // Create confetti effect
    function createConfetti(color, x, y) {
        for (let i = 0; i < 30; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.setProperty('--color', color);
            confetti.style.left = (x + (Math.random() - 0.5) * 50) + 'px';
            confetti.style.top = y + 'px';
            confetti.style.width = (Math.random() * 8 + 4) + 'px';
            confetti.style.height = (Math.random() * 8 + 4) + 'px';
            confetti.style.background = color;
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
            confetti.style.animationDuration = (Math.random() * 0.5 + 0.5) + 's';
            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 800);
        }
    }
    
    // Play sound effect (optional, jika ingin suara)
    function playClickSound() {
        // Menggunakan Web Audio API untuk suara 'pop'
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gain = audioContext.createGain();
            oscillator.connect(gain);
            gain.connect(audioContext.destination);
            oscillator.frequency.value = 880;
            gain.gain.value = 0.1;
            oscillator.start();
            gain.gain.exponentialRampToValueAtTime(0.00001, audioContext.currentTime + 0.3);
            oscillator.stop(audioContext.currentTime + 0.3);
            audioContext.resume();
        } catch(e) { /* silent fail */ }
    }
    
    // Handle status button click
    document.querySelectorAll('.status-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const studentId = this.getAttribute('data-student-id');
            const newStatus = this.getAttribute('data-status');
            const newColor = this.getAttribute('data-color');
            const studentName = document.querySelector(`tr[data-student-id="${studentId}"]`)?.getAttribute('data-student-name') || 'Siswa';
            
            // Get current status dari hidden input
            const hiddenInput = document.querySelector(`input[name="attendance[${studentId}]"]`);
            const oldStatus = hiddenInput ? hiddenInput.value : null;
            
            if (oldStatus === newStatus) return;
            
            // Update hidden input
            if (hiddenInput) hiddenInput.value = newStatus;
            
            // Update UI buttons
            const buttonsGroup = this.closest('td').querySelectorAll('.status-btn');
            buttonsGroup.forEach(button => {
                button.classList.remove('active-status');
                button.style.removeProperty('--active-color');
            });
            this.classList.add('active-status');
            this.style.setProperty('--active-color', newColor);
            
            // Update stat counters
            if (oldStatus) {
                updateStatCounter(getStatIdFromStatus(oldStatus), -1);
            }
            updateStatCounter(getStatIdFromStatus(newStatus), 1);
            
            // Animasi ripple pada button
            this.classList.add('ripple');
            setTimeout(() => this.classList.remove('ripple'), 300);
            
            // Animasi pada baris siswa
            const studentRow = this.closest('.student-row');
            studentRow.style.backgroundColor = newColor + '20';
            setTimeout(() => {
                studentRow.style.backgroundColor = '';
            }, 300);
            
            // Confetti effect (hanya untuk status Hadir)
            if (newStatus === 'hadir') {
                const rect = this.getBoundingClientRect();
                createConfetti(newColor, rect.left + rect.width / 2, rect.top);
            }
            
            // Animasi avatar siswa
            const avatar = studentRow.querySelector('.student-avatar');
            avatar.style.transform = 'scale(1.1)';
            setTimeout(() => {
                avatar.style.transform = '';
            }, 200);
            
            // Optional: Play sound
            // playClickSound();
            
            // Tampilkan feedback di pojok card (bukan notifikasi)
            showInlineFeedback(studentName, newStatus, newColor);
        });
    });
    
    // Inline feedback di stat card (bukan toast)
    function showInlineFeedback(studentName, status, color) {
        const statLabels = {
            'hadir': 'Hadir ✅',
            'izin': 'Izin 📋',
            'sakit': 'Sakit 🤒',
            'alpha': 'Alpha ❌'
        };
        
        const statCards = document.querySelectorAll('.neo-card');
        statCards.forEach(card => {
            // Hapus feedback lama
            const oldFeedback = card.querySelector('.inline-feedback');
            if (oldFeedback) oldFeedback.remove();
            
            // Tambah feedback baru di card yang sesuai
            if (card.querySelector(`[data-stat="stat-${status}"]`) || card.querySelector(`.text-${status === 'hadir' ? 'emerald' : status === 'izin' ? 'amber' : status === 'sakit' ? 'blue' : 'rose'}-500`)) {
                const feedback = document.createElement('div');
                feedback.className = 'inline-feedback absolute bottom-2 right-2 text-[10px] font-medium px-2 py-1 rounded-full';
                feedback.style.background = color + '20';
                feedback.style.color = color;
                feedback.style.position = 'absolute';
                feedback.style.bottom = '8px';
                feedback.style.right = '8px';
                feedback.innerHTML = `⬆ ${studentName} → ${statLabels[status]}`;
                card.style.position = 'relative';
                card.appendChild(feedback);
                
                setTimeout(() => feedback.remove(), 1500);
            }
        });
    }
    
    // Mark all students as present
    function markAllPresent() {
        document.querySelectorAll('.status-btn[data-status="hadir"]').forEach(btn => {
            if (!btn.classList.contains('active-status')) {
                btn.click();
            }
        });
    }
    
    // Reset all attendance
    function resetAttendance() {
        if (confirm('Reset semua status kehadiran?')) {
            document.querySelectorAll('.status-btn[data-status="hadir"]').forEach(btn => {
                const studentId = btn.getAttribute('data-student-id');
                const hiddenInput = document.querySelector(`input[name="attendance[${studentId}]"]`);
                if (hiddenInput && hiddenInput.value !== 'hadir') {
                    btn.click();
                }
            });
        }
    }
    
    // Save attendance
    function saveAttendance() {
        const classId = '{{ $classId ?? '' }}';
        const scheduleId = '{{ $scheduleId ?? '' }}';
        
        if (!classId) {
            showInlineError('Pilih kelas terlebih dahulu!');
            return;
        }
        
        if (!scheduleId) {
            showInlineError('Pilih jadwal terlebih dahulu!');
            return;
        }
        
        // Animasi tombol simpan
        const saveBtn = document.querySelector('button[onclick="saveAttendance()"]');
        saveBtn.style.transform = 'scale(0.95)';
        setTimeout(() => saveBtn.style.transform = '', 200);
        
        document.getElementById('attendanceForm').submit();
    }
    
    // Error feedback di stat card
    function showInlineError(message) {
        const firstCard = document.querySelector('.neo-card');
        if (firstCard) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'absolute top-2 right-2 text-rose-500 text-xs font-medium px-2 py-1 rounded-full';
            errorDiv.style.background = '#f43f5e20';
            errorDiv.style.position = 'absolute';
            errorDiv.innerHTML = `⚠️ ${message}`;
            firstCard.style.position = 'relative';
            firstCard.appendChild(errorDiv);
            setTimeout(() => errorDiv.remove(), 2000);
        }
    }
    
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.student-row').forEach(row => {
            const name = row.querySelector('.font-semibold')?.textContent.toLowerCase() || '';
            row.style.display = name.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endsection