@extends('layouts.student')

@section('title', 'Jadwal Temu - Schoolify')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 animate-fadeInUp">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 shadow-lg shadow-purple-500/30 flex items-center justify-center flex-shrink-0">
                <i data-lucide="calendar" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <h1 class="font-outfit font-bold text-3xl text-[var(--brand-secondary)] mb-1">Jadwal Temu & Antrian</h1>
                <p class="text-[var(--text-muted)] text-sm">Pantau status dari janji temu dengan Guru BK.</p>
            </div>
        </div>
        <button onclick="document.getElementById('modal-appointment').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition flex items-center gap-2 shadow-md shadow-indigo-600/30 hover:scale-105">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i> Ajukan Jadwal Baru
        </button>
    </div>

    {{-- Alert Success / Error --}}
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

    {{-- ============================================================ --}}
    {{-- BANNER PANGGILAN DARI BK (muncul jika ada panggilan baru)    --}}
    {{-- ============================================================ --}}
    @php
        $panggilanBaru = $appointments->filter(function($a) {
            return ($a->initiated_by ?? 'student') === 'teacher'
                && in_array($a->status, ['approved', 'pending']);
        });
    @endphp

    @if($panggilanBaru->isNotEmpty())
    <div class="rounded-2xl border-2 p-5 animate-fadeInUp"
         style="background: rgba(168,85,247,.08); border-color: rgba(168,85,247,.4)">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(168,85,247,.2)">
                <i class='bx bx-phone-call text-xl' style="color: var(--accent-light)"></i>
            </div>
            <div>
                <p class="font-outfit font-bold text-base" style="color: var(--text-primary)">
                    Kamu dipanggil oleh Guru BK!
                </p>
                <p class="text-xs" style="color: var(--text-muted)">
                    Hadir sesuai jadwal yang telah ditentukan.
                </p>
            </div>
        </div>
        <div class="space-y-2">
            @foreach($panggilanBaru as $p)
            <div class="flex items-center justify-between rounded-xl px-4 py-3 text-sm"
                 style="background: rgba(168,85,247,.1)">
                <div class="flex items-center gap-2">
                    <i class='bx bx-calendar-event' style="color: var(--accent-light)"></i>
                    <span class="font-bold" style="color: var(--text-primary)">
                        {{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}
                        pukul {{ \Carbon\Carbon::parse($p->time)->format('H:i') }} WIB
                    </span>
                </div>
                @if($p->notes)
                <span class="text-xs px-2 py-1 rounded-lg" style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                    {{ Str::limit($p->notes, 40) }}
                </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ============================================================ --}}
    {{-- TABEL JADWAL TEMU                                            --}}
    {{-- ============================================================ --}}
    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="neo-pressed text-xs uppercase text-[var(--text-muted)] font-bold tracking-wider">
                        <th class="px-6 py-4">Guru BK</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                        <th class="px-6 py-4">Keperluan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr class="hover:neo-pressed transition
                        @if(($appt->initiated_by ?? 'student') === 'teacher' && in_array($appt->status, ['approved','pending'])) bg-purple-50/30 @endif">
                        <td class="px-6 py-4 font-bold text-[var(--brand-secondary)]">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[10px] text-white"
                                     style="background: var(--accent)">BK</div>
                                <span>{{ $appt->teacher->name ?? 'Guru Bimbingan Konseling' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-[var(--brand-secondary)]">
                                {{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}
                            </p>
                            <p class="text-xs text-indigo-600 font-bold">
                                {{ \Carbon\Carbon::parse($appt->time)->format('H:i') }} WIB
                            </p>
                        </td>
                        <td class="px-6 py-4 text-[var(--text-muted)]">
                            {{ $appt->notes ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if(($appt->initiated_by ?? 'student') === 'teacher')
                                <span class="px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                                    <i class='bx bx-phone-call text-xs'></i> Panggilan BK
                                </span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class='bx bx-user text-xs'></i> Permintaanku
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 neo-badge-orange text-white rounded-full text-xs font-bold">Menunggu</span>
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
                        <td colspan="5" class="px-6 py-10 text-center text-[var(--text-muted)]">
                            <div class="w-14 h-14 neo-pressed rounded-full flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="calendar-x" class="w-8 h-8 text-[var(--text-muted)]"></i>
                            </div>
                            <p class="font-bold text-[var(--text-primary)]">Tidak Ada Antrian</p>
                            <p class="text-xs text-[var(--text-muted)] mt-1">Kamu belum memiliki jadwal temu.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL AJUKAN JADWAL (oleh siswa)                             --}}
    {{-- ============================================================ --}}
    <div id="modal-appointment"
         class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/20 backdrop-blur-sm">
        <div class="neo-flat rounded-3xl w-full max-w-md overflow-hidden">
            <div class="px-5 py-4 border-b border-[var(--shadow-dark)]/5 flex justify-between items-center bg-[var(--bg)]">
                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Ajukan Jadwal Temu</h3>
                <button onclick="document.getElementById('modal-appointment').classList.add('hidden')"
                        class="w-8 h-8 neo-btn rounded-full flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('student.appointments.store') }}" method="POST"
                  class="p-5 space-y-4 bg-[var(--bg)]">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                        Pilih Guru BK <span class="text-red-500">*</span>
                    </label>
                    <select name="teacher_id" required
                            class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                        <option value="" disabled selected>Pilih Guru BK</option>
                        @foreach($bkUsers as $bk)
                            <option value="{{ $bk->id }}">{{ $bk->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                        Pilih Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                           class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                        Pilih Jam <span class="text-red-500">*</span>
                    </label>
                    <input type="time" name="time" required
                           class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1.5">
                        Catatan/Tujuan
                        <span class="text-[9px] text-[var(--text-muted)]">(Opsional)</span>
                    </label>
                    <textarea name="notes" rows="3"
                              placeholder="Misal: Konsultasi pemilihan jurusan kuliah..."
                              class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold text-[var(--text-primary)] resize-none"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="calendar-plus" class="w-4 h-4"></i> Ajukan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection