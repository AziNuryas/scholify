@extends('layouts.student')

@section('title', 'Profil & Pengaturan - Schoolify')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Informasi Profil Siswa</h1>
        <p class="text-[#A3AED0]">Lihat dan lengkapi data dirimu (NISN, Nama, Alamat) dengan sesuai.</p>
    </div>

    <!-- Alert Success/Error (Jika ada fungsi simpan form nanti) -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Kartu Identitas (Kiri) -->
        <div class="glass-card bg-white rounded-[24px] border border-gray-100 shadow-sm p-8 text-center flex flex-col items-center relative">
            <div class="relative mb-6">
                <!-- Gunakan asset path / public bila upload dr storage berhasil -->
                <img id="avatar-preview" src="{{ str_starts_with($student['avatar'] ?? '', 'http') ? $student['avatar'] : asset($student['avatar'] ?? 'https://ui-avatars.com/api/?name=User&background=6366f1&color=fff') }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-50 shadow-md">
                
                <!-- JS Trigger buat buka file upload tersembunyi yang ada di dalam form -->
                <button type="button" onclick="document.getElementById('avatar-input').click()" class="absolute bottom-1 right-1 w-8 h-8 bg-[#4318FF] text-white rounded-full flex items-center justify-center shadow hover:bg-blue-700 transition" title="Ganti Foto Profil">
                    <i class='bx bx-camera'></i>
                </button>
            </div>
            
            <h2 class="font-outfit font-bold text-xl text-[#2B3674] mb-1">{{ $student['name'] ?? 'Nama Siswa' }}</h2>
            <p class="text-sm font-bold text-[#A3AED0] mb-4 bg-gray-50 px-3 py-1 rounded inline-block border border-gray-100">
                Siswa Kelas {{ $student['class'] ?? 'X' }}
            </p>
            
            <div class="w-full text-left space-y-3 mt-4 border-t border-gray-100 pt-6">
                <!-- Data Singkat -->
                <div>
                    <label class="text-[10px] uppercase font-bold text-[#A3AED0] tracking-wider block">ID Sistem / NIS</label>
                    <p class="font-medium text-[#2B3674]">{{ $student['nis'] ?? 'Belum ada NIS' }}</p>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-[#A3AED0] tracking-wider block">Status</label>
                    <p class="font-bold text-green-500 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Aktif</p>
                </div>
            </div>
        </div>

        <!-- Form Edit Data (Kanan dan Kiri dibungkus) -->
        <div class="md:col-span-2 glass-card bg-white rounded-[24px] border border-gray-100 shadow-sm p-8">
            <h3 class="font-bold text-[#2B3674] text-lg mb-6 flex items-center gap-2 pb-4 border-b border-gray-100">
                <i class='bx bx-user-pin text-[#4318FF]'></i> Data Pribadi Lengkap
            </h3>

            <!-- Form Edit Profile Aktif Tembus ke Database -->
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Input Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-xs text-red-500 font-normal ml-1">(Tidak dapat diubah)</span></label>
                        <input type="text" name="name" value="{{ $student['name'] ?? 'Nama Siswa' }}" readonly class="w-full bg-gray-100 border-none text-gray-500 font-medium px-4 py-3 rounded-xl cursor-not-allowed outline-none">
                    </div>
                    
                    <!-- Input Nomor Telepon -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp / No. HP</label>
                        <input type="text" name="phone" value="{{ $studentData->phone ?? '' }}" class="w-full bg-[#F4F7FE] border-none text-[#2B3674] font-medium px-4 py-3 rounded-xl focus:ring-2 focus:ring-[#4318FF] outline-none placeholder-gray-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Input NISN -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">NISN <span class="text-xs text-red-500 font-normal ml-1">(Tidak dapat diubah)</span></label>
                        <input type="text" name="nisn" value="{{ $studentData->nisn ?? '' }}" readonly class="w-full bg-gray-100 border-none text-gray-500 font-medium px-4 py-3 rounded-xl cursor-not-allowed outline-none">
                    </div>

                    <!-- Input Tempat Lahir -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tempat Lahir <span class="text-xs text-red-500 font-normal ml-1">(Tidak dapat diubah)</span></label>
                        <input type="text" name="birth_place" value="{{ $studentData->birth_place ?? '' }}" readonly class="w-full bg-gray-100 border-none text-gray-500 font-medium px-4 py-3 rounded-xl cursor-not-allowed outline-none">
                    </div>
                </div>

                <!-- Input Alamat -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap Domisili</label>
                    <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap rumahmu saat ini" class="w-full bg-[#F4F7FE] border-none text-[#2B3674] font-medium px-4 py-3 rounded-xl focus:ring-2 focus:ring-[#4318FF] outline-none resize-none">{{ $studentData->address ?? '' }}</textarea>
                </div>
                
                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="submit" class="px-6 py-2.5 bg-[#4318FF] text-white font-bold rounded-xl hover:bg-[#3311CC] transition shadow-md shadow-indigo-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Input File diletakkan di luar lalu di attach form agar stylingnya rapi (Html5 Form Attribute) 
     Atau ditaruh di mana saja, yang penting triggernya kena -->
<input type="file" id="avatar-input" form="profile-form" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    
    // Assign ID ke form agar saling nyambung
    document.querySelector('form').id = 'profile-form';
</script>
@endsection
