@extends('layouts.student')

@section('title', 'Tugas - Schoolify')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Daftar Tugas</h1>
            <p class="text-[#A3AED0]">Selesaikan semua kewajiban akademismu tepat waktu.</p>
        </div>
        <div class="flex gap-2">
            <button class="bg-[#4318FF] text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-indigo-100">Sedang Aktif</button>
            <button class="bg-white text-[#A3AED0] border border-gray-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50">Selesai</button>
        </div>
    </div>

    @if($assignments->count() > 0)
        <div class="grid grid-cols-1 gap-4">
            @foreach($assignments as $assign)
            <div class="glass-card bg-white p-5 rounded-2xl border border-gray-100 hover:border-indigo-200 transition-colors shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 cursor-pointer group">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class='bx bx-book-bookmark'></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[#2B3674] group-hover:text-[#4318FF] transition">{{ $assign->title ?? 'Tugas Baru' }}</h3>
                        <p class="text-sm font-medium text-[#A3AED0]">{{ $assign->subject->name ?? 'Mata Pelajaran' }} • Diberikan bulan ini</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto">
                    <!-- Deadline Box -->
                    <div class="bg-red-50 border border-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1">
                        <i class='bx bx-time-five text-sm'></i> 
                        Tenggat: {{ $assign->due_date ? \Carbon\Carbon::parse($assign->due_date)->format('d M Y, H:i') : 'Segera' }}
                    </div>
                    <button class="w-full sm:w-auto bg-white border border-gray-200 hover:bg-gray-50 text-[#2B3674] px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                        Kumpulkan Tugas
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-[24px] p-12 text-center bg-white border border-gray-100 mt-8">
            <div class="w-24 h-24 bg-green-50 text-green-500 mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                🎉
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">Tidak Ada Tugas Aktif!</h2>
            <p class="text-[#A3AED0] max-w-md mx-auto">Selamat! Kamu sudah menyelesaikan semua tugas dari guru. Tetap pantau untuk update tugas baru.</p>
        </div>
    @endif
</div>
@endsection
