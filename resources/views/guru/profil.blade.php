@extends('layouts.guru')

@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kelola informasi akun dan data diri Anda')

@section('content')
<style>
    .profile-card {
        transition: all 0.2s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    
    .info-item {
        transition: all 0.2s ease;
    }
    
    .info-item:hover {
        background-color: #F8FAFC;
    }
    
    .form-input:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
        outline: none;
    }
    
    .btn-primary {
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #4F46E5;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        background-color: #F1F5F9;
    }
</style>

<div class="p-6">
    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar Profil - Kolom Kiri -->
        <div class="col-span-12 lg:col-span-4">
            <div class="profile-card bg-white rounded-xl border border-gray-200 overflow-hidden">
                <!-- Header Avatar -->
                <div class="bg-gray-50 border-b border-gray-200 px-6 pt-8 pb-6 text-center">
                    <div class="relative inline-block">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guru') }}&background=6366F1&color=ffffff&size=100&bold=true&length=2" 
                             class="w-24 h-24 rounded-full border-4 border-white shadow-md mx-auto">
                        <div class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mt-3">{{ auth()->user()->name ?? 'Guru' }}</h3>
                    <p class="text-gray-500 text-sm mt-0.5">Tenaga Pendidik</p>
                    <span class="inline-block mt-2 px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-medium">Aktif</span>
                </div>
                
                <!-- Informasi Ringkas -->
                <div class="p-5 space-y-3">
                    <div class="info-item flex items-center gap-3 p-2 rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Email</p>
                            <p class="font-medium text-sm text-gray-700 truncate">{{ auth()->user()->email ?? 'guru@schoolify.com' }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item flex items-center gap-3 p-2 rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Telepon</p>
                            <p class="font-medium text-sm text-gray-700" id="displayPhone">-</p>
                        </div>
                    </div>
                    
                    <div class="info-item flex items-center gap-3 p-2 rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">NIP</p>
                            <p class="font-medium text-sm text-gray-700" id="displayNip">-</p>
                        </div>
                    </div>
                    
                    <div class="info-item flex items-center gap-3 p-2 rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Bergabung</p>
                            <p class="font-medium text-sm text-gray-700">{{ date('d F Y', strtotime(auth()->user()->created_at ?? '2024-01-01')) }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item flex items-center gap-3 p-2 rounded-lg">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Mata Pelajaran</p>
                            <p class="font-medium text-sm text-gray-700">Matematika, Fisika</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil - Kolom Kanan -->
        <div class="col-span-12 lg:col-span-8">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800">Edit Profil</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi akun Anda</p>
                </div>
                
                <form action="{{ route('guru.profil.update') }}" method="POST" class="p-6 space-y-5" id="formProfil">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="inputName" value="{{ auth()->user()->name ?? 'Guru' }}" 
                                   class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ auth()->user()->email ?? 'guru@schoolify.com' }}" 
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" readonly>
                            <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nomor Telepon
                            </label>
                            <input type="tel" name="phone" id="inputPhone" placeholder="0812-3456-7890" 
                                   class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                NIP
                            </label>
                            <input type="text" name="nip" id="inputNip" placeholder="197501012005011001" 
                                   class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Alamat
                        </label>
                        <textarea name="address" id="inputAddress" rows="3" 
                                  placeholder="Jl. Pendidikan No. 123, Kota ..." 
                                  class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500 resize-none"></textarea>
                    </div>

                    <!-- Ganti Password -->
                    <div class="border-t border-gray-200 pt-5">
                        <h4 class="font-medium text-gray-800 text-sm mb-4">Ganti Password</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Password Baru
                                </label>
                                <input type="password" name="new_password" id="newPassword" placeholder="Minimal 8 karakter" 
                                       class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Ketik ulang password" 
                                       class="form-input w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-indigo-500">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengganti password</p>
                    </div>

                    <div class="flex gap-3 pt-3">
                        <button type="button" onclick="resetForm()" class="btn-secondary flex-1 px-3 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary flex-1 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Aktivitas Terakhir -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mt-6">
                <div class="border-b border-gray-200 px-6 py-3 bg-gray-50/50">
                    <h4 class="font-medium text-gray-800 text-sm">Aktivitas Terakhir</h4>
                </div>
                <div class="divide-y divide-gray-100">
                    <div class="px-6 py-3 flex justify-between items-center text-sm">
                        <span class="text-gray-600">Terakhir login</span>
                        <span class="text-gray-400 text-xs">{{ date('d M Y H:i:s') }}</span>
                    </div>
                    <div class="px-6 py-3 flex justify-between items-center text-sm">
                        <span class="text-gray-600">IP Address</span>
                        <span class="text-gray-400 text-xs">127.0.0.1</span>
                    </div>
                    <div class="px-6 py-3 flex justify-between items-center text-sm">
                        <span class="text-gray-600">Browser</span>
                        <span class="text-gray-400 text-xs">Chrome / Windows</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update display fields
    const inputName = document.getElementById('inputName');
    const inputPhone = document.getElementById('inputPhone');
    const inputNip = document.getElementById('inputNip');
    const displayPhone = document.getElementById('displayPhone');
    const displayNip = document.getElementById('displayNip');
    
    if (inputPhone) {
        inputPhone.addEventListener('input', function() {
            if (displayPhone) displayPhone.textContent = this.value || '-';
        });
    }
    
    if (inputNip) {
        inputNip.addEventListener('input', function() {
            if (displayNip) displayNip.textContent = this.value || '-';
        });
    }
    
    // Reset form
    function resetForm() {
        if (inputName) inputName.value = '{{ auth()->user()->name ?? "Guru" }}';
        if (inputPhone) inputPhone.value = '';
        if (inputNip) inputNip.value = '';
        if (inputAddress) inputAddress.value = '';
        
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        if (newPassword) newPassword.value = '';
        if (confirmPassword) confirmPassword.value = '';
        
        if (displayPhone) displayPhone.textContent = '-';
        if (displayNip) displayNip.textContent = '-';
        
        alert('Form telah direset');
    }
    

</script>
@endsection