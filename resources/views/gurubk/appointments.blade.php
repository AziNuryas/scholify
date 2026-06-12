@extends('layouts.gurubk')

@section('title', 'Jadwal Temu - Schoolify')
@section('page-title', 'Jadwal Temu')

@section('content')
<div class="space-y-6 pt-2 animate-fadeInUp">

    <div class="mb-2">
        <h1 class="font-outfit font-bold text-3xl mb-1" style="color: var(--text-primary)">Jadwal Temu Siswa</h1>
        <p class="text-sm" style="color: var(--text-secondary)">Kelola permintaan antrian konsultasi langsung dari siswa.</p>
    </div>

    @if(session('success'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="border px-4 py-3 rounded-xl flex items-center gap-2 font-medium"
         style="background: rgba(239,68,68,.1); border-color: rgba(239,68,68,.3); color: #f87171">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    {{-- Filter --}}
    <div class="neo-flat rounded-2xl p-4">
        <form method="GET" action="{{ route('gurubk.appointments') }}" class="flex flex-wrap gap-3 items-end">

            {{-- Filter Status --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Status</label>
                <select name="status"
                        class="text-xs rounded-lg px-3 py-2 outline-none"
                        style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                    <option value="">Semua Status</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Disetujui</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            {{-- Filter Sumber --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Sumber</label>
                <select name="sumber"
                        class="text-xs rounded-lg px-3 py-2 outline-none"
                        style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
                    <option value="">Semua Sumber</option>
                    <option value="teacher" {{ request('sumber') === 'teacher' ? 'selected' : '' }}>Panggilan BK</option>
                    <option value="student" {{ request('sumber') === 'student' ? 'selected' : '' }}>Permintaan Siswa</option>
                </select>
            </div>

            {{-- Filter Tanggal Dari --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Dari Tanggal</label>
                <input type="date" name="dari"
                       value="{{ request('dari') }}"
                       class="text-xs rounded-lg px-3 py-2 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
            </div>

            {{-- Filter Tanggal Sampai --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Sampai Tanggal</label>
                <input type="date" name="sampai"
                       value="{{ request('sampai') }}"
                       class="text-xs rounded-lg px-3 py-2 outline-none"
                       style="background: var(--bg); border: 1px solid var(--border); color: var(--text-primary)">
            </div>

            {{-- Tombol Filter + Reset --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 text-xs text-white rounded-lg transition"
                        style="background: var(--accent)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">
                    <i class='bx bx-filter-alt'></i> Filter
                </button>
                @if(request()->hasAny(['status','sumber','dari','sampai']))
                    <a href="{{ route('gurubk.appointments') }}"
                       class="px-4 py-2 text-xs rounded-lg transition flex items-center gap-1"
                       style="border: 1px solid var(--border); color: var(--text-secondary)">
                        <i class='bx bx-x'></i> Reset
                    </a>
                @endif
            </div>

            {{-- Tombol Panggil Siswa (paling kanan) --}}
            <div class="ml-auto">
                <button type="button"
                        onclick="document.getElementById('modal-panggil').classList.remove('hidden')"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-white transition hover:scale-105 shadow-md"
                        style="background: var(--accent)">
                    <i class='bx bx-phone-call text-lg'></i> Panggil Siswa
                </button>
            </div>

        </form>
    </div>

    <div class="neo-flat rounded-2xl overflow-hidden">
        <div class="p-6 flex justify-between items-center" style="border-bottom: 1px solid var(--border)">
            <h2 class="font-outfit font-bold text-lg" style="color: var(--text-primary)">Daftar Permintaan Jadwal</h2>
            <span class="text-xs font-medium px-3 py-1 rounded-full"
                  style="background: rgba(168,85,247,.12); color: var(--accent-light)">
                {{ $appointments->total() }} data
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs uppercase font-bold tracking-wider" style="border-bottom: 1px solid var(--border); color: var(--text-muted)">
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Tanggal &amp; Waktu</th>
                        <th class="px-6 py-4">Catatan/Alasan</th>
                        <th class="px-6 py-4">Sumber</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($appointments as $appt)
                    <tr style="border-bottom: 1px solid var(--border); transition: background .15s"
                        onmouseover="this.style.background='rgba(168,85,247,.06)'" onmouseout="this.style.background=''">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $appt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($appt->student->name ?? 'S') }}"
                                     class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold" style="color: var(--text-primary)">{{ $appt->student->name ?? '-' }}</p>
                                    <p class="text-xs" style="color: var(--text-muted)">{{ $appt->student->schoolClass->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium" style="color: var(--text-secondary)">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                            <p class="text-xs font-bold" style="color: var(--accent-light)">
                                <i class='bx bx-time-five'></i> {{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}
                            </p>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate" style="color: var(--text-secondary)" title="{{ $appt->notes }}">
                            {{ $appt->notes ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if(($appt->initiated_by ?? 'student') === 'teacher')
                                <span class="px-2 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">
                                    <i class='bx bx-phone-call'></i> Panggilan BK
                                </span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                    <i class='bx bx-user'></i> Permintaan Siswa
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($appt->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                            @elseif($appt->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold"
                                      style="background: rgba(168,85,247,.15); color: var(--accent-light)">Disetujui</span>
                            @elseif($appt->status === 'completed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($appt->status === 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="w-8 h-8 rounded-xl flex items-center justify-center transition"
                                            style="background: rgba(168,85,247,.15); color: var(--accent-light)"
                                            onmouseover="this.style.background='var(--accent)';this.style.color='#fff'"
                                            onmouseout="this.style.background='rgba(168,85,247,.15)';this.style.color='var(--accent-light)'"
                                            title="Setujui"><i class='bx bx-check'></i></button>
                                </form>
                                <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="w-8 h-8 rounded-xl bg-red-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition"
                                            title="Tolak"><i class='bx bx-x'></i></button>
                                </form>
                            </div>
                            @elseif($appt->status === 'approved')
                            <form action="{{ route('gurubk.appointments.status', $appt->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center gap-1 text-xs font-bold transition">
                                    <i class='bx bx-check-double'></i> Tandai Selesai
                                </button>
                            </form>
                            @else
                            <span class="text-xs font-medium" style="color: var(--text-muted)">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center" style="color: var(--text-muted)">
                            Belum ada permintaan jadwal temu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
            <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL PANGGIL SISWA --}}
<div id="modal-panggil"
     class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/30 backdrop-blur-sm">
    <div class="neo-flat rounded-3xl w-full max-w-md overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 flex justify-between items-center" style="border-bottom: 1px solid var(--border); background: var(--bg)">
            <div class="flex items-center gap-2">
                <i class='bx bx-phone-call text-xl' style="color: var(--accent-light)"></i>
                <h3 class="font-outfit font-extrabold text-lg" style="color: var(--text-primary)">Panggil Siswa</h3>
            </div>
            <button onclick="document.getElementById('modal-panggil').classList.add('hidden')"
                    class="w-8 h-8 rounded-full neo-btn flex items-center justify-center transition hover:text-red-500"
                    style="color: var(--text-muted)">
                <i class='bx bx-x text-lg'></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="form-panggil" action="{{ route('gurubk.appointments.call') }}" method="POST"
              class="p-6 space-y-4" style="background: var(--bg)">
            @csrf

            {{-- Hidden input time yang akan diisi JS --}}
            <input type="hidden" name="time" id="input-time-final">

            {{-- Pilih Siswa --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color: var(--text-secondary)">
                    Pilih Siswa <span class="text-red-500">*</span>
                </label>
                <select name="student_id" required
                        class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold"
                        style="color: var(--text-primary)">
                    <option value="" disabled selected>-- Pilih siswa --</option>
                    @foreach($students as $siswa)
                        <option value="{{ $siswa->id }}">
                            {{ $siswa->name }}
                            @if($siswa->schoolClass) — {{ $siswa->schoolClass->name }} @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color: var(--text-secondary)">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                       class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold"
                       style="color: var(--text-primary)">
            </div>

            {{-- Jam — dropdown 24 jam --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color: var(--text-secondary)">
                    Jam <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <select id="select-jam" required
                            class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold"
                            style="color: var(--text-primary)">
                        <option value="" disabled selected>Jam</option>
                        @for($h = 6; $h <= 18; $h++)
                            <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endfor
                    </select>
                    <div class="flex items-center font-bold text-lg" style="color: var(--text-muted)">:</div>
                    <select id="select-menit" required
                            class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold"
                            style="color: var(--text-primary)">
                        <option value="" disabled selected>Menit</option>
                        <option value="00">00</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </select>
                </div>
                <p id="error-jam" class="text-xs text-red-400 mt-1 hidden">Jam dan menit wajib dipilih.</p>
            </div>

            {{-- Keperluan --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color: var(--text-secondary)">
                    Keperluan / Catatan
                    <span class="text-[9px] normal-case" style="color: var(--text-muted)">(Opsional)</span>
                </label>
                <textarea name="notes" rows="3"
                          placeholder="Misal: Diskusi perkembangan belajar, tindak lanjut laporan..."
                          class="w-full neo-input rounded-xl px-4 py-2.5 text-sm font-semibold resize-none"
                          style="color: var(--text-primary)"></textarea>
            </div>

            {{-- Info --}}
            <div class="flex items-start gap-2 rounded-xl px-4 py-3 text-xs font-medium"
                 style="background: rgba(168,85,247,.08); border: 1px solid rgba(168,85,247,.2); color: var(--text-secondary)">
                <i class='bx bx-info-circle text-base mt-0.5' style="color: var(--accent-light)"></i>
                <span>Jadwal akan langsung berstatus <strong>Disetujui</strong> dan siswa akan mendapat notifikasi otomatis.</span>
            </div>

            <div class="pt-1">
                <button type="submit"
                        class="w-full py-2.5 rounded-xl text-sm font-bold text-white transition flex items-center justify-center gap-2 shadow-md hover:scale-[1.02]"
                        style="background: var(--accent)">
                    <i class='bx bx-phone-call'></i> Kirim Panggilan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('form-panggil').addEventListener('submit', function(e) {
        const jam   = document.getElementById('select-jam').value;
        const menit = document.getElementById('select-menit').value;
        const error = document.getElementById('error-jam');

        if (!jam || !menit) {
            e.preventDefault();
            error.classList.remove('hidden');
            return;
        }

        error.classList.add('hidden');
        document.getElementById('input-time-final').value = jam + ':' + menit + ':00';
    });
</script>
@endsection