<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Schoolify</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg: #e6edf3;
            --shadow-dark: 184, 198, 214;
            --shadow-light: 255, 255, 255;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --accent: #5A189A;
            --accent-light: #7B2CBF;
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
            border-radius: 24px;
            box-shadow: 12px 12px 24px rgba(var(--shadow-dark), 0.65),
                        -12px -12px 24px rgba(var(--shadow-light), 1);
            transition: all 0.3s ease;
        }

        .neo-pressed {
            background: var(--bg);
            border-radius: 16px;
            box-shadow: inset 6px 6px 12px rgba(var(--shadow-dark), 0.6),
                        inset -6px -6px 12px rgba(var(--shadow-light), 0.9);
            transition: all 0.3s ease;
        }

        .neo-btn {
            background: var(--bg);
            border-radius: 16px;
            box-shadow: 6px 6px 12px rgba(var(--shadow-dark), 0.6),
                        -6px -6px 12px rgba(var(--shadow-light), 1);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-primary);
        }
        
        .neo-btn:hover {
            box-shadow: 3px 3px 6px rgba(var(--shadow-dark), 0.4),
                        -3px -3px 6px rgba(var(--shadow-light), 0.7),
                        0 0 20px rgba(90, 24, 154, 0.4);
            background: var(--accent);
            color: white !important;
            transform: translateY(-2px);
        }

        .neo-btn:active {
            box-shadow: inset 4px 4px 8px rgba(var(--shadow-dark), 0.6),
                        inset -4px -4px 8px rgba(var(--shadow-light), 0.8);
            transform: translateY(0);
        }

        .neo-input {
            background: var(--bg);
            box-shadow: inset 4px 4px 8px rgba(var(--shadow-dark), 0.5),
                        inset -4px -4px 8px rgba(var(--shadow-light), 0.6);
            border: none;
            outline: none;
            padding: 14px 18px;
            border-radius: 16px;
            color: var(--text-primary);
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .neo-input:focus {
            box-shadow: inset 2px 2px 4px rgba(var(--shadow-dark), 0.5),
                        inset -2px -2px 4px rgba(var(--shadow-light), 0.6),
                        0 0 0 2px rgba(90, 24, 154, 0.3);
        }
        
        .neo-input::placeholder { color: var(--text-muted); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        
        /* Blue Accent Button */
        .btn-blue {
            background: #2563eb; /* Blue 600 */
            color: white !important;
            border-radius: 16px;
            box-shadow: 6px 6px 12px rgba(37, 99, 235, 0.3),
                        -4px -4px 10px rgba(var(--shadow-light), 0.8),
                        inset 2px 2px 4px rgba(255, 255, 255, 0.2);
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-blue:hover {
            background: #1d4ed8; /* Blue 700 */
            transform: translateY(-2px);
            box-shadow: 4px 4px 8px rgba(37, 99, 235, 0.4),
                        -2px -2px 5px rgba(var(--shadow-light), 0.7),
                        0 0 15px rgba(37, 99, 235, 0.4);
        }
        .btn-blue:active {
            box-shadow: inset 4px 4px 8px rgba(30, 58, 138, 0.6),
                        inset -4px -4px 8px rgba(96, 165, 250, 0.4);
            transform: translateY(0);
        }
    </style>
    
    <script>
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
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Theme Toggle (Top Right) -->
    <button onclick="toggleTheme()" class="absolute top-6 right-6 neo-btn p-3 rounded-xl text-[var(--text-secondary)] outline-none hover:text-[var(--accent)] transition-colors z-20" title="Ubah Tema">
        <i data-lucide="moon" class="w-5 h-5 hidden dark:block"></i>
        <i data-lucide="sun" class="w-5 h-5 block dark:hidden"></i>
    </button>

    <div class="w-full max-w-[420px] neo-flat p-8 sm:p-10 relative z-10 animate-fadeInUp">
        
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl mb-5 text-white shadow-lg shadow-blue-500/30 bg-blue-600">
                <i data-lucide="book-open" class="w-10 h-10"></i>
            </div>
            <h1 class="font-outfit font-extrabold text-3xl text-[var(--text-primary)] tracking-tight">Scholify</h1>
            <p class="text-[var(--text-secondary)] text-sm mt-2 font-medium">Sistem Manajemen Sekolah Modern</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-600 rounded-xl text-sm font-semibold flex items-start gap-3 shadow-inner">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i> 
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6 relative z-20">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider ml-1">Email</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)] group-focus-within:text-blue-500 transition-colors">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </span>
                    <input type="email" name="email" required 
                        class="neo-input pl-12"
                        placeholder="Masukkan alamat email">
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider">Password</label>
                    <a href="#" class="text-xs font-bold text-blue-500 hover:text-[var(--accent)] hover:underline transition-all">Lupa Sandi?</a>
                </div>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[var(--text-muted)] group-focus-within:text-blue-500 transition-colors">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>
                    <input type="password" name="password" id="passwordInput" required 
                        class="neo-input pl-12 pr-12"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-[var(--text-muted)] hover:text-blue-500 transition duration-200 outline-none">
                        <i data-lucide="eye" id="toggleIcon" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                    class="w-full btn-blue py-4 text-sm font-bold flex items-center justify-center gap-2">
                    <span class="tracking-wide">Masuk ke Dashboard</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs font-semibold text-[var(--text-muted)]">
                &copy; {{ date('Y') }} Scholify. Hak Cipta Dilindungi.
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('toggleIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>