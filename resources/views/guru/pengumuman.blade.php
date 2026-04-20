@extends('layouts.guru')

@section('page_title', 'Pengumuman')
@section('page_subtitle', 'Buat dan kelola pengumuman untuk siswa.')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap');
    
    * {
        font-family: 'Inter', sans-serif;
    }
    
    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 10px;
    }
    
    /* Glass morphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    /* Animation */
    @keyframes fadeInUp {
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
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes modalPop {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out; }
    .animate-slideInLeft { animation: slideInLeft 0.5s ease-out; }
    .animate-slideInRight { animation: slideInRight 0.5s ease-out; }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; opacity: 0; }
    .animate-modalPop { animation: modalPop 0.3s ease-out; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Hover effect untuk card pengumuman */
    .announcement-card {
        transition: all 0.3s ease;
    }
    
    .announcement-card:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        transform: translateX(5px);
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50/20 to-purple-50/30">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Header -->
        <div class="mb-6 animate-fadeInUp">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-900 via-indigo-800 to-purple-800 bg-clip-text text-transparent">
                            Pengumuman
                        </h1>
                        <p class="text-slate-500 text-xs">Buat dan kelola pengumuman untuk siswa</p>
                    </div>
                </div>
                
                <div class="glass-card rounded-xl px-3 py-1.5 shadow-sm">
                    <div class="text-xs text-slate-500">Total</div>
                    <div class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ $announcements->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-6">
            
            <!-- FORM SECTION -->
            <div class="lg:col-span-5 animate-slideInLeft">
                <div class="glass-card rounded-xl shadow-lg overflow-hidden">
                    
                    <div class="px-5 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-sm">Buat Pengumuman Baru</h3>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('guru.pengumuman.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="p-4 space-y-4">

                        @csrf

                        <!-- Alert Messages -->
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-3">
                                <div class="flex items-center gap-2 text-red-700 text-sm mb-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-semibold">Perlu diperhatikan!</span>
                                </div>
                                <ul class="text-xs text-red-600 space-y-1 ml-6">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-3">
                                <div class="flex items-center gap-2 text-emerald-700 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-semibold">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Input Judul -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Pengumuman</label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Ujian Akhir Semester"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm"
                                   required>
                        </div>

                        <!-- Textarea Content -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Pengumuman</label>
                            <textarea name="content" 
                                      rows="4"
                                      placeholder="Tulis detail pengumuman di sini..."
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm resize-none"
                                      required>{{ old('content') }}</textarea>
                        </div>

                        <!-- Target dengan Icon SVG (Tanpa Bola Dunia) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Target Pengumuman</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="target" value="all_classes"
                                           {{ old('target', 'all_classes') == 'all_classes' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <div class="p-2.5 rounded-lg border-2 text-center peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Icon Group/Users untuk Semua Kelas (Pengganti Bola Dunia) -->
                                            <svg class="w-4 h-4 text-slate-500 peer-checked:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Semua Kelas</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="target" value="single_class"
                                           {{ old('target') == 'single_class' ? 'checked' : '' }}
                                           class="peer sr-only">
                                    <div class="p-2.5 rounded-lg border-2 text-center peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Icon Book untuk Kelas Tertentu -->
                                            <svg class="w-4 h-4 text-slate-500 peer-checked:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Kelas Tertentu</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Pilih Kelas -->
                        <div id="classSelect" class="transition-all duration-300 {{ old('target') == 'single_class' ? '' : 'hidden' }}">
                            <select name="class_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                                <option value="">📚 Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->students_count ?? 0 }} siswa)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Upload File -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Lampiran</label>
                            <div class="relative">
                                <input type="file" name="file" id="fileInput" class="hidden">
                                <label for="fileInput" class="flex items-center justify-center w-full px-3 py-3 bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg cursor-pointer hover:border-indigo-400 transition-all">
                                    <div class="text-center">
                                        <svg class="w-6 h-6 mx-auto text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-xs text-slate-500 mt-1">Klik untuk upload</p>
                                        <p id="fileName" class="text-xs text-indigo-600 mt-1 hidden"></p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-lg font-semibold text-sm hover:shadow-lg transition-all">
                            Kirim Pengumuman
                        </button>
                    </form>
                </div>
            </div>

            <!-- LIST PENGUMUMAN -->
            <div class="lg:col-span-7 animate-slideInRight">
                <div class="glass-card rounded-xl shadow-lg overflow-hidden">
                    
                    <div class="px-5 py-3 bg-gradient-to-r from-slate-50 to-indigo-50/50 border-b">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm">Riwayat Pengumuman</h3>
                            </div>
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full px-3 py-0.5">
                                <span class="text-xs font-bold text-white">{{ $announcements->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto custom-scroll">

                        @forelse($announcements as $index => $item)
                        <div class="announcement-card p-3 cursor-pointer group" 
                             style="animation: fadeIn 0.3s ease-out {{ $index * 0.03 }}s forwards; opacity: 0;"
                             onclick="openModal({{ json_encode([
                                 'id' => $item->id,
                                 'title' => $item->title,
                                 'content' => $item->content,
                                 'target' => $item->target,
                                 'class_name' => optional($item->class)->name,
                                 'created_at' => $item->created_at->isoFormat('dddd, D MMM YYYY • HH:mm'),
                                 'file' => $item->file
                             ]) }})">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <!-- Badges dengan Icon SVG (Tanpa Bola Dunia) -->
                                    <div class="flex flex-wrap gap-1.5 mb-2">
                                        @if($item->target == 'all')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                                <!-- Icon Group untuk Semua Kelas -->
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                Semua Kelas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <!-- Icon Book untuk Kelas Tertentu -->
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                {{ optional($item->class)->name ?? 'Kelas Tertentu' }}
                                            </span>
                                        @endif
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h4 class="font-semibold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors">
                                        {{ $item->title }}
                                    </h4>

                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                        {{ $item->content }}
                                    </p>

                                    @if($item->file)
                                        <div class="mt-2">
                                            <span class="inline-flex items-center gap-1 text-xs text-indigo-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                                </svg>
                                                Ada lampiran
                                            </span>
                                        </div>
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
                                            class="opacity-0 group-hover:opacity-100 transition-all duration-200 text-slate-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-slate-500 text-sm">Belum ada pengumuman</p>
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PENGUMUMAN -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="bg-white rounded-xl shadow-2xl w-[500px] max-w-[90%] max-h-[80vh] overflow-hidden animate-modalPop" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3">
            <div class="flex justify-between items-center">
                <h3 id="modalTitle" class="font-bold text-white text-base">Detail Pengumuman</h3>
                <button onclick="closeModal()" class="text-white hover:text-gray-200">
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
            <button onclick="closeModal()" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Toggle class select
    const radioSingle = document.querySelector('input[value="single_class"]');
    const radioAll = document.querySelector('input[value="all_classes"]');
    const classSelect = document.getElementById('classSelect');

    if(radioSingle && radioAll) {
        function toggleClassSelect() {
            if (radioSingle.checked) {
                classSelect.classList.remove('hidden');
            } else {
                classSelect.classList.add('hidden');
            }
        }
        
        radioSingle.addEventListener('change', toggleClassSelect);
        radioAll.addEventListener('change', toggleClassSelect);
    }

    // File name preview
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                fileName.textContent = `📎 ${this.files[0].name}`;
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
        
        // Icon untuk meta modal (Tanpa Bola Dunia)
        const targetIcon = item.target === 'all' 
            ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
            : '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>';
        
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
                   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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