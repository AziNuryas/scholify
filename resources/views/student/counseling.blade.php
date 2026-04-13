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
            <button onclick="document.getElementById('modal-appointment').classList.remove('hidden')" class="w-full bg-[#F4F7FE] text-[#2B3674] border-none px-6 py-3 rounded-xl font-bold hover:bg-[#E2E8F0] transition flex items-center justify-center gap-2">
                Atur Jadwal Konsultasi
            </button>
        </div>
    </div>

    <!-- Modal Buat Janji -->
    <div id="modal-appointment" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-outfit font-bold text-xl text-[#1E293B]">Ajukan Jadwal Temu</h3>
                <button onclick="document.getElementById('modal-appointment').classList.add('hidden')" class="text-gray-400 hover:text-red-500"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="{{ route('student.appointment.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $bkUser ? $bkUser->id : '' }}">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Tanggal</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#4318FF] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Jam</label>
                    <input type="time" name="time" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#4318FF] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tujuan / Catatan Acara</label>
                    <textarea name="notes" rows="3" placeholder="Misal: Konsultasi pemilihan jurusan kuliah..." required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#4318FF] outline-none"></textarea>
                </div>
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#4318FF] hover:bg-blue-800 text-white rounded-xl py-3 font-bold shadow-md shadow-indigo-200 transition">Ajukan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ruang Obrolan / Riwayat Chat -->
    <div class="pt-8">
        <h3 class="font-bold text-[#2B3674] text-xl mb-4">Ruang Percakapan BK</h3>
        <div class="glass-card bg-white rounded-3xl border border-indigo-50 overflow-hidden flex flex-col h-[550px] shadow-sm relative">
            
            <div id="chat-messages-container" class="flex-1 p-6 overflow-y-auto bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-[#F8FAFC]/90">
                <div class="text-center mb-8">
                    <span class="bg-indigo-100 text-indigo-500 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                </div>
                <!-- Messages will be loaded here via JS -->
            </div>

            <!-- Typing Area -->
            <div class="h-20 px-6 border-t border-gray-100 bg-white flex items-center shrink-0">
                <form id="chat-form" class="w-full flex items-center gap-4" onsubmit="sendMessage(event)">
                    <button type="button" class="text-gray-400 hover:text-[#4318FF] transition"><i class='bx bx-paperclip text-2xl'></i></button>
                    <input type="text" id="chat-input" placeholder="Ketik pesan..." required class="flex-1 bg-gray-100 border-none rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#4318FF] transition">
                    <button type="submit" class="w-12 h-12 rounded-xl bg-[#4318FF] hover:bg-blue-800 shadow-md shadow-indigo-200 text-white flex items-center justify-center transition transform hover:scale-105">
                        <i class='bx bxs-send text-xl relative left-0.5'></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const bkUserId = {{ $bkUser ? $bkUser->id : 'null' }};
    const chatContainer = document.getElementById('chat-messages-container');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    async function fetchMessages() {
        if (!bkUserId) return;
        try {
            const res = await fetch(`/api/chat/fetch/${bkUserId}`);
            const data = await res.json();
            
            if (data.messages) {
                // Clear state but keep the header
                chatContainer.innerHTML = `
                    <div class="text-center mb-8">
                        <span class="bg-indigo-100 text-indigo-500 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                    </div>
                `;

                if (data.messages.length === 0) {
                     chatContainer.innerHTML += `
                     <div class="h-full flex flex-col items-center justify-center text-gray-400 opacity-50 relative pb-10 mt-10">
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                            <i class='bx bx-message-rounded-dots text-5xl text-indigo-400'></i>
                        </div>
                        <p class="text-sm text-center font-medium">Ruang chat masih kosong.<br>Silakan kirimkan pesanmu.</p>
                    </div>`;
                    return;
                }

                data.messages.forEach(msg => {
                    const isMine = msg.is_mine;
                    if (isMine) {
                        chatContainer.innerHTML += `
                            <div class="flex items-end justify-end mb-6 w-full">
                                <div class="flex flex-col items-end max-w-[70%]">
                                    <div class="bg-gradient-to-br from-[#4318FF] to-[#3A14E0] text-white p-4 rounded-3xl rounded-br-sm shadow-md">
                                        <p class="text-sm leading-relaxed">${msg.message}</p>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1.5">
                                        <p class="text-[10px] font-semibold text-gray-400">${msg.time}</p>
                                        <i class="bx bx-check-double text-[#4318FF] text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        chatContainer.innerHTML += `
                            <div class="flex items-end gap-3 mb-6 w-full">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md font-bold text-xs ring-4 ring-white relative top-2">BK</div>
                                <div class="flex flex-col items-start max-w-[70%]">
                                    <div class="bg-white border border-gray-100 p-4 rounded-3xl rounded-bl-sm shadow-md">
                                        <p class="text-sm text-[#2B3674] font-medium leading-relaxed">${msg.message}</p>
                                    </div>
                                    <p class="text-[10px] font-semibold text-gray-400 mt-1.5 ml-2">${msg.time} • Guru BK</p>
                                </div>
                            </div>
                        `;
                    }
                });
            }
        } catch(e) {
            console.error('Error fetching messages', e);
        }
    }

    async function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message || !bkUserId) return;
        
        input.value = ''; // Clear input eagerly

        try {
            await fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    receiver_id: bkUserId,
                    message: message
                })
            });
            fetchMessages().then(scrollToBottom);
        } catch (e) {
            console.error('Failed to send message', e);
        }
    }

    // Polling every 3 seconds
    setInterval(fetchMessages, 3000);
    
    // Initial fetch
    fetchMessages().then(() => setTimeout(scrollToBottom, 500));
</script>
@endsection
