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
            --secondary-indigo: #818CF8;
            --bg-gradient-start: #F8FAFC;
            --bg-gradient-end: #EEF2FF;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
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
            z-index: 0;
            opacity: 0.4;
            pointer-events: none;
        }
        
        .orb-1 { 
            top: -100px; 
            right: -100px; 
            background: radial-gradient(circle, rgba(79, 70, 229, 0.4), rgba(124, 58, 237, 0.2));
        }
        
        .orb-2 { 
            bottom: -100px; 
            left: -100px; 
            background: radial-gradient(circle, rgba(139, 92, 246, 0.4), rgba(79, 70, 229, 0.2));
        }
        
        .orb-3 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15), transparent);
            filter: blur(100px);
        }

        /* Sidebar Active State */
        .sidebar-active {
            position: relative;
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.12) 0%, rgba(79, 70, 229, 0) 100%);
            color: var(--primary-indigo);
            font-weight: 600;
        }
        
        .sidebar-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 3px;
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-purple));
            border-radius: 0 4px 4px 0;
        }

        /* Sidebar item hover effect */
        .sidebar-item {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-item:hover:not(.sidebar-active) {
            background: rgba(79, 70, 229, 0.06);
            transform: translateX(4px);
        }

        /* Animasi untuk logout button */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logout-btn {
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            transform: scale(1.02);
        }
        
        .logout-btn:hover i {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Dropdown animation */
        .dropdown-menu {
            animation: slideIn 0.2s ease-out;
        }
        
        /* Card hover effect */
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #E2E8F0;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-purple));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-purple), var(--primary-indigo));
        }
        
        /* Glassmorphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Logo image style */
        .logo-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

    <!-- Decorative Background Elements -->
    <div class="mesh-orb orb-1"></div>
    <div class="mesh-orb orb-2"></div>
    <div class="mesh-orb orb-3"></div>

    <div class="flex min-h-screen relative z-10">
        <!-- Sidebar dengan Logo Scholify (Gambar) -->
        <aside class="w-72 bg-white/60 backdrop-blur-xl border-r border-white/40 shadow-xl p-6 sticky top-0 h-screen">
            <!-- Logo Scholify dengan Gambar -->
            <div class="flex items-center gap-3 mb-8">
                <!-- Logo Gambar Scholify - Ganti dari ikon toga ke gambar -->
                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg shadow-indigo-200 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                    <img src="{{ asset('images/scholify-logo.png') }}" 
                         alt="Scholify Logo" 
                         class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-2xl font-heading font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent leading-tight">
                        Scholify<span class="text-indigo-600">.</span>
                    </h1>
                    <p class="text-[10px] font-semibold text-slate-400 tracking-wide uppercase mt-0.5">Belajar · Terhubung · Berkembang</p>
                </div>
            </div>

            <nav class="space-y-1.5">
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Menu Utama</p>
                
                @php
                    $menus = [
                        ['route' => 'guru.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'badge' => null],
                        ['route' => 'guru.jadwal', 'icon' => 'calendar', 'label' => 'Jadwal Kelas', 'badge' => null],
                        ['route' => 'guru.absensi', 'icon' => 'user-check', 'label' => 'Absensi', 'badge' => null],
                        ['route' => 'guru.nilai', 'icon' => 'edit-3', 'label' => 'Nilai & Rapor', 'badge' => null],
                        ['route' => 'guru.tugas', 'icon' => 'clipboard-list', 'label' => 'Tugas', 'badge' => ''],
                        ['route' => 'guru.pengumuman', 'icon' => 'megaphone', 'label' => 'Pengumuman', 'badge' => null],
                    ];
                @endphp

                @foreach($menus as $menu)
                <a href="{{ route($menu['route']) }}" 
                   class="sidebar-item flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs($menu['route']) ? 'sidebar-active' : 'text-slate-500 hover:bg-indigo-50/50' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5"></i>
                        <span class="text-sm font-medium">{{ $menu['label'] }}</span>
                    </div>
                    @if($menu['badge'])
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $menu['badge'] }}</span>
                    @endif
                </a>
                @endforeach

                <div class="my-6 border-t border-white/40 mx-3"></div>
                
                <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Lainnya</p>
                
                <a href="{{ route('guru.profil') }}" 
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('guru.profil') ? 'sidebar-active' : 'text-slate-500 hover:bg-indigo-50/50' }}">
                    <i data-lucide="user-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">Profil Saya</span>
                </a>

            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-1 h-6 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                        <h2 class="text-2xl font-heading font-bold text-slate-800">@yield('page_title', 'Selamat Datang')</h2>
                    </div>
                    <p class="text-slate-500 text-sm ml-3">@yield('page_subtitle', 'Kelola data akademik Anda dengan mudah.')</p>
                </div>

                <!-- Profile Dropdown dengan Menu Lengkap -->
                <div class="relative group">
                    <div class="flex items-center gap-4 bg-white/70 backdrop-blur-sm p-1.5 pr-5 rounded-2xl shadow-lg border border-white/40 cursor-pointer hover:shadow-xl hover:border-indigo-200 transition-all duration-300">
                        <div class="relative">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center rounded-xl font-bold shadow-lg shadow-indigo-200">
                                BG
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-bold text-sm leading-tight text-slate-800">Bapak Guru Budi</p>
                            <p class="text-[10px] uppercase tracking-wider font-semibold text-indigo-500">Tenaga Pendidik</p>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:rotate-180 transition-transform duration-300"></i>
                    </div>

                    <!-- Dropdown Menu Premium -->
                    <div class="absolute top-full right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden dropdown-menu">
                        <!-- Header Dropdown -->
                        <div class="relative px-4 py-4 bg-gradient-to-r from-indigo-50 via-purple-50 to-indigo-50 border-b border-indigo-100">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        BG
                                    </div>
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-slate-800">Bapak Guru Budi</p>
                                    <p class="text-xs text-slate-500">budi.guru@schoolify.com</p>
                                    <p class="text-[10px] font-semibold text-indigo-600 mt-0.5">Guru Mapel RPL</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Items - Profil dan Pengaturan -->
                        <div class="p-2">
                            <a href="{{ route('guru.profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 rounded-xl transition-all duration-200 group">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                    <i data-lucide="user-circle" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                                <span class="font-medium">Profil Saya</span>
                            </a>
                            
                            <div class="border-t border-gray-100 my-2"></div>
                            
                            <!-- Tombol Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                                @csrf
                                <button type="submit" class="logout-btn w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 rounded-xl transition-all duration-300 group">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                        <i data-lucide="log-out" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                                    </div>
                                    <span>Keluar Aplikasi</span>
                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
        
        // Konfirmasi logout dengan custom dialog
        document.querySelectorAll('.logout-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Custom confirm dialog yang lebih modern
                const confirmed = confirm('⚠️ Apakah Anda yakin ingin keluar?\n\nSemua sesi akan berakhir dan Anda perlu login kembali.');
                
                if(confirmed) {
                    // Tampilkan loading indicator
                    const btn = this.querySelector('button');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mx-auto"></div>';
                    btn.disabled = true;
                    
                    // Submit form
                    this.submit();
                }
            });
        });
        
        // Tooltip untuk badge (opsional)
        const badges = document.querySelectorAll('[data-tooltip]');
        badges.forEach(badge => {
            badge.addEventListener('mouseenter', (e) => {
                const tooltip = document.createElement('div');
                tooltip.textContent = badge.dataset.tooltip;
                tooltip.className = 'absolute bg-gray-900 text-white text-xs px-2 py-1 rounded-lg whitespace-nowrap z-50';
                tooltip.style.top = (e.target.offsetTop - 30) + 'px';
                tooltip.style.left = (e.target.offsetLeft) + 'px';
                document.body.appendChild(tooltip);
                
                badge.addEventListener('mouseleave', () => {
                    tooltip.remove();
                });
            });
        });
    </script>
</body>
</html>