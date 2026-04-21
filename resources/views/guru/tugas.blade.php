@extends('layouts.guru')

@section('page_title', 'Tugas Mandiri')
@section('page_subtitle', 'Buat dan kelola tugas untuk siswa')

@section('content')
<style>
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.05); opacity: 0.5; }
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.5s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    /* Card hover effect premium */
    .task-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .task-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
    }
    
    /* Form input focus effect */
    .form-input:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    
    /* Custom file input premium */
    .file-input-label {
        transition: all 0.3s ease;
    }
    
    .file-input-label:hover {
        background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        border-color: #4F46E5;
        transform: translateY(-2px);
    }
    
    /* Scrollbar premium */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #6366F1, #8B5CF6);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
    }
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Glass morphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    /* Gradient border animation */
    @keyframes borderGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .animated-border {
        background: linear-gradient(90deg, #6366F1, #8B5CF6, #EC4899, #6366F1);
        background-size: 300% 100%;
        animation: borderGradient 3s ease infinite;
    }
    
    /* Select custom styling */
    select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236366F1'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.25rem;
    }
</style>

<div class="p-6 max-w-7xl mx-auto">
    <div class="grid lg:grid-cols-12 gap-8">
        
        {{-- =========================
            FORM BUAT TUGAS - LEFT COLUMN
        ========================== --}}
        <div class="lg:col-span-5 animate-slideInLeft">
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                <!-- Animated Border Effect -->
                <div class="absolute inset-0 animated-border opacity-20"></div>
                
                <div class="relative glass-card rounded-3xl overflow-hidden">
                    <!-- Header Premium -->
                    <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 px-7 py-6 overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                        <div class="relative flex items-center gap-4">
                            <div class="relative">
                                <div class="absolute inset-0 bg-white/20 rounded-2xl blur-md"></div>
                                <div class="relative w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-white font-bold text-2xl tracking-tight">Buat Tugas Baru</h2>
                                <p class="text-white/80 text-sm mt-1">Isi form berikut untuk membuat tugas</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data" class="p-7 space-y-6">
                        @csrf

                        <!-- Judul Tugas -->
                        <div class="group">
                            <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Judul Tugas
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   placeholder="Contoh: Tugas Basis Data Pertemuan 5"
                                   class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300">
                        </div>

                        <!-- Deskripsi -->
                        <div class="group">
                            <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                Deskripsi
                            </label>
                            <textarea name="description" rows="4"
                                      placeholder="Jelaskan detail tugas, materi yang dipelajari, dan instruksi pengerjaan..."
                                      class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300 resize-none">{{ old('description') }}</textarea>
                        </div>

                        <!-- Kelas & Mapel -->
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Kelas
                                </label>
                                <select name="class_id" class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Mata Pelajaran
                                </label>
                                <select name="subject_id" class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300" required>
                                    <option value="">Pilih Mapel</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Tipe & Deadline -->
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                    Tipe
                                </label>
                                <select name="type" class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300">
                                    <option value="tugas" {{ old('type') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                                    <option value="ujian" {{ old('type') == 'ujian' ? 'selected' : '' }}>Ujian</option>
                                    <option value="materi" {{ old('type') == 'materi' ? 'selected' : '' }}>Materi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Deadline
                                </label>
                                <input type="datetime-local" name="due_date" value="{{ old('due_date') }}"
                                       class="form-input w-full px-5 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition-all duration-300">
                            </div>
                        </div>

                        <!-- File Upload Premium -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                </svg>
                                Lampiran
                            </label>
                            <div class="relative">
                                <input type="file" name="file" id="fileInput" class="hidden">
                                <label for="fileInput" class="file-input-label flex items-center justify-center w-full px-6 py-5 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer transition-all duration-300">
                                    <div class="text-center">
                                        <div class="w-16 h-16 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-600">Klik untuk upload file</p>
                                        <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, JPG, PNG (Max 5MB)</p>
                                        <p id="fileName" class="text-xs font-semibold text-indigo-600 mt-3 hidden"></p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button Premium -->
                        <button class="group relative w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 text-white py-3.5 rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <span class="relative flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Simpan Tugas
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- =========================
            LIST TUGAS - RIGHT COLUMN
        ========================== --}}
        <div class="lg:col-span-7 animate-slideInRight">
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                <div class="relative glass-card rounded-3xl overflow-hidden">
                    <!-- Header Premium -->
                    <div class="relative bg-gradient-to-r from-slate-100 via-indigo-50 to-slate-100 px-7 py-6 border-b">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl blur-lg opacity-30"></div>
                                    <div class="relative w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="font-bold text-slate-800 text-2xl tracking-tight">Daftar Tugas</h2>
                                    <p class="text-sm text-slate-500 mt-1">Semua tugas yang telah dibuat</p>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-md"></div>
                                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full px-4 py-2 shadow-lg">
                                    <span class="text-sm font-bold text-white">{{ $assignments->count() }}</span>
                                    <span class="text-sm text-white/80"> Tugas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-[680px] overflow-y-auto custom-scroll">
                        @forelse($assignments as $task)
                            <div class="task-card p-6 hover:bg-gradient-to-r hover:from-indigo-50/30 hover:to-transparent transition-all duration-300">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <!-- Badges Premium -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm 
                                                @if($task->type == 'tugas') bg-blue-500 text-white
                                                @elseif($task->type == 'ujian') bg-red-500 text-white
                                                @else bg-purple-500 text-white @endif">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($task->type == 'tugas')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    @elseif($task->type == 'ujian')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    @endif
                                                </svg>
                                                {{ ucfirst($task->type) }}
                                            </span>
                                            
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $task->class->name ?? '-' }}
                                            </span>
                                            
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700 shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                {{ $task->subject->name ?? '-' }}
                                            </span>
                                            
                                            @if($task->due_date)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Deadline: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y H:i') }}
                                            </span>
                                            @endif
                                        </div>

                                        <h3 class="font-bold text-slate-800 text-xl mb-2 group-hover:text-indigo-600 transition-colors">
                                            {{ $task->title }}
                                        </h3>
                                        
                                        @if($task->description)
                                            <p class="text-sm text-slate-600 mb-4 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                                        @endif

                                        @if($task->file)
                                            <a href="{{ asset('storage/'.$task->file) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm font-semibold bg-indigo-50 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-all duration-300 shadow-sm hover:shadow">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                                </svg>
                                                Download Lampiran
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Delete Button Premium -->
                                    <form action="{{ route('guru.tugas.destroy', $task->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tugas ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="opacity-0 group-hover:opacity-100 transition-all duration-300 text-slate-400 hover:text-red-600 p-3 rounded-xl hover:bg-red-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-16 text-center">
                                <div class="relative w-28 h-28 mx-auto mb-6">
                                    <div class="absolute inset-0 bg-gradient-to-br from-slate-400 to-slate-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
                                    <div class="relative w-28 h-28 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-slate-600 font-bold text-lg">Belum ada tugas</p>
                                <p class="text-sm text-slate-400 mt-2">Buat tugas pertama Anda melalui form di samping</p>
                            </div>
                        @endforelse
                    </div>
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
</script>
@endsection