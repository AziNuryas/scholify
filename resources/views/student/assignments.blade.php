@extends('layouts.student')

@section('title', 'Tugas - Schoolify')

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
    .task-card {
        transition: all 0.25s ease;
    }
    
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        background: #fafbff;
    }
    
    /* Task completed style */
    .task-card.completed {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.04) 0%, rgba(16, 185, 129, 0.01) 100%);
        border-left: 3px solid #10B981;
    }
    
    .task-card.completed h3 {
        text-decoration: line-through;
        opacity: 0.6;
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
    
    /* Filter button */
    .filter-btn {
        transition: all 0.2s ease;
        font-size: 0.8125rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    .filter-btn.active {
        background: #8B5CF6;
        color: white;
        border-color: transparent;
        box-shadow: 0 1px 2px rgba(139, 92, 246, 0.2);
    }
    
    /* Badge styles - Soft pastel colors */
    .badge {
        font-size: 0.6875rem;
        font-weight: 500;
        padding: 0.25rem 0.625rem;
        border-radius: 0.5rem;
        letter-spacing: -0.01em;
    }
    
    /* Button action */
    .btn-action {
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: scale(1.05);
    }
</style>

{{-- PERUBAHAN 1: padding top dikurangi dari p-5 menjadi pt-2 px-5 pb-5 --}}
<div class="pt-2 px-5 pb-5 max-w-7xl mx-auto">
    {{-- PERUBAHAN 2: jarak antar elemen dikurangi dari space-y-6 menjadi space-y-4 --}}
    <div class="space-y-4">
        
        {{-- PERUBAHAN 3: header digeser ke atas dengan -mt-1 --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 animate-fadeIn -mt-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#4318FF] to-[#9F7AEA] rounded-full"></div>
                    <span class="text-sm font-semibold text-[#4318FF] tracking-wide">TASK DASHBOARD</span>
                </div>
                <h1 class="font-outfit font-bold text-4xl text-[#2B3674] mb-2 tracking-tight">Tugas & <span class="bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] bg-clip-text text-transparent">Deadline</span></h1>
                <p class="text-[#A3AED0] text-base">Kelola dan selesaikan semua tugas akademismu tepat waktu.</p>
            </div>
            
            <!-- Stat Cards Premium -->
            <div class="flex gap-4">
                <div class="group relative bg-white rounded-2xl px-6 py-4 text-center min-w-[110px] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 hover:border-orange-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="text-3xl font-bold text-orange-600 mb-1">{{ $assignments->where('status', 'pending')->count() }}</div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending</p>
                        <div class="w-8 h-0.5 bg-orange-200 mx-auto mt-2 rounded-full group-hover:w-12 transition-all duration-300"></div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-2xl px-6 py-4 text-center min-w-[110px] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 hover:border-green-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="text-3xl font-bold text-green-600 mb-1">{{ $assignments->where('status', 'submitted')->count() }}</div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Submitted</p>
                        <div class="w-8 h-0.5 bg-green-200 mx-auto mt-2 rounded-full group-hover:w-12 transition-all duration-300"></div>
                    </div>
                </div>
                <div class="group relative bg-white rounded-2xl px-6 py-4 text-center min-w-[110px] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 hover:border-purple-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="text-3xl font-bold text-purple-600 mb-1">{{ $assignments->where('is_late', true)->count() }}</div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Late</p>
                        <div class="w-8 h-0.5 bg-purple-200 mx-auto mt-2 rounded-full group-hover:w-12 transition-all duration-300"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NOTIFIKASI TUGAS BELUM DIKERJAKAN -->
        @php
            $pendingAssignments = $assignments->where('status', 'pending');
            $pendingCount = $pendingAssignments->count();
            $urgentCount = $pendingAssignments->filter(function($assign) {
                $dueDate = $assign->due_date ? \Carbon\Carbon::parse($assign->due_date) : null;
                return $dueDate && ($dueDate->isToday() || $dueDate->diffInDays(now()) <= 2);
            })->count();
            $todayDeadline = $pendingAssignments->filter(function($assign) {
                $dueDate = $assign->due_date ? \Carbon\Carbon::parse($assign->due_date) : null;
                return $dueDate && $dueDate->isToday();
            })->count();
        @endphp

        @if($pendingCount > 0)
        <div class="relative overflow-hidden bg-gradient-to-r from-orange-50 via-amber-50 to-orange-50 border-l-4 border-orange-500 rounded-2xl p-5 shadow-lg animate-slideInRight" id="notificationBanner">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-start gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-orange-500 rounded-xl blur-lg opacity-30"></div>
                    <div class="relative w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 flex-wrap">
                        <p class="font-bold text-orange-800 text-lg">
                            @if($pendingCount == 1)
                                Ada 1 Tugas Belum Dikerjakan!
                            @else
                                Ada {{ $pendingCount }} Tugas Belum Dikerjakan!
                            @endif
                        </p>
                        @if($urgentCount > 0)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-500 text-white shadow-md">
                                {{ $urgentCount }} Tugas Urgent
                            </span>
                        @endif
                        @if($todayDeadline > 0)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-500 text-white shadow-md">
                                Deadline Hari Ini!
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-orange-700 mt-1">
                        @if($todayDeadline > 0)
                            Perhatian! {{ $todayDeadline }} tugas harus dikumpulkan hari ini.
                        @else
                            Segera selesaikan tugas sebelum deadline untuk mendapatkan nilai maksimal.
                        @endif
                    </p>
                    <div class="flex gap-3 mt-3">
                        <button onclick="document.querySelector('.filter-btn[data-filter=\"active\"]').click(); document.getElementById('notificationBanner').style.display='none';" 
                                class="text-sm font-semibold text-orange-700 bg-orange-100 px-3 py-1.5 rounded-lg hover:bg-orange-200 transition-all">
                            Lihat Tugas Aktif
                        </button>
                        <button onclick="document.getElementById('pendingTasksModal').classList.remove('hidden')" 
                                class="text-sm font-semibold text-orange-600 hover:text-orange-800 underline">
                            Lihat Detail ({{ $pendingCount }} Tugas)
                        </button>
                        <button onclick="document.getElementById('notificationBanner').style.display='none'" 
                                class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal Detail Tugas Belum Dikerjakan -->
        <div id="pendingTasksModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
            <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[80vh] overflow-hidden transform transition-all scale-95 opacity-0 animate-modal-in shadow-2xl">
                <div class="relative bg-gradient-to-r from-orange-500 to-amber-600 p-6">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-xl">Tugas Belum Dikerjakan</h3>
                                <p class="text-white/80 text-sm">Segera selesaikan {{ $pendingCount }} tugas berikut</p>
                            </div>
                        </div>
                        <button onclick="document.getElementById('pendingTasksModal').classList.add('hidden')" class="text-white/80 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 overflow-y-auto max-h-[60vh]">
                    <div class="space-y-4">
                        @foreach($pendingAssignments as $task)
                        @php
                            $dueDate = $task->due_date ? \Carbon\Carbon::parse($task->due_date) : \Carbon\Carbon::now()->addDays(7);
                            $isUrgent = $dueDate->isToday() || $dueDate->diffInDays(now()) <= 2;
                            $isTodayDeadline = $dueDate->isToday();
                            $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                            if($daysLeft < 0) {
                                $deadlineText = 'Terlambat ' . abs($daysLeft) . ' hari';
                            } elseif($daysLeft == 0) {
                                $deadlineText = 'Hari terakhir - Segera Kumpulkan!';
                            } elseif($daysLeft == 1) {
                                $deadlineText = 'Besok';
                            } else {
                                $deadlineText = $daysLeft . ' hari lagi';
                            }
                        @endphp
                        <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-4 border border-gray-100 hover:shadow-md transition-all">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        @if($isTodayDeadline)
                                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                                Deadline Hari Ini!
                                            </span>
                                        @elseif($isUrgent)
                                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                                Urgent
                                            </span>
                                        @endif
                                        <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-gray-200 text-gray-700">
                                            {{ $task->subject->name ?? 'Mata Pelajaran' }}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-[#2B3674] mb-1">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-3 text-sm text-gray-500 flex-wrap">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $dueDate->format('d M Y') }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $dueDate->format('H:i') }} WIB
                                        </span>
                                        <span class="text-xs {{ $isUrgent ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                            {{ $deadlineText }}
                                        </span>
                                    </div>
                                </div>
                                <button onclick="closeModalAndOpenSubmit({{ $task->id }})" 
                                        class="bg-gradient-to-r from-[#4318FF] to-[#5B4DFF] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition-all ml-3">
                                    Kumpulkan
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            Total: {{ $pendingCount }} tugas belum dikerjakan
                        </p>
                        <div class="flex gap-2">
                            <button onclick="document.querySelector('.filter-btn[data-filter=\"active\"]').click(); document.getElementById('pendingTasksModal').classList.add('hidden');" 
                                    class="px-4 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-all">
                                Lihat Semua
                            </button>
                            <button onclick="document.getElementById('pendingTasksModal').classList.add('hidden')" 
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Filter Premium -->
        <div class="flex flex-wrap gap-2 border-b border-gray-100 pb-0 animate-fadeIn">
            <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-t-xl" data-filter="all">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Semua Tugas</span>
                </span>
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </button>
            <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-t-xl" data-filter="active">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Aktif</span>
                    @if($pendingCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1 shadow-md">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </span>
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </button>
            <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-t-xl" data-filter="completed">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Selesai</span>
                </span>
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </button>
            <button class="filter-btn group relative px-6 py-3 text-sm font-semibold transition-all duration-300 rounded-t-xl" data-filter="late">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Terlambat</span>
                </span>
                <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            </button>
        </div>

        @if($assignments->count() > 0)
            <!-- Grid Layout Premium -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
                @foreach($assignments as $assign)
                @php
                    $status = $assign->status ?? 'pending';
                    $isLate = $assign->is_late ?? false;
                    $dueDate = $assign->due_date ? \Carbon\Carbon::parse($assign->due_date) : \Carbon\Carbon::now()->addDays(7);
                    $isUrgent = $dueDate->isToday() || $dueDate->diffInDays(now()) <= 2;
                    $isTodayDeadline = $dueDate->isToday();
                    $submission = null;
                    $progress = null;
                    
                    if(isset($assign->submissions) && $assign->submissions) {
                        $submission = $assign->submissions->where('student_id', auth()->id())->first();
                        $progress = $submission ? $submission->score : null;
                    }
                    
                    $daysLeft = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
                    if($daysLeft < 0) {
                        $deadlineText = 'Terlambat ' . abs($daysLeft) . ' hari';
                    } elseif($daysLeft == 0) {
                        $deadlineText = 'Hari terakhir';
                    } elseif($daysLeft == 1) {
                        $deadlineText = 'Besok';
                    } else {
                        $deadlineText = $daysLeft . ' hari lagi';
                    }
                @endphp
                <div class="task-card group relative bg-white rounded-2xl border border-gray-100 hover:border-[#4318FF]/20 transition-all duration-500 overflow-hidden shadow-sm hover:shadow-2xl" data-status="{{ $status }}">
                    <!-- Progress Bar -->
                    <div class="h-1 w-full bg-gray-100">
                        <div class="h-full bg-gradient-to-r from-[#4318FF] to-[#9F7AEA] transition-all duration-700 ease-out" style="width: {{ $progress ? min(($progress / 100) * 100, 100) : 0 }}%"></div>
                    </div>
                    
                    <div class="p-5">
                        <!-- Header Card -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4318FF]/10 to-[#9F7AEA]/10 text-[#4318FF] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex gap-2">
                                @if($isTodayDeadline && $status == 'pending')
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-500 text-white">
                                        Deadline Today!
                                    </span>
                                @elseif($isUrgent && $status == 'pending')
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-500 text-white">
                                        Urgent
                                    </span>
                                @elseif($status == 'submitted')
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-500 text-white">
                                        Completed
                                    </span>
                                @elseif($isLate)
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-amber-500 text-white">
                                        Late
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <h3 class="font-bold text-lg text-slate-800 mb-2 line-clamp-1">
                            {{ $assign->title ?? 'Tugas Baru' }}
                        </h3>
                        
                        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-3">
                            <div class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>{{ $assign->subject->name ?? 'Mata Pelajaran' }}</span>
                            </div>
                            <div class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $dueDate->format('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {{ Str::limit($assign->description ?? 'Tidak ada deskripsi untuk tugas ini.', 100) }}
                        </p>

                        <!-- Deadline & Action -->
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-1 text-xs font-semibold text-slate-400 mb-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Deadline</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1">
                                        <div class="w-1.5 h-1.5 rounded-full {{ ($isUrgent && $status == 'pending') || $isLate ? 'bg-red-500' : 'bg-slate-400' }}"></div>
                                        <span class="text-sm font-semibold {{ ($isUrgent && $status == 'pending') || $isLate ? 'text-red-600' : 'text-slate-700' }}">
                                            {{ $dueDate->format('H:i') }} WIB
                                        </span>
                                    </div>
                                    @if($status == 'pending' && !$isLate)
                                        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">{{ $deadlineText }}</span>
                                    @elseif($isLate)
                                        <span class="text-xs font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded-full">{{ $deadlineText }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($status != 'submitted')
                                <button class="submit-btn bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm" data-id="{{ $assign->id }}">
                                    Submit
                                </button>
                            @else
                                <div class="text-right">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-xs font-semibold text-slate-500">Score</div>
                                            <div class="text-xl font-bold text-emerald-600 leading-tight">{{ $progress ?? '—' }}</div>
                                        </div>
                                        <button class="text-indigo-500 text-sm font-semibold hover:underline">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Info jumlah tugas -->
            <div class="mt-8 pt-5 text-center text-sm text-slate-400 border-t border-slate-100">
                <span class="inline-flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full">
                    Menampilkan {{ $assignments->count() }} tugas
                </span>
            </div>
        @else
            <!-- Empty State -->
            <div class="relative rounded-2xl p-16 text-center bg-white border border-slate-100 mt-6">
                <div class="relative w-24 h-24 mx-auto mb-6">
                    <div class="absolute inset-0 bg-emerald-100 rounded-full blur-xl opacity-30"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-md">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="font-bold text-2xl text-slate-800 mb-2">Tidak Ada Tugas</h2>
                <p class="text-slate-400 max-w-md mx-auto">Selamat! Semua tugas telah diselesaikan. Gunakan waktumu untuk mempersiapkan materi selanjutnya.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Kumpul Tugas -->
<div id="submitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl max-w-md w-full p-0 transform transition-all scale-95 opacity-0 animate-modal-in shadow-xl overflow-hidden">
        <div class="relative bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-5">
            <div class="relative text-center">
                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl text-white mt-3">Submit Assignment</h3>
                <p class="text-white/80 text-sm mt-1">Pastikan tugasmu sudah benar sebelum dikirim</p>
            </div>
        </div>
        
        <form id="submitForm" class="space-y-5 p-6">
            @csrf
            <input type="hidden" id="assignment_id" name="assignment_id">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Link Tugas</label>
                <input type="text" name="submission_link" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all outline-none" 
                       placeholder="https://drive.google.com/...">
                <p class="text-xs text-slate-400 mt-1 ml-1">Masukkan link Google Drive, GitHub, atau platform lainnya</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan <span class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all outline-none resize-none" 
                          placeholder="Tambahkan catatan untuk guru..."></textarea>
            </div>
            
            <div class="flex gap-3 pt-3">
                <button type="button" id="closeModalBtn" class="flex-1 bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2.5 rounded-xl font-semibold transition-all shadow-sm">
                    Kirim Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-modal-in {
        animation: modal-in 0.2s ease-out forwards;
    }
</style>

<script>
    // Function to close modal and open submit
    function closeModalAndOpenSubmit(assignmentId) {
        document.getElementById('pendingTasksModal').classList.add('hidden');
        openModal(assignmentId);
    }
    
    // Filter Tugas
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const cards = document.querySelectorAll('.task-card');
            
            cards.forEach(card => {
                if(filter === 'all') {
                    card.style.display = 'block';
                } else if(filter === 'active' && card.dataset.status === 'pending') {
                    card.style.display = 'block';
                } else if(filter === 'completed' && card.dataset.status === 'submitted') {
                    card.style.display = 'block';
                } else if(filter === 'late' && card.dataset.status === 'late') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Modal Handling
    const modal = document.getElementById('submitModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const submitBtns = document.querySelectorAll('.submit-btn');
    const assignmentIdInput = document.getElementById('assignment_id');
    
    function openModal(assignmentId) {
        assignmentIdInput.value = assignmentId;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        document.getElementById('submitForm').reset();
    }
    
    if(submitBtns.length > 0) {
        submitBtns.forEach(btn => {
            btn.addEventListener('click', () => openModal(btn.dataset.id));
        });
    }
    
    if(closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if(modal) {
        modal.addEventListener('click', (e) => {
            if(e.target === modal) closeModal();
        });
    }
    
    // Form Submit AJAX
    const submitForm = document.getElementById('submitForm');
    if(submitForm) {
        submitForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Mengirim...';
            
            try {
                const formData = new FormData(this);
                const response = await fetch('{{ route("student.assignments.submit") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if(data.success) {
                    showNotification('Berhasil', 'Tugas berhasil dikirimkan!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            } catch(error) {
                console.error('Error:', error);
                showNotification('Error', 'Gagal mengirim tugas.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Toast Notification
    function showNotification(title, message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-white animate-fadeIn ${
            type === 'success' ? 'bg-emerald-500' : 'bg-rose-500'
        }`;
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold text-sm">${title}</p>
                <p class="text-xs opacity-90">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-3 text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
</script>
@endsection