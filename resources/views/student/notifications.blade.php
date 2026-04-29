@extends('layouts.student')

@section('title', 'Notifikasi - Scholify')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="mb-6">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Pusat Notifikasi</h1>
        <p class="text-gray-500">Semua pemberitahuan dan aktivitas terbaru Anda.</p>
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notif)
            <div class="neu-flat p-5 rounded-2xl flex gap-4 {{ !$notif->is_read ? 'border-l-4 border-[#4318FF]' : '' }}">
                <div class="w-12 h-12 rounded-xl neu-inset flex items-center justify-center shrink-0 text-[#4318FF]">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-lg text-[#2B3674]">{{ $notif->title }}</h3>
                        <span class="text-xs text-gray-400 font-semibold">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">{{ $notif->message }}</p>
                    <div class="flex items-center gap-3">
                        @if($notif->link)
                            <a href="{{ $notif->link }}" class="text-xs neu-btn px-3 py-1.5 rounded-lg text-[#4318FF] font-bold">Lihat Detail</a>
                        @endif
                        @if(!$notif->is_read)
                            <button onclick="markAsRead({{ $notif->id }}, this)" class="text-xs text-gray-400 hover:text-[#4318FF] font-semibold transition">Tandai sudah dibaca</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="neu-inset p-10 rounded-3xl text-center">
                <i data-lucide="bell-off" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                <h3 class="font-bold text-xl text-[#2B3674] mb-2">Tidak ada notifikasi</h3>
                <p class="text-gray-500">Kamu belum memiliki pemberitahuan baru saat ini.</p>
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
              btnElement.closest('.neu-flat').classList.remove('border-l-4', 'border-[#4318FF]');
              btnElement.remove();
          }
      });
}
</script>
@endsection
