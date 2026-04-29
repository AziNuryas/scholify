@extends('layouts.guru')

@section('page_title', 'Tugas Mandiri')
@section('page_subtitle', 'Buat dan kelola tugas untuk siswa')

@section('content')
<style>
    /* Font & Base */
    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.4s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.4s ease-out forwards;
    }
    
    /* Card hover */
    .task-card {
        transition: all 0.25s ease;
    }
    
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        background: #fafbff;
    }
    
    /* Task completed style */
    .task-card.completed {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.04) 0%, rgba(16, 185, 129, 0.01) 100%);
        border-left: 3px solid #10B981;
    }
    
    .task-card.completed h3 {
        text-decoration: line-through;
        opacity: 0.6;
    }
    
    /* Form input focus */
    .form-input {
        transition: all 0.2s ease;
    }
    
    .form-input:focus {
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.08);
        border-color: #A78BFA;
        background: white;
    }
    
    /* File input */
    .file-input-label:hover {
        background: #F5F3FF;
        border-color: #C4B5FD;
        transform: translateY(-1px);
    }
    
    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #DDD6FE;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #A78BFA;
    }
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Filter button */
    .filter-btn {
        transition: all 0.2s ease;
        font-size: 0.8125rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    .filter-btn.active {
        background: #8B5CF6;
        color: white;
        border-color: transparent;
        box-shadow: 0 1px 2px rgba(139, 92, 246, 0.2);
    }
    
    /* Badge styles */
    .badge {
        font-size: 0.6875rem;
        font-weight: 500;
        padding: 0.25rem 0.625rem;
        border-radius: 0.5rem;
        letter-spacing: -0.01em;
    }
    
    /* Select custom arrow */
    select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B5CF6' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    
    /* Button action */
    .btn-action {
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
</style>

<div class="p-5 max-w-7xl mx-auto">
    <div class="grid lg:grid-cols-12 gap-6">
        
        {{-- =========================
            FORM BUAT TUGAS - LEFT COLUMN
        ========================== --}}
        <div class="lg:col-span-5 animate-slideInLeft">
            <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-5 py-4 border-b border-purple-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-purple-800 text-base">Buat Tugas Baru</h2>
                            <p class="text-xs text-purple-400 mt-0.5">Isi form berikut untuk membuat tugas</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Tugas</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Contoh: Tugas Basis Data Pertemuan 5"
                               class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all">
                        @error('title')
                            <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  placeholder="Jelaskan detail tugas, materi yang dipelajari, dan instruksi pengerjaan..."
                                  class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kelas</label>
                            <select name="class_id" class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Mata Pelajaran</label>
                            <select name="subject_id" class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all" required>
                                <option value="">Pilih Mapel</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tipe</label>
                            <select name="type" class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all">
                                <option value="tugas" {{ old('type') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                                <option value="ujian" {{ old('type') == 'ujian' ? 'selected' : '' }}>Ujian</option>
                                <option value="materi" {{ old('type') == 'materi' ? 'selected' : '' }}>Materi</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deadline</label>
                            <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                   class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Lampiran</label>
                        <div class="relative">
                            <input type="file" name="file" id="fileInput" class="hidden">
                            <label for="fileInput" class="file-input-label flex items-center justify-between w-full px-3 py-2 bg-purple-50/50 border-2 border-dashed border-purple-200 rounded-lg cursor-pointer transition-all hover:bg-purple-100/50">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="text-xs text-purple-600 font-medium">Klik untuk upload file</span>
                                </div>
                                <span class="text-[10px] text-slate-400">PDF, DOC, JPG | Max 5MB</span>
                            </label>
                            <p id="fileName" class="text-xs text-purple-500 mt-1.5 hidden"></p>
                        </div>
                        @error('file')
                            <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2.5 rounded-lg font-semibold text-sm transition-all shadow-sm">
                        Simpan Tugas
                    </button>
                </form>
            </div>
        </div>

        {{-- =========================
            LIST TUGAS - RIGHT COLUMN
        ========================== --}}
        <div class="lg:col-span-7 animate-slideInRight">
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4 border-b border-emerald-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-emerald-800 text-base">Daftar Tugas</h2>
                                <p class="text-xs text-emerald-400 mt-0.5">Semua tugas yang telah dibuat</p>
                            </div>
                        </div>
                        <div class="bg-emerald-100 rounded-full px-2.5 py-1">
                            <span class="text-xs font-semibold text-emerald-600">{{ $assignments->count() }}</span>
                            <span class="text-xs text-emerald-500"> Tugas</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-1.5 mt-3">
                        <button onclick="filterTasks('all')" id="filterAll" class="filter-btn active px-3 py-1.5 rounded-lg text-xs font-medium bg-purple-500 text-white shadow-sm">
                            Semua
                        </button>
                        <button onclick="filterTasks('active')" id="filterActive" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200">
                            Aktif
                        </button>
                        <button onclick="filterTasks('completed')" id="filterCompleted" class="filter-btn px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-600 hover:bg-slate-200">
                            Selesai
                        </button>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 max-h-[520px] overflow-y-auto custom-scroll" id="tasksList">
                    @forelse($assignments as $task)
                        <div class="task-card p-4 hover:bg-slate-50/50 transition-all {{ $task->is_completed ? 'completed' : '' }}" 
                             data-status="{{ $task->is_completed ? 'completed' : 'active' }}">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-1.5 mb-2">
                                        <span class="badge 
                                            @if($task->type == 'tugas') bg-sky-100 text-sky-700
                                            @elseif($task->type == 'ujian') bg-rose-100 text-rose-600
                                            @else bg-purple-100 text-purple-600 @endif">
                                            {{ ucfirst($task->type) }}
                                        </span>
                                        
                                        <span class="badge bg-emerald-100 text-emerald-700">
                                            {{ $task->class->name ?? '-' }}
                                        </span>
                                        
                                        <span class="badge bg-indigo-100 text-indigo-600">
                                            {{ $task->subject->name ?? '-' }}
                                        </span>
                                        
                                        @if($task->due_date)
                                            <span class="badge bg-amber-100 text-amber-700">
                                                Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y H:i') }}
                                            </span>
                                        @endif
                                        
                                        @if($task->is_completed)
                                            <span class="badge bg-emerald-100 text-emerald-700">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-amber-100 text-amber-700">
                                                Belum Selesai
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="font-semibold text-slate-700 text-sm mb-1.5">
                                        {{ $task->title }}
                                    </h3>
                                    
                                    @if($task->description)
                                        <p class="text-xs text-slate-500 mb-2 line-clamp-2">{{ $task->description }}</p>
                                    @endif

                                    @if($task->file)
                                        <a href="{{ asset('storage/'.$task->file) }}" 
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 text-purple-500 hover:text-purple-600 text-xs font-medium bg-purple-50 hover:bg-purple-100 px-2.5 py-1 rounded-md transition-all">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                            </svg>
                                            Lampiran
                                        </a>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-1.5">
                                    <form action="{{ route('guru.tugas.update', $task->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="toggle_complete" value="1">
                                        <button type="submit" 
                                                class="btn-action w-7 h-7 rounded-md flex items-center justify-center transition-all 
                                                {{ $task->is_completed ? 'bg-rose-50 hover:bg-rose-100 text-rose-500' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-500' }}"
                                                title="{{ $task->is_completed ? 'Tandai belum selesai' : 'Tandai selesai' }}">
                                            @if($task->is_completed)
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @else
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    <form action="{{ route('guru.tugas.destroy', $task->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action w-7 h-7 rounded-md flex items-center justify-center text-slate-400 hover:text-rose-500 bg-slate-100 hover:bg-rose-50 transition-all"
                                                title="Hapus tugas">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium text-sm">Belum ada tugas</p>
                            <p class="text-xs text-slate-400 mt-1">Buat tugas pertama Anda melalui form di samping</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // File name preview
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                fileName.textContent = this.files[0].name;
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
                btn.classList.remove('active', 'bg-purple-500', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-600');
            }
        });
        
        let activeBtn;
        if(status === 'all') activeBtn = filterAll;
        else if(status === 'active') activeBtn = filterActive;
        else activeBtn = filterCompleted;
        
        if(activeBtn) {
            activeBtn.classList.remove('bg-slate-100', 'text-slate-600');
            activeBtn.classList.add('active', 'bg-purple-500', 'text-white');
        }
        
        tasks.forEach(task => {
            if(status === 'all') {
                task.style.display = 'flex';
            } else {
                task.style.display = task.dataset.status === status ? 'flex' : 'none';
            }
        });
    }
</script>
@endsection