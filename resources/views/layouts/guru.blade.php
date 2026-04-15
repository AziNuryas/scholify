<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolify - Tenaga Pendidik</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-indigo: #4F46E5;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #F1F5F9;
            color: #0F172A;
        }
        .font-heading { font-family: 'Outfit', sans-serif; }

        /* Efek Blur Latar Belakang */
        .mesh-orb {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
        }
        .orb-1 { top: -100px; right: -100px; background: rgba(99, 102, 241, 0.3); }
        .orb-2 { bottom: -100px; left: -100px; background: rgba(168, 85, 247, 0.3); }

        /* Sidebar Active State */
        .sidebar-active {
            position: relative;
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.1) 0%, rgba(79, 70, 229, 0) 100%);
            color: var(--primary-indigo);
            font-weight: 600;
        }
        .sidebar-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: var(--primary-indigo);
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>
<body>

    <div class="mesh-orb orb-1"></div>
    <div class="mesh-orb orb-2"></div>

    <div class="flex min-h-screen">
        <aside class="w-72 bg-white/70 backdrop-blur-xl border-r border-gray-200/50 p-8 sticky top-0 h-screen">
            <div class="flex items-center gap-3 mb-12">
                <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200">
                    <i data-lucide="graduation-cap" class="text-white w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-heading font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Schoolify
                </h1>
            </div>

            <nav class="space-y-4">
                @php
                    $menus = [
                        ['route' => 'guru.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                        ['route' => 'guru.jadwal', 'icon' => 'calendar', 'label' => 'Jadwal'],
                        ['route' => 'guru.absensi', 'icon' => 'user-check', 'label' => 'Absensi'],
                        ['route' => 'guru.nilai', 'icon' => 'edit-3', 'label' => 'Nilai'],           // Icon: edit-3 (pensil untuk edit nilai)
                        ['route' => 'guru.tugas', 'icon' => 'clipboard-list', 'label' => 'Tugas'],    // Icon: clipboard-list (daftar tugas)     // Icon: file-text (dokumen raport)
                        ['route' => 'guru.pengumuman', 'icon' => 'megaphone', 'label' => 'Pengumuman'],
                        ['route' => 'guru.profil', 'icon' => 'user-circle', 'label' => 'Profil'],     // Icon: user-circle (profil pengguna)
                    ];
                @endphp

                @foreach($menus as $menu)
                <a href="{{ route($menu['route']) }}" 
                   class="flex items-center gap-3 p-3 rounded-xl transition-all {{ request()->routeIs($menu['route']) ? 'sidebar-active' : 'text-slate-500 hover:bg-gray-50' }}">
                    <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5"></i>
                    {{ $menu['label'] }}
                </a>
                @endforeach
            </nav>
        </aside>

        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-heading font-bold text-slate-800">@yield('page_title', 'Selamat Datang')</h2>
                    <p class="text-slate-500 mt-1">@yield('page_subtitle', 'Kelola data akademik Anda dengan mudah.')</p>
                </div>

                <div class="relative group">
                    <div class="flex items-center gap-4 bg-white p-1.5 pr-5 rounded-2xl shadow-sm border border-gray-100 cursor-pointer hover:border-indigo-200 transition-all">
                        <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center rounded-xl font-bold shadow-indigo-200 shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-bold text-sm leading-none">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-indigo-500">Tenaga Pendidik</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform"></i>
                    </div>

                    <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>