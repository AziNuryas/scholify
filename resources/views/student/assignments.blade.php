@extends('layouts.student')

@section('title', 'Tugas - Schoolify')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6">
    <!-- Header Section dengan Statistik Premium -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                <span class="text-sm font-semibold text-[#4318FF] tracking-wide">TASK DASHBOARD</span>
            </div>
            <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Tugas & <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Deadline</span></h1>
            <p class="text-[#A3AED0] text-base">Kelola dan selesaikan semua tugas akademismu tepat waktu.</p>
        </div>
        
        <!-- Stat Cards Neumorphism Combo -->
        <div class="flex gap-4">
            <div class="neo-flat rounded-2xl px-6 py-4 text-center min-w-[110px] transition-all duration-500 hover:neo-pressed">
                <div class="relative flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full neo-flat flex items-center justify-center mb-2">
                        <div class="text-xl font-bold text-orange-500">{{ $assignments->where('status', 'pending')->count() }}</div>
                    </div>
                    <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wide">Pending</p>
                </div>
            </div>
            <div class="neo-flat rounded-2xl px-6 py-4 text-center min-w-[110px] transition-all duration-500 hover:neo-pressed">
                <div class="relative flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full neo-flat flex items-center justify-center mb-2">
                        <div class="text-xl font-bold text-green-500">{{ $assignments->where('status', 'submitted')->count() }}</div>
                    </div>
                    <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wide">Submitted</p>
                </div>
            </div>
            <div class="neo-flat rounded-2xl px-6 py-4 text-center min-w-[110px] transition-all duration-500 hover:neo-pressed">
                <div class="relative flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full neo-flat flex items-center justify-center mb-2">
                        <div class="text-xl font-bold text-purple-500">{{ $assignments->where('is_late', true)->count() }}</div>
                    </div>
                    <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wide">Late</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Filter Neumorphism -->
    <div class="flex flex-wrap gap-4 pb-0 mt-4">
        <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-xl neo-flat" data-filter="all">
            <span class="relative z-10 flex items-center gap-2 text-[var(--brand-secondary)]">
                <i class='bx bx-grid-alt text-lg text-blue-500'></i>
                <span>Semua Tugas</span>
            </span>
        </button>
        <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-xl neo-btn" data-filter="active">
            <span class="relative z-10 flex items-center gap-2 text-[var(--brand-secondary)]">
                <i class='bx bx-play-circle text-lg text-green-500'></i>
                <span>Aktif</span>
            </span>
        </button>
        <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-xl neo-btn" data-filter="completed">
            <span class="relative z-10 flex items-center gap-2 text-[var(--brand-secondary)]">
                <i class='bx bx-check-circle text-lg text-indigo-500'></i>
                <span>Selesai</span>
            </span>
        </button>
        <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-xl neo-btn" data-filter="late">
            <span class="relative z-10 flex items-center gap-2 text-[var(--brand-secondary)]">
                <i class='bx bx-alarm-exclamation text-lg text-red-500'></i>
                <span>Terlambat</span>
            </span>
        </button>
    </div>

    @if($assignments->count() > 0)
        <!-- Grid Layout Premium -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7 mt-6">
            @foreach($assignments as $assign)
            @php
                $status = $assign->status ?? 'pending';
                $isLate = $assign->is_late ?? false;
                $dueDate = $assign->due_date ? \Carbon\Carbon::parse($assign->due_date) : null;
                $isUrgent = $dueDate ? ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 2) : false;
                $submission = null;
                $progress = null;
                
                if(isset($assign->submissions) && $assign->submissions) {
                    $submission = $assign->submissions->where('student_id', auth()->id())->first();
                    $progress = $submission ? $submission->score : null;
                }
                
                $deadlineText = '-';
                if ($dueDate) {
                    $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                    if($daysLeft < 0) {
                        $deadlineText = 'Terlambat ' . abs($daysLeft) . ' hari';
                    } elseif($daysLeft == 0) {
                        $deadlineText = 'Hari terakhir';
                    } elseif($daysLeft == 1) {
                        $deadlineText = 'Besok';
                    } else {
                        $deadlineText = $daysLeft . ' hari lagi';
                    }
                }
            @endphp
            <div class="task-card group relative neo-flat rounded-2xl transition-all duration-500 overflow-hidden" data-status="{{ $status }}">
                <!-- Premium Gradient Progress Bar -->
                <div class="h-1 w-full neo-pressed">
                    <div class="h-full neo-badge-blue transition-all duration-700 ease-out" style="width: {{ $progress ? min(($progress / 100) * 100, 100) : 0 }}%"></div>
                </div>
                
                <div class="p-6">
                    <!-- Header Card Premium -->
                    <div class="flex justify-between items-start mb-5">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#4318FF] to-[#9F7AEA] rounded-xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                            <div class="relative w-12 h-12 rounded-xl bg-gradient-to-br from-[#4318FF]/10 to-[#9F7AEA]/10 text-[#4318FF] flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                                <i class='bx bx-notepad'></i>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @if($isUrgent && $status == 'pending')
                                <span class="relative px-3 py-1 text-xs font-bold rounded-full neo-badge-red text-white">
                                    <i class='bx bx-time-five mr-1'></i> Urgent
                                </span>
                            @elseif($status == 'submitted')
                                <span class="px-3 py-1 text-xs font-bold rounded-full neo-badge-green text-white">
                                    <i class='bx bx-check-circle mr-1'></i> Completed
                                </span>
                            @elseif($isLate)
                                <span class="px-3 py-1 text-xs font-bold rounded-full neo-badge-orange text-white">
                                    <i class='bx bx-alarm-exclamation mr-1'></i> Late
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Content Premium -->
                    <h3 class="font-outfit font-bold text-xl text-[#2B3674] mb-3 line-clamp-1 group-hover:text-[#4318FF] transition-colors duration-300">
                        {{ $assign->title ?? 'Tanpa Judul' }}
                    </h3>
                    
                    <div class="flex flex-wrap items-center gap-2 text-sm text-[var(--text-muted)] mb-4">
                        <div class="flex items-center gap-1.5 neo-pressed px-3 py-1.5 rounded-lg text-[var(--brand-secondary)] font-medium">
                            <i class='bx bx-book-open text-xs'></i>
                            <span>{{ $assign->subject->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 neo-pressed px-3 py-1.5 rounded-lg text-[var(--brand-secondary)] font-medium">
                            <i class='bx bx-calendar text-xs'></i>
                            <span>{{ $dueDate ? $dueDate->format('d M Y') : 'Tanpa Tenggat' }}</span>
                        </div>
                    </div>
                    
                    <p class="text-[#2B3674]/60 text-sm mb-5 line-clamp-2 leading-relaxed">
                        {{ Str::limit($assign->description ?? 'Tidak ada deskripsi untuk tugas ini.', 100) }}
                    </p>

                    <!-- Deadline & Action Premium -->
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-[#A3AED0] mb-1.5">
                                <i class='bx bx-time-five'></i>
                                <span>Deadline</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full {{ ($isUrgent && $status == 'pending') || $isLate ? 'bg-red-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                    <span class="text-sm font-bold {{ ($isUrgent && $status == 'pending') || $isLate ? 'text-red-600' : 'text-[#2B3674]' }}">
                                        {{ $dueDate ? $dueDate->format('H:i') . ' WIB' : '-' }}
                                    </span>
                                </div>
                                @if($dueDate)
                                    @if($status == 'pending' && !$isLate)
                                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $deadlineText }}</span>
                                    @elseif($isLate)
                                        <span class="text-xs font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded-full">{{ $deadlineText }}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        @if($status != 'submitted')
                            <button class="submit-btn relative overflow-hidden neo-badge-blue px-6 py-2 rounded-full text-sm font-bold transition-all duration-300 hover:scale-105 active:scale-95" data-id="{{ $assign->id }}">
                                <span class="relative z-10 flex items-center gap-2">
                                    <i class='bx bx-upload'></i> 
                                    <span>Submit</span>
                                </span>
                            </button>
                        @else
                            <div class="text-right">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="text-xs font-semibold text-gray-500">Score</div>
                                        <div class="text-2xl font-bold text-green-600 leading-tight">{{ $progress ?? '—' }}</div>
                                    </div>
                                    <button class="text-[#4318FF] text-sm font-semibold hover:underline flex items-center gap-1">
                                        Detail <i class='bx bx-right-arrow-alt'></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Info jumlah tugas premium -->
        <div class="mt-10 pt-6 text-center text-sm text-[#A3AED0] border-t border-gray-100">
            <div class="inline-flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-full">
                <i class='bx bx-info-circle'></i>
                <span>Menampilkan {{ $assignments->count() }} tugas</span>
            </div>
        </div>
    @else
        <!-- Empty State Premium -->
        <div class="relative rounded-3xl p-20 text-center bg-gradient-to-br from-white via-gray-50 to-gray-100/50 border border-gray-100 mt-8 overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-[#4318FF]/5 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-[#9F7AEA]/5 to-transparent rounded-full blur-3xl"></div>
            
            <div class="relative">
                <div class="relative w-32 h-32 mx-auto mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                    <div class="relative w-32 h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center text-5xl shadow-xl group-hover:scale-110 transition-transform duration-500">
                        <i class='bx bx-calendar-check text-white text-5xl'></i>
                    </div>
                </div>
                
                <h2 class="font-outfit font-bold text-3xl text-[#2B3674] mb-3">Tidak Ada Tugas</h2>
                <p class="text-[#A3AED0] text-lg max-w-md mx-auto mb-6">Selamat! Semua tugas telah diselesaikan. Gunakan waktumu untuk mempersiapkan materi selanjutnya.</p>
                
                <button class="inline-flex items-center gap-2 bg-white border border-gray-200 text-[#4318FF] px-6 py-3 rounded-xl font-semibold hover:shadow-md transition-all duration-300 hover:border-[#4318FF]/30">
                    <i class='bx bx-history'></i>
                    <span>Lihat Riwayat Tugas</span>
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Modal Kumpul Tugas Premium -->
<div id="submitModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-md w-full p-0 transform transition-all scale-95 opacity-0 animate-modal-in shadow-2xl overflow-hidden">
        <div class="relative bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] p-6 text-center">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="relative">
                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center text-white text-4xl mx-auto shadow-lg backdrop-blur-sm">
                    <i class='bx bx-cloud-upload'></i>
                </div>
                <h3 class="font-outfit font-bold text-2xl text-white mt-4">Submit Assignment</h3>
                <p class="text-white/80 text-sm mt-1">Pastikan tugasmu sudah benar sebelum dikirim</p>
            </div>
        </div>
        
        <form id="submitForm" class="space-y-5 p-6">
            @csrf
            <input type="hidden" id="assignment_id" name="assignment_id">
            
            <div>
                <label class="block text-sm font-bold text-[#2B3674] mb-2 flex items-center gap-2">
                    <i class='bx bx-link-alt text-indigo-500'></i>
                    Link Tugas
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-link-alt text-gray-400 group-focus-within:text-indigo-500 transition-colors'></i>
                    </div>
                    <input type="text" name="submission_link" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#4318FF] focus:ring-4 focus:ring-indigo-100 transition-all outline-none" 
                           placeholder="https://drive.google.com/...">
                </div>
                <p class="text-xs text-gray-400 mt-2 ml-1">Masukkan link Google Drive, GitHub, atau platform lainnya</p>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-[#2B3674] mb-2 flex items-center gap-2">
                    <i class='bx bx-note text-indigo-500'></i>
                    Catatan <span class="text-gray-400 text-xs font-normal">(Opsional)</span>
                </label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#4318FF] focus:ring-4 focus:ring-indigo-100 transition-all outline-none resize-none" 
                          placeholder="Tambahkan catatan untuk guru..."></textarea>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" id="closeModalBtn" class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all duration-300 hover:scale-[1.02] active:scale-95">Batal</button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-[#4318FF] to-[#5B4DFF] text-white px-4 py-3 rounded-xl font-bold shadow-md hover:shadow-xl transition-all duration-300 hover:scale-[1.02] active:scale-95">
                    <i class='bx bx-send mr-2'></i>
                    Kirim Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom Animations & Premium Styles */
    @keyframes modalIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-modal-in {
        animation: modalIn 0.2s ease-out forwards;
    }
    
    .animate-slide-up {
        animation: slideUp 0.3s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    /* Filter Button Active State */
    .filter-btn.active {
        color: #4318FF;
        background: linear-gradient(to bottom, white, #F8FAFF);
    }
    
    .filter-btn.active .absolute {
        transform: scaleX(1);
    }
    
    /* Line clamp utility */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Premium Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #4318FF, #9F7AEA);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #5B4DFF, #B794F4);
    }
    
    /* Smooth hover effects */
    .task-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .task-card:hover {
        transform: translateY(-4px);
    }
    
    /* Animation delay for cards */
    .task-card {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .task-card:nth-child(1) { animation-delay: 0.05s; }
    .task-card:nth-child(2) { animation-delay: 0.1s; }
    .task-card:nth-child(3) { animation-delay: 0.15s; }
    .task-card:nth-child(4) { animation-delay: 0.2s; }
    .task-card:nth-child(5) { animation-delay: 0.25s; }
    .task-card:nth-child(6) { animation-delay: 0.3s; }
</style>

<script>
    // Filter Tugas with Animation
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const cards = document.querySelectorAll('.task-card');
            
            cards.forEach((card, index) => {
                if(filter === 'all') {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                    card.style.animationDelay = `${index * 0.05}s`;
                } else if(filter === 'active' && card.dataset.status === 'pending') {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                    card.style.animationDelay = `${index * 0.05}s`;
                } else if(filter === 'completed' && card.dataset.status === 'submitted') {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                    card.style.animationDelay = `${index * 0.05}s`;
                } else if(filter === 'late' && card.dataset.status === 'late') {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                    card.style.animationDelay = `${index * 0.05}s`;
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Modal Handling
    const modal = document.getElementById('submitModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const submitBtns = document.querySelectorAll('.submit-btn');
    const assignmentIdInput = document.getElementById('assignment_id');
    
    function openModal(assignmentId) {
        assignmentIdInput.value = assignmentId;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        document.getElementById('submitForm').reset();
    }
    
    if(submitBtns.length > 0) {
        submitBtns.forEach(btn => {
            btn.addEventListener('click', () => openModal(btn.dataset.id));
        });
    }
    
    if(closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if(modal) {
        modal.addEventListener('click', (e) => {
            if(e.target === modal) closeModal();
        });
    }
    
    // Form Submit AJAX with Enhanced Feedback
    const submitForm = document.getElementById('submitForm');
    if(submitForm) {
        submitForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengirim...';
            
            try {
                const formData = new FormData(this);
                const response = await fetch('{{ route("student.assignments.submit") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if(data.success) {
                    showNotification('Berhasil', 'Tugas berhasil dikirimkan!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            } catch(error) {
                console.error('Error:', error);
                showNotification('Error', 'Gagal mengirim tugas.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Premium Toast Notification
    function showNotification(title, message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-2xl text-white animate-slide-up ${
            type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-rose-600'
        }`;
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <i class='bx ${type === 'success' ? 'bx-check' : 'bx-x'} text-xl'></i>
            </div>
            <div>
                <p class="font-bold text-sm">${title}</p>
                <p class="text-xs opacity-90">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white/70 hover:text-white transition-colors">
                <i class='bx bx-x text-xl'></i>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
</script>
@endsection