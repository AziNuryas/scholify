@extends('layouts.student')
@section('title', 'Pengaturan - Schoolify')
@section('page-title', 'Pengaturan Akun & Sistem')

@section('content')
<div class="space-y-6 pb-10 animate-fadeInUp">
    
    <!-- Header Banner -->
    <div class="neo-flat rounded-3xl p-6 relative overflow-hidden flex flex-col md:flex-row items-center gap-6">
        <div class="w-20 h-20 rounded-full neo-pressed p-1.5 flex-shrink-0 relative z-10">
            <div class="w-full h-full rounded-full overflow-hidden bg-[var(--bg)] flex items-center justify-center border-[3px] border-[var(--bg)]">
                @if($studentData && $studentData->avatar)
                    <img src="{{ asset('storage/' . str_replace('/storage/', '', $studentData->avatar)) }}" alt="Profile" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-black text-[var(--accent)]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                @endif
            </div>
            <!-- Status indicator -->
            <div class="absolute bottom-0.5 right-0.5 w-5 h-5 bg-emerald-500 rounded-full border-[3px] border-[var(--bg)] z-20 shadow-sm"></div>
        </div>
        
        <div class="text-center md:text-left z-10 flex-1">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full neo-pressed mb-2">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i>
                <span class="text-[10px] font-bold tracking-widest text-[var(--text-secondary)] uppercase">Siswa Terverifikasi</span>
            </div>
            <h1 class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] mb-1">{{ $user->name }}</h1>
            <p class="text-sm font-semibold text-[var(--text-secondary)]">{{ $studentData->nis ?? 'NIS belum diatur' }} • {{ $studentData->schoolClass->name ?? 'Kelas belum diatur' }}</p>
        </div>

        <!-- Decorative BG -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl neo-flat border-l-4 border-emerald-500 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full neo-pressed flex items-center justify-center flex-shrink-0 text-emerald-500">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <p class="text-sm font-bold text-[var(--text-primary)]">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl neo-flat border-l-4 border-rose-500 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full neo-pressed flex items-center justify-center flex-shrink-0 text-rose-500 mt-0.5">
                <i data-lucide="alert-octagon" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-[var(--text-primary)] mb-2">Terjadi Kesalahan</p>
                <ul class="text-xs font-semibold text-[var(--text-secondary)] list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Grid Settings -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Kiri: Keamanan & Preferensi -->
        <div class="space-y-6">
            
            <!-- Keamanan Akun -->
            <div class="neo-flat rounded-3xl p-5 sm:p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4 group-hover:bg-indigo-500/10 transition-colors pointer-events-none"></div>
                
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center text-white">
                        <i data-lucide="key-round" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Keamanan Akun</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)]">Perbarui kata sandi secara berkala.</p>
                    </div>
                </div>

                <form action="{{ route('student.settings.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-extrabold text-[var(--text-secondary)] uppercase tracking-wider mb-2 ml-1">Kata Sandi Baru</label>
                            <div class="relative">
                                <i data-lucide="lock" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                                <input type="password" name="password" class="neo-input w-full pl-12 h-12" placeholder="Minimal 8 karakter unik">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-[var(--text-secondary)] uppercase tracking-wider mb-2 ml-1">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <i data-lucide="shield-check" class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                                <input type="password" name="password_confirmation" class="neo-input w-full pl-12 h-12" placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 text-right">
                        <button type="submit" class="neo-btn px-6 py-2.5 font-bold text-sm w-full sm:w-auto">
                            Update Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tampilan & Sistem -->
            <div class="neo-flat rounded-3xl p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-lg shadow-purple-500/30 flex items-center justify-center text-white">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Preferensi Sistem</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)]">Personalisasi pengalaman Schoolify Anda.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Tema Toggle -->
                    <div class="flex items-center justify-between p-3.5 rounded-2xl neo-pressed group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[var(--bg)] neo-flat flex items-center justify-center text-[var(--text-primary)]">
                                <i data-lucide="moon-star" class="w-4 h-4 hidden dark:block"></i>
                                <i data-lucide="sun-dim" class="w-4 h-4 block dark:hidden"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[var(--text-primary)]">Mode Gelap Global</p>
                                <p class="text-[11px] text-[var(--text-secondary)] mt-0.5">Ubah tema seluruh sistem</p>
                            </div>
                        </div>
                        <button onclick="toggleTheme()" class="w-10 h-10 rounded-xl neo-btn flex items-center justify-center hover:text-[var(--accent)] transition-colors">
                            <i data-lucide="power" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <!-- Animasi Toggle -->
                    <label class="flex items-center justify-between p-3.5 rounded-2xl neo-pressed cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[var(--bg)] neo-flat flex items-center justify-center text-[var(--text-primary)]">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[var(--text-primary)]">Animasi UI Dinamis</p>
                                <p class="text-[11px] text-[var(--text-secondary)] mt-0.5">Transisi dan efek visual (hover)</p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer ml-2">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-[var(--bg)] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--accent)] shadow-[inset_2px_2px_4px_rgba(0,0,0,0.1)]"></div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Kanan: Notifikasi & Bug Report -->
        <div class="space-y-6">
            
            <!-- Preferensi Notifikasi -->
            <div class="neo-flat rounded-3xl p-5 sm:p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-orange-500/30 flex items-center justify-center text-white">
                        <i data-lucide="bell-ring" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Notifikasi & Peringatan</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)]">Kontrol informasi yang Anda terima.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center justify-between p-3.5 rounded-2xl neo-pressed cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[var(--bg)] neo-flat flex items-center justify-center text-blue-500">
                                <i data-lucide="book-open-check" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[var(--text-primary)]">Tugas Baru</p>
                                <p class="text-[11px] text-[var(--text-secondary)] mt-0.5">Peringatan tugas dari guru mapel</p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer ml-2">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-[var(--bg)] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.1)]"></div>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3.5 rounded-2xl neo-pressed cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[var(--bg)] neo-flat flex items-center justify-center text-emerald-500">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[var(--text-primary)]">Pesan Konseling</p>
                                <p class="text-[11px] text-[var(--text-secondary)] mt-0.5">Balasan obrolan dari Guru BK</p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer ml-2">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-[var(--bg)] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.1)]"></div>
                        </div>
                    </label>

                    <label class="flex items-center justify-between p-3.5 rounded-2xl neo-pressed cursor-pointer opacity-80">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[var(--bg)] neo-flat flex items-center justify-center text-[var(--text-muted)]">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-[var(--text-primary)]">Email Mingguan</p>
                                <p class="text-[11px] text-[var(--text-secondary)] mt-0.5">Laporan rekap nilai mingguan</p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer ml-2">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-[var(--bg)] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--accent)] shadow-[inset_2px_2px_4px_rgba(0,0,0,0.1)]"></div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Laporkan Bug -->
            <div class="neo-flat rounded-3xl p-5 sm:p-6 border border-rose-500/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-400 to-red-600 shadow-lg shadow-red-500/30 flex items-center justify-center text-white">
                        <i data-lucide="bug" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-extrabold text-lg text-[var(--text-primary)]">Laporkan Masalah</h3>
                        <p class="text-xs font-medium text-[var(--text-secondary)]">Hubungkan kendala teknis ke Admin.</p>
                    </div>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-extrabold text-[var(--text-secondary)] uppercase tracking-wider mb-2 ml-1">Kategori Kendala</label>
                        <div class="relative">
                            <i data-lucide="layers" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)]"></i>
                            <select class="neo-input w-full pl-11 h-11 text-sm appearance-none cursor-pointer">
                                <option>Tugas / Upload Error</option>
                                <option>Sistem Jadwal Berantakan</option>
                                <option>Fitur Chat Konseling Mati</option>
                                <option>Lainnya</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-[var(--text-secondary)] uppercase tracking-wider mb-2 ml-1">Detail Informasi</label>
                        <textarea rows="3" class="neo-input w-full resize-none p-3.5 text-sm" placeholder="Ceritakan detail masalah yang Anda temui..."></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="button" onclick="alert('Terima kasih! Laporan Anda telah diteruskan ke Administrator jaringan.')" class="neo-btn w-full px-6 py-2.5 font-bold text-sm text-rose-500 hover:!bg-rose-500 hover:!text-white flex items-center justify-center gap-2 transition-all">
                            <i data-lucide="send" class="w-4 h-4"></i> Kirim Laporan Bug
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
