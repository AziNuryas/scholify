<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Schoolify')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #e6edf3;
            --shadow-dark: 184, 198, 214;
            --shadow-light: 255, 255, 255;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent: #2563EB; /* Blue for Admin */
            --accent-light: #3B82F6;
        }

        .dark {
            --bg: #2b3040;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --accent: #3B82F6;
            --accent-light: #60A5FA;
            --shadow-light: 50, 56, 75;
            --shadow-dark: 35, 39, 53;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg);
            color: var(--text-primary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }

        /* ====== NEUMORPHISM CORE ====== */
        .neo-flat {
            background: var(--bg);
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(var(--shadow-dark), 0.65),
                        -8px -8px 16px rgba(var(--shadow-light), 1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .neo-pressed {
            background: var(--bg);
            border-radius: 15px;
            box-shadow: inset 6px 6px 12px rgba(var(--shadow-dark), 0.6),
                        inset -6px -6px 12px rgba(var(--shadow-light), 0.9);
            transition: all 0.3s ease;
        }

        .neo-card {
            background: var(--bg);
            border-radius: 20px;
            box-shadow: 8px 8px 16px rgba(var(--shadow-dark), 0.5),
                        -8px -8px 16px rgba(var(--shadow-light), 1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .neo-btn {
            background: var(--bg);
            border-radius: 12px;
            box-shadow: 5px 5px 10px rgba(var(--shadow-dark), 0.6),
                        -5px -5px 10px rgba(var(--shadow-light), 1);
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-primary);
        }
        .neo-btn:hover {
            box-shadow: 2px 2px 5px rgba(var(--shadow-dark), 0.4),
                        -2px -2px 5px rgba(var(--shadow-light), 0.7),
                        0 0 20px rgba(37, 99, 235, 0.5); /* Blue glow */
            background: var(--accent);
            color: white !important;
            transform: translateY(-2px);
        }
        .neo-btn:active, .neo-btn.active {
            box-shadow: inset 4px 4px 8px rgba(var(--shadow-dark), 0.6),
                        inset -4px -4px 8px rgba(var(--shadow-light), 0.8);
            transform: translateY(0);
        }

        .neo-input {
            background: var(--bg);
            box-shadow: inset 3px 3px 6px rgba(var(--shadow-dark), 0.5),
                        inset -3px -3px 6px rgba(var(--shadow-light), 0.6);
            border: none;
            outline: none;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .neo-input:focus {
            box-shadow: inset 2px 2px 4px rgba(var(--shadow-dark), 0.5),
                        inset -2px -2px 4px rgba(var(--shadow-light), 0.6),
                        0 0 0 2px rgba(37, 99, 235, 0.2);
        }
        .neo-input::placeholder { color: var(--text-muted); }

        /* ====== CARD HOVER ====== */
        .neo-card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .neo-card-hover:hover, .hover-neo:hover {
            box-shadow: 12px 12px 20px rgba(var(--shadow-dark), 0.7),
                        -12px -12px 20px rgba(var(--shadow-light), 1);
            transform: translateY(-3px);
        }

        .hover-glow:hover {
            box-shadow: inset 2px 2px 5px rgba(var(--shadow-dark), 0.4),
                        inset -2px -2px 5px rgba(var(--shadow-light), 0.7),
                        0 0 15px rgba(37, 99, 235, 0.2);
            border-color: rgba(37, 99, 235, 0.3);
        }

        /* ====== SCROLLBAR ====== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(var(--shadow-dark), 0.8); border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ====== ANIMATIONS ====== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-15px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(15px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.4s ease-out forwards; }
        .animate-slideInLeft { animation: slideInLeft 0.4s ease-out forwards; }
        .animate-slideInRight { animation: slideInRight 0.4s ease-out forwards; }

        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        [x-cloak] { display: none !important; }
    </style>

    <script>
        // Inisialisasi Tema
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</head>
<body class="antialiased flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 lg:hidden" x-transition x-cloak></div>

    <!-- ====== SIDEBAR ====== -->
    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="w-[260px] h-full fixed lg:static inset-y-0 left-0 flex flex-col bg-[var(--bg)] z-40 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none">
        
        <!-- Logo -->
        <div class="h-[88px] px-4 pt-6 pb-0">
            <div class="neo-flat w-full h-16 px-4 rounded-3xl flex items-center gap-3">
                <!-- Icon mark -->
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#6366f1,#0891b2);box-shadow:4px 4px 8px rgba(99,102,241,0.3),-2px -2px 6px rgba(255,255,255,0.8);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3L2 8L12 13L22 8L12 3Z" fill="white" opacity="0.9"/>
                        <path d="M2 16L12 21L22 16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
                    </svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-outfit font-black text-base text-[var(--text-primary)] tracking-tight">Schoolify</span>
                    <span class="text-[9px] font-black uppercase tracking-[0.2em]"
                          style="background:linear-gradient(90deg,#6366f1,#0891b2);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Admin Panel</span>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-4 pb-4 pt-6 custom-scroll">
            <div class="neo-flat rounded-3xl p-3 flex flex-col gap-0.5">
                <p class="px-3 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-[0.15em] mb-2 mt-1">Menu Utama</p>
                
                @php
                    $menus = [
                        ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'color' => 'text-blue-500'],
                        ['route' => 'admin.students', 'icon' => 'users', 'label' => 'Data Siswa', 'color' => 'text-emerald-500'],
                        ['route' => 'admin.teachers', 'icon' => 'graduation-cap', 'label' => 'Data Guru Mapel', 'color' => 'text-amber-500', 'query' => '?role=guru'],
                        ['route' => 'admin.teachers', 'icon' => 'heart', 'label' => 'Data Guru BK', 'color' => 'text-rose-500', 'query' => '?role=guru_bk'],
                    ];
                    $manajemen = [
                        ['route' => 'admin.classes', 'icon' => 'school', 'label' => 'Data Kelas', 'color' => 'text-cyan-500'],
                        ['route' => 'admin.jadwal.index', 'icon' => 'calendar-days', 'label' => 'Jadwal Pelajaran', 'color' => 'text-rose-500'],
                        ['route' => 'admin.agendas.index', 'icon' => 'list-todo', 'label' => 'Agenda Sekolah', 'color' => 'text-indigo-500'],
                        ['route' => 'admin.reports', 'icon' => 'file-text', 'label' => 'Laporan', 'color' => 'text-purple-500'],
                    ];
                    $pengaturan = [
                        ['route' => 'admin.profile', 'icon' => 'user', 'label' => 'Profil', 'color' => 'text-slate-500'],
                        ['route' => 'admin.settings', 'icon' => 'settings', 'label' => 'Pengaturan', 'color' => 'text-rose-500'],
                    ];
                @endphp

                <div class="space-y-0.5">
                    @foreach($menus as $m)
                        <a href="{{ route($m['route']) }}{{ $m['query'] ?? '' }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 group
                                  {{ request()->routeIs($m['route'].'*') && (!isset($m['query']) || request('role') == ltrim(explode('=', $m['query'] ?? '')[1] ?? '', '?role='))
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40 dark:hover:bg-black/10' }}">
                            <div class="w-8 h-8 rounded-xl {{ request()->routeIs($m['route'].'*') ? 'neo-pressed' : 'bg-transparent' }} flex items-center justify-center transition-all group-hover:scale-110">
                                <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5 {{ $m['color'] }} transition-colors"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="my-3 mx-4 h-px bg-[var(--shadow-dark)]/10"></div>
                <p class="px-3 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-[0.15em] mb-2">Manajemen</p>

                <div class="space-y-0.5">
                    @foreach($manajemen as $m)
                        <a href="{{ route($m['route']) }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 group
                                  {{ request()->routeIs($m['route'].'*') 
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40 dark:hover:bg-black/10' }}">
                            <div class="w-8 h-8 rounded-xl {{ request()->routeIs($m['route'].'*') ? 'neo-pressed' : 'bg-transparent' }} flex items-center justify-center transition-all group-hover:scale-110">
                                <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5 {{ $m['color'] }} transition-colors"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="my-3 mx-4 h-px bg-[var(--shadow-dark)]/10"></div>
                <p class="px-3 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-[0.15em] mb-2">Pengaturan</p>

                <div class="space-y-0.5">
                    @foreach($pengaturan as $m)
                        <a href="{{ route($m['route']) }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 group
                                  {{ request()->routeIs($m['route'].'*') 
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40 dark:hover:bg-black/10' }}">
                            <div class="w-8 h-8 rounded-xl {{ request()->routeIs($m['route'].'*') ? 'neo-pressed' : 'bg-transparent' }} flex items-center justify-center transition-all group-hover:scale-110">
                                <i data-lucide="{{ $m['icon'] }}" class="w-5 h-5 {{ $m['color'] }} transition-colors"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                        </a>
                    @endforeach
                    
                    <div class="mt-2 pt-2 border-t border-[var(--shadow-dark)]/10">
                        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full rounded-2xl text-sm font-bold transition-all duration-300 group text-[var(--text-secondary)] hover:bg-red-50/50 dark:hover:bg-red-900/20">
                                <div class="w-8 h-8 rounded-xl bg-transparent flex items-center justify-center transition-all group-hover:scale-110">
                                    <i data-lucide="log-out" class="w-5 h-5 text-red-500 transition-colors"></i>
                                </div>
                                <span class="group-hover:text-red-500 transition-colors">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </aside>

    <!-- ====== MAIN ====== -->
    <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative">
        
        <!-- Header -->
        <header class="p-4 lg:p-6 pb-0 flex-shrink-0 z-20">
            <div class="neo-flat rounded-3xl h-16 px-4 md:px-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden neo-btn p-2 rounded-xl text-[var(--text-secondary)] outline-none" @click="mobileMenuOpen = true">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div class="lg:hidden flex items-center gap-2">
                        <div class="w-8 h-8 neo-pressed rounded-lg flex items-center justify-center text-[var(--accent)]">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h2 class="hidden lg:block font-outfit font-bold text-lg text-[var(--text-primary)]">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="hidden md:flex items-center neo-pressed rounded-full px-5 py-2.5 w-64">
                        <i data-lucide="search" class="w-4 h-4 text-[var(--text-muted)]"></i>
                        <input type="text" placeholder="Cari..." class="bg-transparent border-none outline-none text-sm ml-3 w-full text-[var(--text-primary)] placeholder-[var(--text-muted)]">
                    </div>

                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="neo-btn p-2.5 rounded-xl text-[var(--text-secondary)] outline-none hover:text-[var(--accent)] transition-colors" title="Ubah Tema">
                        <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
                        <i data-lucide="sun" class="w-4 h-4 block dark:hidden"></i>
                    </button>

                    <!-- Profile -->
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 neo-flat px-4 py-1.5 rounded-full outline-none hover:scale-105 transition-transform">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-[var(--text-primary)]">{{ Str::words(auth()->user()->name ?? 'Admin', 2, '') }}</p>
                                <p class="text-[10px] font-semibold text-blue-500 uppercase">Administrator</p>
                            </div>
                            
                            <div class="w-9 h-9 bg-[var(--accent)] text-white rounded-full overflow-hidden flex items-center justify-center font-bold shadow-md shadow-[var(--accent)]/30 border-2 border-[var(--bg)]">
                                {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-[var(--text-muted)] ml-1" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 neo-flat py-2 z-50" x-cloak>
                            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:neo-pressed transition-all duration-300">
                                <i data-lucide="user" class="w-4 h-4"></i> Profil
                            </a>
                            <div class="my-2 mx-4 h-px bg-[var(--shadow-dark)]/10"></div>
                            <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold text-red-500 hover:text-red-600 hover:neo-pressed w-[calc(100%-16px)] text-left transition-all duration-300">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-4 lg:p-6 custom-scroll">
            <div class="w-full pb-20 lg:pb-6">
                @if(session('success'))
                    <div class="neo-flat mb-6 p-4 border-l-4 border-green-500 rounded-2xl flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-bold text-sm text-[var(--text-primary)]">Berhasil!</p>
                            <p class="text-xs text-[var(--text-secondary)] mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="neo-flat mb-6 p-4 border-l-4 border-red-500 rounded-2xl flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-bold text-sm text-[var(--text-primary)]">Gagal!</p>
                            <p class="text-xs text-[var(--text-secondary)] mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>