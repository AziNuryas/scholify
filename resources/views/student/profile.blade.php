@extends('layouts.student')

@section('title', 'Profil & Pengaturan - Schoolify')

@section('content')
@php
    $user = auth()->user();
    $name = $user->name ?? $student['name'] ?? 'Siswa';
    $avatarUrl = $user->avatar ?? $student['avatar'] ?? null;
    $class = $student['class'] ?? 'XII RPL 1';
    $nis = $student['nis'] ?? '-';
    $email = $user->email ?? $student['email'] ?? 'siswa@scholify.com';
    
    $initials = collect(explode(' ', $name))
        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
        ->take(3)
        ->implode('');
@endphp

<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">
    
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="font-outfit font-bold text-3xl md:text-4xl text-[#2B3674] mb-3">Profil Saya</h1>
        <p class="text-[#A3AED0] text-base">Kelola dan perbarui informasi data diri Anda</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Alert Error -->
    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium">{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- LEFT COLUMN - Profile Card (Tanpa Sticky) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                
                <!-- Cover Banner -->
                <div class="relative h-28 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                </div>
                
                <!-- Avatar Section -->
                <div class="relative px-6 pb-6">
                    <div class="relative -mt-14 mb-5 flex justify-center">
                        @if($avatarUrl)
                            <img id="avatar-preview"
                                src="{{ $avatarUrl }}"
                                class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl">
                        @else
                            <div id="avatar-preview"
                                class="w-28 h-28 rounded-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-3xl font-bold border-4 border-white shadow-xl">
                                {{ $initials }}
                            </div>
                        @endif
                        
                        <button onclick="document.getElementById('avatar-input').click()"
                            class="absolute bottom-0 right-24 bg-white rounded-full p-2 shadow-md hover:bg-gray-50 hover:scale-110 transition-all duration-200">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Student Info -->
                    <div class="text-center">
                        <h2 class="font-outfit font-bold text-xl text-[#2B3674]">{{ $name }}</h2>
                        <p class="text-sm text-indigo-600 font-semibold bg-indigo-50 inline-block px-3 py-1.5 rounded-full mt-2">
                            🎓 Kelas {{ $class }}
                        </p>
                        
                        <div class="mt-6 space-y-3 text-left bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">📋 NIS</span>
                                <span class="font-semibold text-gray-800">{{ $nis }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-500 text-sm">📧 Email</span>
                                <span class="font-semibold text-gray-800 text-sm break-all">{{ $email }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500 text-sm">🟢 Status</span>
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span class="font-semibold text-emerald-600">Aktif</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN - Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                <!-- Form Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-xl text-[#2B3674]">Edit Data Pribadi</h3>
                            <p class="text-sm text-gray-400 mt-0.5">Perbarui informasi profil Anda di sini</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $name) }}" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                            </div>
                        </div>

                        <!-- No. HP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                WhatsApp / No. HP
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                            </div>
                        </div>

                        <!-- NISN -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                NISN
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="nisn" value="{{ old('nisn', $user->nisn ?? '') }}" 
                                    placeholder="10 Digit NISN"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                            </div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tempat Lahir
                            </label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place ?? '') }}" 
                                placeholder="Contoh: Jakarta"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Lengkap
                            </label>
                            <textarea name="address" rows="3" 
                                placeholder="Masukkan alamat lengkap Anda"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none">{{ old('address', $user->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="reset" 
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tips Card -->
            <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-indigo-800 text-base">💡 Tips Keamanan Akun</h4>
                        <p class="text-sm text-indigo-600 mt-1 leading-relaxed">
                            Jangan bagikan informasi pribadi Anda kepada siapapun. Pastikan data yang Anda masukkan sudah benar sebelum menyimpan. 
                            Gunakan foto profil yang jelas untuk memudahkan identifikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('avatar-preview');

    reader.onload = function() {
        if (preview.tagName === 'IMG') {
            preview.src = reader.result;
        } else {
            const img = document.createElement('img');
            img.src = reader.result;
            img.className = preview.className;
            img.id = 'avatar-preview';
            preview.replaceWith(img);
        }
    }

    if (event.target.files && event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection