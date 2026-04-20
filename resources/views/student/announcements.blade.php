@extends('layouts.student')

@section('title', 'Pengumuman')

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
        
        <!-- Header Modern -->
        <div class="mb-6 animate-fadeInUp">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-900 via-indigo-800 to-purple-800 bg-clip-text text-transparent">
                            Pengumuman
                        </h1>
                        <p class="text-slate-500 text-xs">Informasi dan pengumuman penting untukmu</p>
                    </div>
                </div>
                
                <!-- Statistik -->
                <div class="glass-card rounded-xl px-3 py-1.5 shadow-sm">
                    <div class="text-xs text-slate-500">Total</div>
                    <div class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" id="totalCount">0</div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-6">
            
            <!-- FILTER - Glassmorphism Sidebar -->
            <div class="lg:col-span-3 animate-slideInLeft">
                <div class="glass-card rounded-xl shadow-lg overflow-hidden sticky top-6">
                    
                    <div class="px-4 py-3 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border-b">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h3 class="font-bold text-slate-800 text-sm">Filter Pengumuman</h3>
                        </div>
                    </div>

                    <div class="p-4 space-y-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Cari</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Cari judul atau isi..."
                                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>

                        <!-- Filter Kelas -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kelas</label>
                            <select id="classFilter" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                                <option value="all">Semua Kelas</option>
                                @foreach($classes ?? [] as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-400 mt-1">Pengumuman untuk semua kelas juga akan muncul</p>
                        </div>

                        <!-- Filter Waktu -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Waktu</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button data-date="all" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all bg-indigo-600 text-white shadow-sm">Semua</button>
                                <button data-date="week" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all bg-slate-100 text-slate-700 hover:bg-slate-200">7 Hari</button>
                                <button data-date="month" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all bg-slate-100 text-slate-700 hover:bg-slate-200">30 Hari</button>
                                <button data-date="3months" class="date-filter-btn px-2 py-1.5 rounded-lg text-xs font-medium transition-all bg-slate-100 text-slate-700 hover:bg-slate-200">3 Bulan</button>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <button id="resetFilter" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold">
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
                <div class="glass-card rounded-xl shadow-lg overflow-hidden">
                    
                    <div class="px-4 py-3 bg-gradient-to-r from-slate-50 to-indigo-50/50 border-b">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm">Daftar Pengumuman</h3>
                            </div>
                            <div class="text-xs text-slate-500">
                                Menampilkan <span id="showingCount">0</span> dari <span id="totalFiltered">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loadingState" class="hidden p-8 text-center">
                        <div class="inline-block">
                            <div class="w-8 h-8 border-3 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Memuat pengumuman...</p>
                    </div>

                    <!-- List Container -->
                    <div id="announcementList" class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto custom-scroll"></div>

                    <!-- Empty State -->
                    <div id="emptyState" class="hidden p-8 text-center">
                        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">Tidak ada pengumuman</p>
                        <p class="text-xs text-slate-400 mt-1">Coba ubah filter atau cari dengan kata kunci berbeda</p>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 py-3 bg-slate-50/50 border-t flex justify-between items-center">
                        <div id="paginationInfo" class="text-xs text-slate-600"></div>
                        <div id="paginationButtons" class="flex gap-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL -->
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
    if (!fileName) return '';
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
        <div class="announcement-card p-3 cursor-pointer group" 
             style="animation: fadeIn 0.3s ease-out ${index * 0.03}s forwards; opacity: 0;"
             onclick='openModal(${JSON.stringify(item).replace(/'/g, "&#39;")})'>
            
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex flex-wrap gap-1.5 mb-2">
                        ${item.target === 'all' ? 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Semua Kelas
                            </span>` : 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                ${item.class_target || 'Kelas Tertentu'}
                            </span>`
                        }
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ${formatRelativeTime(item.created_at)}
                        </span>
                        ${item.file ? 
                            `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                </svg>
                                Lampiran
                            </span>` : ''
                        }
                    </div>
                    
                    <h4 class="font-semibold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors">
                        ${escapeHtml(item.title)}
                    </h4>
                    
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                        ${escapeHtml(item.content.substring(0, 120))}${item.content.length > 120 ? '...' : ''}
                    </p>
                </div>
                
                <svg class="w-4 h-4 text-slate-300 group-hover:text-indigo-500 transition-colors flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    html += `<button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === 1 ? 'text-slate-300 cursor-not-allowed' : 'text-indigo-600 hover:bg-indigo-50'}">«</button>`;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        html += `<button onclick="changePage(1)" class="px-2 py-0.5 rounded text-xs hover:bg-indigo-50">1</button>`;
        if (startPage > 2) html += `<span class="px-1 text-xs">...</span>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `<button onclick="changePage(${i})" class="px-2 py-0.5 rounded text-xs ${i === currentPage ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 text-slate-700'}">${i}</button>`;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) html += `<span class="px-1 text-xs">...</span>`;
        html += `<button onclick="changePage(${totalPages})" class="px-2 py-0.5 rounded text-xs hover:bg-indigo-50">${totalPages}</button>`;
    }
    
    html += `<button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="px-2 py-0.5 rounded text-xs ${currentPage === totalPages ? 'text-slate-300 cursor-not-allowed' : 'text-indigo-600 hover:bg-indigo-50'}">»</button>`;
    
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
        ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
        : '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>';
    
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
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-3">
                <p class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                    </svg>
                    Lampiran
                </p>
                <a href="${fileUrl}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-xs bg-white px-3 py-1.5 rounded-lg hover:shadow-md transition-all border border-indigo-200">
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
        if(modalInner) modalInner.classList.remove('scale-95', 'opacity-0');
        modalInner.classList.add('scale-100', 'opacity-100');
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
            b.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
            b.classList.add('bg-slate-100', 'text-slate-700');
        });
        btn.classList.remove('bg-slate-100', 'text-slate-700');
        btn.classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
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
        b.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
        b.classList.add('bg-slate-100', 'text-slate-700');
    });
    document.querySelector('[data-date="all"]').classList.remove('bg-slate-100', 'text-slate-700');
    document.querySelector('[data-date="all"]').classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
    filterData();
});

// Initial render
filterData();
</script>
@endsection