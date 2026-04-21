@extends('layouts.student')

@section('title', 'Konsultasi BK - Schoolify')

@section('content')
<style>
    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes modalPop {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-slideInRight {
        animation: slideInRight 0.5s ease-out forwards;
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.5s ease-out forwards;
    }
    
    .animate-modalPop {
        animation: modalPop 0.3s ease-out forwards;
    }
    
    /* Chat bubble animations */
    .chat-bubble {
        animation: fadeInUp 0.3s ease-out;
    }
    
    /* Custom scrollbar for chat */
    .chat-scroll::-webkit-scrollbar {
        width: 4px;
    }
    
    .chat-scroll::-webkit-scrollbar-track {
        background: #F1F5F9;
        border-radius: 10px;
    }
    
    .chat-scroll::-webkit-scrollbar-thumb {
        background: #C7D2FE;
        border-radius: 10px;
    }
    
    .chat-scroll::-webkit-scrollbar-thumb:hover {
        background: #818CF8;
    }
    
    /* Typing indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 8px 12px;
        background: #F1F5F9;
        border-radius: 20px;
        width: fit-content;
    }
    
    .typing-indicator span {
        width: 6px;
        height: 6px;
        background: #94A3B8;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    
    .typing-indicator span:nth-child(1) { animation-delay: 0s; }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-6px); opacity: 1; }
    }
</style>

<div class="max-w-6xl mx-auto space-y-6 p-4">
    <!-- Header -->
    <div class="animate-fadeInUp">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-1 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
            <span class="text-sm font-semibold text-indigo-500 tracking-wide">LAYANAN KONSULTASI</span>
        </div>
        <h1 class="font-outfit font-bold text-3xl text-slate-800 mb-2">Konsultasi <span class="bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">BK</span></h1>
        <p class="text-slate-500 text-sm">Butuh teman cerita soal akademis, jurusan, atau beban pikiran? Guru BK siap membantumu!</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-xl p-4 animate-fadeInUp">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-emerald-800 text-sm">Berhasil!</p>
                <p class="text-emerald-700 text-xs">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-rose-50 border-l-4 border-rose-500 rounded-xl p-4 animate-fadeInUp">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-rose-800 text-sm">Terjadi kesalahan!</p>
                <p class="text-rose-700 text-xs">{{ $errors->first() }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Pilihan Tindakan Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Direct Chat Card -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slideInLeft">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-4 backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h2 class="font-outfit font-bold text-xl mb-2">Pesan Cepat</h2>
                <p class="text-white/80 text-sm mb-6">Hubungi Guru BK-mu saat ini juga via pesan rahasia.</p>
                
                <form action="{{ route('student.counseling.send') }}" method="POST" class="space-y-3">
                    @csrf
                    <textarea name="message" rows="3" placeholder="Ceritakan keluhan akademis atau kebingunganmu di sini..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-sm text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 backdrop-blur-sm resize-none transition-all"></textarea>
                    <button type="submit" class="w-full md:w-auto bg-white text-indigo-600 px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-50 hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Buat Janji Temu Card -->
        <div class="group relative bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-slideInRight cursor-pointer" onclick="openModal()">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-amber-100 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <div class="relative z-10">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-orange-200 transition-colors duration-300">
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="font-outfit font-bold text-xl text-slate-800 mb-2">Buat Janji Temu</h2>
                <p class="text-slate-500 text-sm mb-6">Atur waktu ketemu langsung di ruang BK untuk membicarakan karir / minat kuliah.</p>
                <button class="w-full bg-slate-100 text-slate-700 px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300 flex items-center justify-center gap-2 group-hover:bg-indigo-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Atur Jadwal Konsultasi
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL BUAT JANJI - DIPOSISIKAN DI TENGAH LAYAR -->
    <div id="modal-appointment" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-all duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-modalPop">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-white text-lg">Ajukan Jadwal Temu</h3>
                            <p class="text-white/80 text-xs">Isi form berikut untuk membuat janji</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Form Modal -->
            <form action="{{ route('student.appointment.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $bkUser ? $bkUser->id : '' }}">
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Tanggal</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Jam</label>
                    <input type="time" name="time" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tujuan / Catatan Acara</label>
                    <textarea name="notes" rows="3" placeholder="Misal: Konsultasi pemilihan jurusan kuliah..." required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 transition-all resize-none"></textarea>
                </div>
                
                <!-- Tombol Modal -->
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-slate-100 text-slate-700 px-4 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-all shadow-sm">
                        Ajukan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ruang Obrolan / Riwayat Chat -->
    <div class="pt-4 animate-fadeInUp">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full"></div>
            <h3 class="font-outfit font-bold text-xl text-slate-800">Ruang Percakapan BK</h3>
            <span class="bg-emerald-100 text-emerald-600 text-xs font-semibold px-2 py-0.5 rounded-full">Live</span>
        </div>
        
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col h-[500px] shadow-sm">
            <!-- Chat Header -->
            <div class="px-5 py-3 bg-gradient-to-r from-slate-50 to-indigo-50/30 border-b border-slate-100 flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center text-white font-bold shadow-md">
                        BK
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                <div>
                    <p class="font-semibold text-slate-800 text-sm">Guru BK</p>
                    <p class="text-xs text-slate-400">Online • Biasanya membalas dalam beberapa menit</p>
                </div>
            </div>
            
            <!-- Chat Messages Container -->
            <div id="chat-messages-container" class="flex-1 p-5 overflow-y-auto chat-scroll bg-gradient-to-b from-slate-50/50 to-white">
                <div class="text-center mb-5">
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                </div>
            </div>

            <!-- Typing Area -->
            <div class="px-5 py-3 border-t border-slate-100 bg-white">
                <form id="chat-form" class="flex items-center gap-3" onsubmit="sendMessage(event)">
                    <button type="button" class="text-slate-400 hover:text-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </button>
                    <input type="text" id="chat-input" placeholder="Ketik pesan..." autocomplete="off" class="flex-1 bg-slate-100 border-none rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-200 transition-all">
                    <button type="submit" class="w-9 h-9 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white flex items-center justify-center transition-all hover:scale-105 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
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

    // Fungsi untuk membuka modal
    function openModal() {
        const modal = document.getElementById('modal-appointment');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        const modal = document.getElementById('modal-appointment');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function scrollToBottom() {
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatTime(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    async function fetchMessages() {
        if (!bkUserId) return;
        try {
            const res = await fetch(`/api/chat/fetch/${bkUserId}`);
            const data = await res.json();
            
            if (data.messages && chatContainer) {
                chatContainer.innerHTML = `
                    <div class="text-center mb-5">
                        <span class="bg-indigo-100 text-indigo-600 text-[10px] font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider">Histori Percakapan Hari Ini</span>
                    </div>
                `;

                if (data.messages.length === 0) {
                    chatContainer.innerHTML += `
                        <div class="flex flex-col items-center justify-center text-center py-12">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium text-sm">Belum ada pesan</p>
                            <p class="text-slate-400 text-xs mt-1">Kirim pesan pertama ke Guru BK</p>
                        </div>
                    `;
                    return;
                }

                data.messages.forEach(msg => {
                    const isMine = msg.is_mine;
                    const time = formatTime(msg.created_at);
                    
                    if (isMine) {
                        chatContainer.innerHTML += `
                            <div class="flex justify-end mb-4 chat-bubble">
                                <div class="max-w-[75%]">
                                    <div class="bg-indigo-500 text-white rounded-2xl rounded-br-md px-4 py-2.5 shadow-sm">
                                        <p class="text-sm leading-relaxed">${escapeHtml(msg.message)}</p>
                                    </div>
                                    <div class="flex items-center justify-end gap-1 mt-1">
                                        <span class="text-[10px] text-slate-400">${time}</span>
                                        <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        chatContainer.innerHTML += `
                            <div class="flex gap-3 mb-4 chat-bubble">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white text-xs font-bold shadow-sm flex-shrink-0">BK</div>
                                <div class="max-w-[70%]">
                                    <div class="bg-slate-100 text-slate-700 rounded-2xl rounded-bl-md px-4 py-2.5 shadow-sm">
                                        <p class="text-sm leading-relaxed">${escapeHtml(msg.message)}</p>
                                    </div>
                                    <div class="mt-1 ml-1">
                                        <span class="text-[10px] text-slate-400">${time} • Guru BK</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });
                scrollToBottom();
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
        
        input.value = '';
        input.disabled = true;

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
            await fetchMessages();
        } catch (e) {
            console.error('Failed to send message', e);
            input.value = message;
        } finally {
            input.disabled = false;
            input.focus();
        }
    }

    // Tutup modal jika klik di luar area modal
    window.onclick = function(event) {
        const modal = document.getElementById('modal-appointment');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Polling every 3 seconds
    setInterval(fetchMessages, 3000);
    
    // Initial fetch
    if (chatContainer) {
        fetchMessages().then(() => setTimeout(scrollToBottom, 500));
    }
</script>
@endsection