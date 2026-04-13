@extends('layouts.student')

@section('title', 'Ruang Konsultasi BK - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Konsultasi BK</h1>
        <p class="text-[#A3AED0]">Butuh teman cerita soal akademis, jurusan, atau beban pikiran? Guru BK siap membantumu!</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <!-- Pilihan Tindakan Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Direct Chat -->
        <div class="bg-gradient-to-br from-[#868CFF] to-[#4318FF] rounded-3xl p-8 text-white relative overflow-hidden shadow-lg shadow-indigo-200">
            <div class="relative z-10 w-full md:w-3/4">
                <h2 class="font-outfit font-bold text-2xl mb-2 flex items-center gap-2"><i class='bx bx-message-rounded-dots'></i> Pesan Cepat</h2>
                <p class="text-indigo-100 text-sm mb-6">Hubungi Guru BK-mu saat ini juga via pesan rahasia.</p>
                
                <form action="{{ route('student.counseling.send') }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="message" rows="3" placeholder="Ceritakan keluhan akademis atau kebingunganmu di sini..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 backdrop-blur-sm resize-none" required></textarea>
                    <button type="submit" class="bg-white text-[#4318FF] px-6 py-2.5 rounded-xl font-bold shadow-md hover:bg-gray-50 flex items-center justify-center gap-2 transition w-full md:w-auto">
                        Kirim Pesan <i class='bx bx-send'></i>
                    </button>
                </form>
            </div>
            <!-- Dekorasi Abstrak -->
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white opacity-10 rounded-full blur-2xl"></div>
        </div>

        <!-- Minta Jadwal Ketemu Fisik -->
        <div class="glass-card bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative cursor-pointer hover:border-indigo-100 transition pt-20">
            <div class="absolute top-8 left-8 w-12 h-12 rounded-xl bg-orange-50 text-orange-500 text-2xl flex items-center justify-center">
                <i class='bx bx-calendar-heart'></i>
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">Buat Janji Temu</h2>
            <p class="text-[#A3AED0] text-sm mb-6">Atur waktu ketemu langsung di ruang BK untuk membicarakan karir / minat kuliah.</p>
            <button class="w-full bg-[#F4F7FE] text-[#2B3674] border-none px-6 py-3 rounded-xl font-bold hover:bg-[#E2E8F0] transition flex items-center justify-center gap-2">
                Atur Jadwal Konsultasi
            </button>
        </div>
    </div>

    <!-- Ruang Obrolan / Riwayat Chat -->
    <div class="pt-8">
        <h3 class="font-bold text-[#2B3674] text-xl mb-4">Ruang Percakapan BK</h3>
        <div class="glass-card bg-white rounded-3xl border border-indigo-50 overflow-hidden flex flex-col h-[550px] shadow-sm">
            
            <div class="flex-1 p-6 overflow-y-auto bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-[#F8FAFC]/90">
                @if(isset($counselingHistory) && $counselingHistory->count() > 0)
                    <div class="text-center mb-8">
                        <span class="bg-indigo-100 text-indigo-500 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                    </div>

                    @foreach($counselingHistory as $msg)
                        @php 
                            // Pastikan relasi sender di-load dan dicek rolenya secara mutlak
                            $isFromBK = ($msg->sender_id !== auth()->id() || ($msg->sender && $msg->sender->role === 'guru_bk')); 
                        @endphp

                        @if(!$isFromBK)
                            <!-- Chat Siswa (Kanan) -->
                            <div class="flex items-end justify-end mb-6 w-full">
                                <div class="flex flex-col items-end max-w-[70%]">
                                    <div class="bg-gradient-to-br from-[#4318FF] to-[#3A14E0] text-white p-4 rounded-3xl rounded-br-sm shadow-md">
                                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1.5">
                                        <p class="text-[10px] font-semibold text-gray-400">{{ $msg->created_at->format('H:i') }}</p>
                                        <i class="bx bx-check-double text-[#4318FF] text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Chat BK (Kiri) -->
                            <div class="flex items-end gap-3 mb-6 w-full">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md font-bold text-xs ring-4 ring-white relative top-2">BK</div>
                                <div class="flex flex-col items-start max-w-[70%]">
                                    <div class="bg-white border border-gray-100 p-4 rounded-3xl rounded-bl-sm shadow-md">
                                        <p class="text-sm text-[#2B3674] font-medium leading-relaxed">{{ $msg->message }}</p>
                                    </div>
                                    <p class="text-[10px] font-semibold text-gray-400 mt-1.5 ml-2">{{ $msg->created_at->format('H:i') }} • Guru BK</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 opacity-50 relative pb-10">
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                            <i class='bx bx-message-rounded-dots text-5xl text-indigo-400'></i>
                        </div>
                        <p class="text-sm text-center font-medium">Ruang chat masih kosong.<br>Silakan kirimkan keluhanmu pada kolom di bawah.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
