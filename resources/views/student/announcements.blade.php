@extends('layouts.student')

@section('title', 'Pengumuman - Schoolify')

@section('content')
<style>
    /* Font & Base - SAMA DENGAN HALAMAN LAIN */
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
    
    @keyframes modalPop {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
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
    
    .animate-modalPop {
        animation: modalPop 0.2s ease-out forwards;
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
    
    /* Announcement card hover */
    .announcement-card {
        transition: all 0.25s ease;
    }
    
    .announcement-card:hover {
        background: linear-gradient(90deg, rgba(67, 24, 255, 0.02) 0%, rgba(159, 122, 234, 0.02) 100%);
        transform: translateX(4px);
    }
</style>

<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    <div class="space-y-5">
        
        <!-- Header Section Premium - SAMA DENGAN HALAMAN LAIN -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">ANNOUNCEMENT DASHBOARD</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Pengumuman <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Sekolah</span></h1>
                <p class="text-[#A3AED0] text-base">Informasi dan pengumuman penting untukmu</p>
            </div>
            
            <!-- Statistik Total -->
            <div class="relative flex-shrink-0">
                <div class="bg-white border border-gray-200 px-5 py-2.5 rounded-xl shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="text-sm font-semibold text-[#2B3674]">Total <span id="totalCount">0</span> Pengumuman</span>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-6">
            
            <!-- FILTER SIDEBAR -->
            <div class="lg:col-span-3 animate-slideInLeft">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm sticky top-6">
                    
                    <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h3 class="font-bold text-[#2B3674] text-sm">Filter Pengumuman</h3>
                        </div>
                    </div>

                    <div class="p-4 space-y-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold text-[#A3AED0] mb-1 uppercase tracking-wide">Cari</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Cari judul atau isi..."
                                       class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4318FF] focus:ring-1 focus:ring-[#4318FF]/20 text-sm">
                            </div>
                        </div>

                        <!-- Filter Kelas -->
                        <div>
                            <label class="block text-xs font-semibold text-[#A3AED0] mb-1 uppercase tracking-wide">Kelas</label>
                            <select id="classFilter" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4318FF] focus:ring-1 focus:ring-[#4318FF]/20 text-sm">
                                <option value="all">Semua Kelas</option>
                                @foreach($classes ?? [] as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-[#A3AED0] mt-1">Pengumuman untuk semua kelas juga akan muncul</p>
                        </div>

                        <!-- Filter Waktu -->
                        <div>
                            <label class="block text-xs font-semibold text-[#A3AED0] mb-2 uppercase tracking-wide">Waktu</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button data-date="all" class="date-filter-btn px-2 py-1.5 rounded-xl text-xs font-medium transition-all bg-[#4318FF] text-white shadow-sm">Semua</button>
                                <button data-date="week" class="date-filter-btn px-2 py-1.5 rounded-xl text-xs font-medium transition-all bg-gray-100 text-[#2B3674] hover:bg-gray-200">7 Hari</button>
                                <button data-date="month" class="date-filter-btn px-2 py-1.5 rounded-xl text-xs font-medium transition-all bg-gray-100 text-[#2B3674] hover:bg-gray-200">30 Hari</button>
                                <button data-date="3months" class="date-filter-btn px-2 py-1.5 rounded-xl text-xs font-medium transition-all bg-gray-100 text-[#2B3674] hover:bg-gray-200">3 Bulan</button>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <button id="resetFilter" class="w-full bg-gray-100 hover:bg-gray-200 text-[#2B3674] py-2 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold">
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
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                    
                    <div class="px-5 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-[#2B3674] text-sm">Daftar Pengumuman</h3>
                            </div>
                            <div class="text-xs text-[#A3AED0]">
                                Menampilkan <span id="showingCount">0</span> dari <span id="totalFiltered">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loadingState" class="hidden p-8 text-center">
                        <div class="inline-block">
                            <div class="w-8 h-8 border-2 border-indigo-200 border-t-[#4318FF] rounded-full animate-spin"></div>
                        </div>
                        <p class="mt-2 text-xs text-[#A3AED0]">Memuat pengumuman...</p>
                    </div>

                    <!-- List Container -->
                    <div id="announcementList" class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto custom-scroll"></div>

                    <!-- Empty State -->
                    <div id="emptyState" class="hidden p-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <p class="text-[#2B3674] text-sm font-medium">Tidak ada pengumuman</p>
                        <p class="text-xs text-[#A3AED0] mt-1">Coba ubah filter atau cari dengan kata kunci berbeda</p>
                    </div>

                    <!-- Pagination -->
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/30 flex justify-between items-center">
                        <div id="paginationInfo" class="text-xs text-[#A3AED0]"></div>
                        <div id="paginationButtons" class="flex gap-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="detailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="closeModal()">
    <div class="bg-white rounded-2xl w-full max-w-md transform transition-all scale-95 opacity-0 shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
        <div class="relative bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] px-5 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 id="modalTitle" class="font-bold text-white text-base">Detail Pengumuman</h3>
                    <p id="modalSubtitle" class="text-white/80 text-xs mt-0.5">Informasi lengkap</p>
                </div>
                <button onclick="closeModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-5 overflow-y-auto max-h-[60vh] space-y-4">
            <div id="modalMeta" class="flex flex-wrap gap-2 text-xs text-[#A3AED0] pb-2 border-b border-gray-100"></div>
            <p id="modalContent" class="text-[#2B3674] text-sm leading-relaxed whitespace-pre-line"></p>
            <div id="modalFile" class="mt-2"></div>
        </div>
        
        <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/30 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-1.5 bg-[#4318FF] hover:bg-[#3520d1] text-white rounded-lg text-sm font-semibold transition-all">
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

// Format tanggal Indonesia
function formatDate(dateString) {
    const date = new Date(dateString);
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()} • ${date.getHours().toString().padStart(2,'0')}:${date.getMinutes().toString().padStart(2,'0')}`;
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
    if (!fileName) return '📎';
    const ext = fileName.split('.').pop().toLowerCase();
    const icons = {
        'pdf': '📄', 'doc': '📘', 'docx': '📘', 'xls': '📊', 'xlsx': '📊',
        'ppt': '📽️', 'pptx': '📽️', 'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️',
        'gif': '🖼️', 'zip': '📦', 'rar': '📦', 'txt': '📝'
    };
    return icons[ext] || '📎';
}

function filterData() {
    const search = document.getElementById('searchInput').value.toLowerCase().trim();
    const kelas = document.getElementById('classFilter').value;

    filtered = data.filter(item => {
        let match = true;

        if (search) {
            match = item.title.toLowerCase().includes(search) || 
                    item.content.toLowerCase().includes(search);
            if (!match) return false;
        }

        if (kelas !== 'all') {
            match = (item.target === 'all') || 
                    (item.class_target && item.class_target.includes(kelas));
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
    const loading = document.getElementById('loadingState');
    
    loading.classList.add('hidden');
    
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
        <div class="announcement-card p-4 cursor-pointer transition-all duration-200" 
             style="animation: fadeIn 0.3s ease-out ${index * 0.03}s forwards; opacity: 0;"
             onclick='openModal(${JSON.stringify(item).replace(/'/g, "&#39;")})'>
            
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex flex-wrap gap-1.5 mb-2">
                        ${item.target === 'all' ? 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Semua Kelas
                            </span>` : 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                ${item.class_target || 'Kelas Tertentu'}
                            </span>`
                        }
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium bg-gray-100 text-[#A3AED0]">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ${formatRelativeTime(item.created_at)}
                        </span>
                        ${item.file ? 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-medium bg-purple-50 text-purple-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                </svg>
                                Lampiran
                            </span>` : ''
                        }
                    </div>
                    
                    <h4 class="font-semibold text-[#2B3674] text-sm group-hover:text-[#4318FF] transition-colors">
                        ${escapeHtml(item.title)}
                    </h4>
                    
                    <p class="text-xs text-[#A3AED0] mt-1 line-clamp-2">
                        ${escapeHtml(item.content.substring(0, 120))}${item.content.length > 120 ? '...' : ''}
                    </p>
                </div>
                
                <svg class="w-4 h-4 text-[#A3AED0] group-hover:text-[#4318FF] transition-colors flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    
    if (totalPages <= 1) {
        paginationDiv.innerHTML = '';
        infoSpan.innerHTML = '';
        return;
    }
    
    infoSpan.innerHTML = `Halaman ${currentPage} dari ${totalPages}`;
    
    let html = '';
    html += `<button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === 1 ? 'text-[#A3AED0] cursor-not-allowed' : 'text-[#4318FF] hover:bg-indigo-50'}">«</button>`;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        html += `<button onclick="changePage(1)" class="px-2 py-0.5 rounded text-xs hover:bg-indigo-50 text-[#2B3674]">1</button>`;
        if (startPage > 2) html += `<span class="px-1 text-xs text-[#A3AED0]">...</span>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `<button onclick="changePage(${i})" class="px-2 py-0.5 rounded text-xs ${i === currentPage ? 'bg-[#4318FF] text-white' : 'hover:bg-indigo-50 text-[#2B3674]'}">${i}</button>`;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) html += `<span class="px-1 text-xs text-[#A3AED0]">...</span>`;
        html += `<button onclick="changePage(${totalPages})" class="px-2 py-0.5 rounded text-xs hover:bg-indigo-50 text-[#2B3674]">${totalPages}</button>`;
    }
    
    html += `<button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === totalPages ? 'text-[#A3AED0] cursor-not-allowed' : 'text-[#4318FF] hover:bg-indigo-50'}">»</button>`;
    
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
    const modalInner = modal.querySelector('.bg-white');
    
    document.getElementById('modalTitle').innerHTML = item.title;
    document.getElementById('modalContent').innerHTML = escapeHtml(item.content).replace(/\n/g, '<br>');
    
    const targetIcon = item.target === 'all' 
        ? '<svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
        : '<svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>';
    
    document.getElementById('modalMeta').innerHTML = `
        <span class="inline-flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            ${formatDate(item.created_at)}
        </span>
        <span class="inline-flex items-center gap-1">${targetIcon} ${item.target === 'all' ? 'Semua Kelas' : 'Kelas ' + (item.class_target || 'Tertentu')}</span>
    `;
    
    const fileDiv = document.getElementById('modalFile');
    if (item.file && item.file !== null && item.file !== '') {
        const fileUrl = getFileUrl(item.file);
        const fileName = item.file.split('/').pop();
        const fileIcon = getFileIcon(fileName);
        
        fileDiv.innerHTML = `
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-3">
                <p class="text-xs font-semibold text-[#2B3674] mb-2 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-[#4318FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                    </svg>
                    Lampiran
                </p>
                <a href="${fileUrl}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 text-[#4318FF] hover:text-[#3520d1] text-xs bg-white px-3 py-1.5 rounded-lg hover:shadow-md transition-all border border-indigo-200">
                    <span>${fileIcon}</span>
                    <span class="flex-1">${escapeHtml(fileName)}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </a>
            </div>
        `;
    } else {
        fileDiv.innerHTML = '';
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        if(modalInner) {
            modalInner.classList.remove('scale-95', 'opacity-0');
            modalInner.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('detailModal');
    const modalInner = modal.querySelector('.bg-white');
    if(modalInner) {
        modalInner.classList.remove('scale-100', 'opacity-100');
        modalInner.classList.add('scale-95', 'opacity-0');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Date filter buttons
document.querySelectorAll('.date-filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        currentDateFilter = btn.dataset.date;
        document.querySelectorAll('.date-filter-btn').forEach(b => {
            b.classList.remove('bg-[#4318FF]', 'text-white', 'shadow-sm');
            b.classList.add('bg-gray-100', 'text-[#2B3674]');
        });
        btn.classList.remove('bg-gray-100', 'text-[#2B3674]');
        btn.classList.add('bg-[#4318FF]', 'text-white', 'shadow-sm');
        filterData();
    });
});

// Event listeners
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
        b.classList.remove('bg-[#4318FF]', 'text-white', 'shadow-sm');
        b.classList.add('bg-gray-100', 'text-[#2B3674]');
    });
    document.querySelector('[data-date="all"]').classList.remove('bg-gray-100', 'text-[#2B3674]');
    document.querySelector('[data-date="all"]').classList.add('bg-[#4318FF]', 'text-white', 'shadow-sm');
    filterData();
});

// Initial render
filterData();
</script>
@endsection