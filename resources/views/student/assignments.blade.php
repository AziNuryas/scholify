@extends('layouts.student')
@section('title', 'Tugas - Schoolify')
@section('page-title', 'Tugas & Ulangan')

@section('content')
<div class="space-y-6 animate-fadeInUp">

    <div>
        <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Daftar Tugas & Ulangan</h1>
        <p class="text-sm text-[var(--text-secondary)]">Kelola dan selesaikan semua tugas akademismu tepat waktu.</p>
    </div>

    <!-- Tabs Filter Neumorphism -->
    <div class="flex flex-wrap gap-3">
        <button class="filter-btn group px-5 py-2.5 text-xs font-bold transition-all rounded-xl neo-flat" data-filter="all">
            <span class="flex items-center gap-2 text-indigo-500">
                <i data-lucide="grid" class="w-4 h-4"></i>
                <span>Semua Tugas</span>
            </span>
        </button>
        <button class="filter-btn group px-5 py-2.5 text-xs font-bold transition-all rounded-xl neo-btn text-[var(--text-secondary)] hover:text-indigo-500" data-filter="active">
            <span class="flex items-center gap-2">
                <i data-lucide="play-circle" class="w-4 h-4"></i>
                <span>Aktif</span>
            </span>
        </button>
        <button class="filter-btn group px-5 py-2.5 text-xs font-bold transition-all rounded-xl neo-btn text-[var(--text-secondary)] hover:text-emerald-500" data-filter="completed">
            <span class="flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                <span>Selesai</span>
            </span>
        </button>
        <button class="filter-btn group px-5 py-2.5 text-xs font-bold transition-all rounded-xl neo-btn text-[var(--text-secondary)] hover:text-red-500" data-filter="late">
            <span class="flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>Terlambat</span>
            </span>
        </button>
    </div>

    @if($assignments->count() > 0)
        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
            <div class="task-card group relative neo-flat rounded-2xl transition-all duration-300 overflow-hidden hover:-translate-y-1" data-status="{{ $status }}">
                <!-- Progress Bar -->
                <div class="h-1 w-full neo-pressed">
                    <div class="h-full bg-indigo-500 transition-all duration-700 ease-out" style="width: {{ $progress ? min(($progress / 100) * 100, 100) : 0 }}%"></div>
                </div>
                
                <div class="p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-2">
                            @if($isUrgent && $status == 'pending')
                                <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md bg-red-500/10 text-red-600">Urgent</span>
                            @elseif($status == 'submitted')
                                <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md bg-emerald-500/10 text-emerald-600">Selesai</span>
                            @elseif($isLate)
                                <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md bg-orange-500/10 text-orange-600">Terlambat</span>
                            @else
                                <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md bg-blue-500/10 text-blue-600">Aktif</span>
                            @endif
                        </div>
                    </div>

                    <h3 class="font-outfit font-extrabold text-base text-[var(--text-primary)] mb-2 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors">
                        {{ $assign->title ?? 'Tanpa Judul' }}
                    </h3>
                    
                    <div class="space-y-1 mb-4">
                        <div class="flex items-center gap-2 text-xs font-semibold text-[var(--text-secondary)]">
                            <i data-lucide="book-open" class="w-3.5 h-3.5 text-[var(--text-muted)]"></i>
                            <span>{{ $assign->subject->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-[var(--text-secondary)]">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-[var(--text-muted)]"></i>
                            <span>{{ $dueDate ? $dueDate->format('d M Y') : 'Tanpa Tenggat' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-[var(--shadow-dark)]/5">
                        <div class="flex flex-col">
                            <div class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-0.5">Deadline</div>
                            <span class="text-xs font-bold {{ ($isUrgent && $status == 'pending') || $isLate ? 'text-red-500' : 'text-[var(--text-primary)]' }}">
                                {{ $dueDate ? $dueDate->format('H:i') . ' WIB' : '-' }}
                            </span>
                        </div>
                        
                        @if($status != 'submitted')
                            <button class="submit-btn bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center gap-1.5" data-id="{{ $assign->id }}">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i> Submit
                            </button>
                        @else
                            <div class="text-right">
                                <div class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-0.5">Nilai</div>
                                <div class="text-xl font-extrabold text-emerald-500 leading-none">{{ $progress ?? '—' }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    @else
        <!-- Empty State -->
        <div class="neo-flat rounded-2xl p-12 text-center">
            <div class="w-16 h-16 neo-pressed rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500">
                <i data-lucide="check-square" class="w-8 h-8"></i>
            </div>
            <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)] mb-1">Tidak Ada Tugas Aktif</h2>
            <p class="text-sm text-[var(--text-secondary)] max-w-sm mx-auto">Semua tugas telah diselesaikan. Gunakan waktumu untuk mempersiapkan materi selanjutnya.</p>
        </div>
    @endif
</div>

<!-- Modal Kumpul Tugas -->
<div id="submitModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
    <div class="neo-flat rounded-2xl max-w-sm w-full overflow-hidden transform transition-all shadow-xl border border-white/20">
        <div class="p-5 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center bg-[var(--bg)]">
            <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Kumpulkan Tugas</h3>
            <button type="button" id="closeModalBtn" class="w-8 h-8 rounded-lg neo-btn flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        
        <form id="submitForm" class="p-5 space-y-4 bg-[var(--bg)]">
            @csrf
            <input type="hidden" id="assignment_id" name="assignment_id">
            
            <div>
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                    Link Tugas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="submission_link" class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]" placeholder="https://drive.google.com/..." required>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                    Catatan <span class="text-[9px] text-[var(--text-muted)]">(Opsional)</span>
                </label>
                <textarea name="notes" rows="3" class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)] resize-none" placeholder="Tambahkan catatan..."></textarea>
            </div>
            
            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i> Kirim Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('neo-flat');
                b.classList.add('neo-btn');
                b.querySelector('span').classList.remove('text-indigo-500');
                b.querySelector('span').classList.add('text-[var(--text-secondary)]');
            });
            
            this.classList.remove('neo-btn');
            this.classList.add('neo-flat');
            this.querySelector('span').classList.remove('text-[var(--text-secondary)]');
            this.querySelector('span').classList.add('text-indigo-500');
            
            const filter = this.dataset.filter;
            const cards = document.querySelectorAll('.task-card');
            
            cards.forEach(card => {
                if(filter === 'all' || 
                  (filter === 'active' && card.dataset.status === 'pending') ||
                  (filter === 'completed' && card.dataset.status === 'submitted') ||
                  (filter === 'late' && card.dataset.status === 'late')) {
                    card.style.display = 'block';
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
    }
    
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('submitForm').reset();
    }
    
    if(submitBtns.length > 0) {
        submitBtns.forEach(btn => btn.addEventListener('click', () => openModal(btn.dataset.id)));
    }
    if(closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if(modal) modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
    
    const submitForm = document.getElementById('submitForm');
    if(submitForm) {
        submitForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Mengirim...';
            
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
                    alert('✓ Tugas berhasil dikirimkan!');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert('✗ ' + (data.message || 'Terjadi kesalahan.'));
                }
            } catch(error) {
                console.error('Error:', error);
                alert('✗ Gagal mengirim tugas.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
</script>
@endsection