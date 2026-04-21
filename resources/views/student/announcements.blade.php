@extends('layouts.student')

@section('title', 'Pengumuman - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Papan Pengumuman</h1>
        <p class="text-[#A3AED0]">Informasi terbaru dan penting dari pihak sekolah.</p>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 px-8 py-5 bg-gradient-to-r from-indigo-50/50 to-purple-50/50 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                    <i class='bx bx-megaphone text-white text-xl'></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#2B3674] text-lg">Notifikasi & Pengumuman</h3>
                    <p class="text-xs text-slate-500 font-medium">Update aktivitas terbaru</p>
                </div>
            </div>
            <div class="text-xs font-bold text-slate-400 bg-white px-3 py-1.5 rounded-lg border border-gray-100">
                Total: {{ $announcements->count() }}
            </div>
        </div>
        
        <div class="divide-y divide-gray-100 max-h-[650px] overflow-y-auto">
            @if($announcements->count() > 0)
                @foreach($announcements as $item)
                <div class="p-6 hover:bg-slate-50/80 transition-all cursor-pointer group">
                    <div class="flex justify-between items-start gap-4">
                        <!-- Icon Priority -->
                        <div class="flex-shrink-0 mt-1">
                            @php
                                $priority = $item->priority ?? 'normal'; // Asumsi ada field priority, atau default normal
                                $bgClass = 'bg-sky-50';
                                $textClass = 'text-sky-500';
                                $icon = 'bx-info-circle';
                                
                                if($priority == 'high') {
                                    $bgClass = 'bg-rose-50';
                                    $textClass = 'text-rose-500';
                                    $icon = 'bx-error-circle';
                                } elseif($priority == 'normal') {
                                    $bgClass = 'bg-amber-50';
                                    $textClass = 'text-amber-500';
                                    $icon = 'bx-bell';
                                }
                            @endphp
                            <div class="w-12 h-12 rounded-2xl {{ $bgClass }} flex items-center justify-center">
                                <i class='bx {{ $icon }} text-2xl {{ $textClass }}'></i>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <h4 class="font-bold text-[#2B3674] text-lg group-hover:text-indigo-600 transition-colors">
                                    {{ $item->title }}
                                </h4>
                                @if($priority == 'high')
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-rose-100 text-rose-600 uppercase tracking-widest">
                                        Penting
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-600 mb-3">{{ $item->content }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-400">
                                <span class="flex items-center gap-1.5">
                                    <i class='bx bx-calendar text-sm'></i>
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <i class='bx bx-group text-sm'></i>
                                    Target: {{ $item->target ?? 'Semua' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="py-16 text-center">
                    <div class="w-24 h-24 bg-indigo-50 text-indigo-300 rounded-full flex items-center justify-center mx-auto mb-4 text-5xl">
                        <i class='bx bx-envelope'></i>
                    </div>
                    <p class="text-slate-800 font-bold text-xl mb-1">Tidak Ada Pengumuman</p>
                    <p class="text-sm text-slate-500 max-w-sm mx-auto">Saat ini belum ada notifikasi atau pengumuman dari pihak sekolah.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection