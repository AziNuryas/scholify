@extends('layouts.guru')

@section('page_title', 'Pengumuman')
@section('page_subtitle', 'Buat dan kelola pengumuman untuk siswa')

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
    .announcement-card {
        transition: all 0.25s ease;
    }
    
    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        background: #fafbff;
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
    
    /* Badge styles - Soft pastel colors */
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
    
    /* Radio card style */
    .radio-card {
        transition: all 0.2s ease;
    }
    .radio-card.selected {
        border-color: #8B5CF6;
        background: #F5F3FF;
    }
</style>

<div class="p-5 max-w-7xl mx-auto">
    <div class="grid lg:grid-cols-12 gap-6">
        
        {{-- =========================
            FORM BUAT PENGUMUMAN - LEFT COLUMN
        ========================== --}}
        <div class="lg:col-span-5 animate-slideInLeft">
            <div class="bg-white rounded-xl shadow-sm border border-purple-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-5 py-4 border-b border-purple-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-purple-800 text-base">Buat Pengumuman Baru</h2>
                            <p class="text-xs text-purple-400 mt-0.5">Isi form berikut untuk membuat pengumuman</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('guru.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                    @csrf

                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="bg-rose-50 border-l-4 border-rose-500 rounded-lg p-3">
                            <div class="flex items-center gap-2 text-rose-700 text-xs mb-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">Perlu diperhatikan!</span>
                            </div>
                            <ul class="text-xs text-rose-600 space-y-1 ml-6">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-3">
                            <div class="flex items-center gap-2 text-emerald-700 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Judul Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Pengumuman</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Contoh: Ujian Akhir Semester"
                               class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all"
                               required>
                    </div>

                    <!-- Isi Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Isi Pengumuman</label>
                        <textarea name="content" rows="4"
                                  placeholder="Tulis detail pengumuman di sini..."
                                  class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all resize-none"
                                  required>{{ old('content') }}</textarea>
                    </div>

                    <!-- Target Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Target Pengumuman</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="radio-card relative cursor-pointer">
                                <input type="radio" name="target" value="all"
                                       {{ old('target', 'all') == 'all' ? 'checked' : '' }}
                                       class="peer sr-only" onchange="toggleClassSelect()">
                                <div class="p-2.5 rounded-lg border-2 border-slate-200 text-center peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 peer-checked:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-slate-700 peer-checked:text-purple-700">Semua Kelas</span>
                                    </div>
                                </div>
                            </label>

                            <label class="radio-card relative cursor-pointer">
                                <input type="radio" name="target" value="single_class"
                                       {{ old('target') == 'single_class' ? 'checked' : '' }}
                                       class="peer sr-only" onchange="toggleClassSelect()">
                                <div class="p-2.5 rounded-lg border-2 border-slate-200 text-center peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500 peer-checked:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-slate-700 peer-checked:text-purple-700">Kelas Tertentu</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Pilih Kelas (hidden by default) -->
                    <div id="classSelect" class="transition-all duration-300 {{ old('target') == 'single_class' ? '' : 'hidden' }}">
                        <select name="class_id" class="form-input w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:bg-white transition-all">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Upload File -->
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
                                <span class="text-[10px] text-slate-400">PDF, DOC, JPG, PNG | Max 5MB</span>
                            </label>
                            <p id="fileName" class="text-xs text-purple-500 mt-1.5 hidden"></p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2.5 rounded-lg font-semibold text-sm transition-all shadow-sm">
                        Kirim Pengumuman
                    </button>
                </form>
            </div>
        </div>

        {{-- =========================
            LIST PENGUMUMAN - RIGHT COLUMN
        ========================== --}}
        <div class="lg:col-span-7 animate-slideInRight">
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4 border-b border-emerald-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-semibold text-emerald-800 text-base">Daftar Pengumuman</h2>
                                <p class="text-xs text-emerald-400 mt-0.5">Semua pengumuman yang telah dibuat</p>
                            </div>
                        </div>
                        <div class="bg-emerald-100 rounded-full px-2.5 py-1">
                            <span class="text-xs font-semibold text-emerald-600">{{ $announcements->count() }}</span>
                            <span class="text-xs text-emerald-500"> Pengumuman</span>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 max-h-[520px] overflow-y-auto custom-scroll" id="announcementsList">
                    @forelse($announcements as $item)
                        <div class="announcement-card p-4 hover:bg-slate-50/50 transition-all cursor-pointer"
                             onclick="openModal({{ json_encode([
                                 'id' => $item->id,
                                 'title' => $item->title,
                                 'content' => $item->content,
                                 'target' => $item->target,
                                 'class_name' => optional($item->class)->name,
                                 'created_at' => $item->created_at->isoFormat('d MMM Y H:i'),
                                 'created_at_human' => $item->created_at->diffForHumans(),
                                 'file' => $item->file
                             ]) }})">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <!-- Badges - Soft pastel colors -->
                                    <div class="flex flex-wrap gap-1.5 mb-2">
                                        @if($item->target == 'all')
                                            <span class="badge bg-emerald-100 text-emerald-700">
                                                <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                Semua Kelas
                                            </span>
                                        @else
                                            <span class="badge bg-blue-100 text-blue-700">
                                                <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                {{ optional($item->class)->name ?? 'Kelas Tertentu' }}
                                            </span>
                                        @endif
                                        
                                        <span class="badge bg-slate-100 text-slate-600">
                                            <svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h3 class="font-semibold text-slate-700 text-sm mb-1.5 group-hover:text-purple-600 transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                    
                                    <p class="text-xs text-slate-500 mb-2 line-clamp-2">
                                        {{ $item->content }}
                                    </p>

                                    @if($item->file)
                                        <span class="inline-flex items-center gap-1.5 text-purple-500 text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                            </svg>
                                            Ada lampiran
                                        </span>
                                    @endif
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('guru.pengumuman.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus pengumuman ini?')"
                                      onclick="event.stopPropagation()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action w-7 h-7 rounded-md flex items-center justify-center text-slate-400 hover:text-rose-500 bg-slate-100 hover:bg-rose-50 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium text-sm">Belum ada pengumuman</p>
                            <p class="text-xs text-slate-400 mt-1">Buat pengumuman pertama Anda melalui form di samping</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PENGUMUMAN -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="bg-white rounded-xl shadow-2xl w-[500px] max-w-[90%] max-h-[80vh] overflow-hidden animate-fadeIn" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-5 py-4">
            <div class="flex justify-between items-center">
                <h3 id="modalTitle" class="font-bold text-white text-base">Detail Pengumuman</h3>
                <button onclick="closeModal()" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-5 overflow-y-auto max-h-[60vh]">
            <div id="modalMeta" class="flex flex-wrap gap-2 text-xs text-slate-500 mb-3 pb-2 border-b"></div>
            <p id="modalContent" class="text-slate-700 text-sm leading-relaxed whitespace-pre-line"></p>
            <div id="modalFile" class="mt-4 pt-3 border-t"></div>
        </div>
        
        <div class="px-5 py-3 bg-slate-50 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-1.5 bg-purple-500 hover:bg-purple-600 text-white rounded-lg text-sm font-medium transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Toggle class select
    function toggleClassSelect() {
        const radioSingle = document.querySelector('input[value="single_class"]');
        const classSelect = document.getElementById('classSelect');
        
        if(radioSingle && radioSingle.checked) {
            classSelect.classList.remove('hidden');
        } else {
            classSelect.classList.add('hidden');
        }
    }

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

    // Modal functions
    function openModal(item) {
        document.getElementById('modalTitle').innerHTML = item.title;
        document.getElementById('modalContent').innerHTML = item.content.replace(/\n/g, '<br>');
        
        const targetIcon = item.target === 'all' 
            ? '<svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
            : '<svg class="w-3 h-3 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>';
        
        document.getElementById('modalMeta').innerHTML = `
            <span class="inline-flex items-center gap-1">📅 ${item.created_at}</span>
            <span class="inline-flex items-center gap-1">${targetIcon} ${item.target === 'all' ? 'Semua Kelas' : 'Kelas ' + (item.class_name || 'Tertentu')}</span>
        `;
        
        const fileDiv = document.getElementById('modalFile');
        if (item.file && item.file !== null && item.file !== '') {
            fileDiv.innerHTML = `
                <p class="text-xs font-semibold text-slate-700 mb-2">Lampiran:</p>
                <a href="/storage/${item.file}" 
                   target="_blank"
                   class="inline-flex items-center gap-1.5 text-purple-500 hover:text-purple-600 text-xs font-medium bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                    </svg>
                    Download Lampiran
                </a>
            `;
        } else {
            fileDiv.innerHTML = '';
        }
        
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }

    // Auto hide success message
    setTimeout(() => {
        const successAlert = document.querySelector('.bg-emerald-50');
        if(successAlert) {
            successAlert.style.opacity = '0';
            successAlert.style.transform = 'translateY(-10px)';
            successAlert.style.transition = 'all 0.3s ease';
            setTimeout(() => successAlert.remove(), 300);
        }
    }, 3000);
</script>
@endsection