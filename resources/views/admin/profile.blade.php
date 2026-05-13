@extends('layouts.admin')
@section('title', 'Profil Admin - Schoolify Admin')
@section('page-title', 'Profil Saya')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <!-- Hero Header -->
    <div class="neo-flat rounded-[32px] overflow-hidden relative min-h-[200px] flex items-center p-8 bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950">
        <!-- Abstract Pattern -->
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 24px 24px;"></div>
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-[80px]"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-purple-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 w-full text-center md:text-left">
            <div class="relative group">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name ?? 'Administrator') }}&size=120&background=6366F1&color=fff&bold=true" class="w-28 h-28 rounded-[35px] border-4 border-white/10 shadow-2xl transition-transform group-hover:scale-105 duration-500">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-[var(--accent)] flex items-center justify-center text-white shadow-lg border-2 border-slate-900">
                    <i data-lucide="crown" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-3xl font-outfit font-extrabold text-white">{{ $admin->name ?? 'Administrator' }}</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-2">
                    <span class="flex items-center gap-2 text-indigo-200/80 font-semibold text-sm">
                        <i data-lucide="mail" class="w-4 h-4"></i> {{ $admin->email ?? 'admin@schoolify.com' }}
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 hidden md:block"></span>
                    <span class="flex items-center gap-2 text-indigo-200/80 font-semibold text-sm">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Super Administrator
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-600 rounded-2xl p-4 flex items-center gap-3 font-bold text-sm">
        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Form Profile -->
        <div class="lg:col-span-2 space-y-6">
            <div class="neo-flat rounded-3xl p-6 relative">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                    <div class="p-2 rounded-lg bg-[var(--accent)]/10 text-[var(--accent)]">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Informasi Pribadi</h3>
                        <p class="text-xs text-[var(--text-secondary)]">Kelola data dasar akun Anda</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-[var(--accent)]"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('name', $admin->name) }}" placeholder="Nama lengkap">
                            @error('name')<p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4 text-[var(--accent)]"></i> Email Address
                            </label>
                            <input type="email" name="email" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('email', $admin->email) }}" placeholder="Email">
                            @error('email')<p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="phone" class="w-4 h-4 text-[var(--accent)]"></i> No. Telepon
                            </label>
                            <input type="tel" name="phone" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('phone', $admin->phone) }}" placeholder="Nomor telepon">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i> Tanggal Lahir
                            </label>
                            <input type="date" name="birth_date" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ old('birth_date', $admin->birth_date ? $admin->birth_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[var(--accent)]"></i> Alamat
                        </label>
                        <textarea name="address" class="w-full neo-input py-3 px-4 text-sm font-semibold min-h-[100px] resize-y" placeholder="Alamat lengkap">{{ old('address', $admin->address) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center gap-2 shadow-lg shadow-[var(--accent)]/20 transition-all active:scale-95">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Section -->
            <div class="neo-flat rounded-3xl p-6 relative">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                    <div class="p-2 rounded-lg bg-[var(--accent)]/10 text-[var(--accent)]">
                        <i data-lucide="shield-lock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Keamanan Akun</h3>
                        <p class="text-xs text-[var(--text-secondary)]">Perbarui kata sandi Anda secara berkala</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                            <i data-lucide="key" class="w-4 h-4 text-[var(--accent)]"></i> Password Saat Ini
                        </label>
                        <input type="password" name="current_password" class="w-full neo-input py-3 px-4 text-sm font-semibold" placeholder="••••••••">
                        @error('current_password')<p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="lock" class="w-4 h-4 text-[var(--accent)]"></i> Password Baru
                            </label>
                            <input type="password" name="password" class="w-full neo-input py-3 px-4 text-sm font-semibold" placeholder="Minimum 8 karakter">
                            @error('password')<p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-[var(--accent)]"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" class="w-full neo-input py-3 px-4 text-sm font-semibold" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-4 flex items-start gap-3">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                        <p class="text-[11px] font-bold text-amber-700 leading-relaxed">
                            <strong>Tips Keamanan:</strong> Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password yang lebih kuat.
                        </p>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 flex items-center gap-2 shadow-lg transition-all active:scale-95">
                            <i data-lucide="key-round" class="w-4 h-4 text-indigo-400"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Info & History -->
        <div class="space-y-6">
            <div class="neo-flat rounded-3xl p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[var(--shadow-dark)]/10">
                    <div class="p-2 rounded-lg bg-[var(--accent)]/10 text-[var(--accent)]">
                        <i data-lucide="history" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[var(--text-primary)]">Riwayat Login</h3>
                        <p class="text-xs text-[var(--text-secondary)]">Aktivitas terakhir Anda</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="neo-pressed p-4 rounded-2xl flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-600 shrink-0">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-[var(--text-primary)] truncate">Login Hari Ini</h4>
                            <p class="text-[11px] text-[var(--text-muted)] font-semibold truncate">127.0.0.1 • Chrome on Linux</p>
                        </div>
                        <span class="text-[10px] font-bold text-[var(--text-secondary)] bg-white px-2 py-1 rounded-lg">09:30</span>
                    </div>

                    <div class="neo-pressed p-4 rounded-2xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-500/10 flex items-center justify-center text-slate-600 shrink-0">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-[var(--text-primary)] truncate">Login Kemarin</h4>
                            <p class="text-[11px] text-[var(--text-muted)] font-semibold truncate">192.168.1.1 • Firefox</p>
                        </div>
                        <span class="text-[10px] font-bold text-[var(--text-secondary)] bg-white px-2 py-1 rounded-lg">14:20</span>
                    </div>

                    <div class="neo-pressed p-4 rounded-2xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-500/10 flex items-center justify-center text-slate-600 shrink-0">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-[var(--text-primary)] truncate">Login 2 Hari Lalu</h4>
                            <p class="text-[11px] text-[var(--text-muted)] font-semibold truncate">192.168.0.5 • Safari</p>
                        </div>
                        <span class="text-[10px] font-bold text-[var(--text-secondary)] bg-white px-2 py-1 rounded-lg">10:15</span>
                    </div>
                </div>
            </div>

            <div class="neo-flat rounded-3xl p-6 bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-xl shadow-indigo-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 rounded-lg bg-white/20">
                        <i data-lucide="info" class="w-5 h-5 text-white"></i>
                    </div>
                    <h3 class="font-outfit font-bold text-lg">Informasi Tambahan</h3>
                </div>
                <p class="text-sm text-indigo-100/90 leading-relaxed font-medium">
                    Halaman profil ini digunakan untuk mengelola data otentikasi administrator. Pastikan data email valid untuk keperluan pemulihan akun.
                </p>
                <div class="mt-6 pt-6 border-t border-white/10 flex items-center justify-between">
                    <span class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Status Akun</span>
                    <span class="px-3 py-1 rounded-full bg-green-400/20 border border-green-400/40 text-green-300 text-[10px] font-bold">AKTIF</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection