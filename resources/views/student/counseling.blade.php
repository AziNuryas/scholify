@extends('layouts.student')

@section('title', 'Konsultasi BK - Schoolify')
@section('page-title', 'Bimbingan Konseling')

@section('content')
<div class="h-[calc(100vh-140px)] flex flex-col gap-6 animate-fadeInUp">
    
    <div class="flex flex-col md:flex-row gap-6 h-full">
        <!-- Sidebar: Info Guru BK -->
        <div class="w-full md:w-80 flex flex-col gap-6">
            <div class="neo-flat rounded-3xl p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-3xl neo-pressed p-2 mb-4">
                    <div class="w-full h-full rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-indigo-500/20">
                        @if($bkUser && $bkUser->avatar)
                            <img src="{{ $bkUser->avatar }}" class="w-full h-full object-cover rounded-2xl" alt="Avatar">
                        @else
                            {{ strtoupper(substr($bkUser->name ?? 'BK', 0, 2)) }}
                        @endif
                    </div>
                </div>
                <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">{{ $bkUser->name ?? 'Guru BK' }}</h3>
                <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mt-1">Konselor Sekolah</p>
                
                <div class="w-full h-px bg-[var(--shadow-dark)]/10 my-6"></div>
                
                <div class="w-full space-y-4">
                    <div class="flex items-center gap-3 text-left p-3 neo-pressed rounded-2xl">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase">Jam Kerja</p>
                            <p class="text-xs font-bold text-[var(--text-primary)]">07:30 - 15:30</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-left p-3 neo-pressed rounded-2xl">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase">Privasi</p>
                            <p class="text-xs font-bold text-[var(--text-primary)]">Rahasia Terjamin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="neo-flat rounded-3xl p-4">
                <a href="{{ route('student.appointments') }}" class="flex items-center justify-between p-3 neo-btn rounded-2xl group transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold text-[var(--text-primary)]">Buat Janji Temu</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-[var(--text-muted)]"></i>
                </a>
            </div>
        </div>

        <!-- Main: Chat Area -->
        <div class="flex-1 neo-flat rounded-3xl overflow-hidden flex flex-col relative">
            <!-- Chat Header -->
            <div class="p-4 border-b border-[var(--shadow-dark)]/5 flex items-center justify-between bg-[var(--bg)]/50 backdrop-blur-sm z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl neo-pressed flex items-center justify-center text-indigo-500">
                        <i data-lucide="messages-square" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-outfit font-bold text-sm text-[var(--text-primary)]">Ruang Konsultasi</h4>
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-tighter">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 custom-scroll bg-[var(--bg)]/30">
                @forelse($counselingHistory as $chat)
                    @php $isMe = $chat->sender_id == auth()->id(); @endphp
                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} animate-fadeInUp">
                        <div class="max-w-[80%] md:max-w-[70%]">
                            <div class="flex items-center gap-2 mb-1.5 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                <p class="text-[10px] font-bold text-[var(--text-muted)] uppercase">{{ $isMe ? 'Saya' : ($bkUser->name ?? 'Guru BK') }}</p>
                                <p class="text-[9px] text-[var(--text-muted)]">{{ $chat->created_at->format('H:i') }}</p>
                            </div>
                            <div class="{{ $isMe ? 'neo-flat bg-indigo-600 text-white rounded-2xl rounded-tr-none' : 'neo-pressed bg-white/50 text-[var(--text-primary)] rounded-2xl rounded-tl-none' }} px-4 py-3 shadow-sm">
                                <p class="text-sm leading-relaxed">{{ $chat->message }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center opacity-50">
                        <div class="w-20 h-20 neo-pressed rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="message-circle" class="w-10 h-10 text-[var(--text-muted)]"></i>
                        </div>
                        <h5 class="font-bold text-[var(--text-primary)]">Belum ada percakapan</h5>
                        <p class="text-xs text-[var(--text-muted)] max-w-[200px] mt-1">Mulai konsultasi dengan mengirimkan pesan pertama Anda.</p>
                    </div>
                @endforelse
            </div>

            <!-- Chat Input -->
            <div class="p-4 bg-[var(--bg)]/80 backdrop-blur-md border-t border-[var(--shadow-dark)]/5">
                <form action="{{ route('student.counseling.send') }}" method="POST" class="flex gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <input type="text" name="message" required placeholder="Tulis pesan konsultasi..." 
                               class="w-full neo-pressed rounded-2xl px-5 py-3.5 text-sm font-medium text-[var(--text-primary)] focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                    <button type="submit" class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/30 hover:scale-105 active:scale-95 transition-all">
                        <i data-lucide="send" class="w-6 h-6"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto scroll to bottom
    const container = document.getElementById('chat-container');
    if (container) container.scrollTop = container.scrollHeight;
</script>
@endsection
