@extends('layouts.admin')
@section('title', 'Laporan & Statistik - Schoolify Admin')
@section('page-title', 'Laporan & Statistik')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="message-square" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Total Konsultasi</h3>
            <div class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $data['totalConsultations'] ?? 456 }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 shadow-lg shadow-rose-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Catatan Disiplin</h3>
            <div class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $data['disciplineRecords'] ?? 24 }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 shadow-lg shadow-amber-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Jadwal Temu</h3>
            <div class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $data['appointments'] ?? 89 }}</div>
        </div>

        <div class="neo-flat rounded-2xl p-4 flex flex-col items-center justify-center text-center neo-card-hover group transition-all">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <i data-lucide="check-circle" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-1">Kehadiran</h3>
            <div class="font-outfit font-extrabold text-2xl text-[var(--text-primary)]">{{ $data['attendanceRate'] ?? 94 }}%</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Distribusi Pengguna -->
        <div class="neo-flat rounded-3xl p-6 neo-card-hover">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                </div>
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Distribusi Pengguna</h3>
            </div>

            <div class="space-y-5">
                <div>
                    <div class="flex justify-between text-sm font-bold text-[var(--text-primary)] mb-2">
                        <span>Siswa</span>
                        <span>76%</span>
                    </div>
                    <div class="w-full bg-[var(--shadow-dark)]/10 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: 76%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-[var(--text-primary)] mb-2">
                        <span>Guru Mapel</span>
                        <span>12%</span>
                    </div>
                    <div class="w-full bg-[var(--shadow-dark)]/10 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 12%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-[var(--text-primary)] mb-2">
                        <span>Guru BK</span>
                        <span>8%</span>
                    </div>
                    <div class="w-full bg-[var(--shadow-dark)]/10 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 8%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm font-bold text-[var(--text-primary)] mb-2">
                        <span>Lainnya</span>
                        <span>4%</span>
                    </div>
                    <div class="w-full bg-[var(--shadow-dark)]/10 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: 4%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Bulan Ini -->
        <div class="neo-flat rounded-3xl p-6 neo-card-hover">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Aktivitas Bulan Ini</h3>
            </div>

            <div class="space-y-3">
                <div class="neo-pressed rounded-xl p-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">Konsultasi Selesai</span>
                    <span class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">{{ $data['completedConsultations'] ?? 234 }}</span>
                </div>
                <div class="neo-pressed rounded-xl p-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">Konsultasi Pending</span>
                    <span class="font-outfit font-extrabold text-lg text-amber-500">{{ $data['pendingConsultations'] ?? 12 }}</span>
                </div>
                <div class="neo-pressed rounded-xl p-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">Jadwal Temu Dikonfirmasi</span>
                    <span class="font-outfit font-extrabold text-lg text-emerald-500">{{ $data['approvedAppointments'] ?? 67 }}</span>
                </div>
                <div class="neo-pressed rounded-xl p-4 flex justify-between items-center">
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">Jadwal Temu Ditolak</span>
                    <span class="font-outfit font-extrabold text-lg text-red-500">8</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="neo-flat rounded-3xl p-6 neo-card-hover">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-light)] shadow-sm flex items-center justify-center text-white">
                <i data-lucide="history" class="w-5 h-5"></i>
            </div>
            <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Aktivitas Terbaru</h3>
        </div>

        <div class="space-y-4">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
                <div class="border-b border-[var(--shadow-dark)]/10 pb-4 flex-1">
                    <p class="text-sm font-bold text-[var(--text-primary)]">Siswa Ahmad Rizki melakukan konsultasi</p>
                    <p class="text-xs text-[var(--text-muted)] mt-1">2 jam yang lalu</p>
                </div>
            </div>
            
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <div class="border-b border-[var(--shadow-dark)]/10 pb-4 flex-1">
                    <p class="text-sm font-bold text-[var(--text-primary)]">Catatan disiplin ditambahkan untuk Budi Santoso</p>
                    <p class="text-xs text-[var(--text-muted)] mt-1">5 jam yang lalu</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-[var(--text-primary)]">Jadwal temu baru dijadwalkan</p>
                    <p class="text-xs text-[var(--text-muted)] mt-1">1 hari yang lalu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-[var(--accent)] rounded-3xl p-8 relative overflow-hidden text-white shadow-xl shadow-[var(--accent)]/20 mt-8">
        <!-- Decoration -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-48 h-48 bg-black/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="font-outfit font-extrabold text-2xl mb-2">Ekspor Laporan</h3>
                <p class="text-sm text-blue-100 font-semibold max-w-md">Unduh laporan dalam berbagai format untuk keperluan analisis dan dokumentasi administratif.</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.reports.export-pdf') }}" class="flex items-center gap-2 px-5 py-3 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md transition-colors text-sm font-bold">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Export PDF
                </a>
                <a href="{{ route('admin.reports.export-excel') }}" class="flex items-center gap-2 px-5 py-3 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md transition-colors text-sm font-bold">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Export Excel
                </a>
                <button onclick="window.print()" class="flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-[var(--accent)] hover:bg-blue-50 transition-colors text-sm font-bold shadow-lg">
                    <i data-lucide="printer" class="w-4 h-4"></i> Cetak
                </button>
            </div>
        </div>
    </div>

</div>
@endsection