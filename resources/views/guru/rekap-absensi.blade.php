@extends('layouts.guru')

@section('title', 'Rekap Absensi Siswa - Scholify Guru')
@section('page-title', 'Rekap Absensi Siswa')
@section('page-subtitle', 'Lihat riwayat kehadiran siswa')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    {{-- Header --}}
    <div class="neo-flat p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="neo-pressed w-8 h-8 rounded-lg flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-[var(--accent)]"></i>
                    </div>
                    <h1 class="font-outfit text-2xl font-bold text-[var(--text-primary)]">Rekap Absensi Siswa</h1>
                </div>
                <p class="text-[var(--text-secondary)] text-sm ml-10">Lihat riwayat kehadiran siswa secara lengkap</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="neo-card p-4">
        <form method="GET" action="{{ route('guru.rekap.absensi') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Kelas</label>
                <select name="class_id" class="neo-input w-full px-4 py-2.5 text-sm" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ ($classId ?? '') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Siswa</label>
                <select name="student_id" class="neo-input w-full px-4 py-2.5 text-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ ($studentId ?? '') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="neo-input w-full px-4 py-2.5 text-sm" onchange="this.form.submit()">
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="neo-input w-full px-4 py-2.5 text-sm" onchange="this.form.submit()">
            </div>
            
            <div>
                <button type="button" onclick="window.location.href='{{ route('guru.rekap.absensi') }}'" 
                        class="neo-btn px-4 py-2.5 rounded-xl text-sm font-semibold">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-1"></i> Reset
                </button>
            </div>
        </form>
    </div>

    @if($classId)
        {{-- Statistik Ringkasan per Siswa --}}
        <div class="neo-card p-6">
            <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)] mb-4">Ringkasan Kehadiran per Siswa</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                            <th class="text-left py-3 px-4 rounded-l-xl">Siswa</th>
                            <th class="text-center py-3 px-4">Hadir</th>
                            <th class="text-center py-3 px-4">Izin</th>
                            <th class="text-center py-3 px-4">Sakit</th>
                            <th class="text-center py-3 px-4">Alpha</th>
                            <th class="text-center py-3 px-4">Total</th>
                            <th class="text-center py-3 px-4 rounded-r-xl">% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistikSiswa as $siswa)
                        <tr class="border-b border-[var(--shadow-dark)]/5 hover:bg-[var(--bg)]/30 transition">
                            <td class="py-3 px-4 font-semibold">
                                {{ $siswa['nama'] }}
                                <div class="text-[10px] text-[var(--text-muted)]">NIS: {{ $siswa['nis'] ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4 text-center text-emerald-600 font-bold">{{ $siswa['hadir'] }}</td>
                            <td class="py-3 px-4 text-center text-amber-600">{{ $siswa['izin'] }}</td>
                            <td class="py-3 px-4 text-center text-blue-600">{{ $siswa['sakit'] }}</td>
                            <td class="py-3 px-4 text-center text-red-600">{{ $siswa['alpha'] }}</td>
                            <td class="py-3 px-4 text-center">{{ $siswa['total'] }}</td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $persen = $siswa['total'] > 0 ? round(($siswa['hadir'] / $siswa['total']) * 100) : 0;
                                    $color = $persen >= 80 ? 'text-emerald-600' : ($persen >= 60 ? 'text-amber-600' : 'text-red-600');
                                @endphp
                                <span class="font-bold {{ $color }}">{{ $persen }}%</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-[var(--text-muted)]">Belum ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Detail Absensi Harian --}}
        <div class="neo-card p-6">
            <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)] mb-4">Detail Absensi Harian</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--shadow-dark)]/10 bg-[var(--bg)]/50">
                            <th class="text-left py-3 px-4 rounded-l-xl">Tanggal</th>
                            <th class="text-left py-3 px-4">Siswa</th>
                            <th class="text-center py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Keterangan</th>
                            <th class="text-center py-3 px-4 rounded-r-xl">Dicatat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $item)
                        <tr class="border-b border-[var(--shadow-dark)]/5 hover:bg-[var(--bg)]/30 transition">
                            <td class="py-3 px-4">
                                {{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('D MMM YYYY') }}
                                <div class="text-[10px] text-[var(--text-muted)]">{{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd') }}</div>
                            </td>
                            <td class="py-3 px-4 font-semibold">{{ $item->student->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $statusClass = [
                                        'hadir' => 'bg-emerald-100 text-emerald-700',
                                        'izin' => 'bg-amber-100 text-amber-700',
                                        'sakit' => 'bg-blue-100 text-blue-700',
                                        'alpha' => 'bg-red-100 text-red-700',
                                    ][$item->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-[var(--text-secondary)]">{{ $item->notes ?: '-' }}</td>
                            <td class="py-3 px-4 text-center text-xs text-[var(--text-muted)]">
                                @php
                                    $recordedBy = \App\Models\Teacher::find($item->recorded_by);
                                @endphp
                                {{ $recordedBy ? $recordedBy->name : ($item->recorded_by ? 'Admin' : 'Siswa') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[var(--text-muted)]">
                                <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-2 opacity-30"></i>
                                <p>Belum ada data absensi untuk periode yang dipilih</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="neo-card p-12 text-center text-[var(--text-muted)]">
            <i data-lucide="filter" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
            <p class="text-lg font-medium">Pilih kelas untuk melihat rekap absensi</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endpush