<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guru BK Portal - Schoolify')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* ── LIGHT MODE (default) ── */
        :root {
            --bg:             #e6edf3;
            --bg-card:        #dde5ed;
            --text-primary:   #1e293b;
            --text-secondary: #475569;
            --text-muted:     #94a3b8;
            --accent:         #7C3AED;
            --accent-light:   #8B5CF6;
            --accent-hover:   #6D28D9;
            --border:         rgba(184,198,214,0.35);
            --shadow-light:   255, 255, 255;
            --shadow-dark:    184, 198, 214;
        }

        /* ── DARK MODE ── */
        html.dark {
            --bg:             #2b3040;
            --bg-card:        #252a38;
            --text-primary:   #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted:     #64748b;
            --accent:         #a855f7;
            --accent-light:   #c084fc;
            --accent-hover:   #9333ea;
            --border:         rgba(35,39,53,0.6);
            --shadow-light:   50, 56, 75;
            --shadow-dark:    35, 39, 53;
        }

        /* ── RESET ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
        }

        /* ── SMOOTH TRANSITION ── */
        body, body * {
            transition:
                background-color .25s ease,
                border-color .25s ease,
                color .25s ease,
                box-shadow .25s ease;
        }
        /* Jangan transisi transform (bisa bikin layout flash) */
        body *[class*="transition"],
        body *[class*="duration"] {
            transition-property: color, background-color, border-color, box-shadow, opacity, transform;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }

        /* ─────────────────────────────────────────
           GLOBAL DARK MODE OVERRIDE
           Semua kelas Tailwind hardcoded warna akan
           otomatis di-override saat html.dark aktif
        ───────────────────────────────────────── */

        /* TEXT — dark/strong */
        html.dark .text-gray-900,
        html.dark .text-gray-800,
        html.dark .text-gray-700,
        html.dark .text-slate-900,
        html.dark .text-slate-800,
        html.dark .text-slate-700,
        html.dark .text-\[\#1E293B\],
        html.dark .text-\[\#334155\] { color: var(--text-primary) !important; }

        /* TEXT — medium */
        html.dark .text-gray-600,
        html.dark .text-gray-500,
        html.dark .text-slate-600,
        html.dark .text-slate-500,
        html.dark .text-\[\#475569\] { color: var(--text-secondary) !important; }

        /* TEXT — muted */
        html.dark .text-gray-400,
        html.dark .text-gray-300,
        html.dark .text-slate-400,
        html.dark .text-slate-300 { color: var(--text-muted) !important; }

        /* BACKGROUND — putih & abu terang → bg variable */
        html.dark .bg-white           { background-color: var(--bg-card) !important; }
        html.dark .bg-gray-50,
        html.dark .bg-gray-50\/50     { background-color: var(--bg) !important; }
        html.dark .bg-gray-100,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100       { background-color: var(--bg) !important; }

        /* BACKGROUND — teal → purple */
        html.dark .bg-teal-50    { background-color: rgba(168,85,247,0.12) !important; }
        html.dark .bg-teal-100   { background-color: rgba(168,85,247,0.18) !important; }
        html.dark .bg-teal-600   { background-color: var(--accent) !important; }
        html.dark .bg-teal-700   { background-color: var(--accent-hover) !important; }
              .bg-teal-600       { background-color: var(--accent) !important; }
              .bg-teal-700       { background-color: var(--accent-hover) !important; }
              .hover\:bg-teal-700:hover { background-color: var(--accent-hover) !important; }

        /* TEXT — teal → purple */
        .text-teal-600,
        .text-teal-700 { color: var(--accent) !important; }
        html.dark .text-teal-600,
        html.dark .text-teal-700 { color: var(--accent-light) !important; }
        html.dark .text-teal-800 { color: var(--accent-light) !important; }

        /* BORDER — teal → purple */
        .border-teal-200 { border-color: rgba(139,92,246,0.35) !important; }
        html.dark .border-teal-200 { border-color: rgba(168,85,247,0.3) !important; }
        html.dark .border-teal-100 { border-color: rgba(168,85,247,0.2) !important; }

        /* BORDER — abu terang */
        html.dark .border-gray-50,
        html.dark .border-gray-100,
        html.dark .border-gray-200,
        html.dark .border-slate-100,
        html.dark .border-slate-200 { border-color: var(--border) !important; }

        /* RING FOCUS — teal → purple */
        .focus\:ring-teal-500:focus,
        .focus\:ring-teal-400:focus {
            --tw-ring-color: rgba(139,92,246,0.4) !important;
        }

        /* INPUT / SELECT / TEXTAREA — bg putih jadi var(--bg-card) di dark */
        html.dark input:not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]),
        html.dark select,
        html.dark textarea {
            background-color: var(--bg) !important;
            color: var(--text-primary) !important;
            border-color: var(--border) !important;
        }

        /* SHADOW — teal → purple */
        .shadow-teal-200 { box-shadow: 0 4px 14px rgba(139,92,246,0.25) !important; }
        .shadow-teal-100 { box-shadow: 0 2px 8px rgba(139,92,246,0.15) !important; }

        /* TABLE hover rows */
        html.dark .hover\:bg-teal-50\/30:hover { background-color: rgba(168,85,247,0.06) !important; }
        html.dark .hover\:bg-gray-50:hover      { background-color: rgba(var(--shadow-dark),0.3) !important; }

        /* STATUS BADGES — teal */
        html.dark .bg-teal-50.text-teal-700,
        html.dark .bg-teal-50.text-teal-800 {
            background-color: rgba(168,85,247,0.15) !important;
            color: var(--accent-light) !important;
        }
        /* Inline bg-teal-50 + text-teal-700/800 combo */
        html.dark [class*="bg-teal-50"] { background-color: rgba(168,85,247,0.12) !important; }
        html.dark [class*="text-teal-7"],
        html.dark [class*="text-teal-8"] { color: var(--accent-light) !important; }

        /* AVATAR default bg teal → purple */
        html.dark .bg-teal-600.text-white:not(button):not(a) { background-color: var(--accent) !important; }
              .bg-teal-600.text-white:not(button):not(a)     { background-color: var(--accent) !important; }

        /* GLASS CARD */
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(20px);
        }
        html.dark .glass-card {
            background: rgba(37,42,56,0.85) !important;
            backdrop-filter: blur(20px);
        }

        /* ── NEUMORPHISM ── */
        .neo-flat {
            background: var(--bg);
            border-radius: 20px;
            box-shadow:  8px  8px 16px rgba(var(--shadow-dark),.65),
                        -8px -8px 16px rgba(var(--shadow-light),1);
        }
        .neo-pressed {
            background: var(--bg);
            border-radius: 15px;
            box-shadow: inset  6px  6px 12px rgba(var(--shadow-dark),.6),
                        inset -6px -6px 12px rgba(var(--shadow-light),.9);
        }
        .neo-btn {
            background: var(--bg);
            border-radius: 12px;
            box-shadow:  5px  5px 10px rgba(var(--shadow-dark),.6),
                        -5px -5px 10px rgba(var(--shadow-light),1);
            border: none;
            cursor: pointer;
            color: var(--text-primary);
        }
        .neo-btn:hover {
            background: var(--accent);
            color: white !important;
            box-shadow: 2px 2px 5px rgba(var(--shadow-dark),.4),
                       -2px -2px 5px rgba(var(--shadow-light),.7),
                        0 0 20px rgba(124,58,237,.4);
            transform: translateY(-2px);
        }
        .neo-btn:active {
            box-shadow: inset 4px 4px 8px rgba(var(--shadow-dark),.6),
                        inset -4px -4px 8px rgba(var(--shadow-light),.8);
            transform: translateY(0);
        }
        .neo-card-hover {
            transition: box-shadow .3s cubic-bezier(.4,0,.2,1), transform .3s cubic-bezier(.4,0,.2,1) !important;
        }
        .neo-card-hover:hover {
            box-shadow: 12px 12px 20px rgba(var(--shadow-dark),.7),
                       -12px -12px 20px rgba(var(--shadow-light),1);
            transform: translateY(-3px);
        }
        .hover-glow:hover {
            box-shadow: inset 2px 2px 5px rgba(var(--shadow-dark),.4),
                        inset -2px -2px 5px rgba(var(--shadow-light),.7),
                        0 0 15px rgba(124,58,237,.2);
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(var(--shadow-dark),.8); border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }

        /* ── ANIMATIONS ── */
        @keyframes fadeInUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp .4s ease-out forwards; }

        [x-cloak] { display: none !important; }
    </style>

    <script>
        /* Default: dark mode. Key terpisah dari student agar tidak bentrok. */
        (function () {
            if (localStorage.getItem('themeBK') === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();

        function toggleTheme() {
            var html = document.documentElement;
            var isDark = html.classList.toggle('dark');
            localStorage.setItem('themeBK', isDark ? 'dark' : 'light');
            document.getElementById('icon-moon').style.display = isDark ? 'none'  : 'block';
            document.getElementById('icon-sun').style.display  = isDark ? 'block' : 'none';
        }
    </script>
</head>
<body class="antialiased flex h-screen overflow-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 lg:hidden"
         x-transition x-cloak></div>

    <!-- ══ SIDEBAR ══ -->
    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="w-[260px] h-full fixed lg:static inset-y-0 left-0 flex flex-col z-40 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none"
           style="background: var(--bg);">

        <!-- Logo -->
        <div class="h-[88px] px-4 pt-6 pb-0">
            <div class="neo-flat w-full h-16 px-4 rounded-3xl flex items-center gap-3 justify-center">
                <div class="w-8 h-8 neo-pressed rounded-xl flex items-center justify-center text-xl" style="color: var(--accent)">
                    <i class='bx bxs-school text-lg'></i>
                </div>
                <span class="font-outfit font-extrabold text-2xl tracking-tight" style="color: var(--text-primary)">
                    Schoolify<span style="color: var(--accent)">.</span>
                </span>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-4 pb-4 pt-6 custom-scroll">
            <div class="neo-flat rounded-3xl p-3 flex flex-col gap-0.5">
                <p class="px-3 text-[10px] font-extrabold uppercase tracking-[0.15em] mb-2 mt-1"
                   style="color: var(--text-muted)">Menu Utama</p>

                @php
                    $menus = [
                        ['route' => 'gurubk.dashboard',               'icon' => 'bxs-dashboard',   'label' => 'Dashboard'],
                        ['route' => 'gurubk.profile',                 'icon' => 'bx-user',         'label' => 'Profil Saya'],
                        ['route' => 'gurubk.discipline',              'icon' => 'bx-error-circle', 'label' => 'Catatan Disiplin'],
                        ['route' => 'gurubk.appointments',            'icon' => 'bx-calendar',     'label' => 'Jadwal Temu'],
                        ['route' => 'gurubk.catatan-konseling.index', 'icon' => 'bx-book-open',    'label' => 'Catatan Konseling'],
                        ['route' => 'gurubk.deteksi-asesmen.index',   'icon' => 'bx-search-alt',   'label' => 'Deteksi Dini & Asesmen'],
                    ];
                @endphp

                <div class="space-y-0.5">
                    @foreach($menus as $m)
                        @php $active = request()->routeIs($m['route']); @endphp
                        <a href="{{ route($m['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm font-bold transition-all duration-200 group {{ $active ? 'neo-pressed' : '' }}"
                           style="color: {{ $active ? 'var(--text-primary)' : 'var(--text-secondary)' }}">
                            <div class="w-8 h-8 rounded-xl {{ $active ? 'neo-pressed' : '' }} flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class='bx {{ $m["icon"] }} text-lg'
                                   style="color: {{ $active ? 'var(--accent)' : 'var(--text-muted)' }}"></i>
                            </div>
                            <span>{{ $m['label'] }}</span>
                            @if($active)
                                <span class="ml-auto w-1.5 h-1.5 rounded-full flex-shrink-0"
                                      style="background: var(--accent)"></span>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="my-3 mx-4 h-px" style="background: var(--border)"></div>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 px-3 py-2.5 w-full rounded-2xl text-sm font-bold transition-all duration-200 group"
                            style="color: var(--text-secondary)">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class='bx bx-log-out text-lg' style="color: #f87171"></i>
                        </div>
                        <span class="group-hover:text-red-400" style="transition: color .2s">Keluar</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- ══ MAIN ══ -->
    <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative">

        <!-- Header -->
        <header class="p-4 lg:p-6 pb-0 flex-shrink-0 z-20">
            <div class="neo-flat rounded-3xl h-16 px-4 md:px-6 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <button class="lg:hidden neo-btn p-2 rounded-xl outline-none" @click="mobileMenuOpen = true"
                            style="color: var(--text-secondary)">
                        <i class='bx bx-menu text-xl'></i>
                    </button>
                    <h2 class="hidden lg:block font-outfit font-bold text-lg"
                        style="color: var(--text-primary)">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3">

                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()"
                            class="neo-btn p-2.5 rounded-xl outline-none"
                            style="color: var(--text-secondary)"
                            title="Ubah Tema">
                        <i class='bx bx-moon text-lg' id="icon-moon"></i>
                        <i class='bx bx-sun  text-lg' id="icon-sun" style="display:none"></i>
                    </button>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="relative neo-btn p-2.5 rounded-xl outline-none"
                                style="color: var(--text-secondary)">
                            <i class='bx bx-bell text-lg'></i>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2"
                                  style="border-color: var(--bg)"></span>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-72 neo-flat p-3 z-50" x-cloak>
                            <div class="flex justify-between items-center mb-2 pb-2"
                                 style="border-bottom: 1px solid var(--border)">
                                <h4 class="font-bold text-sm" style="color: var(--text-primary)">Notifikasi</h4>
                            </div>
                            <p class="text-xs text-center py-3" style="color: var(--text-muted)">
                                Belum ada notifikasi baru
                            </p>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative ml-1" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-3 neo-flat px-4 py-1.5 rounded-full outline-none hover:scale-105 transition-transform">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-bold" style="color: var(--text-primary)">
                                    {{ $guru['name'] ?? 'Guru BK' }}
                                </p>
                                <p class="text-[10px] font-semibold uppercase" style="color: var(--text-muted)">
                                    Bimbingan Konseling
                                </p>
                            </div>
                            <div class="w-9 h-9 rounded-full overflow-hidden flex items-center justify-center font-bold text-white text-sm"
                                 style="background: var(--accent); box-shadow: 0 4px 12px rgba(124,58,237,.3)">
                                @if(!empty($guru['avatar']))
                                    <img src="{{ $guru['avatar'] }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($guru['name'] ?? 'BK', 0, 2)) }}
                                @endif
                            </div>
                            <i class='bx bx-chevron-down text-sm' style="color: var(--text-muted)"
                               :style="open ? 'transform:rotate(180deg)' : ''"
                               style="transition:transform .2s"></i>
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 neo-flat py-2 z-50" x-cloak>
                            <a href="{{ route('gurubk.profile') }}"
                               class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold transition-all hover:neo-pressed"
                               style="color: var(--text-secondary)">
                                <i class='bx bx-user text-base'></i> Profil
                            </a>
                            <div class="my-2 mx-4 h-px" style="background: var(--border)"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-3 px-4 py-2.5 mx-2 rounded-xl text-sm font-semibold hover:neo-pressed w-[calc(100%-16px)] text-left transition-all"
                                        style="color: #f87171">
                                    <i class='bx bx-log-out text-base'></i> Keluar
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
        /* Sync ikon saat halaman load */
        (function () {
            var isDark = document.documentElement.classList.contains('dark');
            document.getElementById('icon-moon').style.display = isDark ? 'none'  : 'block';
            document.getElementById('icon-sun').style.display  = isDark ? 'block' : 'none';
        })();
    </script>
</body>
</html>