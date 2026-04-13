<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Schoolify - Student Space')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CDN (Tidak Perlu Vite/NPM Run Dev lagi) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Premium Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F4F7FE; /* Premium soft background */
            color: #2B3674; 
        }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Custom Scrollbar for a premium feel */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E0E5F2; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #A3AED0; }
        
        /* Glass card effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 18px 40px rgba(112, 144, 176, 0.12);
        }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden text-[#2B3674]">

    <!-- Sidebar -->
    <aside class="w-[280px] bg-white h-full shadow-sm flex flex-col justify-between transition-all duration-300 z-20">
        <div>
            <!-- Logo -->
            <div class="h-24 flex items-center px-8 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#4318FF] to-[#868CFF] flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200">
                        S
                    </div>
                    <span class="font-outfit font-extrabold text-2xl tracking-tight text-[#2B3674]">Schoolify<span class="text-[#4318FF]">.</span></span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-2 mt-4 font-outfit">
                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.dashboard') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }}">
                    <i class='bx bxs-dashboard text-xl'></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('student.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.schedule') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }}">
                    <i class='bx bx-calendar text-xl'></i>
                    <span>Jadwal Kelas</span>
                </a>
                <a href="{{ route('student.assignments') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.assignments') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }} relative">
                    <i class='bx bx-book-content text-xl'></i>
                    <span>Tugas</span>
                </a>
                <a href="{{ route('student.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.grades') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }}">
                    <i class='bx bx-bar-chart-alt-2 text-xl'></i>
                    <span>Nilai</span>
                </a>
                <a href="{{ route('student.counseling') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.counseling') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }} relative">
                    <i class='bx bx-support text-xl'></i>
                    <span>Konsultasi BK</span>
                    @php $unread = \App\Models\Chat::where('receiver_id', auth()->id())->where('is_read', false)->count(); @endphp
                    @if($unread > 0)
                    <span class="absolute right-4 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center shadow-sm uppercase">{{ $unread }}</span>
                    @endif
                </a>
                <a href="{{ route('student.appointments') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.appointments') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }}">
                    <i class='bx bx-calendar text-xl'></i>
                    <span>Jadwal Temu</span>
                </a>
                <a href="{{ route('student.discipline') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.discipline') ? 'bg-[#4318FF] text-white font-semibold shadow-md shadow-indigo-100 transition-transform hover:-translate-y-0.5' : 'text-[#A3AED0] hover:text-[#2B3674] hover:bg-gray-50 font-medium transition-colors' }}">
                    <i class='bx bx-error-circle text-xl'></i>
                    <span>Catatan Disiplin</span>
                </a>
            </nav>
        </div>

        <!-- Upgrade/Promo Card (Common in modern dashboards) -->
        <div class="p-6">
            <div class="glass-card rounded-2xl p-5 text-center relative overflow-hidden bg-gradient-to-br from-[#868CFF] to-[#4318FF] text-white shadow-xl shadow-indigo-200 border-none">
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-white opacity-10 rounded-full blur-xl"></div>
                <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-white opacity-10 rounded-full blur-xl"></div>
                <h4 class="font-outfit font-bold text-lg mb-1 relative z-10">Ujian Semester</h4>
                <p class="text-xs text-indigo-100 mb-4 relative z-10">Tinggal 14 hari lagi, persiapkan dirimu dari sekarang!</p>
                <button class="w-full py-2 bg-white text-[#4318FF] rounded-lg text-sm font-semibold hover:bg-gray-50 transition relative z-10">Lihat Kisi-kisi</button>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="p-6 mt-auto border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 font-bold py-3 rounded-xl transition cursor-pointer">
                    <i class='bx bx-log-out text-lg'></i>
                    <span>Keluar / Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        <!-- Top Header -->
        <header class="h-24 px-8 flex items-center justify-between glass-card border-b-0 border-x-0 border-t-0 bg-white/40 sticky top-0 z-10">
            <div>
                <p class="text-sm text-[#A3AED0] font-medium mb-1">Welcome back,</p>
                <h2 class="font-outfit font-bold text-2xl text-[#2B3674]">Ruang Belajar</h2>
            </div>

            <div class="flex items-center gap-6 glass-card px-4 py-2 rounded-full border border-white">
                <!-- Search Bar -->
                <div class="relative hidden py-1 md:flex items-center bg-[#F4F7FE] rounded-full px-4 w-64">
                    <i class='bx bx-search text-[#A3AED0] text-lg'></i>
                    <input type="text" placeholder="Cari materi..." class="bg-transparent border-none outline-none text-sm ml-2 w-full text-[#2B3674] placeholder-[#A3AED0]">
                </div>

                <!-- Notifications -->
                <button class="relative text-[#A3AED0] hover:text-[#4318FF] transition">
                    <i class='bx bxs-bell text-2xl'></i>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                </button>

                <!-- Profile Dropdown -->
                <a href="{{ route('student.profile') }}" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition block">
                    <img src="{{ $student['avatar'] ?? 'https://ui-avatars.com/api/?name=User&background=6366f1&color=fff' }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                    <div class="hidden sm:block text-sm">
                        <p class="font-bold text-[#2B3674]">{{ $student['name'] ?? 'Siswa' }}</p>
                        <p class="text-[#A3AED0] text-xs font-medium">{{ request()->routeIs('student.profile') ? 'Lihat Profil >' : ($student['class'] ?? 'Kelas') }}</p>
                    </div>
                </a>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>
