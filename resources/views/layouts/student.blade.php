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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #e6edf3;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent: #5A189A; 
            --accent-light: #7B2CBF;
            
            --shadow-light: 255, 255, 255;
            --shadow-dark: 184, 198, 214;
        }

        .dark {
            --bg: #2b3040;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --accent: #a855f7;
            --accent-light: #c084fc;

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
                        0 0 20px rgba(90, 24, 154, 0.5);
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
                        0 0 0 2px rgba(90, 24, 154, 0.2);
        }
        .neo-input::placeholder { color: var(--text-muted); }

        /* ====== ACCENT BADGES ====== */
        .neo-badge-blue {
            background: var(--accent);
            color: white;
            box-shadow: 4px 4px 8px rgba(90, 24, 154, 0.25);
        }
        .neo-badge-green {
            background: #10b981;
            color: white;
            box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.25);
        }
        .neo-badge-red {
            background: #ef4444;
            color: white;
            box-shadow: 4px 4px 8px rgba(239, 68, 68, 0.25);
        }
        .neo-badge-orange {
            background: #f59e0b;
            color: white;
            box-shadow: 4px 4px 8px rgba(245, 158, 11, 0.25);
        }

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
                        0 0 15px rgba(90, 24, 154, 0.2);
            border-color: rgba(90, 24, 154, 0.3);
        }

        /* ====== SCROLLBAR ====== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(var(--shadow-dark), 0.8); border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }

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
            <div class="neo-flat w-full h-16 px-4 rounded-3xl flex items-center gap-3 justify-center">
                <div class="w-8 h-8 neo-pressed rounded-xl flex items-center justify-center text-[var(--accent)] text-xl">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
                <span class="font-outfit font-extrabold text-2xl text-[var(--text-primary)] tracking-tight">Scholify</span>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-4 pb-4 pt-6 custom-scroll">
            <div class="neo-flat rounded-3xl p-3 flex flex-col gap-0.5">
                <p class="px-3 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-[0.15em] mb-2 mt-1">Menu Utama</p>
                
                @php
                    $menus = [
                        ['route' => 'student.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'color' => 'text-indigo-500'],
                        ['route' => 'student.schedule', 'icon' => 'calendar', 'label' => 'Jadwal', 'color' => 'text-emerald-500'],
                        ['route' => 'student.grades', 'icon' => 'bar-chart-2', 'label' => 'Nilai', 'color' => 'text-amber-500'],
                    ];
                    $lainnya = [
                        ['route' => 'student.assignments', 'icon' => 'clipboard-list', 'label' => 'Tugas', 'color' => 'text-blue-500'],
                        ['route' => 'student.absensi', 'icon' => 'user-check', 'label' => 'Absensi', 'color' => 'text-orange-500'],
                        ['route' => 'student.appointments', 'icon' => 'users', 'label' => 'Konseling', 'color' => 'text-pink-500'],
                        ['route' => 'student.discipline', 'icon' => 'alert-triangle', 'label' => 'Pelanggaran', 'color' => 'text-rose-500'],
                        ['route' => 'student.notifications', 'icon' => 'bell', 'label' => 'Notifikasi', 'color' => 'text-red-500'],
                    ];
                    $pengaturan = [
                        ['route' => 'student.profile', 'icon' => 'user', 'label' => 'Profil', 'color' => 'text-purple-500'],
                        ['route' => 'student.settings', 'icon' => 'settings', 'label' => 'Pengaturan', 'color' => 'text-slate-500'],
                    ];
                @endphp

                <div class="space-y-0.5">
                    @foreach($menus as $m)
                        <a href="{{ route($m['route']) }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 group
                                  {{ request()->routeIs($m['route']) 
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40' }}">
                            <div class="w-7 h-7 rounded-lg {{ request()->routeIs($m['route']) ? 'neo-flat' : 'bg-[var(--bg)] group-hover:neo-flat' }} flex items-center justify-center transition-all">
                                <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4 {{ request()->routeIs($m['route']) ? $m['color'] : 'text-[var(--text-muted)] group-hover:'.$m['color'] }} transition-colors"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="my-3 mx-4 h-px bg-[var(--shadow-dark)]/10"></div>
                <p class="px-3 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-[0.15em] mb-2">Lainnya</p>

                <div class="space-y-0.5">
                    @foreach($lainnya as $m)
                        <a href="{{ route($m['route']) }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-300 group
                                  {{ request()->routeIs($m['route']) 
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40' }}">
                            <div class="w-7 h-7 rounded-lg {{ request()->routeIs($m['route']) ? 'neo-flat' : 'bg-[var(--bg)] group-hover:neo-flat' }} flex items-center justify-center transition-all">
                                <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4 {{ request()->routeIs($m['route']) ? $m['color'] : 'text-[var(--text-muted)] group-hover:'.$m['color'] }} transition-colors"></i>
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
                                  {{ request()->routeIs($m['route']) 
                                     ? 'neo-pressed text-[var(--text-primary)]' 
                                     : 'text-[var(--text-secondary)] hover:bg-white/40' }}">
                            <div class="w-7 h-7 rounded-lg {{ request()->routeIs($m['route']) ? 'neo-flat' : 'bg-[var(--bg)] group-hover:neo-flat' }} flex items-center justify-center transition-all">
                                <i data-lucide="{{ $m['icon'] }}" class="w-4 h-4 {{ request()->routeIs($m['route']) ? $m['color'] : 'text-[var(--text-muted)] group-hover:'.$m['color'] }} transition-colors"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                        </a>
                    @endforeach
                    
                    <div class="mt-2 pt-2 border-t border-[var(--shadow-dark)]/10">
                        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full rounded-2xl text-sm font-bold transition-all duration-300 group text-[var(--text-secondary)] hover:bg-red-50/50">
                                <div class="w-7 h-7 rounded-lg bg-[var(--bg)] group-hover:neo-flat flex items-center justify-center transition-all">
                                    <i data-lucide="log-out" class="w-4 h-4 text-[var(--text-muted)] group-hover:text-red-500 transition-colors"></i>
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
                        <div class="w-8 h-8 bg-white shadow-sm rounded-lg flex items-center justify-center text-[var(--accent)]">
                            <i data-lucide="book-open" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h2 class="hidden lg:block font-outfit font-bold text-lg text-[var(--text-primary)]">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="hidden md:flex items-center neo-pressed rounded-full px-5 py-2.5 w-64">
                        <i data-lucide="search" class="w-4 h-4 text-[var(--text-muted)]"></i>
                        <input type="text" placeholder="Cari sesuatu..." class="bg-transparent border-none outline-none text-sm ml-3 w-full text-[var(--text-primary)] placeholder-[var(--text-muted)]">
                    </div>

                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="neo-btn p-2.5 rounded-xl text-[var(--text-secondary)] outline-none hover:text-[var(--accent)] transition-colors" title="Ubah Tema">
                        <i data-lucide="moon" class="w-4 h-4 hidden dark:block"></i>
                        <i data-lucide="sun" class="w-4 h-4 block dark:hidden"></i>
                    </button>

                <!-- Notification -->
                <div x-data="{ 
                        unread: 0, showDropdown: false, notifications: [],
                        fetchNotifs() {
                            fetch('{{ route('student.notifications.fetch') }}')
                                .then(r => r.json())
                                .then(d => { if(d.success) { this.unread = d.unread_count; this.notifications = d.notifications; } });
                        }
                     }" 
                     x-init="fetchNotifs(); setInterval(() => fetchNotifs(), 15000)"
                     class="relative">
                    <button @click="showDropdown = !showDropdown" class="relative neo-btn p-2 rounded-xl text-[var(--text-secondary)] outline-none">
                        <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
                        <span x-show="unread > 0" class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full" x-cloak></span>
                    </button>
                    <div x-show="showDropdown" @click.away="showDropdown = false" class="absolute right-0 mt-2 w-72 neo-flat p-3 z-50" x-cloak>
                        <div class="flex justify-between items-center mb-2 pb-2 border-b border-[var(--shadow-dark)]/10">
                            <h4 class="font-bold text-sm">Notifikasi</h4>
                            <a href="{{ route('student.notifications') }}" class="text-xs text-[var(--accent)] font-semibold hover:underline">Semua</a>
                        </div>
                        <div class="space-y-1 max-h-[250px] overflow-y-auto custom-scroll">
                            <template x-for="n in notifications" :key="n.id">
                                <a :href="n.link || '{{ route('student.notifications') }}'" class="block p-2 rounded-lg hover:bg-white/30 transition text-sm">
                                    <p class="font-semibold text-[var(--text-primary)] text-xs" x-text="n.title"></p>
                                    <p class="text-[var(--text-muted)] text-[11px] mt-0.5 line-clamp-1" x-text="n.message"></p>
                                </a>
                            </template>
                            <div x-show="notifications.length === 0" class="text-center py-3">
                                <p class="text-xs text-[var(--text-muted)]">Belum ada notifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 neo-flat px-4 py-1.5 rounded-full outline-none hover:scale-105 transition-transform">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ Str::words(auth()->user()->name, 2, '') }}</p>
                            <p class="text-[10px] font-semibold text-[var(--text-muted)] uppercase">{{ $student['class'] ?? 'Siswa' }}</p>
                        </div>
                        
                        @php
                            $navStudent = \App\Models\Student::where('user_id', auth()->id())->first();
                        @endphp
                        <div class="w-9 h-9 bg-[var(--accent)] text-white rounded-full overflow-hidden flex items-center justify-center font-bold shadow-md shadow-[var(--accent)]/30">
                            @if($navStudent && $navStudent->avatar)
                                <img src="{{ asset('storage/' . str_replace('/storage/', '', $navStudent->avatar)) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            @endif
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-[var(--text-muted)] ml-1" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 neo-flat py-2 z-50" x-cloak>
                        <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:neo-pressed transition-all duration-300">
                            <i data-lucide="user" class="w-4 h-4"></i> Profil
                        </a>
                        <a href="{{ route('student.settings') }}" class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:neo-pressed transition-all duration-300">
                            <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan
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
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>