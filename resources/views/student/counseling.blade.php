@extends('layouts.student')
@section('title', 'Layanan BK - Schoolify')
@section('page_title', 'Layanan BK')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#ecfdf5; border:1.5px solid rgba(16,185,129,0.25); border-radius:16px; font-size:14px; font-weight:600; color:#065f46;">
        <div style="width:32px; height:32px; background:#10b981; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-check' style="color:white; font-size:18px;"></i></div>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#fff1f2; border:1.5px solid rgba(239,68,68,0.25); border-radius:16px; font-size:14px; font-weight:600; color:#be123c;">
        <div style="width:32px; height:32px; background:#ef4444; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-x' style="color:white; font-size:18px;"></i></div>
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Premium BK Teacher Card (Sidebar) --}}
        <div class="col-span-1 lg:col-span-4 bg-white rounded-[32px] overflow-hidden relative shadow-[0_12px_32px_rgba(0,0,0,0.03)] border border-slate-200/60 sticky top-6">
            {{-- Soft Gradient Header --}}
            <div class="h-32 bg-gradient-to-br from-teal-100 to-emerald-100 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.6),transparent)] mix-blend-overlay"></div>
                <div class="absolute w-48 h-48 bg-teal-500/10 rounded-full -top-24 -right-16 blur-2xl"></div>
            </div>

                <div style="padding:0 32px 32px 32px; display:flex; flex-direction:column; align-items:center; margin-top:-50px; position:relative; z-index:10;">
                    {{-- Avatar --}}
                    <div style="width:100px; height:100px; border-radius:50%; padding:6px; background:rgba(255,255,255,0.6); backdrop-filter:blur(8px); box-shadow:0 8px 32px rgba(0,0,0,0.06); margin-bottom:16px;">
                        @if($bkTeacher && $bkTeacher->avatar)
                            <img src="{{ $bkTeacher->avatar }}" alt="" style="width:100%; height:100%; border-radius:50%; object-fit:cover; border:1px solid rgba(226,232,240,0.5);">
                        @else
                            <div style="width:100%; height:100%; border-radius:50%; background:linear-gradient(135deg, #14b8a6, #0d9488); display:flex; align-items:center; justify-content:center; border:1px solid rgba(226,232,240,0.5);">
                                <i class='bx bx-user' style="color:white; font-size:36px;"></i>
                            </div>
                        @endif
                    </div>

                    <h2 style="font-size:20px; font-weight:800; color:#0f172a; text-align:center;">{{ $bkUser->name ?? 'Guru BK' }}</h2>
                    <p style="font-size:13px; color:#64748b; font-weight:500; margin-top:2px; text-align:center;">Guru Bimbingan Konseling</p>

                    <div style="width:100%; margin-top:28px; display:flex; flex-direction:column; gap:16px;">
                        @foreach([
                            ['icon'=>'bx-id-card','label'=>'NIP','value'=> $bkTeacher->nip ?? '-'],
                            ['icon'=>'bx-phone','label'=>'Telepon','value'=> $bkTeacher->phone ?? '-'],
                            ['icon'=>'bx-time','label'=>'Jam Layanan','value'=>'Senin–Jumat, 08:00–14:00'],
                        ] as $info)
                        <div style="display:flex; align-items:flex-start; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:12px; background:#f0fdfa; display:flex; align-items:center; justify-content:center; color:#0d9488; flex-shrink:0;">
                                <i class='bx {{ $info['icon'] }}' style="font-size:18px;"></i>
                            </div>
                            <div>
                                <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8;">{{ $info['label'] }}</p>
                                <p style="font-size:14px; font-weight:700; color:#0f172a; margin-top:2px;">{{ $info['value'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-1 lg:col-span-8 flex flex-col gap-6">
                {{-- Appointment Form --}}
                <div class="bg-white rounded-[32px] p-10 shadow-[0_12px_32px_rgba(0,0,0,0.03)] border border-slate-200/60">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 shrink-0">
                            <i class='bx bx-calendar-plus text-3xl'></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Ajukan Jadwal Temu</h2>
                            <p class="text-sm font-medium text-slate-500 mt-1">Atur waktu untuk berkonsultasi di ruang BK.</p>
                        </div>
                    </div>

                    <form action="{{ route('student.appointment.store') }}" method="POST" class="flex flex-col gap-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-slate-600 mb-2.5">Guru BK Tujuan</label>
                            <select name="teacher_id" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-800 font-semibold focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_1.25rem_center]">
                                @foreach($bkUsers as $bk)
                                    <option value="{{ $bk->id }}">{{ $bk->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-600 mb-2.5">Tanggal</label>
                                <input type="date" name="date" required min="{{ date('Y-m-d') }}" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-800 font-semibold focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-600 mb-2.5">Waktu</label>
                                <input type="time" name="time" required 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-800 font-semibold focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-600 mb-2.5">Tujuan Konsultasi</label>
                            <textarea name="notes" rows="3" required placeholder="Ceritakan tujuan konsultasimu..." 
                                      class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-5 text-slate-800 font-medium focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 resize-none leading-relaxed"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-slate-900 text-white border-none rounded-2xl py-4 text-sm font-extrabold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 mt-2 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(15,23,42,0.2)]">
                            Ajukan Jadwal Sekarang <i class='bx bx-right-arrow-alt text-xl'></i>
                        </button>
                    </form>
                </div>

                {{-- History --}}
                @if($appointments->count() > 0)
                <div class="bg-white rounded-[32px] shadow-[0_12px_32px_rgba(0,0,0,0.03)] border border-slate-200/60 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-extrabold text-slate-800">Riwayat Pertemuan</h3>
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                            <i class='bx bx-history text-xl'></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-8 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50 border-b border-slate-100">Guru BK</th>
                                    <th class="px-8 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50 border-b border-slate-100">Jadwal</th>
                                    <th class="px-8 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50 border-b border-slate-100">Tujuan</th>
                                    <th class="px-8 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50 border-b border-slate-100 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($appointments as $appt)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5 font-bold text-slate-800 text-sm whitespace-nowrap">{{ $appt->teacher->name ?? 'Guru BK' }}</td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="font-bold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</span>
                                        <span class="text-indigo-600 font-extrabold text-xs ml-2 bg-indigo-50 px-2.5 py-1 rounded-md">{{ \Carbon\Carbon::parse($appt->time)->format('H:i') }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-slate-500 font-medium text-sm">{{ Str::limit($appt->notes, 60) ?: '-' }}</td>
                                    <td class="px-8 py-5 text-center whitespace-nowrap">
                                        @php $statusMap = ['pending'=>['bg'=>'bg-amber-50','color'=>'text-amber-700','text'=>'Menunggu'],'approved'=>['bg'=>'bg-emerald-50','color'=>'text-emerald-700','text'=>'Disetujui'],'completed'=>['bg'=>'bg-blue-50','color'=>'text-blue-700','text'=>'Selesai'],'rejected'=>['bg'=>'bg-rose-50','color'=>'text-rose-700','text'=>'Ditolak']]; $s = $statusMap[$appt->status] ?? $statusMap['pending']; @endphp
                                        <span class="px-4 py-1.5 rounded-full {{ $s['bg'] }} {{ $s['color'] }} text-[11px] font-extrabold uppercase tracking-wide">{{ $s['text'] }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
