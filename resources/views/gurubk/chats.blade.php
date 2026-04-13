@extends('layouts.gurubk')

@section('title', 'Kotak Masuk Konsultasi - Schoolify')

@section('content')
<div class="h-[calc(100vh-140px)] flex flex-col pt-2">
    <div class="mb-6 flex justify-between items-center shrink-0">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#1E293B] mb-1">Pesan Masuk Siswa</h1>
            <p class="text-gray-500 text-sm">Balas keluhan dan curhatan siswa secara privat.</p>
        </div>
    </div>

    <!-- UI Inbox & Chatroom Split -->
    <div class="glass-card bg-white flex-1 rounded-[24px] border border-gray-100 shadow-sm flex overflow-hidden">
        
        <!-- Sidebar Daftar Siswa (Kiri) -->
        <div class="w-full md:w-1/3 bg-gray-50/50 border-r border-gray-100 flex flex-col">
            <div class="p-4 border-b border-gray-100">
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                    <input type="text" placeholder="Cari nama siswa..." class="w-full bg-white border border-gray-200 pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:border-teal-500 transition">
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto">
                @foreach($inbox as $msg)
                <div class="p-4 border-b border-gray-100 hover:bg-white cursor-pointer transition {{ !$msg->is_read ? 'bg-teal-50/30' : '' }}" 
                     onclick="window.location.search = 'student_id={{ $msg->sender_id }}'">
                    <div class="flex items-start gap-3">
                        <img src="{{ $msg->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($msg->student_name) }}" class="w-10 h-10 rounded-full shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-0.5">
                                <h4 class="font-bold text-sm {{ !$msg->is_read ? 'text-[#1E293B]' : 'text-gray-600' }} truncate">{{ $msg->student_name }}</h4>
                                <span class="text-[10px] whitespace-nowrap {{ !$msg->is_read ? 'text-teal-600 font-bold' : 'text-gray-400' }} ml-2">{{ $msg->time }}</span>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 mb-1">{{ $msg->class }}</p>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-xs text-gray-500 truncate">{{ $msg->last_message }}</p>
                                @if(!$msg->is_read)
                                    <span class="w-2 h-2 bg-red-500 rounded-full shrink-0 shadow-sm ml-2"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($inbox->isEmpty())
                <div class="p-10 text-center text-gray-400 text-sm">Belum ada pesan masuk.</div>
                @endif
            </div>
        </div>

        <!-- Chat Area (Kanan) -->
        <div class="hidden md:flex flex-1 flex-col bg-white relative">
            @if($selectedStudent)
            <!-- Alert jika simulasi post data diketik (dummy function trigger form) -->
            @if(session('success'))
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg text-sm z-50 flex items-center gap-2 shadow-lg">
                <i class='bx bx-check-circle text-teal-400'></i> {{ session('success') }}
            </div>
            @endif

            <!-- Top Header Chat -->
            <div class="h-16 px-6 border-b border-gray-100 flex justify-between items-center bg-white/90 backdrop-blur shrink-0">
                <div class="flex items-center gap-3">
                    <img src="{{ $selectedStudent->student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedStudent->name) }}" class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="font-bold text-[#1E293B] text-sm">{{ $selectedStudent->name }}</h3>
                        <p class="text-xs text-teal-600 font-medium">{{ $selectedStudent->student->schoolClass->name ?? 'Siswa' }} • Percakapan Aktif</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-full bg-gray-50 hover:bg-gray-100 text-gray-500 flex items-center justify-center transition" title="Lihat Profil Siswa"><i class='bx bx-info-circle'></i></button>
                </div>
            </div>

            <!-- Message History Area -->
            <div class="flex-1 p-6 overflow-y-auto bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-[#F8FAFC]/90">
                <div class="text-center mb-8">
                    <span class="bg-teal-100 text-teal-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                </div>
                
                @foreach($messages as $msg)
                    @php
                        $isFromBK = ($msg->sender_id === auth()->id() || ($msg->sender && $msg->sender->role === 'guru_bk'));
                    @endphp

                    @if($isFromBK)
                        <!-- Chat Guru (Kanan) -->
                        <div class="flex items-end justify-end mb-6 w-full">
                            <div class="flex flex-col items-end max-w-[70%]">
                                <div class="bg-gradient-to-br from-teal-500 to-emerald-400 text-white p-4 rounded-3xl rounded-br-sm shadow-md">
                                    <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                </div>
                                <div class="flex items-center gap-1 mt-1.5">
                                    <p class="text-[10px] font-semibold text-gray-400">{{ $msg->created_at->format('H:i') }}</p>
                                    <i class="bx bx-check-double text-teal-500 text-sm"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Chat Anak (Kiri) -->
                        <div class="flex items-end gap-3 mb-6 w-full">
                            <img src="{{ $selectedStudent->student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedStudent->name) }}" class="w-9 h-9 rounded-full shrink-0 shadow-md ring-4 ring-white relative top-2">
                            <div class="flex flex-col items-start max-w-[70%]">
                                <div class="bg-white border border-gray-100 p-4 rounded-3xl rounded-bl-sm shadow-md">
                                    <p class="text-sm text-[#1E293B] font-medium leading-relaxed">{{ $msg->message }}</p>
                                </div>
                                <p class="text-[10px] font-semibold text-gray-400 mt-1.5 ml-2">{{ $msg->created_at->format('H:i') }} • {{ explode(' ', $selectedStudent->name)[0] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($messages->isEmpty())
                <div class="h-full flex flex-col items-center justify-center text-gray-400 opacity-50 relative pb-10">
                    <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mb-4">
                        <i class='bx bx-message-rounded-dots text-5xl text-teal-400'></i>
                    </div>
                    <p class="text-sm text-center font-medium">Belum ada riwayat percakapan.<br>Jawab keluhan siswa di bawah.</p>
                </div>
                @endif
            </div>

            <!-- Typing Area -->
            <div class="h-20 px-6 border-t border-gray-100 bg-white flex items-center shrink-0">
                <form action="{{ route('gurubk.reply') }}" method="POST" class="w-full flex items-center gap-4">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                    <button type="button" class="text-gray-400 hover:text-teal-600 transition"><i class='bx bx-paperclip text-2xl'></i></button>
                    <input type="text" name="message" placeholder="Ketik balasan untuk memotivasi anak ini..." required class="flex-1 bg-gray-100 border-none rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-500 transition">
                    <button type="submit" class="w-12 h-12 rounded-xl bg-teal-600 hover:bg-teal-700 shadow-md shadow-teal-200 text-white flex items-center justify-center transition transform hover:scale-105">
                        <i class='bx bxs-send text-xl relative left-0.5'></i>
                    </button>
                </form>
            </div>
            @else
            <!-- Placeholder jika tidak ada chat terpilih -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-10 bg-gray-50">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-4xl shadow-sm border border-gray-100 mb-4 animate-bounce">
                    <i class='bx bx-message-detail text-teal-600 font-bold'></i>
                </div>
                <h3 class="font-outfit font-bold text-xl text-[#1E293B] mb-2">Pilih Pesan Siswa</h3>
                <p class="text-gray-500 max-w-xs text-sm">Klik salah satu daftar siswa di panel kiri untuk mulai memberikan bimbingan atau solusi.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
