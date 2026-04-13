@extends('layouts.student')

@section('title', 'Jadwal Temu - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Jadwal Temu & Antrian</h1>
            <p class="text-[#A3AED0]">Pantau status dari janji temu yang telah kamu ajukan ke Guru BK.</p>
        </div>
        <button onclick="document.getElementById('modal-appointment').classList.remove('hidden')" class="bg-[#4318FF] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl font-bold shadow-md shadow-indigo-200 transition flex items-center gap-2">
            <i class='bx bx-calendar-plus'></i> Ajukan Jadwal Baru
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 font-medium">
        <p class="font-bold mb-2"><i class='bx bx-error-circle text-xl'></i> Terjadi kesalahan validasi:</p>
        <ul class="list-disc ml-6 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="glass-card bg-white rounded-3xl border border-indigo-50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-[#A3AED0] font-bold tracking-wider">
                        <th class="px-6 py-4">Guru BK</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Tujuan</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 font-bold text-[#2B3674]">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-emerald-500 text-white flex items-center justify-center font-bold text-[10px]">BK</div>
                                <span>{{ $appt->teacher->name ?? 'Guru Bimbingan Konseling' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-[#2B3674]">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                            <p class="text-xs text-[#4318FF] font-bold">{{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-[#A3AED0]">{{ $appt->notes ?: '-' }}</td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu Persetujuan</span>
                            @elseif($appt->status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Disetujui</span>
                            @elseif($appt->status === 'completed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-[#A3AED0]">Kamu belum memiliki antrian jadwal temu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Guru BK</label>
                    <select name="teacher_id" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#4318FF] outline-none">
                        @foreach($bkUsers as $bk)
                            <option value="{{ $bk->id }}">{{ $bk->name }}</option>
                        @endforeach
                    </select>
                </div>
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
</div>
@endsection
