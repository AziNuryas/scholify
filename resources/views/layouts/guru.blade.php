<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolify - Tenaga Pendidik</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-indigo: #4F46E5;
            --primary-purple: #7C3AED;
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

        /* Animasi untuk tombol logout */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .logout-btn:hover i {
            animation: pulse 0.3s ease-in-out;
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
                        ['route' => 'guru.nilai', 'icon' => 'edit-3', 'label' => 'Nilai'],
                        ['route' => 'guru.tugas', 'icon' => 'clipboard-list', 'label' => 'Tugas'],
                        ['route' => 'guru.pengumuman', 'icon' => 'megaphone', 'label' => 'Pengumuman'],
                        ['route' => 'guru.profil', 'icon' => 'user-circle', 'label' => 'Profil'],
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

                <!-- Profile Dropdown dengan Tombol Logout yang Lebih Baik -->
                <div class="relative group">
                    <div class="flex items-center gap-4 bg-white p-1.5 pr-5 rounded-2xl shadow-sm border border-gray-100 cursor-pointer hover:border-indigo-200 hover:shadow-md transition-all duration-300">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center rounded-xl font-bold shadow-lg shadow-indigo-200">
                            BG
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-bold text-sm leading-none text-slate-800">Bapak Guru Budi</p>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-indigo-500">Tenaga Pendidik</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform duration-300"></i>
                    </div>

                    <!-- Dropdown Menu Modern -->
                    <div class="absolute top-full right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                        <!-- Header Dropdown -->
                        <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    BG
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-slate-800">Bapak Guru Budi</p>
                                    <p class="text-xs text-slate-500">budi@schoolify.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Items -->
                        <div class="p-2">
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 rounded-xl transition-all duration-200 group">
                                <i data-lucide="settings" class="w-4 h-4 text-indigo-500"></i>
                                <span>Pengaturan</span>
                            </a>
                            <div class="border-t border-gray-100 my-2"></div>
                            
                            <!-- Tombol Logout yang Sudah Diperbaiki -->
                            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                @csrf
                                <button type="submit" class="logout-btn w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group">
                                    <i data-lucide="log-out" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                                    <span>Keluar Aplikasi</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
        
        // Tambahan efek konfirmasi sebelum logout (opsional)
        document.querySelectorAll('.logout-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if(!confirm('Apakah Anda yakin ingin keluar dari aplikasi?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>