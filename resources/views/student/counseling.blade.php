@extends('layouts.student')

@section('title', 'Ruang Konsultasi BK - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="neo-flat rounded-2xl p-10 relative overflow-hidden mt-4 animate-fadeInUp">
        <div class="relative z-10 w-full md:w-2/3">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full neo-pressed text-xs font-bold uppercase tracking-widest text-indigo-600 mb-4">
                <i class='bx bx-support text-lg'></i> Layanan Bimbingan Konseling
            </div>
            <h1 class="font-outfit font-bold text-4xl text-[var(--brand-secondary)] mb-4 leading-tight">Jangan Ragu Bercerita,<br><span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Kami Siap Mendengar!</span></h1>
            <p class="text-[var(--text-muted)] text-sm md:text-base mb-8 leading-relaxed max-w-lg">
                Punya beban pikiran, kebingungan memilih jurusan, atau masalah akademis? Ajukan jadwal pertemuan langsung dengan Guru BK-mu sekarang.
            </p>
            <button onclick="document.getElementById('modal-appointment').classList.remove('hidden'); document.getElementById('modal-appointment').classList.add('flex')" class="neo-badge-blue text-white px-8 py-3.5 rounded-full font-bold flex items-center justify-center gap-3 transition-all hover:opacity-90 hover:scale-105">
                <i class='bx bx-calendar-plus text-xl'></i> Ajukan Jadwal Pertemuan
            </button>
        </div>
        
        <!-- Ilustrasi/Icon -->
        <div class="hidden md:flex absolute right-12 top-1/2 -translate-y-1/2 w-52 h-52 items-center justify-center">
            <div class="neo-pressed rounded-3xl w-full h-full flex items-center justify-center">
                <i class='bx bx-conversation text-[100px] text-indigo-300/30'></i>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="neo-badge-green rounded-2xl px-6 py-4 flex items-center gap-3 font-medium text-white">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
            <i class='bx bx-check text-2xl'></i>
        </div>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="neo-badge-red rounded-2xl px-6 py-4 flex items-center gap-3 font-medium text-white">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
            <i class='bx bx-x text-2xl'></i>
        </div>
        {{ session('error') }}
    </div>
    @endif

    <!-- Riwayat Janji Temu -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-[var(--brand-secondary)] text-xl flex items-center gap-2">
                <i class='bx bx-history text-indigo-500'></i> Riwayat Pengajuan
            </h3>
        </div>

        @if(isset($appointments) && $appointments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($appointments as $appt)
                    <div class="neo-flat rounded-2xl p-6 relative overflow-hidden group neo-card-hover">
                        <!-- Status Strip -->
                        <div class="absolute top-0 left-0 w-full h-1.5 
                            {{ $appt->status === 'approved' ? 'neo-badge-green' : ($appt->status === 'rejected' ? 'neo-badge-red' : 'neo-badge-orange') }}">
                        </div>

                        <div class="flex justify-between items-start mb-4 mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-xl neo-pressed flex items-center justify-center text-[var(--text-muted)] group-hover:scale-110 transition-transform">
                                    <i class='bx bx-calendar text-xl'></i>
                                </div>
                                <div>
                                    <p class="font-bold text-[var(--brand-secondary)] text-sm">{{ \Carbon\Carbon::parse($appt->date)->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-[var(--text-muted)] font-medium">{{ \Carbon\Carbon::parse($appt->time)->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            
                            @if($appt->status === 'approved')
                                <span class="neo-badge-green text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1 text-white">
                                    <i class='bx bx-check'></i> Disetujui
                                </span>
                            @elseif($appt->status === 'rejected')
                                <span class="neo-badge-red text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1 text-white">
                                    <i class='bx bx-x'></i> Ditolak
                                </span>
                            @else
                                <span class="neo-badge-orange text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1 text-white">
                                    <i class='bx bx-time'></i> Menunggu
                                </span>
                            @endif
                        </div>

                        <div class="neo-pressed rounded-xl p-4 mt-4">
                            <p class="text-xs font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Topik/Tujuan</p>
                            <p class="text-sm text-[var(--brand-secondary)] font-medium line-clamp-2" title="{{ $appt->notes }}">{{ $appt->notes }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-flat rounded-2xl p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 neo-pressed text-indigo-500 rounded-full flex items-center justify-center text-4xl mb-4">
                    <i class='bx bx-calendar-x'></i>
                </div>
                <h4 class="font-bold text-lg text-[var(--brand-secondary)] mb-1">Belum Ada Riwayat</h4>
                <p class="text-sm text-[var(--text-muted)] max-w-sm">Kamu belum pernah mengajukan jadwal pertemuan dengan Guru BK.</p>
            </div>
        @endif
    </div>

    <!-- Modal Buat Janji -->
    <div id="modal-appointment" class="hidden fixed inset-0 z-[100] bg-black/40 backdrop-blur-sm items-center justify-center p-4">
        <div class="neo-flat rounded-2xl w-full max-w-md relative overflow-hidden">
            <div class="p-6 neo-pressed flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 neo-badge-blue rounded-xl flex items-center justify-center">
                        <i class='bx bx-calendar-plus text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[var(--brand-secondary)]">Ajukan Jadwal Temu</h3>
                        <p class="text-xs text-[var(--text-muted)] font-medium">Pilih waktu yang pas untuk konsultasi</p>
                    </div>
                </div>
                <button onclick="document.getElementById('modal-appointment').classList.add('hidden'); document.getElementById('modal-appointment').classList.remove('flex')" class="w-8 h-8 rounded-full neo-btn flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 transition-all">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>
            <form action="{{ route('student.appointments.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $bkUser ? $bkUser->id : '' }}">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-[var(--brand-secondary)] mb-1">Pilih Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full neo-input">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[var(--brand-secondary)] mb-1">Pilih Jam <span class="text-red-500">*</span></label>
                        <input type="time" name="time" required class="w-full neo-input">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-[var(--brand-secondary)] mb-1">Topik Pembicaraan <span class="text-red-500">*</span></label>
                    <textarea name="notes" rows="3" placeholder="Misal: Saya bingung memilih jurusan IPA atau IPS..." required class="w-full neo-input resize-none"></textarea>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-appointment').classList.add('hidden'); document.getElementById('modal-appointment').classList.remove('flex')" class="flex-1 px-6 py-3 rounded-full neo-btn text-[var(--brand-secondary)] font-bold transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 rounded-full neo-badge-blue text-white font-bold transition-all text-sm hover:opacity-90 hover:scale-105">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
