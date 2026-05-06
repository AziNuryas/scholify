@extends('layouts.guru')

@section('title', 'Tugas - Scholify Guru')
@section('page-title', 'Manajemen Tugas')
@section('page-subtitle', 'Buat dan kelola tugas untuk siswa')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Tugas Mandiri</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Buat dan kelola tugas untuk siswa</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl">
                <span class="text-xs font-bold text-[var(--text-muted)] flex items-center gap-2">
                    <i data-lucide="calendar" class="w-3 h-3"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-6">
        
        {{-- =========================
            FORM BUAT TUGAS - LEFT COLUMN
        ========================== --}}
        <div class="lg:col-span-5 animate-slideInLeft">
            <div class="neo-card p-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-[var(--shadow-dark)]/10">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="plus" class="w-5 h-5 text-[var(--accent)]"></i>
                    </div>
                    <div>
                        <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Buat Tugas Baru</h2>
                        <p class="text-xs text-[var(--text-muted)]">Isi form berikut untuk membuat tugas</p>
                    </div>
                </div>

                <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Judul Tugas
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Contoh: Tugas Basis Data Pertemuan 5"
                               class="neo-input w-full text-sm">
                        @error('title')
                            <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="3"
                                  placeholder="Jelaskan detail tugas, materi yang dipelajari, dan instruksi pengerjaan..."
                                  class="neo-input w-full text-sm resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                                Kelas
                            </label>
                            <select name="class_id" class="neo-input w-full text-sm" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes ?? [] as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                                Mata Pelajaran
                            </label>
                            <select name="subject_id" class="neo-input w-full text-sm" required>
                                <option value="">Pilih Mapel</option>
                                @foreach($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                                Tipe Tugas
                            </label>
                            <select name="type" class="neo-input w-full text-sm">
                                <option value="tugas" {{ old('type') == 'tugas' ? 'selected' : '' }}>📝 Tugas Harian</option>
                                <option value="ujian" {{ old('type') == 'ujian' ? 'selected' : '' }}>📖 Ujian / Ulangan</option>
                                <option value="materi" {{ old('type') == 'materi' ? 'selected' : '' }}>📚 Materi Belajar</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                                Deadline
                            </label>
                            <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                   class="neo-input w-full text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Lampiran (Opsional)
                        </label>
                        <div class="relative">
                            <input type="file" name="file" id="fileInput" class="hidden">
                            <label for="fileInput" class="neo-flat flex items-center justify-between w-full px-4 py-3 rounded-xl cursor-pointer transition-all hover:neo-pressed group">
                                <div class="flex items-center gap-2">
                                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center group-hover:neo-flat transition-all">
                                        <i data-lucide="upload" class="w-4 h-4 text-[var(--text-muted)]"></i>
                                    </div>
                                    <span class="text-sm text-[var(--text-secondary)]">Pilih file</span>
                                </div>
                                <span class="text-xs text-[var(--text-muted)]">PDF, DOC, JPG | Max 5MB</span>
                            </label>
                            <p id="fileName" class="text-xs text-[var(--accent)] mt-2 hidden"></p>
                        </div>
                    </div>

                    <button class="neo-btn w-full py-3 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-all">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Tugas
                    </button>
                </form>
            </div>
        </div>

        {{-- =========================
            LIST TUGAS - RIGHT COLUMN
        ========================== --}}
        <div class="lg:col-span-7 animate-slideInRight">
            <div class="neo-card p-6">
                <div class="flex flex-wrap justify-between items-center gap-4 mb-5 pb-3 border-b border-[var(--shadow-dark)]/10">
                    <div class="flex items-center gap-3">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="list-todo" class="w-5 h-5 text-[var(--accent)]"></i>
                        </div>
                        <div>
                            <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Daftar Tugas</h2>
                            <p class="text-xs text-[var(--text-muted)]">Semua tugas yang telah dibuat</p>
                        </div>
                    </div>
                    <div class="neo-pressed px-3 py-1.5 rounded-full">
                        <span class="text-xs font-semibold text-[var(--text-primary)]">{{ $assignments->count() ?? 0 }}</span>
                        <span class="text-xs text-[var(--text-muted)]"> Total Tugas</span>
                    </div>
                </div>
                
                <!-- Filter Buttons - Soft design -->
                <div class="flex gap-2 mb-5 flex-wrap">
                    <button onclick="filterTasks('all')" id="filterAll" class="filter-btn neo-flat px-4 py-2 rounded-xl text-xs font-semibold transition-all active">
                        <i data-lucide="grid" class="w-3.5 h-3.5 inline mr-1"></i>
                        Semua
                    </button>
                    <button onclick="filterTasks('active')" id="filterActive" class="filter-btn neo-flat px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                        <i data-lucide="clock" class="w-3.5 h-3.5 inline mr-1"></i>
                        Aktif
                    </button>
                    <button onclick="filterTasks('completed')" id="filterCompleted" class="filter-btn neo-flat px-4 py-2 rounded-xl text-xs font-semibold transition-all">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 inline mr-1"></i>
                        Selesai
                    </button>
                </div>

                <!-- Tasks List -->
                <div class="space-y-3 max-h-[520px] overflow-y-auto custom-scroll pr-1" id="tasksList">
                    @forelse($assignments ?? [] as $task)
                        <div class="task-card neo-flat p-4 transition-all duration-300 hover:neo-pressed {{ $task->is_completed ? 'completed' : '' }}" 
                             data-status="{{ $task->is_completed ? 'completed' : 'active' }}">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <!-- Badges - softer colors -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @php
                                            $typeStyles = [
                                                'tugas' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'file-text'],
                                                'ujian' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'book'],
                                                'materi' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'book-open'],
                                            ];
                                            $style = $typeStyles[$task->type] ?? $typeStyles['tugas'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium {{ $style['bg'] }} {{ $style['text'] }}">
                                            <i data-lucide="{{ $style['icon'] }}" class="w-3 h-3"></i>
                                            {{ ucfirst($task->type) }}
                                        </span>
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs text-[var(--text-secondary)] bg-[var(--bg)]">
                                            <i data-lucide="users" class="w-3 h-3"></i>
                                            {{ $task->class->name ?? '-' }}
                                        </span>
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs text-[var(--text-secondary)] bg-[var(--bg)]">
                                            <i data-lucide="book-open" class="w-3 h-3"></i>
                                            {{ $task->subject->name ?? '-' }}
                                        </span>
                                        
                                        @if($task->due_date)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs text-[var(--text-secondary)] bg-[var(--bg)]">
                                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                                {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                            </span>
                                        @endif
                                        
                                        @if($task->is_completed)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium text-emerald-600 bg-emerald-50/50">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium text-amber-600 bg-amber-50/50">
                                                <i data-lucide="clock" class="w-3 h-3"></i>
                                                Aktif
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="font-semibold text-[var(--text-primary)] text-base mb-2">
                                        {{ $task->title }}
                                    </h3>
                                    
                                    @if($task->description)
                                        <p class="text-sm text-[var(--text-secondary)] mb-3 line-clamp-2">{{ $task->description }}</p>
                                    @endif

                                    @if($task->file)
                                        <a href="{{ asset('storage/'.$task->file) }}" 
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 text-[var(--text-muted)] hover:text-[var(--accent)] text-xs font-medium neo-pressed px-3 py-1.5 rounded-lg transition-all">
                                            <i data-lucide="paperclip" class="w-3 h-3"></i>
                                            Lihat Lampiran
                                        </a>
                                    @endif
                                </div>

                                <!-- Action Buttons - softer -->
                                <div class="flex gap-2">
                                    <form action="{{ route('guru.tugas.update', $task->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="toggle_complete" value="1">
                                        <button type="submit" 
                                                class="btn-action neo-btn w-8 h-8 rounded-lg flex items-center justify-center transition-all
                                                {{ $task->is_completed ? 'text-rose-400 hover:text-rose-500' : 'text-emerald-500 hover:text-emerald-600' }}">
                                            @if($task->is_completed)
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            @else
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            @endif
                                        </button>
                                    </form>

                                    <form action="{{ route('guru.tugas.destroy', $task->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action neo-btn w-8 h-8 rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-rose-400 transition-all">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="neo-flat p-12 text-center">
                            <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="inbox" class="w-10 h-10 text-[var(--text-muted)]"></i>
                            </div>
                            <p class="text-[var(--text-primary)] font-semibold text-base">Belum ada tugas</p>
                            <p class="text-sm text-[var(--text-muted)] mt-1">Buat tugas pertama Anda melalui form di samping</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional styles for softer neumorphism */
    .task-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .task-card.completed h3 {
        text-decoration: line-through;
        opacity: 0.5;
    }
    
    .task-card.completed .neo-pressed {
        opacity: 0.7;
    }
    
    /* Filter button styles - soft */
    .filter-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--text-secondary);
    }
    
    .filter-btn.active {
        background: var(--accent) !important;
        color: white !important;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                    inset -2px -2px 5px rgba(255, 255, 255, 0.1);
    }
    
    .filter-btn.active i {
        color: white !important;
    }
    
    .filter-btn:not(.active):hover {
        transform: translateY(-1px);
        box-shadow: 6px 6px 12px rgba(var(--shadow-dark), 0.5),
                    -6px -6px 12px rgba(var(--shadow-light), 0.9);
    }
    
    .btn-action {
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
    
    /* Animations */
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.4s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.4s ease-out forwards;
    }
    
    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(var(--shadow-dark), 0.08);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(var(--shadow-dark), 0.2);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(var(--accent-color), 0.3);
    }
    
    /* Form select arrow - subtle */
    select.neo-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    /* Input placeholder */
    .neo-input::placeholder {
        color: var(--text-muted);
        font-weight: 400;
    }
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // File name preview
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                fileName.textContent = '📎 ' + this.files[0].name;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        });
    }
    
    // Filter tasks function
    function filterTasks(status) {
        const tasks = document.querySelectorAll('.task-card');
        const filterAll = document.getElementById('filterAll');
        const filterActive = document.getElementById('filterActive');
        const filterCompleted = document.getElementById('filterCompleted');
        
        [filterAll, filterActive, filterCompleted].forEach(btn => {
            if(btn) {
                btn.classList.remove('active');
            }
        });
        
        let activeBtn;
        if(status === 'all') activeBtn = filterAll;
        else if(status === 'active') activeBtn = filterActive;
        else activeBtn = filterCompleted;
        
        if(activeBtn) {
            activeBtn.classList.add('active');
        }
        
        tasks.forEach(task => {
            if(status === 'all') {
                task.style.display = 'block';
            } else {
                task.style.display = task.dataset.status === status ? 'block' : 'none';
            }
        });
    }
    
    // Re-initialize Lucide icons after any DOM updates
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection