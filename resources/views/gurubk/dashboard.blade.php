@extends('layouts.gurubk')

@section('title', 'Dashboard Bimbingan Konseling - Schoolify')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6 animate-fadeInUp">

    <!-- Welcome Banner -->
    <div class="neo-flat rounded-2xl p-6 sm:p-8 relative overflow-hidden flex items-center justify-between neo-card-hover"
         style="background: linear-gradient(135deg, #5B21B6, #7C3AED);">
        <div class="z-10 relative text-white">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-3"
                 style="background: rgba(0,0,0,0.1); box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2), inset -3px -3px 6px rgba(255,255,255,0.1);">
                <i class='bx bx-calendar text-purple-200 text-sm'></i>
                <p class="text-[10px] text-purple-100 font-bold uppercase tracking-wider">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <h1 class="font-outfit font-extrabold text-2xl sm:text-3xl text-white mb-4">
                Selamat Datang, {{ explode(',', $guru['name'])[0] }}! 👋
            </h1>
            <div class="p-3.5 rounded-xl max-w-md"
                 style="background: rgba(255,255,255,0.05); box-shadow: 4px 4px 8px rgba(0,0,0,0.15), -4px -4px 8px rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.08);">
                <p class="text-sm text-purple-100 leading-relaxed">
                    Pantau kesehatan mental dan perkembangan karakter seluruh siswa di sini.
                </p>
            </div>
        </div>
        <div class="hidden sm:flex items-center justify-center w-28 h-28 rounded-full z-10 relative"
             style="background: rgba(0,0,0,0.08); box-shadow: inset 6px 6px 12px rgba(0,0,0,0.25), inset -6px -6px 12px rgba(255,255,255,0.15);">
            <i class='bx bxs-heart-circle text-white/90 text-5xl'></i>
        </div>
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute left-0 bottom-0 w-48 h-48 bg-purple-900/30 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="neo-flat rounded-2xl p-6 flex items-center gap-5 neo-card-hover">
            <div class="w-14 h-14 rounded-full neo-pressed flex items-center justify-center text-2xl" style="color: #60a5fa">
                <i class='bx bx-group'></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-[var(--text-muted)]">Total Siswa Ditangani</p>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ number_format($stats['total_students']) }}</h3>
            </div>
        </div>
        <div class="neo-flat rounded-2xl p-6 flex items-center gap-5 neo-card-hover">
            <div class="w-14 h-14 rounded-full neo-pressed flex items-center justify-center text-2xl" style="color: #fb923c">
                <i class='bx bx-user-voice'></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-[var(--text-muted)]">Kasus Berjalan</p>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ $stats['active_cases'] }}</h3>
            </div>
        </div>
        <div class="neo-flat rounded-2xl p-6 flex items-center gap-5 neo-card-hover">
            <div class="w-14 h-14 rounded-full neo-pressed flex items-center justify-center text-2xl" style="color: var(--accent-light)">
                <i class='bx bx-calendar-heart'></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-[var(--text-muted)]">Jadwal Temu Hari Ini</p>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">{{ $stats['appointments_today'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Agenda + Shortcut -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Agenda -->
        <div class="lg:col-span-2 neo-flat rounded-2xl p-6 neo-card-hover">
            <div class="flex justify-between items-center mb-5 pb-4" style="border-bottom: 1px solid rgba(var(--shadow-dark), 0.15)">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, #7C3AED, #9333EA); box-shadow: 0 4px 12px rgba(124,58,237,0.3)">
                        <i class='bx bx-notepad text-white text-lg'></i>
                    </div>
                    <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Agenda Temu</h3>
                </div>
                <a href="{{ route('gurubk.appointments') }}"
                   class="text-sm font-bold transition-colors hover:opacity-80" style="color: var(--accent-light)">
                    Lihat Semua
                </a>
            </div>

            {{-- Filter --}}
            <div class="flex gap-2 mb-4">
                <a href="?agenda_filter=today"
                   class="px-4 py-1.5 rounded-xl text-xs font-bold transition"
                   style="{{ ($filter ?? 'today') === 'today' ? 'background: var(--accent); color: #fff;' : 'background: var(--bg); border: 1px solid var(--border); color: var(--text-secondary);' }}">
                    Hari Ini
                </a>
                <a href="?agenda_filter=week"
                   class="px-4 py-1.5 rounded-xl text-xs font-bold transition"
                   style="{{ ($filter ?? 'today') === 'week' ? 'background: var(--accent); color: #fff;' : 'background: var(--bg); border: 1px solid var(--border); color: var(--text-secondary);' }}">
                    Minggu Ini
                </a>
            </div>

            <div class="space-y-3">
                @forelse($appointments as $appt)
                <div class="neo-pressed rounded-xl p-4 flex items-center justify-between group hover-glow transition-all cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0"
                             style="background: var(--accent); box-shadow: 0 4px 10px rgba(124,58,237,0.3)">
                            {{ strtoupper(substr($appt['name'] ?? 'BK', 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[var(--text-primary)] group-hover:text-[var(--accent-light)] transition-colors">
                                {{ $appt['name'] ?? '-' }} ({{ $appt['class'] ?? '-' }})
                            </h4>
                            <p class="text-xs font-medium mt-0.5 {{ ($appt['type'] ?? 'normal') === 'alert' ? 'text-red-400' : 'text-[var(--text-secondary)]' }}">
                                {{ $appt['topic'] ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1 flex-shrink-0 ml-3">
                        @if(($filter ?? 'today') === 'week')
                            <span class="text-xs font-medium" style="color: var(--text-muted)">{{ $appt['date'] }}</span>
                        @endif
                        <span class="font-bold text-sm px-3 py-1.5 rounded-xl neo-flat" style="color: var(--accent-light)">
                            {{ $appt['time'] ?? '-' }}
                        </span>
                    </div>
                </div>
                @empty
                    <div class="neo-pressed rounded-xl p-6 text-center">
                        <i class='bx bx-calendar-x text-3xl text-[var(--text-muted)]'></i>
                        <p class="text-sm font-bold text-[var(--text-primary)] mt-2">
                            Tidak ada agenda {{ ($filter ?? 'today') === 'week' ? 'minggu ini' : 'hari ini' }}
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Shortcut Buat Catatan -->
        <div class="neo-flat rounded-2xl p-8 relative overflow-hidden flex flex-col justify-center neo-card-hover"
             style="background: linear-gradient(135deg, #1e1b4b, #312e81);">
            <div class="relative z-10 text-white">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6"
                     style="background: rgba(255,255,255,0.1); box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2), inset -3px -3px 6px rgba(255,255,255,0.08)">
                    <i class='bx bxs-report'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl mb-2">Buat Catatan Konseling</h3>
                <p class="text-purple-300 text-sm mb-6 leading-relaxed">
                    Catat pelanggaran atau lapor keluhan perkembangan karakter siswa secara manual ke dalam sistem.
                </p>
                <a href="{{ route('gurubk.catatan-konseling.index') }}"
                   class="block w-full text-center font-bold py-3 rounded-xl transition-all duration-300 text-white"
                   style="background: var(--accent); box-shadow: 0 4px 15px rgba(124,58,237,0.4);"
                   onmouseover="this.style.background='var(--accent-hover)'"
                   onmouseout="this.style.background='var(--accent)'">
                    Buat Catatan
                </a>
            </div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 rounded-full" style="border: 20px solid rgba(255,255,255,0.04)"></div>
            <div class="absolute -top-8 -left-8 w-32 h-32 rounded-full" style="border: 12px solid rgba(255,255,255,0.03)"></div>
        </div>
    </div>

</div>
@endsection