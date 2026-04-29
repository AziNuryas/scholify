@extends('layouts.student')

@section('title', 'Jadwal Temu - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 animate-fadeInUp">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-1 h-8 neo-badge-blue rounded-full"></div>
                <span class="text-sm font-bold text-indigo-500 tracking-wide">APPOINTMENTS</span>
            </div>
            <h1 class="font-outfit font-bold text-3xl text-[var(--brand-secondary)] mb-2">Jadwal Temu & Antrian</h1>
            <p class="text-[var(--text-muted)]">Pantau status dari janji temu yang telah kamu ajukan ke Guru BK.</p>
        </div>
        <button onclick="document.getElementById('modal-appointment').classList.remove('hidden')" class="neo-badge-blue text-white px-6 py-3 rounded-full font-bold transition flex items-center gap-2 hover:scale-105 hover:opacity-90">
            <i class='bx bx-calendar-plus'></i> Ajukan Jadwal Baru
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="neo-badge-green rounded-xl px-4 py-3 flex items-center gap-2 font-medium text-white">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="neo-badge-red rounded-xl px-4 py-3 flex items-center gap-2 font-medium text-white">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="neo-badge-red rounded-xl px-4 py-3 font-medium text-white">
        <p class="font-bold mb-2"><i class='bx bx-error-circle text-xl'></i> Terjadi kesalahan validasi:</p>
        <ul class="list-disc ml-6 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="neo-pressed text-xs uppercase text-[var(--text-muted)] font-bold tracking-wider">
                        <th class="px-6 py-4">Guru BK</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Tujuan</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr class="hover:neo-pressed transition">
                        <td class="px-6 py-4 font-bold text-[var(--brand-secondary)]">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full neo-badge-green text-white flex items-center justify-center font-bold text-[10px]">BK</div>
                                <span>{{ $appt->teacher->name ?? 'Guru Bimbingan Konseling' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-[var(--brand-secondary)]">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                            <p class="text-xs text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-[var(--text-muted)]">{{ $appt->notes ?: '-' }}</td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 neo-badge-orange text-white rounded-full text-xs font-bold">Menunggu Persetujuan</span>
                            @elseif($appt->status === 'approved')
                                <span class="px-3 py-1 neo-badge-green text-white rounded-full text-xs font-bold">Disetujui</span>
                            @elseif($appt->status === 'completed')
                                <span class="px-3 py-1 neo-badge-blue text-white rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 neo-badge-red text-white rounded-full text-xs font-bold">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-[var(--text-muted)]">
                            <div class="w-14 h-14 neo-pressed rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class='bx bx-calendar-x text-2xl text-[var(--text-muted)]'></i>
                            </div>
                            Kamu belum memiliki antrian jadwal temu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Buat Janji -->
    <div id="modal-appointment" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/20 backdrop-blur-sm transition-opacity">
        <div class="neo-flat rounded-3xl w-full max-w-md overflow-hidden transform transition-transform scale-100">
            <div class="px-5 py-4 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center bg-[var(--bg)]">
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Ajukan Jadwal Temu</h3>
                <button onclick="document.getElementById('modal-appointment').classList.add('hidden')" class="w-8 h-8 neo-btn rounded-full flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('student.appointments.store') }}" method="POST" class="p-5 space-y-4 bg-[var(--bg)]">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Pilih Guru BK <span class="text-red-500">*</span></label>
                    <select name="teacher_id" required class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                        <option value="" disabled selected>Pilih Guru BK</option>
                        @foreach($bkUsers as $bk)
                            <option value="{{ $bk->id }}">{{ $bk->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Pilih Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Pilih Jam <span class="text-red-500">*</span></label>
                    <input type="time" name="time" required class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">Catatan/Tujuan <span class="text-[9px] text-[var(--text-muted)]">(Opsional)</span></label>
                    <textarea name="notes" rows="3" placeholder="Misal: Konsultasi pemilihan jurusan kuliah..." class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)] resize-none"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="calendar-plus" class="w-4 h-4"></i> Ajukan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
