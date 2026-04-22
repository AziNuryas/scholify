@extends('layouts.student')

@section('title', 'Absensi Siswa - Scholify')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-outfit font-extrabold text-[#2B3674]">Kehadiran Siswa</h1>
            <p class="text-[#A3AED0] text-sm mt-1">Rekam dan pantau kehadiran Anda setiap hari</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-[#F4F7FE]">
            <i class="fas fa-calendar-alt text-[#4318FF] mr-2 text-sm"></i>
            <span class="text-sm font-medium text-[#2B3674]">Semester Ganjil 2025/2026</span>
        </div>
    </div>

    <!-- Profile Card -->
    @if($studentData ?? false)
    <div class="bg-white rounded-xl p-4 shadow-sm border border-[#F4F7FE]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#4318FF] to-[#868CFF] flex items-center justify-center text-white font-bold text-lg">
                {{ substr($studentData->name ?? $studentData->first_name ?? 'S', 0, 1) }}
            </div>
            <div>
                <h2 class="font-bold text-base text-[#2B3674]">{{ $studentData->name ?? $studentData->first_name ?? 'Siswa' }}</h2>
                <div class="flex gap-3 mt-1 text-sm text-[#A3AED0]">
                    <span><i class="fas fa-users mr-1"></i> {{ $studentData->schoolClass->name ?? $studentData->class_id ?? '-' }}</span>
                    <span><i class="fas fa-id-card mr-1"></i> NIS: {{ $studentData->nisn ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-[#F4F7FE]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#A3AED0] text-sm font-medium">Hadir</p>
                    <p class="text-2xl font-extrabold text-[#2B3674] mt-1">{{ $statistik['hadir'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-[#F4F7FE]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#A3AED0] text-sm font-medium">Izin</p>
                    <p class="text-2xl font-extrabold text-[#2B3674] mt-1">{{ $statistik['izin'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-yellow-500 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-[#F4F7FE]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#A3AED0] text-sm font-medium">Sakit</p>
                    <p class="text-2xl font-extrabold text-[#2B3674] mt-1">{{ $statistik['sakit'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-thermometer-half text-blue-500 text-lg"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-[#F4F7FE]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[#A3AED0] text-sm font-medium">Alpha</p>
                    <p class="text-2xl font-extrabold text-[#2B3674] mt-1">{{ $statistik['alpha'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-500 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance -->
    @if($studentData ?? false)
        @if($todayAbsen)
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-green-800 text-base">Sudah Absen Hari Ini</p>
                            <p class="text-sm text-green-700 mt-0.5">
                                Status: <span class="font-semibold">{{ ucfirst($todayAbsen->status) }}</span>
                                @if($todayAbsen->keterangan) 
                                    • {{ $todayAbsen->keterangan }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right text-sm text-green-600">
                        <i class="far fa-clock mr-1"></i> {{ now()->locale('id')->isoFormat('dddd, D MMM') }}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-[#4318FF] to-[#868CFF] rounded-xl p-4">
                <div class="flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-fingerprint text-white text-xl"></i>
                        </div>
                        <div class="text-white">
                            <h3 class="text-base font-bold">Absensi Hari Ini</h3>
                            <p class="text-white/80 text-sm mt-0.5">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                    </div>
                    
                    <button onclick="openAbsensiModal()" class="bg-white text-[#4318FF] px-5 py-2 rounded-xl font-semibold hover:shadow-md transition-all flex items-center gap-2 text-sm">
                        <i class="fas fa-pen-alt"></i>
                        <span>Rekam Kehadiran</span>
                    </button>
                </div>
            </div>
        @endif
    @endif

    <!-- History Table -->
    <div class="bg-white rounded-xl shadow-sm border border-[#F4F7FE] overflow-hidden">
        <div class="px-5 py-4 border-b border-[#F4F7FE] flex flex-wrap justify-between items-center gap-3">
            <div>
                <h3 class="font-outfit font-bold text-lg text-[#2B3674]">Riwayat Kehadiran</h3>
                <p class="text-sm text-[#A3AED0] mt-0.5">Data absensi selama periode belajar</p>
            </div>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#A3AED0] text-sm"></i>
                <input type="text" id="searchAttendance" placeholder="Cari tanggal..." class="pl-9 pr-3 py-2 border border-[#F4F7FE] rounded-lg text-sm focus:outline-none focus:border-[#4318FF] w-48">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F4F7FE]">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase">Hari</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-[#A3AED0] uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @forelse($absensi as $item)
                    <tr class="hover:bg-[#F4F7FE]/30 transition">
                        <td class="px-5 py-3 text-sm font-medium text-[#2B3674]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="px-5 py-3 text-sm text-[#A3AED0]">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd') }}</td>
                        <td class="px-5 py-3">
                            @php
                                $statusConfig = [
                                    'hadir' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                                    'izin' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => 'fa-file-alt'],
                                    'sakit' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'fa-thermometer-half'],
                                    'alpha' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
                                ];
                                $config = $statusConfig[$item->status] ?? $statusConfig['alpha'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                <i class="fas {{ $config['icon'] }} text-xs"></i>
                                <span>{{ ucfirst($item->status) }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-3 text-sm text-[#A3AED0]">{{ $item->keterangan ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-[#F4F7FE] rounded-xl flex items-center justify-center mb-3">
                                    <i class="fas fa-calendar-times text-2xl text-[#A3AED0]"></i>
                                </div>
                                <p class="text-[#A3AED0] font-medium">Belum Ada Data Absensi</p>
                                <p class="text-sm text-[#A3AED0] mt-1">Lakukan absensi hari ini untuk memulai</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($absensi, 'links') && $absensi->hasPages())
        <div class="px-5 py-3 border-t border-[#F4F7FE] bg-white">
            {{ $absensi->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Absensi -->
<div id="absensiModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md">
        <form action="{{ route('student.absensi.store') }}" method="POST">
            @csrf
            <div class="p-5 border-b border-[#F4F7FE] flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-[#2B3674]">Rekam Kehadiran</h3>
                    <p class="text-sm text-[#A3AED0] mt-0.5">Isi form di bawah ini</p>
                </div>
                <button type="button" onclick="closeAbsensiModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#A3AED0] hover:text-red-500 hover:bg-red-50 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <i class="fas fa-calendar-day mr-2 text-[#4318FF]"></i>
                        Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border border-[#F4F7FE] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#4318FF] bg-gray-50" readonly>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <i class="fas fa-flag-checkered mr-2 text-[#4318FF]"></i>
                        Status Kehadiran
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 border border-[#F4F7FE] rounded-lg cursor-pointer hover:bg-green-50 transition text-sm">
                            <input type="radio" name="status" value="hadir" required> 
                            <span><i class="fas fa-check-circle text-green-500 mr-1"></i> Hadir</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-[#F4F7FE] rounded-lg cursor-pointer hover:bg-yellow-50 transition text-sm">
                            <input type="radio" name="status" value="izin"> 
                            <span><i class="fas fa-file-alt text-yellow-500 mr-1"></i> Izin</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-[#F4F7FE] rounded-lg cursor-pointer hover:bg-blue-50 transition text-sm">
                            <input type="radio" name="status" value="sakit"> 
                            <span><i class="fas fa-thermometer-half text-blue-500 mr-1"></i> Sakit</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-[#F4F7FE] rounded-lg cursor-pointer hover:bg-red-50 transition text-sm">
                            <input type="radio" name="status" value="alpha"> 
                            <span><i class="fas fa-times-circle text-red-500 mr-1"></i> Alpha</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-[#2B3674] mb-2">
                        <i class="fas fa-pen mr-2 text-[#4318FF]"></i>
                        Keterangan
                        <span class="text-xs text-[#A3AED0] font-normal ml-1">(Opsional)</span>
                    </label>
                    <textarea name="keterangan" rows="3" class="w-full border border-[#F4F7FE] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#4318FF] resize-none" placeholder="Contoh: Terlambat 15 menit, ada keperluan keluarga, sakit dengan surat dokter..."></textarea>
                </div>
            </div>
            
            <div class="p-5 border-t border-[#F4F7FE] flex gap-3">
                <button type="button" onclick="closeAbsensiModal()" class="flex-1 py-2.5 border border-[#F4F7FE] rounded-lg text-sm text-[#A3AED0] font-semibold hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-[#4318FF] text-white rounded-lg text-sm font-semibold hover:bg-[#3520d1] transition">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAbsensiModal() {
    document.getElementById('absensiModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.getElementById('absensiModal')?.addEventListener('click', function(e) {
    if(e.target === this) closeAbsensiModal();
});

document.getElementById('searchAttendance')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const dateCell = row.querySelector('td:first-child');
        if(dateCell && dateCell.textContent.toLowerCase().includes(searchTerm)) {
            row.style.display = '';
        } else if(dateCell && searchTerm === '') {
            row.style.display = '';
        } else if(dateCell) {
            row.style.display = 'none';
        }
    });
});

document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape' && document.getElementById('absensiModal').style.display === 'flex') {
        closeAbsensiModal();
    }
});
</script>

@if(session('success'))
<script>alert('✓ {{ session('success') }}');</script>
@endif

@if(session('error'))
<script>alert('✗ {{ session('error') }}');</script>
@endif
@endsection