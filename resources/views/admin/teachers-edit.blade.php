@extends('layouts.admin')
@section('title', 'Edit Guru - Schoolify Admin')
@section('page-title', 'Edit Guru')

@section('content')
<div class="space-y-6 animate-fadeInUp" x-data="{ role: '{{ old('role', $teacher->role) }}' }">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#0891b2,#0f766e);box-shadow:4px 4px 8px rgba(8,145,178,0.3),-2px -2px 6px rgba(255,255,255,0.8);">
                <i data-lucide="user-pen" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h2 class="font-outfit font-black text-2xl text-[var(--text-primary)]">Edit Data Guru</h2>
                <p class="text-xs font-bold text-[var(--text-muted)] mt-0.5">{{ $teacher->name }}</p>
            </div>
        </div>
        <a href="{{ route('admin.teachers') }}"
           class="neo-btn px-5 py-2.5 rounded-2xl text-sm font-black text-[var(--text-secondary)] flex items-center gap-2 hover:text-teal-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="flex items-start gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700">
        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <div>
            <p class="text-sm font-black mb-1">Ada kesalahan:</p>
            <ul class="text-xs font-semibold space-y-0.5">
                @foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <p class="text-sm font-black">{{ session('success') }}</p>
    </div>
    @endif

    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- Section 1: Akun & Role --}}
            <div class="neo-flat rounded-[2rem] p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                    <div class="w-8 h-8 rounded-xl bg-teal-100 flex items-center justify-center">
                        <i data-lucide="user-circle" class="w-4 h-4 text-teal-600"></i>
                    </div>
                    <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Informasi Akun & Role</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $teacher->name) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl" required
                               placeholder="Nama lengkap guru">
                        @error('name')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl" required
                               placeholder="contoh@email.com">
                        @error('email')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Jenis Guru <span class="text-rose-500">*</span></label>
                        <select name="role" x-model="role" class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl" required>
                            <option value="guru">Guru Mata Pelajaran</option>
                            <option value="guru_bk">Guru BK / Konselor</option>
                        </select>
                        @error('role')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    {{-- Mata Pelajaran: only show for Guru Mapel --}}
                    <div class="space-y-2" x-show="role === 'guru'" x-transition>
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Mata Pelajaran</label>
                        <select name="subject" class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $subj)
                            <option value="{{ $subj->name }}" {{ old('subject', $teacher->subject) == $subj->name ? 'selected' : '' }}>{{ $subj->name }}</option>
                            @endforeach
                        </select>
                        @error('subject')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Password Baru <span class="text-[var(--text-muted)]">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl"
                               placeholder="Min. 6 karakter">
                        @error('password')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            {{-- Section 2: Data Pribadi --}}
            <div class="neo-flat rounded-[2rem] p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i data-lucide="id-card" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <h3 class="font-outfit font-black text-base text-[var(--text-primary)] uppercase tracking-widest">Data Pribadi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $teacher->nip) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl"
                               placeholder="Nomor Induk Pegawai">
                        @error('nip')<p class="text-xs text-rose-500 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Jenis Kelamin</label>
                        <select name="gender" class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $teacher->birth_place) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl"
                               placeholder="Kota kelahiran">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', optional($teacher->birth_date)->format('Y-m-d')) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"
                               class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-black text-[var(--text-primary)] uppercase tracking-widest">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="w-full neo-input py-3 px-4 text-sm font-semibold rounded-2xl resize-none"
                                  placeholder="Alamat lengkap guru">{{ old('address', $teacher->address) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <button type="submit"
                        class="px-8 py-3.5 rounded-2xl text-sm font-black text-white transition-all hover:scale-[1.02] hover:shadow-lg"
                        style="background:linear-gradient(135deg,#0891b2,#0f766e);">
                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.teachers') }}"
                   class="neo-btn px-6 py-3.5 rounded-2xl text-sm font-black text-[var(--text-secondary)] hover:text-rose-600 transition-colors">
                    Batal
                </a>
            </div>

        </div>
    </form>

</div>
@endsection