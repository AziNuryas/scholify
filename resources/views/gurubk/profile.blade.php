@extends('layouts.gurubk')

@section('title', 'Edit Profil Guru BK - Schoolify')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="font-outfit font-bold text-3xl text-[#1E293B] mb-2">Pengaturan Profil</h1>
        <p class="text-gray-500">Kelola informasi data diri dan keamanan akun Bapak/Ibu.</p>
    </div>

    @if(session('success'))
    <div class="bg-teal-50 border border-teal-200 text-teal-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Picture Sidebar -->
        <div class="glass-card bg-white rounded-[24px] border border-gray-100 p-8 shadow-sm text-center h-fit">
            <div class="relative inline-block group mb-6">
                <img id="avatar-preview" src="{{ $guru['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($guru['name'] ?? 'Guru BK') . '&background=0D9488&color=fff' }}" 
                     alt="Profile Picture" 
                     class="w-32 h-32 rounded-3xl object-cover ring-4 ring-teal-50 mx-auto shadow-md">
                <button type="button" onclick="document.getElementById('avatar-input').click()" class="absolute -bottom-2 -right-2 w-10 h-10 bg-teal-600 text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-teal-700 transition cursor-pointer">
                    <i class='bx bx-camera text-xl'></i>
                </button>
            </div>
            <h3 class="font-bold text-lg text-[#1E293B]">{{ $guru['name'] ?? 'Guru BK' }}</h3>
            <p class="text-teal-600 font-medium text-sm mb-4">{{ $guru['role'] ?? 'Bimbingan Konseling' }}</p>
            <div class="pt-4 border-t border-gray-50 text-xs text-gray-400">
                Gunakan resolusi minimal 500x500px untuk hasil terbaik.
            </div>
        </div>

        <!-- Form Edit Profile -->
        <div class="lg:col-span-2 glass-card bg-white rounded-[24px] border border-gray-100 p-8 shadow-sm">
            <form action="{{ route('gurubk.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                @csrf
                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-500 ml-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" value="{{ $guru['name'] ?? '' }}" required class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-500 ml-1">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" value="{{ $guru['nip'] ?? '' }}" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-500 ml-1">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ $guru['phone'] ?? '' }}" placeholder="08xxxx" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-500 ml-1">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ $guru['birth_place'] ?? '' }}" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>

                <div class="space-y-2 mb-8">
                    <label class="text-sm font-bold text-gray-500 ml-1">Alamat Domisili</label>
                    <textarea name="address" rows="3" class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 transition">{{ $guru['address'] ?? '' }}</textarea>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-50">
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-teal-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
