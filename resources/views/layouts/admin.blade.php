<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Schoolify')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>
<body class="text-[#334155] antialiased min-h-screen flex selection:bg-blue-500 selection:text-white">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full md:translate-x-0 shadow-2xl md:shadow-none h-screen overflow-y-auto">
        <div>
            <!-- Logo -->
            <div class="p-8 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <i class='bx bxs-school text-white text-2xl'></i>
                    </div>
                    <span class="font-outfit font-extrabold text-2xl text-[#1E293B] tracking-tight">Schoolify<span class="text-blue-600">.</span></span>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 font-outfit">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.students*') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bx-book text-xl'></i>
                    <span class="font-semibold">Data Siswa</span>
                </a>

                <a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.teachers*') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bx-chalkboard text-xl'></i>
                    <span class="font-semibold">Data Guru BK</span>
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Manajemen</p>

                <a href="{{ route('admin.classes') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.classes*') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bx-buildings text-xl'></i>
                    <span class="font-semibold">Kelas</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.reports*') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bx-file-blank text-xl'></i>
                    <span class="font-semibold">Laporan</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.settings*') ? 'bg-blue-600 text-white shadow-md shadow-blue-100' : 'text-gray-500 hover:text-blue-700 hover:bg-blue-50' }}">
                    <i class='bx bx-cog text-xl'></i>
                    <span class="font-semibold">Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="p-6 mt-10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 font-bold py-3 rounded-xl transition cursor-pointer">
                    <i class='bx bx-log-out text-lg'></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-h-screen max-w-[100vw] overflow-x-hidden relative">
        
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-6 md:px-10 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-blue-600 bg-gray-50 p-2 rounded-lg">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
                <h1 class="text-xl font-outfit font-bold text-[#1E293B]">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563EB&color=fff" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                    <div class="hidden sm:block text-sm">
                        <p class="font-bold text-[#1E293B]">{{ Auth::user()->name }}</p>
                        <p class="text-blue-600 text-xs font-medium">Admin</p>
                    </div>
                </a>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6 md:p-10 flex-1 relative z-10 w-full overflow-hidden">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-start gap-3">
                    <i class='bx bx-check-circle text-xl flex-shrink-0 mt-0.5'></i>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-start gap-3">
                    <i class='bx bx-error-circle text-xl flex-shrink-0 mt-0.5'></i>
                    <div>
                        <p class="font-semibold">Error!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>