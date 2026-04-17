@extends('layouts.student')

@section('title', 'Pengumuman')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Sidebar / Filter Section (Opsional) -->
    <div class="col-span-12 lg:col-span-3">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm sticky top-6">
            <div class="border-b border-slate-100 px-5 py-4 bg-gradient-to-r from-indigo-50/50 to-purple-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i data-lucide="megaphone" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Filter</h3>
                        <p class="text-xs text-slate-400">Saring pengumuman</p>
                    </div>
                </div>
            </div>
            
            <div class="p-5 space-y-5">
                <!-- Pencarian -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Cari Pengumuman</label>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Judul atau isi..." 
                               class="w-full pl-8 pr-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 transition-all">
                        <i data-lucide="search" class="absolute left-2.5 top-2.5 w-4 h-4 text-slate-400"></i>
                    </div>
                </div>

                <!-- Filter Kelas (Jika ingin menampilkan pengumuman berdasarkan kelas siswa) -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Filter Kelas</label>
                    <select id="classFilter" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 bg-white">
                        <option value="all">Semua Kelas</option>
                        <option value="10 - IPA 1">10 - IPA 1</option>
                        <option value="10 - IPA 2">10 - IPA 2</option>
                        <option value="10 - IPS 1">10 - IPS 1</option>
                        <option value="11 - IPA 1">11 - IPA 1</option>
                        <option value="11 - IPA 2">11 - IPA 2</option>
                        <option value="11 - IPS 1">11 - IPS 1</option>
                        <option value="12 - IPA 1">12 - IPA 1</option>
                        <option value="12 - IPS 1">12 - IPS 1</option>
                    </select>
                </div>

                <!-- Filter Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Periode</label>
                    <select id="dateFilter" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 bg-white">
                        <option value="all">Semua Waktu</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                        <option value="3months">3 Bulan Terakhir</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <button id="resetFilter" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-slate-500 text-sm font-medium hover:bg-slate-50 transition-all">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="col-span-12 lg:col-span-9">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <!-- Header -->
            <div class="border-b border-slate-100 px-5 py-4 bg-gradient-to-r from-indigo-50/50 to-purple-50/50">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Daftar Pengumuman</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Informasi terbaru dari guru</p>
                    </div>
                    <div class="text-xs text-slate-400" id="announcementCount">
                        Menampilkan <span id="totalDisplay">0</span> pengumuman
                    </div>
                </div>
            </div>
            
            <!-- List Pengumuman -->
            <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto" id="announcementList">
                @php
                    $announcements = [
                        [
                            'id' => 1,
                            'title' => 'Ujian Tengah Semester Genap 2026',
                            'content' => 'UTS akan dilaksanakan pada tanggal 15-20 Maret 2026. Harap mempersiapkan diri dengan baik. Jadwal menyusul.',
                            'target' => 'all',
                            'class_target' => null,
                            'created_at' => '2026-03-01',
                            'file' => 'files/uts_schedule.pdf',
                            'priority' => 'high'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Peringatan Hari Pendidikan Nasional',
                            'content' => 'Upacara bendera dalam rangka Hardiknas akan dilaksanakan hari Senin, 2 Mei 2026. Wajib mengenakan seragam putih lengkap.',
                            'target' => 'all',
                            'class_target' => null,
                            'created_at' => '2026-04-28',
                            'file' => null,
                            'priority' => 'normal'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Remedial Matematika Kelas 10',
                            'content' => 'Remedial Matematika akan dilaksanakan hari Sabtu, 10 Mei 2026 pukul 08.00 - 10.00 WIB di Ruang 01. Bawa kalkulator.',
                            'target' => 'specific',
                            'class_target' => '10 - IPA 1, 10 - IPA 2',
                            'created_at' => '2026-05-05',
                            'file' => 'files/remedial_materi.pdf',
                            'priority' => 'high'
                        ],
                        [
                            'id' => 4,
                            'title' => 'Libur Isra Miraj',
                            'content' => 'Libur sekolah dalam rangka peringatan Isra Miraj pada tanggal 27 Februari 2026. Masuk kembali tanggal 28 Februari 2026.',
                            'target' => 'all',
                            'class_target' => null,
                            'created_at' => '2026-02-20',
                            'file' => null,
                            'priority' => 'normal'
                        ],
                        [
                            'id' => 5,
                            'title' => 'Pendaftaran Ekstrakurikuler',
                            'content' => 'Pendaftaran ekskul dibuka mulai 1-10 Maret 2026. Silakan hubungi wali kelas masing-masing.',
                            'target' => 'all',
                            'class_target' => null,
                            'created_at' => '2026-02-25',
                            'file' => 'files/ekskul_form.pdf',
                            'priority' => 'info'
                        ],
                        [
                            'id' => 6,
                            'title' => 'Peringatan Class Meeting',
                            'content' => 'Class Meeting akan diadakan setelah ujian akhir semester. Setiap kelas wajib mendaftarkan minimal 2 cabang olahraga.',
                            'target' => 'specific',
                            'class_target' => '10 - IPA 1, 10 - IPA 2, 11 - IPA 1, 11 - IPA 2',
                            'created_at' => '2026-03-15',
                            'file' => null,
                            'priority' => 'normal'
                        ],
                    ];
                @endphp
                
                @foreach($announcements as $item)
                <div class="p-5 hover:bg-slate-50/80 transition-all cursor-pointer group announcement-item"
                     data-title="{{ strtolower($item['title']) }}"
                     data-content="{{ strtolower($item['content']) }}"
                     data-target="{{ $item['target'] }}"
                     data-class="{{ strtolower($item['class_target'] ?? '') }}"
                     data-date="{{ $item['created_at'] }}"
                     data-priority="{{ $item['priority'] }}">
                    
                    <div class="flex justify-between items-start gap-3">
                        <!-- Icon Priority -->
                        <div class="flex-shrink-0">
                            @if($item['priority'] == 'high')
                                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
                                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
                                </div>
                            @elseif($item['priority'] == 'normal')
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                    <i data-lucide="bell" class="w-5 h-5 text-amber-500"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center">
                                    <i data-lucide="info" class="w-5 h-5 text-sky-500"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                    {{ $item['title'] }}
                                </h4>
                                @if($item['priority'] == 'high')
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-600">
                                        PENTING
                                    </span>
                                @endif
                                @if($item['file'])
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 flex items-center gap-0.5">
                                    <i data-lucide="paperclip" class="w-2.5 h-2.5"></i>
                                    Lampiran
                                </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $item['content'] }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    {{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d F Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                    Target: 
                                    @if($item['target'] == 'all')
                                        Semua Kelas
                                    @else
                                        {{ $item['class_target'] }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all">
                            @if($item['file'])
                            <a href="{{ asset('storage/'.$item['file']) }}" 
                               class="p-1.5 rounded-lg text-indigo-500 hover:bg-indigo-50 transition-colors"
                               title="Download Lampiran">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </a>
                            @endif
                            <button class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 transition-colors view-detail"
                                    data-id="{{ $item['id'] }}"
                                    data-title="{{ $item['title'] }}"
                                    data-content="{{ $item['content'] }}"
                                    data-date="{{ $item['created_at'] }}"
                                    data-target="{{ $item['target'] == 'all' ? 'Semua Kelas' : $item['class_target'] }}"
                                    data-file="{{ $item['file'] ? asset('storage/'.$item['file']) : '' }}"
                                    title="Lihat Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-12">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-10 h-10 text-slate-400"></i>
                </div>
                <p class="text-slate-500 font-medium">Tidak ada pengumuman</p>
                <p class="text-sm text-slate-400 mt-1">Belum ada pengumuman yang sesuai dengan filter yang dipilih</p>
            </div>
            
            <!-- Pagination -->
            <div class="border-t border-slate-100 px-5 py-3 bg-slate-50/50 flex justify-between items-center">
                <p class="text-[11px] text-slate-400" id="paginationInfo"></p>
                <div class="flex gap-1" id="paginationButtons">
                    <!-- Pagination akan di-generate oleh JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pengumuman -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[80vh] overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="border-b border-slate-100 px-6 py-4 bg-gradient-to-r from-indigo-50/50 to-purple-50/50 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                    <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800" id="modalTitle">Detail Pengumuman</h3>
                    <p class="text-xs text-slate-400" id="modalDate"></p>
                </div>
            </div>
            <button id="closeModal" class="p-1 rounded-lg hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5 text-slate-500"></i>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wide">Target</label>
                    <p class="text-sm text-slate-700 mt-1" id="modalTarget"></p>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wide">Isi Pengumuman</label>
                    <div class="mt-2 p-4 bg-slate-50 rounded-xl text-sm text-slate-700 whitespace-pre-wrap" id="modalContent"></div>
                </div>
                
                <div id="modalFileSection" class="hidden">
                    <label class="text-xs font-bold text-slate-600 uppercase tracking-wide">Lampiran</label>
                    <a href="#" id="modalFileLink" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Download Lampiran
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-slate-100 px-6 py-4 bg-slate-50/50 flex justify-end">
            <button id="closeModalBtn" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // Data announcements dari server-side
    const announcementsData = @json($announcements);
    let currentPage = 1;
    const itemsPerPage = 5;
    let filteredAnnouncements = [...announcementsData];

    // Fungsi untuk memfilter dan merender ulang
    function filterAndRender() {
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const classFilter = document.getElementById('classFilter')?.value || 'all';
        const dateFilter = document.getElementById('dateFilter')?.value || 'all';
        
        filteredAnnouncements = announcementsData.filter(item => {
            // Filter pencarian
            const matchSearch = searchTerm === '' || 
                item.title.toLowerCase().includes(searchTerm) || 
                item.content.toLowerCase().includes(searchTerm);
            
            // Filter kelas
            let matchClass = true;
            if (classFilter !== 'all') {
                if (item.target === 'all') {
                    matchClass = true;
                } else if (item.class_target) {
                    matchClass = item.class_target.includes(classFilter);
                } else {
                    matchClass = false;
                }
            }
            
            // Filter tanggal
            let matchDate = true;
            if (dateFilter !== 'all') {
                const itemDate = new Date(item.created_at);
                const now = new Date();
                const weekAgo = new Date(now.setDate(now.getDate() - 7));
                const monthAgo = new Date(now.setMonth(now.getMonth() - 1));
                const threeMonthsAgo = new Date(now.setMonth(now.getMonth() - 3));
                
                if (dateFilter === 'week') {
                    matchDate = itemDate >= weekAgo;
                } else if (dateFilter === 'month') {
                    matchDate = itemDate >= monthAgo;
                } else if (dateFilter === '3months') {
                    matchDate = itemDate >= threeMonthsAgo;
                }
            }
            
            return matchSearch && matchClass && matchDate;
        });
        
        // Update total display
        document.getElementById('totalDisplay').innerText = filteredAnnouncements.length;
        document.getElementById('announcementCount').classList.remove('hidden');
        
        // Reset ke halaman 1
        currentPage = 1;
        renderPage();
    }
    
    // Fungsi untuk merender halaman
    function renderPage() {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = filteredAnnouncements.slice(start, end);
        const container = document.getElementById('announcementList');
        const emptyState = document.getElementById('emptyState');
        
        if (pageItems.length === 0) {
            container.innerHTML = '';
            emptyState.classList.remove('hidden');
            document.getElementById('paginationInfo').innerText = '';
            document.getElementById('paginationButtons').innerHTML = '';
            return;
        }
        
        emptyState.classList.add('hidden');
        
        // Render items
        container.innerHTML = pageItems.map(item => `
            <div class="p-5 hover:bg-slate-50/80 transition-all cursor-pointer group announcement-item"
                 data-id="${item.id}">
                <div class="flex justify-between items-start gap-3">
                    <div class="flex-shrink-0">
                        ${item.priority === 'high' ? `
                            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
                            </div>
                        ` : (item.priority === 'normal' ? `
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                                <i data-lucide="bell" class="w-5 h-5 text-amber-500"></i>
                            </div>
                        ` : `
                            <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center">
                                <i data-lucide="info" class="w-5 h-5 text-sky-500"></i>
                            </div>
                        `)}
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                ${escapeHtml(item.title)}
                            </h4>
                            ${item.priority === 'high' ? `
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-600">
                                    PENTING
                                </span>
                            ` : ''}
                            ${item.file ? `
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 flex items-center gap-0.5">
                                    <i data-lucide="paperclip" class="w-2.5 h-2.5"></i>
                                    Lampiran
                                </span>
                            ` : ''}
                        </div>
                        <p class="text-sm text-slate-600 mb-3 line-clamp-2">${escapeHtml(item.content)}</p>
                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                ${formatDate(item.created_at)}
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                Target: ${item.target === 'all' ? 'Semua Kelas' : item.class_target}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all">
                        ${item.file ? `
                            <a href="${assetStorage(item.file)}" 
                               class="p-1.5 rounded-lg text-indigo-500 hover:bg-indigo-50 transition-colors"
                               title="Download Lampiran">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </a>
                        ` : ''}
                        <button class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 transition-colors view-detail"
                                data-id="${item.id}"
                                data-title="${escapeHtml(item.title)}"
                                data-content="${escapeHtml(item.content)}"
                                data-date="${item.created_at}"
                                data-target="${item.target === 'all' ? 'Semua Kelas' : item.class_target}"
                                data-file="${item.file ? assetStorage(item.file) : ''}"
                                title="Lihat Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Re-initialize icons
        lucide.createIcons();
        
        // Re-attach event listeners untuk tombol detail
        document.querySelectorAll('.view-detail').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const title = this.dataset.title;
                const content = this.dataset.content;
                const date = this.dataset.date;
                const target = this.dataset.target;
                const file = this.dataset.file;
                
                document.getElementById('modalTitle').innerText = title;
                document.getElementById('modalContent').innerHTML = content.replace(/\n/g, '<br>');
                document.getElementById('modalDate').innerHTML = formatDate(date);
                document.getElementById('modalTarget').innerHTML = target;
                
                if (file && file !== '') {
                    document.getElementById('modalFileSection').classList.remove('hidden');
                    document.getElementById('modalFileLink').href = file;
                } else {
                    document.getElementById('modalFileSection').classList.add('hidden');
                }
                
                document.getElementById('detailModal').classList.remove('hidden');
                document.getElementById('detailModal').classList.add('flex');
            });
        });
        
        // Render pagination
        const totalPages = Math.ceil(filteredAnnouncements.length / itemsPerPage);
        const paginationContainer = document.getElementById('paginationButtons');
        const paginationInfo = document.getElementById('paginationInfo');
        
        paginationInfo.innerText = `Menampilkan ${start + 1}-${Math.min(end, filteredAnnouncements.length)} dari ${filteredAnnouncements.length}`;
        
        let paginationHtml = '';
        paginationHtml += `<button class="px-2 py-1 rounded-lg border border-slate-200 text-slate-400 text-xs hover:bg-white transition-all ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                                onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                            <i data-lucide="chevron-left" class="w-3 h-3"></i>
                        </button>`;
        
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                paginationHtml += `<button class="w-7 h-7 rounded-lg ${i === currentPage ? 'bg-indigo-600 text-white' : 'border border-slate-200 text-slate-500 hover:bg-white'} text-xs transition-all"
                                        onclick="changePage(${i})">
                                    ${i}
                                </button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                paginationHtml += `<span class="px-1 text-slate-400">...</span>`;
            }
        }
        
        paginationHtml += `<button class="px-2 py-1 rounded-lg border border-slate-200 text-slate-400 text-xs hover:bg-white transition-all ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                                onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                            <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        </button>`;
        
        paginationContainer.innerHTML = paginationHtml;
        lucide.createIcons();
    }
    
    // Helper functions
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    }
    
    function assetStorage(path) {
        return `{{ asset('storage') }}/${path}`;
    }
    
    window.changePage = function(page) {
        if (page < 1 || page > Math.ceil(filteredAnnouncements.length / itemsPerPage)) return;
        currentPage = page;
        renderPage();
    };
    
    // Event listeners
    document.getElementById('searchInput')?.addEventListener('input', filterAndRender);
    document.getElementById('classFilter')?.addEventListener('change', filterAndRender);
    document.getElementById('dateFilter')?.addEventListener('change', filterAndRender);
    document.getElementById('resetFilter')?.addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('classFilter').value = 'all';
        document.getElementById('dateFilter').value = 'all';
        filterAndRender();
    });
    
    // Modal handlers
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }
    
    document.getElementById('closeModal')?.addEventListener('click', closeModal);
    document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
    document.getElementById('detailModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'detailModal') closeModal();
    });
    
    // Initial render
    filterAndRender();
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @keyframes fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes zoom-in {
        from {
            transform: scale(0.95);
        }
        to {
            transform: scale(1);
        }
    }
    
    .animate-in {
        animation-duration: 0.2s;
        animation-fill-mode: both;
    }
    
    .fade-in {
        animation-name: fade-in;
    }
    
    .zoom-in {
        animation-name: zoom-in;
    }
</style>
@endsection