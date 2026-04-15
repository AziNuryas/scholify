@extends('layouts.guru')

@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kelola informasi akun dan data diri Anda.')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Sidebar Profil -->
    <div class="col-span-12 lg:col-span-4">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm sticky top-10">
            <!-- Header Avatar -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 pt-8 pb-12 text-center relative">
                <div class="relative inline-block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guru') }}&background=ffffff&color=4F46E5&size=100&bold=true&length=2" 
                         class="w-24 h-24 rounded-xl border-4 border-white shadow-lg mx-auto">
                    <div class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white"></div>
                </div>
                <h3 class="text-white font-bold text-lg mt-3">{{ auth()->user()->name ?? 'Guru' }}</h3>
                <p class="text-indigo-100 text-xs mt-0.5">Tenaga Pendidik</p>
                <span class="inline-block mt-2 px-2 py-0.5 bg-white/20 rounded-full text-[10px] font-bold text-white">Aktif</span>
            </div>
            
            <!-- Informasi Ringkas -->
            <div class="p-5 space-y-3 border-t border-slate-100">
                <div class="flex items-center gap-3 p-2.5 rounded-xl bg-indigo-50/50">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="mail" class="w-4 h-4 text-indigo-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Email</p>
                        <p class="font-medium text-sm text-slate-700 truncate">{{ auth()->user()->email ?? 'guru@schoolify.com' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Bergabung Sejak</p>
                        <p class="font-medium text-sm text-slate-700">{{ date('d F Y', strtotime(auth()->user()->created_at ?? '2024-01-01')) }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="shield" class="w-4 h-4 text-slate-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Role</p>
                        <p class="font-medium text-sm text-slate-700">Guru / Tenaga Pendidik</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="book-open" class="w-4 h-4 text-slate-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">Mata Pelajaran</p>
                        <p class="font-medium text-sm text-slate-700">Matematika, Fisika</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Edit Profil -->
    <div class="col-span-12 lg:col-span-8">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4 bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i data-lucide="user-circle" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Edit Profil</h3>
                        <p class="text-xs text-slate-400">Perbarui informasi akun Anda</p>
                    </div>
                </div>
            </div>
            
            <form class="p-5 space-y-5" id="formProfil">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ auth()->user()->name ?? 'Guru' }}" 
                               class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? 'guru@schoolify.com' }}" 
                               class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed" readonly>
                        <p class="text-[10px] text-slate-400 mt-0.5">Email tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            Nomor Telepon
                        </label>
                        <input type="tel" name="phone" placeholder="0812-3456-7890" value="0812-3456-7890"
                               class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">
                            NIP
                        </label>
                        <input type="text" name="nip" placeholder="197501012005011001" value="197501012005011001"
                               class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Alamat
                    </label>
                    <textarea name="address" rows="2" 
                              placeholder="Jl. Pendidikan No. 123, Kota ..." 
                              class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all resize-none">Jl. Pendidikan No. 45, Surabaya</textarea>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="lock" class="w-4 h-4 text-indigo-500"></i>
                        <h4 class="font-bold text-sm text-slate-800">Ganti Password</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">
                                Password Baru
                            </label>
                            <input type="password" name="new_password" placeholder="••••••••" 
                                   class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="confirm_password" placeholder="••••••••" 
                                   class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2">Kosongkan jika tidak ingin mengganti password</p>
                </div>

                <div class="flex gap-2 pt-3">
                    <button type="button" onclick="resetForm()" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-slate-500 text-sm font-medium hover:bg-slate-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-all shadow-sm flex items-center justify-center gap-1.5">
                        <i data-lucide="save" class="w-3.5 h-3.5"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm mt-6">
            <div class="border-b border-slate-100 px-5 py-3 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-indigo-500"></i>
                    <h4 class="font-bold text-sm text-slate-800">Aktivitas Terakhir</h4>
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                <div class="px-5 py-3 flex justify-between items-center text-sm">
                    <span class="text-slate-600">Terakhir login</span>
                    <span class="text-slate-400 text-xs">{{ date('d M Y H:i:s') }}</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center text-sm">
                    <span class="text-slate-600">IP Address terakhir</span>
                    <span class="text-slate-400 text-xs">127.0.0.1</span>
                </div>
                <div class="px-5 py-3 flex justify-between items-center text-sm">
                    <span class="text-slate-600">Browser</span>
                    <span class="text-slate-400 text-xs">Chrome / Edge</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
    
    function resetForm() {
        document.getElementById('formProfil').reset();
        const nameInput = document.querySelector('input[name="name"]');
        if (nameInput) nameInput.value = '{{ auth()->user()->name ?? "Guru" }}';
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) phoneInput.value = '0812-3456-7890';
        const nipInput = document.querySelector('input[name="nip"]');
        if (nipInput) nipInput.value = '197501012005011001';
        const addressTextarea = document.querySelector('textarea[name="address"]');
        if (addressTextarea) addressTextarea.value = 'Jl. Pendidikan No. 45, Surabaya';
        const passwordInput = document.querySelector('input[name="new_password"]');
        if (passwordInput) passwordInput.value = '';
        const confirmInput = document.querySelector('input[name="confirm_password"]');
        if (confirmInput) confirmInput.value = '';
    }
    
    document.getElementById('formProfil').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPass = document.querySelector('input[name="new_password"]').value;
        const confirmPass = document.querySelector('input[name="confirm_password"]').value;
        
        if (newPass !== confirmPass) {
            alert('Password baru dan konfirmasi password tidak sama!');
            return;
        }
        
        alert('Profil berhasil diperbarui!\n(Nanti akan terhubung ke database)');
    });
</script>
@endsection