@extends('layouts.guru')

@section('title', 'Pengumuman - Scholify Guru')
@section('page-title', 'Manajemen Pengumuman')
@section('page-subtitle', 'Buat dan kelola pengumuman untuk siswa')

@section('content')
<div class="space-y-6">
    {{-- Header dengan neumorphism --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="megaphone" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Pengumuman</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Buat dan kelola pengumuman untuk siswa</p>
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
            FORM BUAT PENGUMUMAN - LEFT COLUMN
        ========================== --}}
        <div class="lg:col-span-5 animate-slideInLeft">
            <div class="neo-card p-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-[var(--shadow-dark)]/10">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="plus" class="w-5 h-5 text-[var(--accent)]"></i>
                    </div>
                    <div>
                        <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Buat Pengumuman Baru</h2>
                        <p class="text-xs text-[var(--text-muted)]">Isi form berikut untuk membuat pengumuman</p>
                    </div>
                </div>

                <form action="{{ route('guru.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="neo-pressed p-3 rounded-xl bg-rose-50/50">
                            <div class="flex items-center gap-2 text-rose-600 text-xs mb-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                <span class="font-semibold">Perlu diperhatikan!</span>
                            </div>
                            <ul class="text-xs text-rose-500 space-y-0.5 ml-6">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="neo-pressed p-3 rounded-xl bg-emerald-50/50">
                            <div class="flex items-center gap-2 text-emerald-600 text-xs">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                <span class="font-semibold">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Judul Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Judul Pengumuman
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Contoh: Ujian Akhir Semester"
                               class="neo-input w-full text-sm" required>
                    </div>

                    <!-- Isi Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Isi Pengumuman
                        </label>
                        <textarea name="content" rows="3"
                                  placeholder="Tulis detail pengumuman di sini..."
                                  class="neo-input w-full text-sm resize-none" required>{{ old('content') }}</textarea>
                    </div>

                    <!-- Target Pengumuman -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-secondary)] mb-1.5">
                            Target Pengumuman
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="radio-card cursor-pointer">
                                <input type="radio" name="target" value="all"
                                       {{ old('target', 'all') == 'all' ? 'checked' : '' }}
                                       class="peer sr-only" onchange="toggleClassSelect()">
                                <div class="neo-flat p-3 rounded-xl text-center transition-all peer-checked:neo-pressed cursor-pointer">
                                    <i data-lucide="users" class="w-5 h-5 mx-auto mb-1 text-[var(--text-muted)] peer-checked:text-[var(--accent)]"></i>
                                    <span class="text-xs font-medium text-[var(--text-secondary)] peer-checked:text-[var(--accent)]">Semua Kelas</span>
                                </div>
                            </label>

                            <label class="radio-card cursor-pointer">
                                <input type="radio" name="target" value="single_class"
                                       {{ old('target') == 'single_class' ? 'checked' : '' }}
                                       class="peer sr-only" onchange="toggleClassSelect()">
                                <div class="neo-flat p-3 rounded-xl text-center transition-all peer-checked:neo-pressed cursor-pointer">
                                    <i data-lucide="book-open" class="w-5 h-5 mx-auto mb-1 text-[var(--text-muted)] peer-checked:text-[var(--accent)]"></i>
                                    <span class="text-xs font-medium text-[var(--text-secondary)] peer-checked:text-[var(--accent)]">Kelas Tertentu</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Pilih Kelas (hidden by default) -->
                    <div id="classSelect" class="transition-all duration-300 {{ old('target') == 'single_class' ? '' : 'hidden' }}">
                        <select name="class_id" class="neo-input w-full text-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach($classes ?? [] as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Upload File -->
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

                    <!-- Submit Button -->
                    <button class="neo-btn w-full py-3 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-all">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        Kirim Pengumuman
                    </button>
                </form>
            </div>
        </div>

        {{-- =========================
            LIST PENGUMUMAN - RIGHT COLUMN
        ========================== --}}
        <div class="lg:col-span-7 animate-slideInRight">
            <div class="neo-card p-6">
                <div class="flex flex-wrap justify-between items-center gap-4 mb-5 pb-3 border-b border-[var(--shadow-dark)]/10">
                    <div class="flex items-center gap-3">
                        <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                            <i data-lucide="list" class="w-5 h-5 text-[var(--accent)]"></i>
                        </div>
                        <div>
                            <h2 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Daftar Pengumuman</h2>
                            <p class="text-xs text-[var(--text-muted)]">Semua pengumuman yang telah dibuat</p>
                        </div>
                    </div>
                    <div class="neo-pressed px-3 py-1.5 rounded-full">
                        <span class="text-xs font-semibold text-[var(--text-primary)]">{{ $announcements->count() ?? 0 }}</span>
                        <span class="text-xs text-[var(--text-muted)]"> Total Pengumuman</span>
                    </div>
                </div>

                <!-- Announcements List -->
                <div class="space-y-3 max-h-[520px] overflow-y-auto custom-scroll pr-1" id="announcementsList">
                    @forelse($announcements ?? [] as $item)
                        <div class="announcement-card neo-flat p-4 transition-all duration-300 hover:neo-pressed cursor-pointer"
                             onclick="openModal({{ json_encode([
                                 'id' => $item->id,
                                 'title' => $item->title,
                                 'content' => $item->content,
                                 'target' => $item->target,
                                 'class_name' => optional($item->class)->name,
                                 'created_at' => $item->created_at->locale('id')->isoFormat('D MMM Y, H:i'),
                                 'created_at_human' => $item->created_at->diffForHumans(),
                                 'file' => $item->file
                             ]) }})">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @if($item->target == 'all')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-indigo-100 text-indigo-600">
                                                <i data-lucide="users" class="w-3 h-3"></i>
                                                Semua Kelas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-sky-100 text-sky-600">
                                                <i data-lucide="book-open" class="w-3 h-3"></i>
                                                {{ optional($item->class)->name ?? 'Kelas Tertentu' }}
                                            </span>
                                        @endif
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs text-[var(--text-secondary)] bg-[var(--bg)]">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h3 class="font-semibold text-[var(--text-primary)] text-base mb-2">
                                        {{ $item->title }}
                                    </h3>
                                    
                                    <p class="text-sm text-[var(--text-secondary)] mb-3 line-clamp-2">
                                        {{ $item->content }}
                                    </p>

                                    @if($item->file)
                                        <span class="inline-flex items-center gap-1.5 text-[var(--text-muted)] text-xs font-medium">
                                            <i data-lucide="paperclip" class="w-3 h-3"></i>
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
                                            class="btn-action neo-btn w-8 h-8 rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-rose-400 transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="neo-flat p-12 text-center">
                            <div class="neo-pressed w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="inbox" class="w-10 h-10 text-[var(--text-muted)]"></i>
                            </div>
                            <p class="text-[var(--text-primary)] font-semibold text-base">Belum ada pengumuman</p>
                            <p class="text-sm text-[var(--text-muted)] mt-1">Buat pengumuman pertama Anda melalui form di samping</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PENGUMUMAN -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="neo-card w-[500px] max-w-[90%] max-h-[80vh] overflow-hidden" onclick="event.stopPropagation()">
        <div class="neo-pressed p-4 rounded-t-xl">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i data-lucide="megaphone" class="w-4 h-4 text-[var(--accent)]"></i>
                    <h3 id="modalTitle" class="font-outfit font-bold text-base text-[var(--text-primary)]">Detail Pengumuman</h3>
                </div>
                <button onclick="closeModal()" class="neo-btn w-8 h-8 rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-rose-400 transition-all">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <div class="p-5 overflow-y-auto max-h-[60vh] custom-scroll">
            <div id="modalMeta" class="flex flex-wrap gap-2 text-xs text-[var(--text-muted)] mb-3 pb-2 border-b border-[var(--shadow-dark)]/10"></div>
            <p id="modalContent" class="text-sm text-[var(--text-primary)] leading-relaxed whitespace-pre-line"></p>
            <div id="modalFile" class="mt-4 pt-3 border-t border-[var(--shadow-dark)]/10"></div>
        </div>
        
        <div class="px-5 py-3 border-t border-[var(--shadow-dark)]/10 flex justify-end">
            <button onclick="closeModal()" class="neo-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    /* Announcement card styles */
    .announcement-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    
    .radio-card {
        transition: all 0.2s ease;
    }
    
    .radio-card input:checked + div {
        box-shadow: inset 4px 4px 8px rgba(var(--shadow-dark), 0.5),
                    inset -4px -4px 8px rgba(var(--shadow-light), 0.8);
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
    
    /* Form select arrow */
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
                fileName.textContent = '📎 ' + this.files[0].name;
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
            ? '<i data-lucide="users" class="w-3 h-3 inline mr-0.5"></i>'
            : '<i data-lucide="book-open" class="w-3 h-3 inline mr-0.5"></i>';
        
        document.getElementById('modalMeta').innerHTML = `
            <span class="inline-flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i> ${item.created_at}</span>
            <span class="inline-flex items-center gap-1">${targetIcon} ${item.target === 'all' ? 'Semua Kelas' : 'Kelas ' + (item.class_name || 'Tertentu')}</span>
        `;
        
        const fileDiv = document.getElementById('modalFile');
        if (item.file && item.file !== null && item.file !== '') {
            fileDiv.innerHTML = `
                <p class="text-xs font-semibold text-[var(--text-secondary)] mb-2">Lampiran:</p>
                <a href="/storage/${item.file}" 
                   target="_blank"
                   class="inline-flex items-center gap-1.5 text-[var(--accent)] hover:text-[var(--accent-light)] text-xs font-medium neo-pressed px-3 py-1.5 rounded-lg transition-all">
                    <i data-lucide="download" class="w-3 h-3"></i>
                    Download Lampiran
                </a>
            `;
        } else {
            fileDiv.innerHTML = '';
        }
        
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }

    // Auto hide success message
    setTimeout(() => {
        const successAlert = document.querySelector('.bg-emerald-50/50');
        if(successAlert) {
            successAlert.style.opacity = '0';
            successAlert.style.transform = 'translateY(-10px)';
            successAlert.style.transition = 'all 0.3s ease';
            setTimeout(() => successAlert.remove(), 300);
        }
    }, 3000);
    
    // Re-initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection