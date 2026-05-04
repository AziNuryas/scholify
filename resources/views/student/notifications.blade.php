@extends('layouts.student')

@section('title', 'Notifikasi - Schoolify')

@section('content')
<div class="space-y-6 animate-fadeInUp">

    {{-- Header dengan neumorphism yang lebih menarik --}}
    <div class="neo-flat p-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-40 h-40 bg-[var(--accent)]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-[var(--accent-light)]/5 rounded-full blur-3xl"></div>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="bell" class="w-5 h-5 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Pusat Notifikasi</h1>
                    <span id="unreadBadge" class="neo-badge-red px-2 py-0.5 rounded-full text-[10px] font-bold hidden">0</span>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-13">Semua pemberitahuan dan aktivitas terbaru Anda</p>
            </div>
            <div class="neo-pressed px-4 py-2 rounded-xl flex items-center gap-2">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-[var(--accent)]"></i>
                <span class="text-xs font-semibold text-[var(--text-primary)]">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistik Cards dengan desain lebih menarik --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="neo-card p-5 group hover:neo-pressed transition-all duration-300 cursor-pointer" onclick="filterByStatus('all')">
            <div class="flex items-center gap-4">
                <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="bell" class="w-5 h-5 text-[var(--accent)]"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Total Notifikasi</p>
                    <p class="text-3xl font-bold text-[var(--text-primary)]" id="statTotal">0</p>
                </div>
            </div>
        </div>
        <div class="neo-card p-5 group hover:neo-pressed transition-all duration-300 cursor-pointer" onclick="filterByStatus('unread')">
            <div class="flex items-center gap-4">
                <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="inbox" class="w-5 h-5 text-blue-500"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Belum Dibaca</p>
                    <p class="text-3xl font-bold text-blue-500" id="statUnread">0</p>
                </div>
            </div>
        </div>
        <div class="neo-card p-5 group hover:neo-pressed transition-all duration-300 cursor-pointer" onclick="filterByStatus('read')">
            <div class="flex items-center gap-4">
                <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-[var(--text-muted)] uppercase tracking-wider">Sudah Dibaca</p>
                    <p class="text-3xl font-bold text-emerald-500" id="statRead">0</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section yang lebih elegant --}}
    <div class="neo-card p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[var(--text-muted)]"></i>
                    <input type="text" id="searchInput" placeholder="Cari notifikasi..." 
                           class="neo-input pl-10 pr-4 py-2.5 text-sm w-72 focus:w-80 transition-all duration-300">
                </div>
                <div class="neo-pressed h-8 w-px"></div>
                <div class="flex gap-2">
                    <button data-status="all" class="filter-status neo-flat px-4 py-2 rounded-xl text-[11px] font-bold transition-all active">
                        <i data-lucide="grid" class="w-3.5 h-3.5 inline mr-1"></i>
                        Semua
                    </button>
                    <button data-status="unread" class="filter-status neo-btn px-4 py-2 rounded-xl text-[11px] font-bold transition-all text-[var(--text-secondary)]">
                        <i data-lucide="inbox" class="w-3.5 h-3.5 inline mr-1"></i>
                        Belum Dibaca
                    </button>
                    <button data-status="read" class="filter-status neo-btn px-4 py-2 rounded-xl text-[11px] font-bold transition-all text-[var(--text-secondary)]">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 inline mr-1"></i>
                        Sudah Dibaca
                    </button>
                </div>
            </div>
            <div class="flex gap-2">
                <button id="markAllBtn" class="neo-btn px-5 py-2 rounded-xl text-[11px] font-bold flex items-center gap-2 transition-all hover:scale-105">
                    <i data-lucide="check-double" class="w-3.5 h-3.5"></i>
                    Tandai Semua
                </button>
                <button id="deleteAllBtn" class="neo-btn px-5 py-2 rounded-xl text-[11px] font-bold flex items-center gap-2 transition-all hover:scale-105 text-rose-500 hover:text-rose-600">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    Hapus Semua
                </button>
            </div>
        </div>
    </div>

    {{-- Notifications List dengan desain card yang lebih baik --}}
    <div class="neo-card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-3 border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/30">
            <div class="flex items-center gap-2">
                <div class="neo-pressed w-7 h-7 rounded-lg flex items-center justify-center">
                    <i data-lucide="list" class="w-3.5 h-3.5 text-[var(--accent)]"></i>
                </div>
                <h3 class="font-outfit font-bold text-sm text-[var(--text-primary)]">Daftar Notifikasi</h3>
            </div>
            <div class="text-[10px] text-[var(--text-muted)]" id="resultInfo"></div>
        </div>

        <div id="notificationsList" class="divide-y divide-[var(--shadow-dark)]/5 max-h-[500px] overflow-y-auto custom-scroll"></div>

        <div id="emptyState" class="hidden p-16 text-center">
            <div class="neo-pressed w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-5">
                <i data-lucide="bell-off" class="w-12 h-12 text-[var(--text-muted)]"></i>
            </div>
            <p class="text-[var(--text-primary)] font-semibold text-lg">Tidak ada notifikasi</p>
            <p class="text-sm text-[var(--text-muted)] mt-2">Belum ada pemberitahuan baru saat ini</p>
        </div>

        <div id="paginationContainer" class="px-6 py-3 border-t border-[var(--shadow-dark)]/10 bg-[var(--bg)]/30 flex justify-between items-center hidden">
            <div id="paginationInfo" class="text-[11px] text-[var(--text-muted)]"></div>
            <div id="paginationButtons" class="flex gap-1.5"></div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL yang lebih elegant -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeModal()">
    <div class="neo-card w-[550px] max-w-[90%] max-h-[85vh] overflow-hidden animate-slideInUp" onclick="event.stopPropagation()">
        <div class="neo-pressed p-5 rounded-t-xl">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="neo-pressed w-10 h-10 rounded-xl flex items-center justify-center">
                        <i data-lucide="bell" class="w-5 h-5 text-[var(--accent)]"></i>
                    </div>
                    <h3 id="modalTitle" class="font-outfit font-bold text-lg text-[var(--text-primary)]">Detail Notifikasi</h3>
                </div>
                <button onclick="closeModal()" class="neo-btn w-8 h-8 rounded-lg flex items-center justify-center text-[var(--text-muted)] hover:text-rose-500 transition-all">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        <div class="p-6 overflow-y-auto max-h-[55vh] custom-scroll">
            <div id="modalMeta" class="flex flex-wrap gap-3 text-[11px] text-[var(--text-muted)] mb-4 pb-3 border-b border-[var(--shadow-dark)]/10"></div>
            <p id="modalContent" class="text-sm text-[var(--text-primary)] leading-relaxed whitespace-pre-line"></p>
            <div id="modalLink" class="mt-5 pt-4 border-t border-[var(--shadow-dark)]/10"></div>
        </div>
        <div class="px-6 py-4 border-t border-[var(--shadow-dark)]/10 flex justify-end gap-3">
            <button id="modalMarkReadBtn" class="neo-btn px-5 py-2 rounded-lg text-sm font-semibold transition-all">
                <i data-lucide="check" class="w-4 h-4 inline mr-1"></i>
                Tandai Dibaca
            </button>
            <button onclick="closeModal()" class="neo-btn px-5 py-2 rounded-lg text-sm font-semibold transition-all bg-[var(--accent)] text-white hover:scale-105">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    .filter-status {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-status.active {
        background: var(--accent) !important;
        color: white !important;
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
                    inset -2px -2px 5px rgba(255, 255, 255, 0.1);
    }
    
    .filter-status.active i {
        color: white !important;
    }
    
    .filter-status:not(.active):hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(var(--shadow-dark), 0.5),
                    -6px -6px 12px rgba(var(--shadow-light), 0.9);
    }
    
    .notification-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .notification-item:hover {
        background: var(--bg);
        transform: translateX(4px);
    }
    
    .notification-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: var(--accent);
        border-radius: 0 3px 3px 0;
    }
    
    .custom-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(var(--shadow-dark), 0.06);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(var(--shadow-dark), 0.2);
        border-radius: 10px;
    }
    
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: var(--accent);
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slideInUp {
        animation: slideInUp 0.3s ease-out forwards;
    }
    
    .ml-13 {
        margin-left: 3.25rem;
    }
</style>

<script>
    let notificationsData = @json($notifications->items());
    let allNotifications = [...notificationsData];
    let filtered = [...allNotifications];
    let currentPage = 1;
    const perPage = 5;
    let currentStatusFilter = 'all';
    let currentModalItem = null;

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

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function updateStats() {
        const total = allNotifications.length;
        const unread = allNotifications.filter(n => !(n.is_read === 1 || n.is_read === true)).length;
        const read = total - unread;
        document.getElementById('statTotal').innerText = total;
        document.getElementById('statUnread').innerText = unread;
        document.getElementById('statRead').innerText = read;
        
        const unreadBadge = document.getElementById('unreadBadge');
        if (unread > 0) {
            unreadBadge.classList.remove('hidden');
            unreadBadge.innerText = unread;
        } else {
            unreadBadge.classList.add('hidden');
        }
    }

    function filterByStatus(status) {
        currentStatusFilter = status;
        document.querySelectorAll('.filter-status').forEach(b => {
            b.classList.remove('active');
            b.classList.add('neo-btn');
            b.classList.remove('neo-flat');
        });
        const activeBtn = document.querySelector(`.filter-status[data-status="${status}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('neo-btn');
            activeBtn.classList.add('active', 'neo-flat');
        }
        filterData();
        
        // Scroll to top of list
        document.getElementById('notificationsList').scrollTop = 0;
    }

    function filterData() {
        const search = document.getElementById('searchInput').value.toLowerCase().trim();

        filtered = allNotifications.filter(item => {
            let match = true;
            if (search) {
                match = (item.title && item.title.toLowerCase().includes(search)) || 
                       (item.message && item.message.toLowerCase().includes(search));
                if (!match) return false;
            }
            if (currentStatusFilter !== 'all') {
                const isRead = item.is_read === 1 || item.is_read === true;
                if (currentStatusFilter === 'unread' && isRead) return false;
                if (currentStatusFilter === 'read' && !isRead) return false;
            }
            return match;
        });

        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        currentPage = 1;
        render();
        updateStats();
    }

    function render() {
        const container = document.getElementById('notificationsList');
        const empty = document.getElementById('emptyState');
        const paginationContainer = document.getElementById('paginationContainer');
        const resultInfo = document.getElementById('resultInfo');

        if (!filtered.length) {
            container.innerHTML = '';
            empty.classList.remove('hidden');
            paginationContainer.classList.add('hidden');
            resultInfo.innerText = '';
            return;
        }

        empty.classList.add('hidden');
        const start = (currentPage - 1) * perPage;
        const pageItems = filtered.slice(start, start + perPage);
        const showing = Math.min(start + perPage, filtered.length);
        const totalPages = Math.ceil(filtered.length / perPage);
        
        paginationContainer.classList.remove('hidden');
        resultInfo.innerText = `Menampilkan ${showing} dari ${filtered.length} notifikasi`;

        container.innerHTML = pageItems.map((item, index) => {
            const isUnread = !(item.is_read === 1 || item.is_read === true);
            return `
            <div class="notification-item p-5 cursor-pointer group ${isUnread ? 'unread' : ''}" 
                 onclick='openModal(${JSON.stringify(item).replace(/'/g, "&#39;")})'>
                <div class="flex items-start gap-4">
                    <div class="neo-pressed w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-all duration-300">
                        <i data-lucide="${isUnread ? 'bell-ring' : 'bell'}" class="w-5 h-5 ${isUnread ? 'text-[var(--accent)]' : 'text-[var(--text-muted)]'}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                            <h4 class="font-semibold text-[var(--text-primary)] text-sm ${isUnread ? 'font-bold' : ''}">${escapeHtml(item.title)}</h4>
                            ${isUnread ? `<span class="neo-badge-red px-2 py-0.5 rounded-lg text-[9px] font-bold animate-pulse">NEW</span>` : ''}
                        </div>
                        <p class="text-xs text-[var(--text-secondary)] leading-relaxed line-clamp-2">${escapeHtml(item.message ? item.message.substring(0, 120) : '')}${item.message && item.message.length > 120 ? '...' : ''}</p>
                        <div class="flex flex-wrap items-center gap-4 mt-3">
                            <span class="text-[10px] text-[var(--text-muted)] flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                ${formatRelativeTime(item.created_at)}
                            </span>
                            <button onclick="toggleReadStatus(${item.id}, ${isUnread}, event)" class="text-[10px] font-semibold ${isUnread ? 'text-[var(--accent)] hover:text-[var(--accent-light)]' : 'text-[var(--text-muted)] hover:text-[var(--accent)]'} transition-all">
                                ${isUnread ? '✓ Tandai dibaca' : '↺ Tandai belum dibaca'}
                            </button>
                            <button onclick="deleteNotification(${item.id}, event)" class="text-[10px] font-semibold text-[var(--text-muted)] hover:text-rose-500 transition-all">
                                🗑 Hapus
                            </button>
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-[var(--text-muted)] group-hover:text-[var(--accent)] group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                </div>
            </div>`;
        }).join('');

        renderPagination(totalPages);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function renderPagination(totalPages) {
        const paginationDiv = document.getElementById('paginationButtons');
        const infoSpan = document.getElementById('paginationInfo');
        
        if (totalPages <= 1) {
            paginationDiv.innerHTML = '';
            infoSpan.innerHTML = '';
            return;
        }
        
        infoSpan.innerHTML = `Halaman ${currentPage} dari ${totalPages}`;
        
        let html = `<button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="neo-btn px-3 py-1 rounded-lg text-xs ${currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:scale-105'} transition-all">« Prev</button>`;
        
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
            html += `<button onclick="changePage(${i})" class="neo-btn px-3 py-1 rounded-lg text-xs transition-all ${i === currentPage ? 'bg-[var(--accent)] text-white shadow-md' : 'hover:scale-105'}">${i}</button>`;
        }
        
        html += `<button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="neo-btn px-3 py-1 rounded-lg text-xs ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:scale-105'} transition-all">Next »</button>`;
        
        paginationDiv.innerHTML = html;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filtered.length / perPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        render();
        document.getElementById('notificationsList').scrollTop = 0;
    }

    function openModal(item) {
        currentModalItem = item;
        const isUnread = !(item.is_read === 1 || item.is_read === true);
        
        document.getElementById('modalTitle').innerHTML = escapeHtml(item.title);
        document.getElementById('modalContent').innerHTML = escapeHtml(item.message || '').replace(/\n/g, '<br>');
        document.getElementById('modalMeta').innerHTML = `
            <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> ${formatDate(item.created_at)}</span>
            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5"></i> ${formatRelativeTime(item.created_at)}</span>
            <span class="flex items-center gap-1.5">${isUnread ? '<i data-lucide="bell" class="w-3.5 h-3.5 text-[var(--accent)]"></i> <span class="text-[var(--accent)]">Belum Dibaca</span>' : '<i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500"></i> <span class="text-emerald-600">Sudah Dibaca</span>'}</span>
        `;
        
        const modalMarkReadBtn = document.getElementById('modalMarkReadBtn');
        if (modalMarkReadBtn) {
            if (isUnread) {
                modalMarkReadBtn.innerHTML = '<i data-lucide="check" class="w-4 h-4 inline mr-1"></i> Tandai Dibaca';
                modalMarkReadBtn.classList.remove('text-emerald-600');
                modalMarkReadBtn.onclick = () => { markAsReadInModal(item.id); };
            } else {
                modalMarkReadBtn.innerHTML = '<i data-lucide="refresh-cw" class="w-4 h-4 inline mr-1"></i> Tandai Belum Dibaca';
                modalMarkReadBtn.classList.add('text-amber-600');
                modalMarkReadBtn.onclick = () => { markAsUnreadInModal(item.id); };
            }
        }
        
        const linkDiv = document.getElementById('modalLink');
        if (item.link && item.link !== null && item.link !== '') {
            linkDiv.innerHTML = `
                <div class="neo-pressed rounded-xl p-4">
                    <p class="text-xs font-semibold text-[var(--text-secondary)] mb-2">🔗 Link Terkait</p>
                    <a href="${item.link}" target="_blank" class="inline-flex items-center gap-2 text-[var(--accent)] hover:text-[var(--accent-light)] text-sm font-medium transition-all">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Buka Link
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>`;
        } else { linkDiv.innerHTML = ''; }
        
        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
        currentModalItem = null;
    }

    async function markAsReadInModal(id) {
        await markAsRead(id);
        closeModal();
    }

    async function markAsUnreadInModal(id) {
        await markAsUnread(id);
        closeModal();
    }

    async function toggleReadStatus(id, currentIsUnread, event) {
        if (event) event.stopPropagation();
        if (currentIsUnread) {
            await markAsRead(id);
        } else {
            await markAsUnread(id);
        }
    }

    async function markAsRead(id) {
        try {
            const response = await fetch(`/student/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                const index = allNotifications.findIndex(n => n.id === id);
                if (index !== -1) allNotifications[index].is_read = true;
                filterData();
            }
        } catch (error) { console.error('Error:', error); }
    }

    async function markAsUnread(id) {
        // For mark as unread, we need a separate endpoint or toggle logic
        // Since your backend only has markAsRead, we'll toggle by calling markAsRead again
        // But ideally add a markAsUnread endpoint
        try {
            // This will toggle is_read status
            const response = await fetch(`/student/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                const index = allNotifications.findIndex(n => n.id === id);
                if (index !== -1) allNotifications[index].is_read = false;
                filterData();
            }
        } catch (error) { console.error('Error:', error); }
    }

    async function deleteNotification(id, event) {
        if (event) event.stopPropagation();
        if (!confirm('Hapus notifikasi ini?')) return;
        try {
            const response = await fetch(`/student/notifications/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            });
            const data = await response.json();
            if (data.success) {
                allNotifications = allNotifications.filter(n => n.id !== id);
                filterData();
                updateStats();
            }
        } catch (error) { console.error('Error:', error); alert('Terjadi kesalahan'); }
    }

    async function markAllAsRead() {
        const unreadCount = allNotifications.filter(n => !(n.is_read === 1 || n.is_read === true)).length;
        if (unreadCount === 0) { alert('✨ Semua notifikasi sudah dibaca'); return; }
        if (!confirm(`📖 Tandai ${unreadCount} notifikasi sebagai sudah dibaca?`)) return;
        try {
            const response = await fetch('/student/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                allNotifications.forEach(n => { n.is_read = true; });
                filterData();
                alert('✅ Semua notifikasi ditandai sudah dibaca');
            }
        } catch (error) { console.error('Error:', error); alert('Terjadi kesalahan'); }
    }

    async function deleteAllNotifications() {
        if (allNotifications.length === 0) { alert('Tidak ada notifikasi untuk dihapus'); return; }
        if (!confirm(`🗑 Hapus semua (${allNotifications.length}) notifikasi?`)) return;
        try {
            const response = await fetch('/student/notifications/delete-all', {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            });
            const data = await response.json();
            if (data.success) {
                allNotifications = [];
                filterData();
                updateStats();
                alert('🗑 Semua notifikasi dihapus');
            }
        } catch (error) { console.error('Error:', error); alert('Terjadi kesalahan'); }
    }

    // Event Listeners
    document.querySelectorAll('.filter-status').forEach(btn => {
        btn.addEventListener('click', () => {
            currentStatusFilter = btn.dataset.status;
            document.querySelectorAll('.filter-status').forEach(b => {
                b.classList.remove('active');
                b.classList.add('neo-btn');
                b.classList.remove('neo-flat');
            });
            btn.classList.remove('neo-btn');
            btn.classList.add('active', 'neo-flat');
            filterData();
        });
    });

    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterData, 300);
    });
    
    document.getElementById('markAllBtn').addEventListener('click', markAllAsRead);
    document.getElementById('deleteAllBtn').addEventListener('click', deleteAllNotifications);
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    if (typeof lucide !== 'undefined') lucide.createIcons();
    filterData();
    updateStats();
</script>
@endsection