@extends('layouts.student')

@section('title', 'Notifikasi - Scholify')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="mb-6 animate-fadeInUp">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-1 h-8 neo-badge-blue rounded-full"></div>
            <span class="text-sm font-bold text-indigo-500 tracking-wide">NOTIFICATIONS</span>
        </div>
        <h1 class="font-outfit font-bold text-3xl text-[var(--brand-secondary)] mb-2">Pusat Notifikasi</h1>
        <p class="text-[var(--text-muted)]">Semua pemberitahuan dan aktivitas terbaru Anda.</p>
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notif)
            <div class="neo-flat p-5 rounded-2xl flex gap-4 {{ !$notif->is_read ? 'ring-2 ring-indigo-400' : '' }} neo-card-hover">
                <div class="w-12 h-12 rounded-xl neo-pressed flex items-center justify-center shrink-0 text-indigo-500">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-lg text-[var(--brand-secondary)]">{{ $notif->title }}</h3>
                        <span class="text-xs text-[var(--text-muted)] font-semibold">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                    </div>
                    <p class="text-[var(--text-muted)] text-sm mb-3">{{ $notif->message }}</p>
                    <div class="flex items-center gap-3">
                        @if($notif->link)
                            <a href="{{ $notif->link }}" class="text-xs neo-badge-blue px-3 py-1.5 rounded-lg text-white font-bold">Lihat Detail</a>
                        @endif
                        @if(!$notif->is_read)
                            <button onclick="markAsRead({{ $notif->id }}, this)" class="text-xs text-[var(--text-muted)] hover:text-indigo-600 font-semibold transition neo-btn px-3 py-1.5 rounded-lg">Tandai sudah dibaca</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="neo-pressed p-10 rounded-2xl text-center">
                <div class="w-16 h-16 neo-flat rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="bell-off" class="w-8 h-8 text-[var(--text-muted)]"></i>
                </div>
                <h3 class="font-bold text-xl text-[var(--brand-secondary)] mb-2">Tidak ada notifikasi</h3>
                <p class="text-[var(--text-muted)]">Kamu belum memiliki pemberitahuan baru saat ini.</p>
            </div>
        @endforelse
        
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

<script>
function markAsRead(id, btnElement) {
    fetch(`/student/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    }).then(res => res.json())
      .then(data => {
          if(data.success) {
              btnElement.closest('.neo-flat').classList.remove('ring-2', 'ring-indigo-400');
              btnElement.remove();
          }
      });
}
</script>
@endsection
