@extends('layouts.student')

@section('title', 'Notifikasi - Scholify')

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
    
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
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
    
    /* Notification item hover */
    .notification-item {
        transition: all 0.2s ease;
    }
    
    .notification-item:hover {
        transform: translateX(4px);
        background: linear-gradient(135deg, #EEF2FF 0%, #FFFFFF 100%);
    }
    
    .filter-btn {
        transition: all 0.25s ease;
        font-family: 'Outfit', sans-serif;
    }
    
    .filter-btn.active {
        background: #4318FF;
        color: white;
        box-shadow: 0 4px 12px rgba(67, 24, 255, 0.2);
    }
</style>

<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    <div class="space-y-5">
        
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">NOTIFICATION CENTER</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Pusat <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Notifikasi</span></h1>
                <p class="text-[#A3AED0] text-base">Semua pemberitahuan dan aktivitas terbaru Anda.</p>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="flex gap-3">
                <button onclick="markAllAsRead()" id="markAllBtn" class="group relative bg-white border border-gray-200 text-[#4318FF] font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-gray-50 hover:border-[#4318FF]/30 transition-all duration-300 shadow-sm overflow-hidden">
                    <i data-lucide="check-double" class="w-4 h-4 relative z-10"></i>
                    <span class="relative z-10">Tandai Semua</span>
                </button>
                <button onclick="deleteAllNotifications()" id="deleteAllBtn" class="group relative bg-white border border-gray-200 text-red-600 font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-red-50 hover:border-red-300 transition-all duration-300 shadow-sm overflow-hidden">
                    <i data-lucide="trash-2" class="w-4 h-4 relative z-10"></i>
                    <span class="relative z-10">Hapus Semua</span>
                </button>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-6 border-b border-[#E0E5F2] pb-3">
            <button onclick="filterNotifications('all')" class="filter-btn px-5 py-2 rounded-xl text-sm font-bold transition-all bg-[#F4F7FE] text-[#2B3674] hover:bg-[#E0E5F2] active" data-filter="all" id="filterAll">
                Semua
                <span class="ml-2 px-2 py-0.5 bg-white rounded-full text-xs" id="totalCount">{{ $notifications->total() }}</span>
            </button>
            <button onclick="filterNotifications('unread')" class="filter-btn px-5 py-2 rounded-xl text-sm font-bold transition-all bg-[#F4F7FE] text-[#2B3674] hover:bg-[#E0E5F2]" data-filter="unread" id="filterUnread">
                Belum Dibaca
                <span class="ml-2 px-2 py-0.5 bg-white rounded-full text-xs" id="unreadCount">{{ $notifications->where('is_read', false)->count() }}</span>
            </button>
            <button onclick="filterNotifications('read')" class="filter-btn px-5 py-2 rounded-xl text-sm font-bold transition-all bg-[#F4F7FE] text-[#2B3674] hover:bg-[#E0E5F2]" data-filter="read" id="filterRead">
                Sudah Dibaca
                <span class="ml-2 px-2 py-0.5 bg-white rounded-full text-xs">{{ $notifications->where('is_read', true)->count() }}</span>
            </button>
        </div>

        <!-- Notifications List -->
        <div id="notificationsContainer" class="space-y-3">
            @forelse($notifications as $notif)
                <div class="notification-item bg-white rounded-2xl border border-[#E0E5F2] p-5 transition-all {{ !$notif->is_read ? 'border-l-4 border-l-[#4318FF] bg-gradient-to-r from-white via-white to-indigo-50/20' : 'hover:bg-[#F4F7FE]/30' }}" 
                     data-id="{{ $notif->id }}"
                     data-status="{{ $notif->is_read ? 'read' : 'unread' }}">
                    <div class="flex gap-4">
                        <!-- Icon Section -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ !$notif->is_read ? 'bg-[#4318FF]/10 text-[#4318FF]' : 'bg-[#F4F7FE] text-[#A3AED0]' }}">
                                <i data-lucide="bell" class="w-6 h-6"></i>
                            </div>
                        </div>
                        
                        <!-- Content Section -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                <h3 class="font-outfit font-bold text-base {{ !$notif->is_read ? 'text-[#2B3674]' : 'text-[#A3AED0]' }}">
                                    {{ $notif->title }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    @if(!$notif->is_read)
                                        <span class="px-2 py-1 bg-[#4318FF]/10 text-[#4318FF] text-xs rounded-full font-bold">Baru</span>
                                    @endif
                                    <span class="text-xs text-[#A3AED0] whitespace-nowrap font-medium">
                                        <i data-lucide="clock" class="w-3 h-3 inline mr-1"></i>
                                        {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            
                            <p class="text-[#2B3674]/70 text-sm mb-3 leading-relaxed">{{ $notif->message }}</p>
                            
                            <div class="flex items-center gap-3 flex-wrap">
                                @if($notif->link)
                                    <a href="{{ $notif->link }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#4318FF] hover:text-[#3412cc] transition-colors">
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        Lihat Detail
                                    </a>
                                @endif
                                
                                @if(!$notif->is_read)
                                    <button onclick="markAsRead({{ $notif->id }}, this)" class="text-xs text-[#A3AED0] hover:text-[#4318FF] font-bold transition flex items-center gap-1">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                                        Tandai dibaca
                                    </button>
                                @endif
                                
                                <button onclick="deleteNotification({{ $notif->id }}, this)" class="text-xs text-[#A3AED0] hover:text-red-500 font-bold transition flex items-center gap-1">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="relative rounded-2xl p-16 text-center bg-white border border-gray-100 mt-6 overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#4318FF]/5 to-[#9F7AEA]/5 rounded-full blur-3xl"></div>
                    <div class="relative">
                        <div class="relative w-24 h-24 mx-auto mb-6">
                            <div class="absolute inset-0 bg-[#4318FF]/10 rounded-full blur-xl opacity-60"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-[#4318FF] to-[#9F7AEA] rounded-2xl flex items-center justify-center shadow-lg">
                                <i data-lucide="bell-off" class="w-10 h-10 text-white"></i>
                            </div>
                        </div>
                        <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">Tidak ada notifikasi</h2>
                        <p class="text-[#A3AED0] max-w-md mx-auto">Belum ada pemberitahuan baru saat ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Info jumlah notifikasi -->
        @if($notifications->count() > 0)
            <div class="mt-6 pt-4 text-center text-sm text-slate-400 border-t border-slate-100">
                <span class="inline-flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    Total {{ $notifications->total() }} notifikasi
                </span>
            </div>
        @endif

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    let currentFilter = 'all';
    
    // Update counters
    function updateCounters() {
        const totalNotif = document.querySelectorAll('.notification-item').length;
        const unreadNotif = document.querySelectorAll('.notification-item[data-status="unread"]').length;
        const readNotif = totalNotif - unreadNotif;
        
        const totalCountSpan = document.getElementById('totalCount');
        const unreadCountSpan = document.getElementById('unreadCount');
        const filterReadBtn = document.getElementById('filterRead');
        
        if(totalCountSpan) totalCountSpan.textContent = totalNotif;
        if(unreadCountSpan) unreadCountSpan.textContent = unreadNotif;
        if(filterReadBtn) {
            const readSpan = filterReadBtn.querySelector('span:last-child');
            if(readSpan) readSpan.textContent = readNotif;
        }
        
        const markAllBtn = document.getElementById('markAllBtn');
        if(markAllBtn) {
            markAllBtn.disabled = (unreadNotif === 0);
            markAllBtn.style.opacity = (unreadNotif === 0) ? '0.5' : '1';
            markAllBtn.style.cursor = (unreadNotif === 0) ? 'not-allowed' : 'pointer';
        }
    }
    
    // Filter notifications
    function filterNotifications(filter) {
        currentFilter = filter;
        const notifications = document.querySelectorAll('.notification-item');
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        let activeBtn;
        if(filter === 'all') activeBtn = document.getElementById('filterAll');
        else if(filter === 'unread') activeBtn = document.getElementById('filterUnread');
        else activeBtn = document.getElementById('filterRead');
        
        if(activeBtn) activeBtn.classList.add('active');
        
        notifications.forEach(notif => {
            if(filter === 'all') {
                notif.style.display = 'flex';
            } else {
                const status = notif.getAttribute('data-status');
                notif.style.display = status === filter ? 'flex' : 'none';
            }
        });
    }
    
    // Mark as read
    function markAsRead(id, element) {
        fetch(`/student/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
          .then(data => {
              if(data.success) {
                  const notification = element.closest('.notification-item');
                  notification.classList.remove('border-l-4', 'border-l-[#4318FF]', 'bg-gradient-to-r', 'from-white', 'via-white', 'to-indigo-50/20');
                  
                  const badge = notification.querySelector('.bg-[#4318FF]/10');
                  if(badge) badge.remove();
                  
                  element.remove();
                  
                  const iconDiv = notification.querySelector('.flex-shrink-0 > div');
                  if(iconDiv) {
                      iconDiv.classList.remove('bg-[#4318FF]/10', 'text-[#4318FF]');
                      iconDiv.classList.add('bg-[#F4F7FE]', 'text-[#A3AED0]');
                  }
                  
                  const title = notification.querySelector('h3');
                  if(title) {
                      title.classList.remove('text-[#2B3674]');
                      title.classList.add('text-[#A3AED0]');
                  }
                  
                  notification.setAttribute('data-status', 'read');
                  updateCounters();
                  
                  if(currentFilter === 'unread') {
                      notification.style.display = 'none';
                  }
                  
                  alert('Notifikasi ditandai sudah dibaca');
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Terjadi kesalahan, silakan coba lagi');
          });
    }
    
    // Mark all as read
    function markAllAsRead() {
        const unreadCount = parseInt(document.getElementById('unreadCount')?.textContent || '0');
        if(unreadCount === 0) {
            alert('Tidak ada notifikasi yang belum dibaca');
            return;
        }
        
        if(!confirm('Tandai semua notifikasi sebagai sudah dibaca?')) return;
        
        fetch('/student/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
          .then(data => {
              if(data.success) {
                  location.reload();
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Terjadi kesalahan, silakan coba lagi');
          });
    }
    
    // Delete single notification
    function deleteNotification(id, element) {
        if(!confirm('Hapus notifikasi ini?')) return;
        
        fetch(`/student/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(res => res.json())
          .then(data => {
              if(data.success) {
                  const notification = element.closest('.notification-item');
                  notification.remove();
                  updateCounters();
                  alert('Notifikasi dihapus');
                  
                  if(document.querySelectorAll('.notification-item').length === 0) {
                      location.reload();
                  }
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Terjadi kesalahan, silakan coba lagi');
          });
    }
    
    // Delete all notifications
    function deleteAllNotifications() {
        const totalCount = document.querySelectorAll('.notification-item').length;
        if(totalCount === 0) {
            alert('Tidak ada notifikasi untuk dihapus');
            return;
        }
        
        if(!confirm(`Hapus semua (${totalCount}) notifikasi?`)) return;
        
        fetch('/student/notifications/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(res => res.json())
          .then(data => {
              if(data.success) {
                  alert('Semua notifikasi dihapus');
                  location.reload();
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('Terjadi kesalahan, silakan coba lagi');
          });
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCounters();
    });
</script>
@endsection