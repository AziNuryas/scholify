@extends('layouts.student')

@section('title', 'Pengumuman - Schoolify')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="mb-4 animate-fadeInUp">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 neo-badge-blue rounded-full"></div>
                    <span class="text-sm font-bold text-indigo-500 tracking-wide">ANNOUNCEMENTS</span>
                </div>
                <h1 class="font-outfit font-bold text-3xl text-[var(--brand-secondary)] mb-2">Papan <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Pengumuman</span></h1>
                <p class="text-[var(--text-muted)]">Informasi terbaru dan penting dari pihak sekolah.</p>
            </div>

            <!-- Statistik -->
            <div class="neo-flat rounded-xl px-4 py-2.5">
                <div class="text-xs text-[var(--text-muted)] font-medium">Total</div>
                <div class="text-2xl font-bold text-indigo-600" id="totalCount">0</div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-6">

        <!-- FILTER Sidebar -->
        <div class="lg:col-span-3 animate-slideInLeft">
            <div class="neo-flat rounded-2xl overflow-hidden sticky top-6">

                <div class="px-4 py-3 neo-pressed">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <h3 class="font-bold text-[var(--brand-secondary)] text-sm">Filter Pengumuman</h3>
                    </div>
                </div>

                <div class="p-4 space-y-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--brand-secondary)] mb-1">Cari</label>
                        <input type="text" id="searchInput" placeholder="Cari judul atau isi..." class="w-full neo-input text-sm">
                    </div>

                    <!-- Filter Kelas -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--brand-secondary)] mb-1">Kelas</label>
                        <select id="classFilter" class="w-full neo-input text-sm">
                            <option value="all">Semua Kelas</option>
                            @foreach($classes ?? [] as $class)
                                <option value="{{ $class->name }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-[var(--text-muted)] mt-1">Pengumuman untuk semua kelas juga akan muncul</p>
                    </div>

                    <!-- Filter Waktu -->
                    <div>
                        <label class="block text-xs font-semibold text-[var(--brand-secondary)] mb-2">Waktu</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button data-date="all" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-badge-blue text-white">Semua</button>
                            <button data-date="week" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-btn text-[var(--brand-secondary)]">7 Hari</button>
                            <button data-date="month" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-btn text-[var(--brand-secondary)]">30 Hari</button>
                            <button data-date="3months" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-btn text-[var(--brand-secondary)]">3 Bulan</button>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button id="resetFilter" class="w-full neo-btn text-[var(--brand-secondary)] py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- LIST PENGUMUMAN -->
        <div class="lg:col-span-9 animate-slideInRight">
            <div class="neo-flat rounded-2xl overflow-hidden">

                <div class="px-4 py-3 neo-pressed">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 neo-badge-green rounded-lg flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-[var(--brand-secondary)] text-sm">Daftar Pengumuman</h3>
                        </div>
                        <div class="text-xs text-[var(--text-muted)]">
                            Menampilkan <span id="showingCount">0</span> dari <span id="totalFiltered">0</span>
                        </div>
                    </div>
                </div>

                <!-- List Container -->
                <div id="announcementList" class="max-h-[500px] overflow-y-auto custom-scroll"></div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden p-8 text-center">
                    <div class="w-16 h-16 mx-auto neo-pressed rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-[var(--text-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <p class="text-[var(--brand-secondary)] text-sm font-medium">Tidak ada pengumuman</p>
                    <p class="text-xs text-[var(--text-muted)] mt-1">Coba ubah filter atau cari dengan kata kunci berbeda</p>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 neo-pressed flex justify-between items-center">
                    <div id="paginationInfo" class="text-xs text-[var(--text-muted)]"></div>
                    <div id="paginationButtons" class="flex gap-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="neo-flat rounded-2xl w-[500px] max-w-[90%] max-h-[80vh] overflow-hidden" onclick="event.stopPropagation()">
        <div class="neo-badge-blue px-5 py-3">
            <div class="flex justify-between items-center">
                <h3 id="modalTitle" class="font-bold text-white text-base">Detail Pengumuman</h3>
                <button onclick="closeModal()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-5 overflow-y-auto max-h-[60vh]">
            <div id="modalMeta" class="flex flex-wrap gap-2 text-xs text-[var(--text-muted)] mb-3 pb-2 border-b border-[var(--neo-shadow-dark)]/10"></div>
            <p id="modalContent" class="text-[var(--brand-secondary)] text-sm leading-relaxed whitespace-pre-line"></p>
            <div id="modalFile" class="mt-4 pt-3 border-t border-[var(--neo-shadow-dark)]/10"></div>
        </div>

        <div class="px-5 py-3 neo-pressed flex justify-end">
            <button onclick="closeModal()" class="px-4 py-1.5 neo-badge-blue text-white rounded-lg text-sm transition-all hover:opacity-90">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    const data = @json($announcements);
    let filtered = [...data];
    let currentPage = 1;
    const perPage = 6;
    let currentDateFilter = 'all';

    function formatDate(dateString) {
        const date = new Date(dateString);
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()} • ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
    }

    function formatRelativeTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return `${Math.floor(diff / 60)} menit yang lalu`;
        if (diff < 86400) return `${Math.floor(diff / 3600)} jam yang lalu`;
        if (diff < 604800) return `${Math.floor(diff / 86400)} hari yang lalu`;
        return formatDate(dateString);
    }

    function getFileUrl(filePath) {
        if (!filePath) return null;
        if (filePath.startsWith('http')) return filePath;
        if (filePath.startsWith('/storage/')) return filePath;
        if (filePath.startsWith('storage/')) return '/' + filePath;
        return '/storage/' + filePath;
    }

    function getFileIcon(fileName) {
        if (!fileName) return '';
        const ext = fileName.split('.').pop().toLowerCase();
        const icons = { 'pdf': '📄', 'doc': '📘', 'docx': '📘', 'xls': '📊', 'xlsx': '📊', 'ppt': '📽️', 'pptx': '📽️', 'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️', 'zip': '📦', 'rar': '📦', 'txt': '📝' };
        return icons[ext] || '📎';
    }

    function filterData() {
        const search = document.getElementById('searchInput').value.toLowerCase().trim();
        const kelas = document.getElementById('classFilter').value;

        filtered = data.filter(item => {
            let match = true;
            if (search) {
                match = item.title.toLowerCase().includes(search) || item.content.toLowerCase().includes(search);
                if (!match) return false;
            }
            if (kelas !== 'all') {
                match = (item.target === 'all') || (item.class_target && item.class_target.includes(kelas));
                if (!match) return false;
            }
            if (currentDateFilter !== 'all') {
                const itemDate = new Date(item.created_at);
                const now = new Date();
                let limit = new Date();
                if (currentDateFilter === 'week') limit.setDate(now.getDate() - 7);
                else if (currentDateFilter === 'month') limit.setMonth(now.getMonth() - 1);
                else if (currentDateFilter === '3months') limit.setMonth(now.getMonth() - 3);
                match = itemDate >= limit;
            }
            return match;
        });

        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        document.getElementById('totalCount').innerText = data.length;
        document.getElementById('totalFiltered').innerText = filtered.length;
        currentPage = 1;
        render();
    }

    function render() {
        const container = document.getElementById('announcementList');
        const empty = document.getElementById('emptyState');

        if (!filtered.length) {
            container.innerHTML = '';
            empty.classList.remove('hidden');
            document.getElementById('showingCount').innerText = '0';
            document.getElementById('paginationInfo').innerHTML = '';
            document.getElementById('paginationButtons').innerHTML = '';
            return;
        }

        empty.classList.add('hidden');
        const start = (currentPage - 1) * perPage;
        const pageItems = filtered.slice(start, start + perPage);
        const showing = Math.min(start + perPage, filtered.length);
        document.getElementById('showingCount').innerText = showing;

        container.innerHTML = pageItems.map((item, index) => `
        <div class="p-4 cursor-pointer group transition-all hover:bg-[var(--neo-shadow-light)]/50 border-b border-[var(--neo-shadow-dark)]/5" 
             style="animation: fadeInUp 0.3s ease-out ${index * 0.03}s forwards; opacity: 0;"
             onclick='openModal(${JSON.stringify(item).replace(/'/g, "&#39;")})'>
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex flex-wrap gap-1.5 mb-2">
                        ${item.target === 'all' ?
                `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium neo-badge-green text-white">Semua Kelas</span>` :
                `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium neo-badge-blue text-white">${item.class_target || 'Kelas Tertentu'}</span>`
            }
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium neo-btn text-[var(--text-muted)]">
                            ${formatRelativeTime(item.created_at)}
                        </span>
                        ${item.file ? `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium neo-badge-purple text-white">📎 Lampiran</span>` : ''}
                    </div>
                    <h4 class="font-semibold text-[var(--brand-secondary)] text-sm group-hover:text-indigo-600 transition-colors">
                        ${escapeHtml(item.title)}
                    </h4>
                    <p class="text-xs text-[var(--text-muted)] mt-1 line-clamp-2">
                        ${escapeHtml(item.content.substring(0, 120))}${item.content.length > 120 ? '...' : ''}
                    </p>
                </div>
                <svg class="w-4 h-4 text-[var(--text-muted)] group-hover:text-indigo-500 transition-colors flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
        `).join('');

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / perPage);
        const paginationDiv = document.getElementById('paginationButtons');
        const infoSpan = document.getElementById('paginationInfo');
        if (totalPages <= 1) { paginationDiv.innerHTML = ''; infoSpan.innerHTML = ''; return; }
        infoSpan.innerHTML = `Halaman ${currentPage} dari ${totalPages}`;
        let html = `<button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === 1 ? 'text-[var(--text-muted)] cursor-not-allowed' : 'text-indigo-600 neo-btn'}">«</button>`;
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
            html += `<button onclick="changePage(${i})" class="px-2 py-0.5 rounded text-xs ${i === currentPage ? 'neo-badge-blue text-white' : 'neo-btn text-[var(--brand-secondary)]'}">${i}</button>`;
        }
        html += `<button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === totalPages ? 'text-[var(--text-muted)] cursor-not-allowed' : 'text-indigo-600 neo-btn'}">»</button>`;
        paginationDiv.innerHTML = html;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filtered.length / perPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        render();
        document.getElementById('announcementList').scrollTop = 0;
    }

    function openModal(item) {
        const modal = document.getElementById('detailModal');
        document.getElementById('modalTitle').innerHTML = item.title;
        document.getElementById('modalContent').innerHTML = escapeHtml(item.content).replace(/\n/g, '<br>');
        document.getElementById('modalMeta').innerHTML = `
            <span class="inline-flex items-center gap-1">📅 ${formatDate(item.created_at)}</span>
            <span class="inline-flex items-center gap-1">👥 ${item.target === 'all' ? 'Semua Kelas' : 'Kelas ' + (item.class_target || 'Tertentu')}</span>
        `;
        const fileDiv = document.getElementById('modalFile');
        if (item.file && item.file !== null && item.file !== '') {
            const fileUrl = getFileUrl(item.file);
            const fileName = item.file.split('/').pop();
            const fileIcon = getFileIcon(fileName);
            fileDiv.innerHTML = `
            <div class="neo-pressed rounded-xl p-3">
                <p class="text-xs font-semibold text-[var(--brand-secondary)] mb-2">📎 Lampiran</p>
                <a href="${fileUrl}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-xs neo-btn px-3 py-1.5 rounded-lg transition-all">
                    <span>${fileIcon}</span><span>${escapeHtml(fileName)}</span>
                </a>
            </div>`;
        } else { fileDiv.innerHTML = ''; }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.querySelectorAll('.date-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            currentDateFilter = btn.dataset.date;
            document.querySelectorAll('.date-filter-btn').forEach(b => {
                b.className = 'date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-btn text-[var(--brand-secondary)]';
            });
            btn.className = 'date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-badge-blue text-white';
            filterData();
        });
    });

    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterData, 300);
    });
    document.getElementById('classFilter').addEventListener('change', filterData);
    document.getElementById('resetFilter').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('classFilter').value = 'all';
        currentDateFilter = 'all';
        document.querySelectorAll('.date-filter-btn').forEach(b => {
            b.className = 'date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-btn text-[var(--brand-secondary)]';
        });
        document.querySelector('[data-date="all"]').className = 'date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all neo-badge-blue text-white';
        filterData();
    });

    filterData();
</script>
@endsection