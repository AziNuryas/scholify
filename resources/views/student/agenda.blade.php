@extends('layouts.student')

@section('title', 'Agenda Sekolah - Schoolify')
@section('page-title', 'Agenda Sekolah')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fadeInUp">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 shadow-lg shadow-teal-500/30 flex items-center justify-center flex-shrink-0">
                <i data-lucide="book-text" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <h1 class="font-outfit font-bold text-3xl text-[var(--text-primary)] mb-1">Agenda & Kegiatan</h1>
                <p class="text-[var(--text-muted)] text-sm">Informasi jadwal kegiatan, ujian, dan hari libur sekolah.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upcoming Events List -->
        <div class="lg:col-span-2 space-y-4">
            <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)] flex items-center gap-2 mb-4">
                <i data-lucide="list-todo" class="w-5 h-5 text-teal-500"></i>
                Daftar Kegiatan Terdekat
            </h3>
            
            @forelse($agendas as $agenda)
            <div class="neo-flat rounded-3xl p-5 neo-card-hover flex gap-5 animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="flex-shrink-0 w-16 h-20 neo-pressed rounded-2xl flex flex-col items-center justify-center text-center">
                    <p class="text-[10px] font-bold text-teal-600 uppercase">{{ \Carbon\Carbon::parse($agenda->start_date)->isoFormat('MMM') }}</p>
                    <p class="text-2xl font-black text-[var(--text-primary)]">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</p>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start gap-2">
                        <h4 class="font-bold text-base text-[var(--text-primary)] truncate">{{ $agenda->title }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full {{ $agenda->type == 'holiday' ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-600' }} text-[8px] font-black uppercase tracking-wider whitespace-nowrap">
                            {{ $agenda->type ?? 'Kegiatan' }}
                        </span>
                    </div>
                    <p class="text-xs text-[var(--text-muted)] mt-1 line-clamp-2">{{ $agenda->description }}</p>
                    <div class="flex flex-wrap gap-4 mt-3">
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-[var(--text-muted)]">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ \Carbon\Carbon::parse($agenda->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($agenda->end_date)->format('H:i') }}
                        </div>
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-[var(--text-muted)]">
                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                            {{ $agenda->location ?? 'Lingkungan Sekolah' }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="neo-flat rounded-3xl p-10 text-center opacity-50">
                <div class="w-16 h-16 neo-pressed rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="calendar-x" class="w-8 h-8 text-[var(--text-muted)]"></i>
                </div>
                <p class="font-bold text-[var(--text-primary)]">Belum Ada Agenda</p>
                <p class="text-xs text-[var(--text-muted)] mt-1">Belum ada jadwal kegiatan sekolah untuk saat ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Sidebar: Info Tambahan -->
        <div class="space-y-6">
            <div class="neo-flat rounded-3xl p-6">
                <h3 class="font-outfit font-bold text-base text-[var(--text-primary)] mb-4">Statistik Bulan Ini</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 neo-pressed rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-[var(--text-secondary)]">Total Kegiatan</span>
                        </div>
                        <span class="font-black text-sm text-[var(--text-primary)]">{{ $agendas->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 neo-pressed rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                                <i data-lucide="party-popper" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-[var(--text-secondary)]">Hari Libur</span>
                        </div>
                        <span class="font-black text-sm text-red-500">{{ $agendas->where('type', 'holiday')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Banner Info -->
            <div class="neo-flat rounded-3xl p-6 bg-gradient-to-br from-indigo-600 to-purple-700 text-white border-none">
                <i data-lucide="megaphone" class="w-10 h-10 mb-4 opacity-30"></i>
                <h4 class="font-outfit font-bold text-lg mb-2">Punya Pertanyaan?</h4>
                <p class="text-xs text-indigo-100 leading-relaxed mb-4">Hubungi wali kelas atau bagian kurikulum untuk informasi lebih detail mengenai agenda sekolah.</p>
                <a href="{{ route('student.dashboard') }}" class="inline-block px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Kembali Ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
