@extends('layouts.student')
@section('title', 'Absensi Siswa - Scholify')
@section('page-title', 'Kehadiran')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div>
        <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">Rekam Kehadiran</h1>
        <p class="text-sm text-[var(--text-secondary)]">Pantau dan rekam kehadiran harian Anda di sini.</p>
    </div>

    <!-- Statistics Cards in a single layout row -->
    <div class="neo-flat rounded-2xl p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 divide-x divide-[var(--shadow-dark)]/5">
            <div class="text-center px-4">
                <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Hadir</p>
                <div class="text-3xl font-extrabold text-emerald-500">{{ $statistik['hadir'] ?? 0 }}</div>
            </div>
            <div class="text-center px-4">
                <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Izin</p>
                <div class="text-3xl font-extrabold text-amber-500">{{ $statistik['izin'] ?? 0 }}</div>
            </div>
            <div class="text-center px-4">
                <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Sakit</p>
                <div class="text-3xl font-extrabold text-blue-500">{{ $statistik['sakit'] ?? 0 }}</div>
            </div>
            <div class="text-center px-4">
                <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Alpha</p>
                <div class="text-3xl font-extrabold text-red-500">{{ $statistik['alpha'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Absensi Hari Ini -->
        <div class="lg:col-span-1">
            <div class="neo-flat rounded-2xl p-6">
                <div class="mb-5">
                    <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Absensi Hari Ini</h3>
                    <p class="text-xs font-medium text-[var(--text-secondary)] mt-0.5">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                
                @if($todayAbsen)
                    <div class="neo-pressed rounded-xl p-5 flex flex-col items-center justify-center text-center">
                        <div class="w-12 h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center mb-3 shadow-md shadow-emerald-500/20">
                            <i data-lucide="check" class="w-6 h-6"></i>
                        </div>
                        <p class="font-bold text-[var(--text-primary)]">Sudah Absen</p>
                        <p class="text-sm font-semibold text-emerald-500 mt-1 uppercase tracking-wide">{{ ucfirst($todayAbsen->status) }}</p>
                        @if($todayAbsen->keterangan) 
                            <p class="text-xs text-[var(--text-muted)] mt-2 italic">"{{ $todayAbsen->keterangan }}"</p>
                        @endif
                    </div>
                @else
                    <button onclick="openAbsensiModal()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="fingerprint" class="w-5 h-5"></i>
                        <span>Rekam Kehadiran</span>
                    </button>
                    <p class="text-[10px] text-center text-[var(--text-muted)] mt-3">Jangan lupa absen sebelum jam masuk kelas</p>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: History Table -->
        <div class="lg:col-span-2">
            <div class="neo-flat rounded-2xl p-6">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Riwayat Kehadiran</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)] mt-0.5">Catatan kehadiran semester ini</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="neo-pressed border-b border-[var(--shadow-dark)]/5">
                                <th class="px-4 py-3 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider rounded-l-lg">Tanggal</th>
                                <th class="px-4 py-3 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider text-center">Status</th>
                                <th class="px-4 py-3 text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider rounded-r-lg">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--shadow-dark)]/5">
                            @forelse($absensi as $item)
                            <tr class="hover:bg-white/40 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-sm font-bold text-[var(--text-primary)]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</p>
                                    <p class="text-xs text-[var(--text-secondary)]">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusColor = [
                                            'hadir' => 'text-emerald-500 bg-emerald-50',
                                            'izin' => 'text-amber-500 bg-amber-50',
                                            'sakit' => 'text-blue-500 bg-blue-50',
                                            'alpha' => 'text-red-500 bg-red-50',
                                        ];
                                        $color = $statusColor[$item->status] ?? 'text-red-500 bg-red-50';
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $color }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs font-medium text-[var(--text-secondary)]">
                                    {{ $item->keterangan ?: '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-[var(--text-muted)] text-sm font-semibold">
                                    Belum ada data absensi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Absensi -->
<div id="absensiModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
    <div class="neo-flat rounded-2xl max-w-sm w-full overflow-hidden transform transition-all shadow-xl border border-white/20">
        <div class="p-5 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center bg-[var(--bg)]">
            <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Rekam Kehadiran</h3>
            <button type="button" onclick="closeAbsensiModal()" class="w-8 h-8 rounded-lg neo-btn flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        
        <form action="{{ route('student.absensi.store') }}" method="POST" class="p-5 space-y-4 bg-[var(--bg)]">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]" readonly>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Status Kehadiran</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 p-3 neo-btn rounded-xl cursor-pointer hover:bg-white/50 transition-colors">
                        <input type="radio" name="status" value="hadir" required class="accent-emerald-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-[var(--text-primary)]">Hadir</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 neo-btn rounded-xl cursor-pointer hover:bg-white/50 transition-colors">
                        <input type="radio" name="status" value="izin" class="accent-amber-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-[var(--text-primary)]">Izin</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 neo-btn rounded-xl cursor-pointer hover:bg-white/50 transition-colors">
                        <input type="radio" name="status" value="sakit" class="accent-blue-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-[var(--text-primary)]">Sakit</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 neo-btn rounded-xl cursor-pointer hover:bg-white/50 transition-colors">
                        <input type="radio" name="status" value="alpha" class="accent-red-500 w-4 h-4"> 
                        <span class="text-sm font-bold text-[var(--text-primary)]">Alpha</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                    Keterangan <span class="text-[9px] text-[var(--text-muted)]">(Opsional)</span>
                </label>
                <textarea name="keterangan" rows="2" class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)] resize-none" placeholder="Tambahkan keterangan..."></textarea>
            </div>
            
            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'flex';
}
function closeAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'none';
}
</script>
@endsection