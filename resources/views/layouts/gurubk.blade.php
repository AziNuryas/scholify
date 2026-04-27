<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guru BK Portal - Schoolify')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Premium Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>
<body class="text-[#334155] antialiased min-h-screen flex selection:bg-teal-500 selection:text-white">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar (Teal Theme) -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 flex flex-col justify-between transition-transform duration-300 transform -translate-x-full md:translate-x-0 shadow-2xl md:shadow-none h-screen overflow-y-auto">
        <div>
            <!-- Logo -->
            <div class="p-8 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-200">
                        <i class='bx bxs-school text-white text-2xl'></i>
                    </div>
                    <span class="font-outfit font-extrabold text-2xl text-[#1E293B] tracking-tight">Schoolify<span class="text-teal-600">.</span></span>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-2 font-outfit">
                <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ route('gurubk.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.dashboard') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span class="font-semibold">Ikhtisar BK</span>
                </a>
                <a href="{{ route('gurubk.chats') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.chats') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }} relative">
                    <i class='bx bx-message-square-dots text-xl'></i>
                    <span class="font-semibold">Ruang Konsultasi</span>
                    @php $unread = \App\Models\Chat::where('receiver_id', auth()->id())->where('is_read', false)->count(); @endphp
                    @if($unread > 0)
                    <span class="absolute right-4 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center shadow-sm uppercase">{{ $unread }}</span>
                    @endif
                </a>
                <a href="{{ route('gurubk.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.profile') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bx-user text-xl'></i>
                    <span class="font-semibold">Profil Saya</span>
                </a>
                <a href="{{ route('gurubk.discipline') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.discipline') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bx-error-circle text-xl'></i>
                    <span class="font-semibold">Catatan Disiplin</span>
                </a>
                <a href="{{ route('gurubk.appointments') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.appointments') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bx-calendar text-xl'></i>
                    <span class="font-semibold">Jadwal Temu</span>
                </a>
                <a href="{{ route('gurubk.catatan-konseling.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.catatan-konseling.index') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bx-book-open text-xl'></i>
                    <span class="font-semibold">Catatan Konseling</span>
                </a>
                <a href="{{ route('gurubk.deteksi-asesmen.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('gurubk.deteksi-asesmen.index') ? 'bg-teal-600 text-white shadow-md shadow-teal-100 transition-transform hover:-translate-y-0.5' : 'text-gray-500 hover:text-teal-700 hover:bg-teal-50 transition-colors' }}">
                    <i class='bx bx-book-open text-xl'></i>
                    <span class="font-semibold">Deteksi Dini & Asesmen</span>
                </a>
            </nav>
        </div>

        <!-- Logout Button -->
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

    <!-- Main Content Wrapper -->
    <main class="flex-1 flex flex-col min-h-screen max-w-[100vw] overflow-x-hidden relative">
        
        <!-- Header -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-6 md:px-10 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-teal-600 bg-gray-50 p-2 rounded-lg">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
            </div>

            <div class="flex items-center gap-6">
                <!-- Notifications -->
                <button class="relative text-gray-400 hover:text-teal-600 transition bg-gray-50 p-2.5 rounded-full">
                    <i class='bx bx-bell text-xl'></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <!-- Profile Dropdown -->
                <a href="{{ route('gurubk.profile') }}" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
                    <img src="{{ $guru['avatar'] ?? 'https://ui-avatars.com/api/?name=BK' }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                    <div class="hidden sm:block text-sm">
                        <p class="font-bold text-[#1E293B]">{{ $guru['name'] ?? 'Guru BK' }}</p>
                        <p class="text-teal-600 text-xs font-medium">{{ request()->routeIs('gurubk.profile') ? 'Lihat Profil >' : ($guru['role'] ?? 'Bimbingan Konseling') }}</p>
                    </div>
                </a>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="p-6 md:p-10 flex-1 relative z-10 w-full overflow-hidden">
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
</body>
</html>
