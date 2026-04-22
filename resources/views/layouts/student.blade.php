<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Schoolify - Student Space')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 (Lebih reliable) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand-primary: #4318FF;
            --brand-secondary: #2D3748;
            --text-muted: #718096;
            --bg-main: #E0E5EC;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-main); 
            color: var(--brand-secondary); 
            letter-spacing: -0.01em;
        }

        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Neumorphism Utilities */
        .neo-bg { background-color: var(--bg-main); }
        .neo-flat {
            background: var(--bg-main);
            box-shadow: 9px 9px 16px rgba(163,177,198,0.6), -9px -9px 16px rgba(255,255,255, 0.5);
            border-radius: 20px;
        }
        .neo-pressed {
            background: var(--bg-main);
            box-shadow: inset 6px 6px 10px 0 rgba(163,177,198, 0.7), inset -6px -6px 10px 0 rgba(255,255,255, 0.8);
            border-radius: 12px;
        }
        .neo-btn {
            background: var(--bg-main);
            box-shadow: 9px 9px 16px rgba(163,177,198,0.6), -9px -9px 16px rgba(255,255,255, 0.5);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .neo-btn:active {
            box-shadow: inset 6px 6px 10px 0 rgba(163,177,198, 0.7), inset -6px -6px 10px 0 rgba(255,255,255, 0.8);
        }
        .neo-circle {
            border-radius: 50%;
        }

        /* Colored Neumorphism Combos (Pastel Cards) */
        .neo-flat-blue {
            background: #e6eefc;
            box-shadow: 9px 9px 16px rgba(181, 195, 222, 0.6), -9px -9px 16px rgba(255, 255, 255, 0.8);
            border-radius: 20px;
        }
        .neo-flat-green {
            background: #e6fceb;
            box-shadow: 9px 9px 16px rgba(181, 222, 189, 0.6), -9px -9px 16px rgba(255, 255, 255, 0.8);
            border-radius: 20px;
        }
        .neo-flat-orange {
            background: #fcece6;
            box-shadow: 9px 9px 16px rgba(222, 194, 181, 0.6), -9px -9px 16px rgba(255, 255, 255, 0.8);
            border-radius: 20px;
        }
        .neo-flat-purple {
            background: #eee6fc;
            box-shadow: 9px 9px 16px rgba(195, 181, 222, 0.6), -9px -9px 16px rgba(255, 255, 255, 0.8);
            border-radius: 20px;
        }

        /* 3D Vibrant Badges (Image 1 style) */
        .neo-badge-blue {
            background: linear-gradient(135deg, #4aa3ff, #1d61ff);
            box-shadow: 4px 4px 10px rgba(67, 24, 255, 0.2), -4px -4px 10px rgba(255, 255, 255, 0.5);
            color: white;
            border-radius: 50%;
        }
        .neo-badge-green {
            background: linear-gradient(135deg, #4ade80, #16a34a);
            box-shadow: 4px 4px 10px rgba(22, 163, 74, 0.2), -4px -4px 10px rgba(255, 255, 255, 0.5);
            color: white;
            border-radius: 50%;
        }
        .neo-badge-red {
            background: linear-gradient(135deg, #f87171, #dc2626);
            box-shadow: 4px 4px 10px rgba(220, 38, 38, 0.2), -4px -4px 10px rgba(255, 255, 255, 0.5);
            color: white;
            border-radius: 50%;
        }
        .neo-badge-orange {
            background: linear-gradient(135deg, #fbbf24, #d97706);
            box-shadow: 4px 4px 10px rgba(217, 119, 6, 0.2), -4px -4px 10px rgba(255, 255, 255, 0.5);
            color: white;
            border-radius: 50%;
        }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a0aec0; }
        
        .glass-header {
            background: var(--bg-main);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 40;
        }

        .nav-link {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link:hover:not(.active) {
            transform: translateX(4px);
        }

        [x-cloak] { display: none !important; }

        @keyframes elasticBounce {
            0% { transform: translateY(100px) scale(0.8); opacity: 0; }
            60% { transform: translateY(-15px) scale(1.05); opacity: 1; }
            80% { transform: translateY(5px) scale(0.98); }
            100% { transform: translateY(0) scale(1); }
        }

        .animate-bounce-in {
            animation: elasticBounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        
        /* Memastikan ikon selalu tampil */
        .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 1.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden neo-bg">

    <aside class="w-[290px] neo-bg h-full flex flex-col transition-all duration-300 z-20">
        <div class="h-24 flex-none flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xl neo-flat text-[#4318FF]">
                    S
                </div>
                <span class="font-outfit font-extrabold text-2xl tracking-tight text-[var(--brand-secondary)]">Schoolify<span class="text-[#4318FF]">.</span></span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-4">
            <div class="neo-flat p-4 h-full flex flex-col">
                <nav class="space-y-3 font-outfit flex-1">
                    <p class="px-2 text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-3">Menu Utama</p>
                    
                    <a href="{{ route('student.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.dashboard') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }}">
                        <i class="fas fa-tachometer-alt text-xl nav-icon"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('student.schedule') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.schedule') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }}">
                        <i class="fas fa-calendar-alt text-xl nav-icon"></i>
                        <span>Jadwal Kelas</span>
                    </a>
                    
                    <a href="{{ route('student.assignments') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.assignments') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }} relative">
                        <i class="fas fa-book-open text-xl nav-icon"></i>
                        <span>Tugas Mandiri</span>
                    </a>

                    <div class="my-6 border-t border-gray-300 mx-2 opacity-50"></div>
                    <p class="px-2 text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-3">Layanan</p>
                    
                    <a href="{{ route('student.grades') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.grades') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }}">
                        <i class="fas fa-chart-line text-xl nav-icon"></i>
                        <span>E-Rapor & Nilai</span>
                    </a>
                    
                    <a href="{{ route('student.counseling') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.counseling') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }}">
                        <i class="fas fa-headset text-xl nav-icon"></i>
                        <span>Konsultasi BK</span>
                    </a>

                    <a href="{{ route('student.discipline') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('student.discipline') ? 'neo-pressed text-[#4318FF] font-semibold active' : 'text-[var(--text-muted)] hover:text-[var(--brand-secondary)] font-medium neo-btn' }}">
                        <i class="fas fa-exclamation-triangle text-xl nav-icon"></i>
                        <span>Poin Disiplin</span>
                    </a>
                </nav>

                <div class="mt-auto pt-6">
                    <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full text-[var(--text-muted)] neo-btn py-3 transition-colors">
                            <i class="fas fa-sign-out-alt text-xl"></i>
                            <span class="font-semibold">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        @php
            $myStudent = \App\Models\Student::with('schoolClass')->where('user_id', auth()->id())->first();
            $classId = $myStudent->class_id ?? null;
            $announcements = collect();
            try {
                $announcements = \App\Models\Announcement::where('target', 'all')
                    ->orWhere(function ($query) use ($classId) {
                        if($classId) {
                            $query->where('target', 'class')->where('class_id', $classId);
                        } else {
                            $query->whereRaw('1=0');
                        }
                    })
                    ->latest()
                    ->limit(5)
                    ->get();
            } catch (\Exception $e) {
                // Catch query errors such as missing class_id column
                try {
                    // Fallback to simple query if class_id is missing
                    $announcements = \App\Models\Announcement::latest()->limit(5)->get();
                } catch (\Exception $inner) {
                    // Fail gracefully
                }
            }
        @endphp
        <header class="h-24 px-10 flex-none flex items-center justify-between glass-header sticky top-0 z-10">
            <div>
                <p class="text-[13px] text-[var(--text-muted)] font-semibold tracking-wide uppercase">Student Workspace</p>
                <h2 class="font-outfit font-extrabold text-2xl text-[var(--brand-secondary)]">Halo, Selamat Belajar! 👋</h2>
            </div>

            <div class="flex items-center gap-4 neo-flat p-2 rounded-2xl">
                <div class="relative hidden lg:flex items-center neo-pressed rounded-xl px-4 py-2 w-72">
                    <i class="fas fa-search text-[var(--text-muted)] text-lg"></i>
                    <input type="text" placeholder="Cari tugas..." class="bg-transparent border-none outline-none text-sm ml-2 w-full text-[var(--brand-secondary)] placeholder-[var(--text-muted)]">
                </div>

                <div class="relative" x-data="{ openNotif: false }">
                    <button @click="openNotif = !openNotif" @click.away="openNotif = false" class="p-2.5 rounded-xl text-[var(--text-muted)] neo-btn transition-all relative outline-none mx-2">
                        <i class="fas fa-bell text-xl"></i>
                        @if($announcements->count() > 0)
                        <span class="absolute top-2.5 right-2 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white shadow-sm"></span>
                        @endif
                    </button>

                    <div x-show="openNotif" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                         class="absolute right-0 mt-3 w-80 neo-flat py-3 z-50 overflow-hidden"
                         x-cloak>
                        
                        <div class="px-5 py-2 border-b border-[#F4F7FE] mb-2 flex justify-between items-center">
                            <p class="text-[12px] font-bold text-[#A3AED0] uppercase tracking-widest">Notifikasi</p>
                            @if($announcements->count() > 0)
                                <span class="bg-red-100 text-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $announcements->count() }} Baru</span>
                            @endif
                        </div>

                        <div class="max-h-[300px] overflow-y-auto">
                            @forelse($announcements as $notif)
                            <div class="px-5 py-3 border-b border-[#F4F7FE] hover:bg-[#F4F7FE]/50 transition-colors cursor-pointer group">
                                <p class="text-sm font-bold text-[#2B3674] group-hover:text-[#4318FF] transition-colors line-clamp-1">{{ $notif->title }}</p>
                                <p class="text-xs text-[#A3AED0] mt-1 line-clamp-2">{!! \Illuminate\Support\Str::limit(strip_tags($notif->content), 80) !!}</p>
                                <p class="text-[10px] font-medium text-[#A3AED0] mt-2 flex items-center gap-1">
                                    <i class="far fa-clock"></i> {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @empty
                            <div class="px-5 py-8 text-center flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-[#F4F7FE] rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-bell-slash text-[#A3AED0] text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-[#A3AED0]">Belum ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-3 neo-btn p-1.5 px-3 rounded-2xl transition-all outline-none group">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-sm text-[var(--brand-secondary)] transition-colors leading-tight">
                                {{ $myStudent->name ?? $myStudent->first_name ?? auth()->user()->name ?? 'Siswa' }}
                            </p>
                            <p class="text-[var(--text-muted)] text-[11px] font-medium uppercase tracking-tighter">
                                {{ $myStudent?->schoolClass?->name ?? $myStudent?->schoolClass?->class_name ?? 'Siswa' }}
                            </p>
                        </div>
                        <div class="relative">
                            @php $avatarName = urlencode($myStudent->name ?? auth()->user()->name ?? 'Siswa'); @endphp
                            <img src="{{ $myStudent->avatar ?? 'https://ui-avatars.com/api/?name='.$avatarName.'&background=4318FF&color=fff&rounded=true' }}" alt="Profile" class="w-11 h-11 rounded-full object-cover">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[var(--bg-main)] rounded-full"></div>
                        </div>
                        <i class="fas fa-chevron-down text-[var(--text-muted)] text-xl transition-transform duration-300" :class="open ? 'rotate-180 text-[#4318FF]' : ''"></i>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                         class="absolute right-0 mt-3 w-56 neo-flat py-2.5 z-50"
                         x-cloak>
                        
                        <div class="px-4 py-2 border-bottom border-[#F4F7FE] mb-1">
                            <p class="text-[10px] font-bold text-[#A3AED0] uppercase tracking-widest">Akun Siswa</p>
                        </div>

                        <a href="{{ route('student.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#2B3674] hover:bg-[#F4F7FE] hover:text-[#4318FF] transition-all font-semibold mx-2 rounded-xl">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <i class="fas fa-user text-lg text-[#4318FF]"></i>
                            </div>
                            Lihat Profil
                        </a>

                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#2B3674] hover:bg-[#F4F7FE] transition-all font-medium mx-2 rounded-xl">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i class="fas fa-cog text-lg text-[#A3AED0]"></i>
                            </div>
                            Pengaturan
                        </a>

                        <div class="border-t border-[#F4F7FE] my-2 mx-4"></div>
                        
                        <form action="{{ route('logout') }}" method="POST" onsubmit="sessionStorage.clear()">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-all font-bold w-[calc(100%-1rem)] mx-2 rounded-xl text-left">
                                <div class="w-8 h-8 rounded-lg bg-red-100/50 flex items-center justify-center">
                                    <i class="fas fa-sign-out-alt text-lg"></i>
                                </div>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>


</body>
</html>