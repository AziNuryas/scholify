@extends('layouts.student')

@section('title', 'Ruang Konsultasi BK - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="glass-card bg-gradient-to-br from-[#4318FF] to-[#3A14E0] rounded-[32px] p-10 text-white relative overflow-hidden shadow-xl shadow-indigo-200/50 mt-4">
        <div class="relative z-10 w-full md:w-2/3">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-widest mb-4">
                <i class='bx bx-support text-lg'></i> Layanan Bimbingan Konseling
            </div>
            <h1 class="font-outfit font-bold text-4xl mb-4 leading-tight">Jangan Ragu Bercerita,<br>Kami Siap Mendengar!</h1>
            <p class="text-indigo-100 text-sm md:text-base mb-8 leading-relaxed max-w-lg">
                Punya beban pikiran, kebingungan memilih jurusan, atau masalah akademis? Ajukan jadwal pertemuan langsung dengan Guru BK-mu sekarang.
            </p>
            <button onclick="document.getElementById('modal-appointment').classList.remove('hidden'); document.getElementById('modal-appointment').classList.add('flex')" class="bg-white text-[#4318FF] px-8 py-3.5 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 hover:bg-gray-50 flex items-center justify-center gap-3 transition-all">
                <i class='bx bx-calendar-plus text-xl'></i> Ajukan Jadwal Pertemuan
            </button>
        </div>
        
        <!-- Dekorasi Abstrak -->
        <div class="absolute -right-16 -top-16 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute right-10 bottom-10 w-40 h-40 bg-indigo-300 opacity-20 rounded-full blur-2xl"></div>
        
        <!-- Ilustrasi/Icon -->
        <div class="hidden md:flex absolute right-12 top-1/2 -translate-y-1/2 w-64 h-64 items-center justify-center">
            <i class='bx bx-conversation text-[180px] text-white/10 rotate-12'></i>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 font-medium shadow-sm animate-in fade-in slide-in-from-top-4">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
            <i class='bx bx-check text-2xl'></i>
        </div>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3 font-medium shadow-sm animate-in fade-in slide-in-from-top-4">
        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
            <i class='bx bx-x text-2xl'></i>
        </div>
        {{ session('error') }}
    </div>
    @endif

    <!-- Riwayat Janji Temu -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-[#2B3674] text-xl flex items-center gap-2">
                <i class='bx bx-history text-[#4318FF]'></i> Riwayat Pengajuan
            </h3>
        </div>

        @if(isset($appointments) && $appointments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($appointments as $appt)
                    <div class="glass-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Status Strip -->
                        <div class="absolute top-0 left-0 w-full h-1.5 
                            {{ $appt->status === 'approved' ? 'bg-green-500' : ($appt->status === 'rejected' ? 'bg-red-500' : 'bg-amber-400') }}">
                        </div>

                        <div class="flex justify-between items-start mb-4 mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-500 group-hover:scale-110 transition-transform">
                                    <i class='bx bx-calendar text-xl'></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($appt->date)->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-slate-500 font-medium">{{ \Carbon\Carbon::parse($appt->time)->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            
                            @if($appt->status === 'approved')
                                <span class="bg-green-50 text-green-600 border border-green-200 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                    <i class='bx bx-check'></i> Disetujui
                                </span>
                            @elseif($appt->status === 'rejected')
                                <span class="bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                    <i class='bx bx-x'></i> Ditolak
                                </span>
                            @else
                                <span class="bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                    <i class='bx bx-time'></i> Menunggu
                                </span>
                            @endif
                        </div>

                        <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-100 mt-4">
                            <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Topik/Tujuan</p>
                            <p class="text-sm text-slate-700 font-medium line-clamp-2" title="{{ $appt->notes }}">{{ $appt->notes }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-indigo-50 text-indigo-300 rounded-full flex items-center justify-center text-4xl mb-4">
                    <i class='bx bx-calendar-x'></i>
                </div>
                <h4 class="font-bold text-lg text-slate-800 mb-1">Belum Ada Riwayat</h4>
                <p class="text-sm text-slate-500 max-w-sm">Kamu belum pernah mengajukan jadwal pertemuan dengan Guru BK.</p>
            </div>
        @endif
    </div>

    <!-- Modal Buat Janji -->
    <div id="modal-appointment" class="hidden fixed inset-0 z-[100] bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-purple-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#4318FF] rounded-xl flex items-center justify-center shadow-sm">
                        <i class='bx bx-calendar-plus text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[#1E293B]">Ajukan Jadwal Temu</h3>
                        <p class="text-xs text-slate-500 font-medium">Pilih waktu yang pas untuk konsultasi</p>
                    </div>
                </div>
                <button onclick="document.getElementById('modal-appointment').classList.add('hidden'); document.getElementById('modal-appointment').classList.remove('flex')" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 hover:border-rose-100 transition-all">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>
            <form action="{{ route('student.appointment.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $bkUser ? $bkUser->id : '' }}">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#4318FF] focus:bg-white outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Jam <span class="text-red-500">*</span></label>
                        <input type="time" name="time" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#4318FF] focus:bg-white outline-none transition-all">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Topik Pembicaraan <span class="text-red-500">*</span></label>
                    <textarea name="notes" rows="3" placeholder="Misal: Saya bingung memilih jurusan IPA atau IPS..." required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#4318FF] focus:bg-white outline-none transition-all resize-none"></textarea>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-appointment').classList.add('hidden'); document.getElementById('modal-appointment').classList.remove('flex')" class="flex-1 px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 rounded-xl bg-[#4318FF] hover:bg-[#3311CC] text-white font-bold shadow-lg shadow-indigo-200 transition-all text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes zoom-in {
        from { transform: scale(0.95); }
        to { transform: scale(1); }
    }
    .animate-in { animation-duration: 0.2s; animation-fill-mode: both; }
    .fade-in { animation-name: fade-in; }
    .zoom-in { animation-name: zoom-in; }
</style>
@endsection
