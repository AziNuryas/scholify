@extends('layouts.gurubk')

@section('title', 'Edit Profil Guru BK - Schoolify')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto animate-fadeInUp">
    <div class="mb-8">
        <h1 class="font-outfit font-bold text-3xl mb-2" style="color: var(--text-primary)">Pengaturan Profil</h1>
        <p style="color: var(--text-secondary)">Kelola informasi data diri dan keamanan akun Bapak/Ibu.</p>
    </div>

    @if(session('success'))
    <div class="border px-4 py-3 rounded-xl mb-6 flex items-center gap-2 font-medium"
         style="background: rgba(168,85,247,.12); border-color: rgba(168,85,247,.3); color: var(--accent-light)">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Avatar Sidebar -->
        <div class="neo-flat rounded-2xl p-8 text-center h-fit">
            <div class="relative inline-block group mb-6">
                <img id="avatar-preview"
                     src="{{ $guru['avatar'] ?? 'https://ui-avatars.com/api/?name='.urlencode($guru['name'] ?? 'Guru BK').'&background=7C3AED&color=fff' }}"
                     alt="Profile Picture"
                     class="w-32 h-32 rounded-3xl object-cover mx-auto shadow-md"
                     style="border: 4px solid rgba(168,85,247,.2)">
                <button type="button" onclick="document.getElementById('avatar-input').click()"
                        class="absolute -bottom-2 -right-2 w-10 h-10 text-white rounded-xl flex items-center justify-center shadow-lg transition cursor-pointer"
                        style="background: var(--accent)"
                        onmouseover="this.style.background='var(--accent-hover)'"
                        onmouseout="this.style.background='var(--accent)'">
                    <i class='bx bx-camera text-xl'></i>
                </button>
            </div>
            <h3 class="font-bold text-lg" style="color: var(--text-primary)">{{ $guru['name'] ?? 'Guru BK' }}</h3>
            <p class="font-medium text-sm mb-4" style="color: var(--accent-light)">{{ $guru['role'] ?? 'Bimbingan Konseling' }}</p>
            <div class="pt-4 text-xs" style="border-top: 1px solid var(--border); color: var(--text-muted)">
                Gunakan resolusi minimal 500x500px untuk hasil terbaik.
            </div>
        </div>

        <!-- Form Edit Profile -->
        <div class="lg:col-span-2 neo-flat rounded-2xl p-8">
            <form action="{{ route('gurubk.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                @csrf
                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewImage(event)">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @php
                        $fields = [
                            ['name' => 'name',        'label' => 'Nama Lengkap & Gelar',    'value' => $guru['name'] ?? ''],
                            ['name' => 'nip',         'label' => 'NIP (Nomor Induk Pegawai)','value' => $guru['nip'] ?? ''],
                            ['name' => 'phone',       'label' => 'Nomor WhatsApp',           'value' => $guru['phone'] ?? '',       'placeholder' => '08xxxx'],
                            ['name' => 'birth_place', 'label' => 'Tempat Lahir',             'value' => $guru['birth_place'] ?? ''],
                        ];
                    @endphp
                    @foreach($fields as $f)
                    <div class="space-y-2">
                        <label class="text-sm font-bold ml-1" style="color: var(--text-muted)">{{ $f['label'] }}</label>
                        <input type="text" name="{{ $f['name'] }}" value="{{ $f['value'] }}"
                               {{ isset($f['placeholder']) ? 'placeholder="'.$f['placeholder'].'"' : '' }}
                               class="w-full neo-pressed rounded-xl px-4 py-3 text-sm outline-none"
                               style="color: var(--text-primary); background: var(--bg)">
                    </div>
                    @endforeach
                </div>

                <div class="space-y-2 mb-8">
                    <label class="text-sm font-bold ml-1" style="color: var(--text-muted)">Alamat Domisili</label>
                    <textarea name="address" rows="3"
                              class="w-full neo-pressed rounded-xl px-4 py-3 text-sm outline-none"
                              style="color: var(--text-primary); background: var(--bg)">{{ $guru['address'] ?? '' }}</textarea>
                </div>

                <div class="flex justify-end pt-6" style="border-top: 1px solid var(--border)">
                    <button type="submit"
                            class="text-white font-bold py-3 px-8 rounded-xl transition shadow-lg"
                            style="background: var(--accent); box-shadow: 0 4px 14px rgba(124,58,237,.3)"
                            onmouseover="this.style.background='var(--accent-hover)'"
                            onmouseout="this.style.background='var(--accent)'">
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
        reader.onload = function(){ document.getElementById('avatar-preview').src = reader.result; };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection