@extends('layouts.admin')
@section('title', 'Pengaturan - Schoolify Admin')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-6 animate-fadeInUp">
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Navigation Settings -->
        <div class="w-full lg:w-64 flex-shrink-0">
            <div class="neo-flat rounded-3xl p-3 flex flex-row lg:flex-col gap-2 overflow-x-auto custom-scroll">
                <button class="neo-btn flex items-center gap-3 px-4 py-3 rounded-2xl w-full text-left bg-[var(--accent)] text-white shadow-md shadow-[var(--accent)]/20 whitespace-nowrap lg:whitespace-normal flex-shrink-0 lg:flex-shrink">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="font-bold text-sm">Umum</span>
                </button>
                <button class="neo-btn flex items-center gap-3 px-4 py-3 rounded-2xl w-full text-left text-[var(--text-secondary)] hover:bg-[var(--shadow-dark)]/5 hover:text-[var(--text-primary)] transition-colors whitespace-nowrap lg:whitespace-normal flex-shrink-0 lg:flex-shrink">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                    <span class="font-bold text-sm">Email</span>
                </button>
                <button class="neo-btn flex items-center gap-3 px-4 py-3 rounded-2xl w-full text-left text-[var(--text-secondary)] hover:bg-[var(--shadow-dark)]/5 hover:text-[var(--text-primary)] transition-colors whitespace-nowrap lg:whitespace-normal flex-shrink-0 lg:flex-shrink">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                    <span class="font-bold text-sm">Keamanan</span>
                </button>
                <button class="neo-btn flex items-center gap-3 px-4 py-3 rounded-2xl w-full text-left text-[var(--text-secondary)] hover:bg-[var(--shadow-dark)]/5 hover:text-[var(--text-primary)] transition-colors whitespace-nowrap lg:whitespace-normal flex-shrink-0 lg:flex-shrink">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="font-bold text-sm">Notifikasi</span>
                </button>
            </div>
        </div>

        <!-- Main Settings Content -->
        <div class="flex-1 space-y-6">
            
            <!-- Pengaturan Umum -->
            <div class="neo-flat rounded-3xl p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-[var(--shadow-dark)]/10">
                    <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                        <i data-lucide="layout" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Pengaturan Umum</h3>
                        <p class="text-xs text-[var(--text-secondary)] mt-0.5">Kelola identitas dan informasi dasar sekolah</p>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                            <i data-lucide="school" class="w-4 h-4 text-[var(--accent)]"></i> Nama Sekolah
                        </label>
                        <input type="text" name="school_name" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['school_name'] ?? 'SMA Negeri 1 Bandung' }}">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[var(--accent)]"></i> Alamat Sekolah
                        </label>
                        <textarea name="school_address" class="w-full neo-input py-3 px-4 text-sm font-semibold min-h-[100px] resize-y">{{ $settings['school_address'] ?? 'Jl. Pendidikan No. 123, Bandung' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4 text-[var(--accent)]"></i> Email Sekolah
                            </label>
                            <input type="email" name="school_email" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['school_email'] ?? 'sekolah@example.com' }}">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="phone" class="w-4 h-4 text-[var(--accent)]"></i> No. Telepon
                            </label>
                            <input type="tel" name="school_phone" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['school_phone'] ?? '+62-274-512345' }}">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                            <i data-lucide="image" class="w-4 h-4 text-[var(--accent)]"></i> Logo Sekolah
                        </label>
                        <div class="flex items-center gap-5 neo-pressed rounded-2xl p-4">
                            <div class="w-16 h-16 rounded-xl border-2 border-white shadow-md overflow-hidden bg-white">
                                <img src="https://ui-avatars.com/api/?name=Schoolify&size=100&background=2563EB&color=fff&bold=true" class="w-full h-full object-cover">
                            </div>
                            <button type="button" class="neo-btn px-4 py-2.5 rounded-xl text-xs font-bold text-[var(--text-secondary)] bg-white hover:text-[var(--accent)] flex items-center gap-2">
                                <i data-lucide="upload" class="w-4 h-4"></i> Unggah Logo Baru
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2 relative">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-[var(--accent)]"></i> Tahun Ajaran
                            </label>
                            <div class="relative">
                                <select name="academic_year" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer">
                                    <option value="2024/2025" selected>2024/2025</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2025/2026">2025/2026</option>
                                </select>
                                <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                            </div>
                        </div>
                        <div class="space-y-2 relative">
                            <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                <i data-lucide="power" class="w-4 h-4 text-[var(--accent)]"></i> Status Aplikasi
                            </label>
                            <div class="relative">
                                <select name="app_status" class="w-full neo-input appearance-none py-3 px-4 text-sm font-semibold cursor-pointer">
                                    <option value="active" selected>Aktif</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="closed">Ditutup</option>
                                </select>
                                <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Lokasi / GPS untuk Absensi -->
                    <div class="mt-8 pt-6 border-t border-[var(--shadow-dark)]/10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-[var(--shadow-dark)]/10 flex items-center justify-center text-[var(--accent)]">
                                <i data-lucide="map" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Pengaturan Lokasi GPS (Absensi)</h3>
                                <p class="text-xs text-[var(--text-secondary)] mt-0.5">Tentukan titik kordinat sekolah untuk fitur absensi radius siswa</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                    <i data-lucide="crosshair" class="w-4 h-4 text-[var(--accent)]"></i> Latitude
                                </label>
                                <input type="text" name="school_lat" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['school_lat'] ?? '-6.1950' }}" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                    <i data-lucide="crosshair" class="w-4 h-4 text-[var(--accent)]"></i> Longitude
                                </label>
                                <input type="text" name="school_lng" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['school_lng'] ?? '106.8230' }}" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-[var(--text-primary)] flex items-center gap-2">
                                    <i data-lucide="radar" class="w-4 h-4 text-[var(--accent)]"></i> Maks. Radius (Meter)
                                </label>
                                <input type="number" name="absensi_radius" class="w-full neo-input py-3 px-4 text-sm font-semibold" value="{{ $settings['absensi_radius'] ?? '100' }}" required>
                            </div>
                        </div>
                        <p class="text-[10px] text-[var(--text-muted)] mt-2 italic">* Cara mendapatkan latitude & longitude: Buka Google Maps, klik kanan pada lokasi sekolah, lalu klik pada deretan angka kordinat (otomatis tersalin).</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-[var(--shadow-dark)]/10 mt-6">
                        <button type="reset" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-[var(--text-secondary)] bg-white hover:text-red-500 flex items-center gap-2">
                            <i data-lucide="x" class="w-4 h-4"></i> Batal
                        </button>
                        <button type="submit" class="neo-btn px-6 py-3 rounded-xl text-sm font-bold text-white bg-[var(--accent)] hover:bg-[var(--accent-light)] flex items-center gap-2 shadow-lg shadow-[var(--accent)]/20">
                            <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sistem & Maintenance -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Backup -->
                <div class="neo-flat rounded-3xl p-6 lg:p-8 flex flex-col h-full neo-card-hover">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                            <i data-lucide="database" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Backup Database</h3>
                    </div>
                    <p class="text-xs text-[var(--text-secondary)] mb-6">Buat backup otomatis data sistem. Pastikan untuk melakukan backup secara berkala.</p>
                    
                    <div class="space-y-3 mb-6 flex-grow">
                        <div class="flex justify-between items-center bg-[var(--shadow-dark)]/5 rounded-xl p-3">
                            <span class="text-xs font-semibold text-[var(--text-secondary)]">Terakhir backup:</span>
                            <span class="text-xs font-bold text-[var(--text-primary)]">15 April 2024, 02:30</span>
                        </div>
                        <div class="flex justify-between items-center bg-[var(--shadow-dark)]/5 rounded-xl p-3">
                            <span class="text-xs font-semibold text-[var(--text-secondary)]">Ukuran file:</span>
                            <span class="text-xs font-bold text-[var(--text-primary)]">245 MB</span>
                        </div>
                    </div>
                    
                    <button onclick="alert('Fitur backup database akan segera tersedia!')" class="neo-btn w-full py-3 rounded-xl text-sm font-bold text-[var(--accent)] border-2 border-[var(--accent)] bg-transparent hover:bg-[var(--accent)] hover:text-white transition-colors flex justify-center items-center gap-2">
                        <i data-lucide="download-cloud" class="w-4 h-4"></i> Backup Sekarang
                    </button>
                </div>

                <!-- Maintenance Mode -->
                <div class="neo-flat rounded-3xl p-6 lg:p-8 flex flex-col h-full neo-card-hover">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                            <i data-lucide="tool" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Mode Maintenance</h3>
                    </div>
                    <p class="text-xs text-[var(--text-secondary)] mb-6">Tutup aplikasi sementara dari pengguna untuk proses pemeliharaan sistem.</p>
                    
                    <div class="flex items-center justify-between mb-6 bg-[var(--shadow-dark)]/5 rounded-xl p-4">
                        <span class="text-sm font-bold text-[var(--text-primary)]">Status Maintenance</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--accent)]"></div>
                        </label>
                    </div>

                    <div class="space-y-2 mt-auto">
                        <label class="text-xs font-bold text-[var(--text-primary)]">Pesan Maintenance</label>
                        <textarea class="w-full neo-input py-3 px-4 text-xs font-semibold resize-none h-20 text-[var(--text-secondary)]">Aplikasi sedang dalam pemeliharaan. Silakan kembali lagi nanti.</textarea>
                    </div>
                </div>
            </div>

            <!-- Informasi Sistem -->
            <div class="neo-flat rounded-3xl p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                        <i data-lucide="info" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Informasi Sistem</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="neo-pressed rounded-2xl p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-2">Laravel Version</span>
                        <span class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">{{ app()->version() }}</span>
                    </div>
                    <div class="neo-pressed rounded-2xl p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-2">PHP Version</span>
                        <span class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">{{ phpversion() }}</span>
                    </div>
                    <div class="neo-pressed rounded-2xl p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-2">Database</span>
                        <span class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">{{ config('database.default') == 'mysql' ? 'MySQL' : config('database.default') }}</span>
                    </div>
                    <div class="neo-pressed rounded-2xl p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider mb-2">App Version</span>
                        <span class="font-outfit font-extrabold text-xl text-[var(--text-primary)]">1.0.0</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection