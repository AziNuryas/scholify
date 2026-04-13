@extends('layouts.gurubk')

@section('title', 'Dashboard Bimbingan Konseling - Schoolify')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <!-- Header Greeting -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#1E293B] mb-2">Selamat Datang, {{ explode(',', $guru['name'])[0] }}!</h1>
            <p class="text-gray-500">Pantau kesehatan mental dan perkembangan karakter seluruh siswa di sini.</p>
        </div>
        <div class="text-sm font-bold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg flex items-center gap-2">
            <i class='bx bx-calendar-event text-lg'></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <!-- Metrik Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm flex items-center gap-5 hover:border-teal-200 transition">
            <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-3xl">
                <i class='bx bx-group'></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Total Siswa Aktif</p>
                <h3 class="font-outfit font-black text-2xl text-[#1E293B]">{{ number_format($stats['total_students']) }}</h3>
            </div>
        </div>
        
        <div class="glass-card bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm flex items-center gap-5 hover:border-teal-200 transition">
            <div class="w-14 h-14 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center text-3xl">
                <i class='bx bx-user-voice'></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Kasus Berjalan</p>
                <h3 class="font-outfit font-black text-2xl text-[#1E293B]">{{ $stats['active_cases'] }}</h3>
            </div>
        </div>

        <div class="glass-card bg-teal-600 p-6 rounded-[24px] shadow-lg shadow-teal-200 flex items-center gap-5 text-white transform hover:-translate-y-1 transition cursor-pointer" onclick="window.location.href='{{ route('gurubk.chats') }}'">
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-3xl">
                <i class='bx bx-envelope'></i>
            </div>
            <div>
                <p class="text-sm font-bold text-teal-100 uppercase tracking-wide">Pesan Baru</p>
                <h3 class="font-outfit font-black text-2xl shadow-sm">{{ $stats['unread_messages'] }} Siswa</h3>
            </div>
        </div>

        <div class="glass-card bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm flex items-center gap-5 hover:border-teal-200 transition">
            <div class="w-14 h-14 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-3xl">
                <i class='bx bx-calendar-heart'></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Jadwal Temu Hari Ini</p>
                <h3 class="font-outfit font-black text-2xl text-[#1E293B]">{{ $stats['appointments_today'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Daftar Jadwal & Kasus -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Agenda Hari Ini -->
        <div class="lg:col-span-2 glass-card bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 md:p-8">
            <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                <h3 class="font-bold text-lg text-[#1E293B]"><i class='bx bx-notepad text-teal-500 mr-2'></i> Agenda Temu Fisik</h3>
                <button class="text-sm font-bold text-teal-600 hover:text-teal-800">Lihat Semua</button>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-teal-50 transition border border-transparent hover:border-teal-100 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=Dimas&background=random" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-[#1E293B]">Dimas Aditya (XII TKR 2)</h4>
                            <p class="text-sm text-gray-500">Konsultasi SNMPTN & Pemilihan Jurusan</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-teal-600 bg-white px-3 py-1 rounded inline-block shadow-sm">13:00 WIB</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-teal-50 transition border border-transparent hover:border-teal-100 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=Siti&background=random" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-[#1E293B]">Siti Nurbaya (X MIPA 1)</h4>
                            <p class="text-sm text-red-500 font-medium">Kasus Pendisiplinan (Ketidakhadiran)</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-teal-600 bg-white px-3 py-1 rounded inline-block shadow-sm">14:30 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shortcut Action -->
        <div class="glass-card bg-gradient-to-br from-[#1E293B] to-[#334155] rounded-[24px] shadow-lg p-8 relative overflow-hidden flex flex-col justify-center">
            <div class="relative z-10 text-white">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-2xl mb-6">
                    <i class='bx bxs-report'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl mb-2">Buat Laporan Baru</h3>
                <p class="text-gray-300 text-sm mb-6">Catat pelanggaran atau lapor keluhan perkembangan karakter siswa secara manual ke dalam sistem.</p>
                <button onclick="alert('Formulir Laporan BK')" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 rounded-xl transition shadow-md">
                    Isi Laporan
                </button>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -bottom-10 -right-10 w-40 h-40 border-[20px] border-white/5 rounded-full"></div>
        </div>
    </div>
</div>
@endsection
