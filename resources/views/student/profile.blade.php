@extends('layouts.student')
@section('title', 'Profil Saya - Schoolify')
@section('page_title', 'Profil Saya')

@section('content')
<div style="max-width:960px; margin:0 auto;">

    @if(session('success'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#ecfdf5; border:1.5px solid rgba(16,185,129,0.2); border-radius:16px; margin-bottom:24px; font-size:14px; font-weight:600; color:#065f46;">
        <div style="width:32px; height:32px; background:#10b981; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-check' style="color:white; font-size:18px;"></i></div>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#fff1f2; border:1.5px solid rgba(239,68,68,0.2); border-radius:16px; margin-bottom:24px; font-size:14px; font-weight:600; color:#be123c;">
        <div style="width:32px; height:32px; background:#ef4444; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-x' style="color:white; font-size:18px;"></i></div>
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Premium Profile Card (Sidebar) --}}
            <div class="col-span-1 lg:col-span-4 bg-white rounded-[32px] overflow-hidden relative shadow-[0_12px_32px_rgba(0,0,0,0.03)] border border-slate-200/60 sticky top-6">
                {{-- Soft Gradient Header --}}
                <div class="h-36 bg-gradient-to-br from-indigo-100 to-purple-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.6),transparent)] mix-blend-overlay"></div>
                    <div class="absolute w-48 h-48 bg-indigo-500/10 rounded-full -top-24 -right-16 blur-2xl"></div>
                </div>

                <div class="px-8 pb-10 flex flex-col items-center -mt-16 relative z-10">
                    {{-- Avatar --}}
                    <div class="relative mb-5 group">
                        <div class="w-32 h-32 rounded-full p-1.5 bg-white/80 backdrop-blur-md shadow-lg">
                            <img id="avatar-preview"
                                 src="{{ ($studentData->avatar ?? false) ? (str_starts_with($studentData->avatar,'http') ? $studentData->avatar : asset($studentData->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($studentData->name ?? 'U') . '&background=6366f1&color=fff&size=240' }}"
                                 alt="" class="w-full h-full rounded-full object-cover border border-slate-200">
                        </div>
                        <button type="button" onclick="document.getElementById('avatar-input').click()"
                                class="absolute inset-1.5 bg-slate-900/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer backdrop-blur-sm border-none">
                            <i class='bx bx-camera text-white text-3xl'></i>
                        </button>
                        <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </div>

                    {{-- Name & Title --}}
                    <h2 class="text-xl font-extrabold text-slate-800 tracking-tight text-center">{{ $studentData->name ?? '-' }}</h2>
                    <p class="text-sm font-semibold text-indigo-500 mt-1 bg-indigo-50 px-3 py-1 rounded-full">Siswa — {{ $studentData->schoolClass->name ?? '-' }}</p>

                    {{-- Vertical Stats List (Like Guru profile but premium) --}}
                    <div class="w-full mt-8 flex flex-col gap-3 border-t border-slate-100 pt-6">
                        <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 px-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">NIS</span>
                            <span class="text-sm font-extrabold text-slate-800">{{ $studentData->nis ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 px-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">NISN</span>
                            <span class="text-sm font-extrabold text-slate-800">{{ $studentData->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 px-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Lahir</span>
                            <span class="text-sm font-extrabold text-slate-800">{{ $studentData->birth_date ? \Carbon\Carbon::parse($studentData->birth_date)->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-emerald-50/50 rounded-2xl p-3 px-4">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Status</span>
                            <span class="flex items-center gap-2 text-xs font-extrabold text-emerald-600">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_0_2px_rgba(16,185,129,0.2)]"></span> Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact & Address Card (Main Content) --}}
            <div class="col-span-1 lg:col-span-8 bg-white rounded-[32px] p-10 shadow-[0_12px_32px_rgba(0,0,0,0.03)] border border-slate-200/60">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">Detail Kontak & Alamat</h3>
                        <p class="text-sm font-medium text-slate-500 mt-1">Perbarui informasi kontak agar sekolah mudah menghubungi Anda.</p>
                    </div>
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500">
                        <i class='bx bx-edit-alt text-2xl'></i>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    {{-- Phone Input --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2.5">Nomor HP / WhatsApp</label>
                        <div class="relative">
                            <i class='bx bxl-whatsapp absolute left-5 top-1/2 -translate-y-1/2 text-2xl text-emerald-500'></i>
                            <input type="text" name="phone" value="{{ $studentData->phone ?? '' }}" placeholder="08xxxxxxxxxx" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-14 pr-5 py-4 text-slate-800 font-semibold focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200">
                        </div>
                    </div>

                    {{-- Address Input --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2.5">Alamat Lengkap</label>
                        <div class="relative">
                            <i class='bx bx-map absolute left-5 top-5 text-2xl text-slate-400'></i>
                            <textarea name="address" rows="4" placeholder="Jl. Contoh No. 12, Kelurahan, Kota ..." 
                                      class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-14 pr-5 py-5 text-slate-800 font-medium focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 resize-none leading-relaxed">{{ $studentData->address ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between mt-10 pt-8 border-t border-slate-100 gap-6">
                    <p class="text-xs font-medium text-slate-500 max-w-sm">
                        <i class='bx bx-lock-alt text-slate-400 mr-1.5 text-base align-text-bottom'></i>
                        Data akademik (Nama, NIS, Tanggal Lahir) tidak dapat diubah secara mandiri. Hubungi admin tata usaha untuk perubahan.
                    </p>
                    <button type="submit" class="w-full sm:w-auto bg-slate-900 text-white border-none rounded-full px-8 py-4 text-sm font-extrabold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2.5 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(15,23,42,0.2)]">
                        Simpan Perubahan <i class='bx bx-right-arrow-alt text-xl'></i>
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>

<script>
function previewImage(e) {
    const r = new FileReader();
    r.onload = () => { document.getElementById('avatar-preview').src = r.result; };
    r.readAsDataURL(e.target.files[0]);
}
</script>
@endsection
