<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Schoolify')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #EEF2FF;
            background-image:
                radial-gradient(ellipse at 0% 0%, rgba(165,180,252,0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 100%, rgba(196,181,253,0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(224,231,255,0.4) 0%, transparent 70%);
            color: #1e293b;
            overflow: hidden;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 99px; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border-right: 1px solid rgba(255,255,255,0.8);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        /* Cards */
        .glass-card {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(99,102,241,0.06), 0 1px 4px rgba(99,102,241,0.04);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }
        .glass-card:hover { box-shadow: 0 8px 40px rgba(99,102,241,0.1), 0 2px 8px rgba(99,102,241,0.06); }

        .glass-card-strong {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(99,102,241,0.08);
        }

        /* Header */
        .topbar {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(32px);
            -webkit-backdrop-filter: blur(32px);
            border-bottom: 1px solid rgba(255,255,255,0.8);
        }

        /* Nav items */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link:hover { background: rgba(99,102,241,0.07); color: #4f46e5; transform: translateX(2px); }
        .nav-link.active {
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(99,102,241,0.35), 0 2px 8px rgba(99,102,241,0.2);
        }
        .nav-link.active i { color: white; }
        .nav-link i { font-size: 18px; color: #94a3b8; transition: color 0.2s; }
        .nav-link:hover i { color: #6366f1; }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            padding: 13px 24px;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(99,102,241,0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover { box-shadow: 0 8px 28px rgba(99,102,241,0.45); transform: translateY(-1px); }

        /* Inputs */
        .form-input {
            width: 100%;
            background: rgba(241,245,249,0.8);
            border: 1.5px solid rgba(226,232,240,0.8);
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none;
            transition: all 0.2s;
        }
        .form-input:focus { border-color: #6366f1; background: white; box-shadow: 0 0 0 4px rgba(99,102,241,0.1); }
        .form-input::placeholder { color: #94a3b8; font-weight: 400; }

        /* Table */
        .premium-table { border-collapse: collapse; width: 100%; }
        .premium-table th { padding: 14px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; background: rgba(248,250,252,0.7); border-bottom: 1px solid rgba(226,232,240,0.5); }
        .premium-table td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid rgba(241,245,249,0.8); }
        .premium-table tr:hover td { background: rgba(238,242,255,0.4); }
        .premium-table tr:last-child td { border-bottom: none; }

        /* Badge */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 99px; font-size: 12px; font-weight: 700; }

        [x-cloak] { display: none !important; }

        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .page-enter { animation: fadeSlideUp 0.45s cubic-bezier(0.22,1,0.36,1) forwards; }
    </style>
</head>
<body class="flex" style="height:100vh; overflow:hidden;">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar z-20">
        {{-- Logo --}}
        <div class="h-[72px] flex items-center px-6 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-400 flex items-center justify-center text-white font-black text-[18px] shadow-lg shadow-indigo-200/60">S</div>
                <div>
                    <span class="font-black text-[20px] text-slate-800 tracking-tight leading-none">Schoolify</span>
                    <span class="text-indigo-500 font-black text-[20px]">.</span>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto px-4 space-y-1 py-2">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.12em] px-3 pt-2 pb-2">Akademik</p>
            <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class='bx bxs-dashboard'></i> Dashboard
            </a>
            <a href="{{ route('student.schedule') }}" class="nav-link {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                <i class='bx bx-calendar'></i> Jadwal Pelajaran
            </a>
            <a href="{{ route('student.assignments') }}" class="nav-link {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                <i class='bx bx-book-open'></i> Tugas
            </a>
            <a href="{{ route('student.grades') }}" class="nav-link {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                <i class='bx bx-bar-chart-alt-2'></i> Nilai & Rapor
            </a>

            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.12em] px-3 pt-4 pb-2">Layanan</p>
            <a href="{{ route('student.counseling') }}" class="nav-link {{ request()->routeIs('student.counseling') ? 'active' : '' }}">
                <i class='bx bx-heart'></i> Layanan BK
            </a>
            <a href="{{ route('student.discipline') }}" class="nav-link {{ request()->routeIs('student.discipline') ? 'active' : '' }}">
                <i class='bx bx-shield-quarter'></i> Kedisiplinan
            </a>
        </nav>

        {{-- Profile mini at bottom --}}
        <div class="p-4 flex-shrink-0">
            <a href="{{ route('student.profile') }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-white/60 transition group">
                <img src="{{ $currentStudent['avatar'] ?? 'https://ui-avatars.com/api/?name=S&background=6366f1&color=fff&size=80' }}" alt="" class="w-10 h-10 rounded-xl object-cover ring-2 ring-white shadow-sm">
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-[13px] text-slate-800 truncate">{{ $currentStudent['name'] ?? 'Siswa' }}</p>
                    <p class="text-[11px] text-slate-400 font-semibold truncate">{{ $currentStudent['class'] ?? '-' }}</p>
                </div>
                <i class='bx bx-chevron-right text-slate-300 group-hover:text-indigo-400 transition text-xl'></i>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 text-slate-400 hover:text-rose-500 font-semibold text-[13px] py-2.5 rounded-xl hover:bg-rose-50/50 transition-all">
                    <i class='bx bx-log-out text-[16px]'></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <main class="flex-1 flex flex-col" style="height:100vh; overflow:hidden;">

        {{-- Topbar --}}
        <header class="topbar h-[72px] px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="font-bold text-[18px] text-slate-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="hidden lg:flex items-center gap-2 bg-slate-100/70 rounded-xl px-4 py-2.5 w-56">
                    <i class='bx bx-search text-slate-400 text-[16px]'></i>
                    <input type="text" placeholder="Cari sesuatu..." class="bg-transparent border-none outline-none text-[13px] w-full text-slate-700 placeholder-slate-400 font-medium">
                </div>
                {{-- Bell --}}
                <button class="w-10 h-10 rounded-xl bg-white/80 hover:bg-indigo-50 text-slate-400 hover:text-indigo-500 flex items-center justify-center transition-all shadow-sm border border-white/80">
                    <i class='bx bx-bell text-[18px]'></i>
                </button>
                {{-- Avatar --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 bg-white/80 hover:bg-white px-3 py-1.5 rounded-2xl shadow-sm border border-white/80 transition-all">
                        <img src="{{ $currentStudent['avatar'] ?? 'https://ui-avatars.com/api/?name=S&background=6366f1&color=fff&size=80' }}" alt="" class="w-8 h-8 rounded-lg object-cover">
                        <span class="font-bold text-[13px] text-slate-700 hidden sm:block">{{ $currentStudent['name'] ?? 'Siswa' }}</span>
                        <i class='bx bx-chevron-down text-slate-400 text-[16px]'></i>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="absolute right-0 mt-2 w-48 glass-card-strong py-2 z-50">
                        <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 font-semibold rounded-xl mx-2 transition">
                            <i class='bx bx-user'></i> Profil Saya
                        </a>
                        <div class="h-px bg-slate-100 mx-4 my-1.5"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-rose-500 hover:bg-rose-50 font-bold rounded-xl mx-2 transition" style="width: calc(100% - 16px)">
                                <i class='bx bx-log-out'></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto page-enter">
                @yield('content')
            </div>
        </div>
    </main>
</body>
</html>