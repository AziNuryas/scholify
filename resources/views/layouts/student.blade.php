<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Schoolify - Student Space')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 (untuk backup jika diperlukan) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand-primary: #4318FF;
            --brand-secondary: #2B3674;
            --text-muted: #A3AED0;
            --bg-main: #F4F7FE;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-main); 
            color: var(--brand-secondary); 
            letter-spacing: -0.01em;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E0E5F2; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #ced4e4; }
        
        .glass-header {
            background: rgba(244, 247, 254, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(224, 229, 242, 0.5);
        }

        .nav-link {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link:hover:not(.active) {
            transform: translateX(4px);
        }

        [x-cloak] { display: none !important; }

        @keyframes elasticBounce {
            0% { transform: translateY(100px) scale(0.8); opacity: 0; }
            60% { transform: translateY(-15px) scale(1.05); opacity: 1; }
            80% { transform: translateY(5px) scale(0.98); }
            100% { transform: translateY(0) scale(1); }
        }

        .animate-bounce-in {
            animation: elasticBounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        
        /* Sidebar Active State */
        .sidebar-active {
            background: #4318FF;
            color: white;
            font-weight: 600;
            box-shadow: 0 8px 16px -4px rgba(67, 24, 255, 0.15);
        }
        
        /* Logo image style */
        .logo-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        
        /* Icon styling */
        .nav-icon {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden">

    <!-- Sidebar dengan Logo Scholify -->
    <aside class="w-[290px] bg-white h-full flex flex-col transition-all duration-300 z-20 border-r border-[#E0E5F2]">
        <!-- Logo Scholify -->
        <div class="h-28 flex-none flex items-center px-6 border-b border-[#F4F7FE]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg shadow-indigo-200 bg-gradient-to-br from-[#4318FF] to-[#868CFF] flex items-center justify-center">
                    <img src="{{ asset('images/scholify-logo.png') }}" 
                         alt="Scholify Logo" 
                         class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="font-outfit font-extrabold text-2xl tracking-tight text-[#2B3674] leading-tight">Scholify</span>
                    <span class="text-xs font-semibold text-[#A3AED0] tracking-wide mt-0.5">BELAJAR · TERHUBUNG · BERKEMBANG</span>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4">
            <nav class="space-y-1.5 font-outfit">
                <!-- MENU UTAMA -->
                <p class="px-4 text-[11px] font-bold text-[#A3AED0] uppercase tracking-widest mb-3">Menu Utama</p>
                
                <a href="{{ route('student.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.dashboard') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="layout-dashboard" class="nav-icon"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('student.schedule') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.schedule') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="calendar" class="nav-icon"></i>
                    <span>Jadwal Kelas</span>
                </a>
                
                <a href="{{ route('student.absensi') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.absensi') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="user-check" class="nav-icon"></i>
                    <span>Absensi</span>
                </a>
                
                <a href="{{ route('student.grades') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.grades') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="trending-up" class="nav-icon"></i>
                    <span>Nilai & Rapor</span>
                </a>
                
                <a href="{{ route('student.assignments') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.assignments') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }} relative">
                    <i data-lucide="clipboard-list" class="nav-icon"></i>
                    <span>Tugas</span>
                </a>

                <!-- Pengumuman -->
                <a href="{{ route('student.announcements') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl 
                   {{ request()->routeIs('student.announcements') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="megaphone" class="nav-icon"></i>
                    <span>Pengumuman</span>
                </a>

                <!-- LAINNYA -->
                <div class="my-6 border-t border-[#F4F7FE] mx-4"></div>
                <p class="px-4 text-[11px] font-bold text-[#A3AED0] uppercase tracking-widest mb-3">Lainnya</p>
                
                <a href="{{ route('student.profile') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.profile') ? 'sidebar-active' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-[#F4F7FE] font-medium' }}">
                    <i data-lucide="user-circle" class="nav-icon"></i>
                    <span>Profil Saya</span>
                </a>
            </nav>
        </div>

        <!-- Tombol Logout -->
        <div class="p-6 flex-none border-t border-[#F4F7FE]">
            <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full text-[#A3AED0] hover:text-red-500 font-semibold py-2.5 transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        <header class="h-24 px-10 flex-none flex items-center justify-between glass-header sticky top-0 z-10">
            <div>
                <p class="text-[13px] text-[#A3AED0] font-semibold tracking-wide uppercase">Student Workspace</p>
                <h2 class="font-outfit font-extrabold text-2xl text-[#2B3674]">Halo, Selamat Belajar! 👋</h2>
            </div>

            <div class="flex items-center gap-4 bg-white p-2 rounded-2xl shadow-sm border border-[#F4F7FE]">
                <div class="relative hidden lg:flex items-center bg-[#F4F7FE] rounded-xl px-4 py-2 w-72">
                    <i data-lucide="search" class="w-5 h-5 text-[#A3AED0]"></i>
                    <input type="text" placeholder="Cari tugas..." class="bg-transparent border-none outline-none text-sm ml-2 w-full text-[#2B3674] placeholder-[#A3AED0]">
                </div>

                <button class="p-2.5 rounded-xl text-[#A3AED0] hover:bg-[#F4F7FE] hover:text-[#4318FF] transition-all relative">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-2.5 right-3 w-2 h-2 rounded-full bg-red-500 border-2 border-white"></span>
                </button>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-3 border-l border-[#F4F7FE] hover:bg-[#F4F7FE]/50 p-1.5 rounded-2xl transition-all outline-none group">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-sm text-[#2B3674] group-hover:text-[#4318FF] transition-colors leading-tight">Ahmad Fauzi</p>
                            <p class="text-[#A3AED0] text-[11px] font-medium uppercase tracking-tighter">XII RPL 1</p>
                        </div>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=4318FF&color=fff&rounded=true" alt="Profile" class="w-11 h-11 rounded-full object-cover shadow-sm ring-2 ring-white group-hover:ring-[#4318FF]/20 transition-all">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-[#A3AED0] transition-transform duration-300" :class="open ? 'rotate-180 text-[#4318FF]' : ''"></i>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-[#F4F7FE] py-2.5 z-50"
                         x-cloak>
                        
                        <div class="px-4 py-2 border-bottom border-[#F4F7FE] mb-1">
                            <p class="text-[10px] font-bold text-[#A3AED0] uppercase tracking-widest">Akun Siswa</p>
                        </div>

                        <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#2B3674] hover:bg-[#F4F7FE] hover:text-[#4318FF] transition-all font-semibold mx-2 rounded-xl">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <i data-lucide="user" class="w-4 h-4 text-[#4318FF]"></i>
                            </div>
                            Lihat Profil
                        </a>

                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#2B3674] hover:bg-[#F4F7FE] transition-all font-medium mx-2 rounded-xl">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i data-lucide="settings" class="w-4 h-4 text-[#A3AED0]"></i>
                            </div>
                            Pengaturan
                        </a>

                        <div class="border-t border-[#F4F7FE] my-2 mx-4"></div>
                        
                        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-all font-bold w-[calc(100%-1rem)] mx-2 rounded-xl text-left">
                                <div class="w-8 h-8 rounded-lg bg-red-100/50 flex items-center justify-center">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                </div>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Popup Notification -->
    <div x-data="{ 
            showPopup: false,
            init() {
                if (!sessionStorage.getItem('dismissExamNotice')) {
                    setTimeout(() => { this.showPopup = true }, 1000); 
                }
            },
            closeForNow() {
                this.showPopup = false;
                sessionStorage.setItem('dismissExamNotice', 'true');
            }
         }" 
         x-show="showPopup" 
         x-cloak
         class="fixed bottom-8 right-8 z-50 w-[340px]">
        
        <div :class="showPopup ? 'animate-bounce-in' : ''" 
             class="bg-[#4318FF] rounded-[28px] relative overflow-hidden p-8 text-white shadow-[0_25px_60px_rgba(67,24,255,0.35)] border border-white/10">
            
            <button @click="closeForNow()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-indigo-400/20 rounded-full blur-3xl"></div>

            <div class="flex flex-col gap-6 relative z-10 text-center items-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-inner ring-1 ring-white/20">
                    <i data-lucide="megaphone" class="w-8 h-8 text-yellow-300 animate-pulse"></i>
                </div>
                
                <div>
                    <h4 class="font-outfit font-extrabold text-xl leading-tight">Ujian Semester</h4>
                    <p class="text-[10px] text-white/60 mt-1 uppercase tracking-[0.2em] font-bold">Pengumuman Penting</p>
                </div>
                
                <p class="text-sm text-white/80 leading-relaxed font-medium">
                    Tinggal <span class="text-white font-bold underline decoration-yellow-400 decoration-4 underline-offset-4">14 hari lagi</span> sebelum ujian dimulai. Sudah sejauh mana persiapanmu?
                </p>

                <div class="flex flex-col w-full gap-3 pt-2">
                    <button class="w-full py-4 bg-white text-[#4318FF] rounded-xl text-xs font-bold hover:bg-yellow-300 hover:text-[#2B3674] transition-all transform active:scale-95 shadow-xl shadow-black/10">
                        Buka Bank Soal
                    </button>
                    <button @click="closeForNow()" class="w-full py-4 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all border border-white/10 active:scale-95 text-white/90">
                        Ingatkan Nanti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Konfirmasi logout dengan custom dialog
        document.querySelectorAll('form[action*="logout"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const confirmed = confirm('⚠️ Apakah Anda yakin ingin keluar?\n\nSemua sesi akan berakhir dan Anda perlu login kembali.');
                
                if(confirmed) {
                    const btn = this.querySelector('button');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mx-auto"></div>';
                    btn.disabled = true;
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>