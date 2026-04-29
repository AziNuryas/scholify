<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan - Schoolify Modern</title>
    <!-- Font: Inter + Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-lavender: #8B5CF6; --primary-peach: #F97316; --primary-mint: #10B981; --primary-sky: #3B82F6;
            --primary-rose: #F43F5E; --primary-amber: #F59E0B; --primary-indigo: #6366F1;
            --bg-base: #F8FAFC; --bg-surface: #FFFFFF; --bg-glass: rgba(255, 255, 255, 0.75); --bg-glass-hover: rgba(255, 255, 255, 0.9);
            --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5);
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05); --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1); --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0,0,0,0.06), -5px -5px 15px rgba(255,255,255,0.8);
            --shadow-clay: 6px 6px 12px rgba(0,0,0,0.04), -4px -4px 8px rgba(255,255,255,0.9);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            --sidebar-width: 280px;
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-peach: linear-gradient(145deg, #834ec9 0%, #6b21a8 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
            --gradient-amber: linear-gradient(145deg, #FBBF24 0%, #F59E0B 100%);
            --gradient-indigo: linear-gradient(145deg, #818CF8 0%, #6366F1 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(99,102,241,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        /* Sidebar */
        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; }
        .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s; font-weight: 600; font-size: 15px; }
        .menu-item i { font-size: 20px; width: 24px; color: var(--text-muted); }
        .menu-item:hover { background: var(--bg-glass-hover); color: var(--primary-lavender); box-shadow: var(--shadow-sm); }
        .menu-item:hover i { color: var(--primary-lavender); }
        .menu-item.active { background: var(--gradient-lavender); color: white; box-shadow: var(--shadow-md), 0 6px 15px rgba(139,92,246,0.3); }
        .menu-item.active i { color: white; }
        .menu-item.has-submenu { cursor: pointer; }
        .menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }
        .submenu { margin-left: 20px; padding-left: 16px; border-left: 2px solid var(--border-glass); display: none; flex-direction: column; gap: 4px; margin-top: 4px; margin-bottom: 4px; }
        .submenu.show { display: flex; }
        .submenu-item { padding: 10px 16px 10px 20px; border-radius: 14px; display: flex; align-items: center; gap: 12px; color: var(--text-secondary); text-decoration: none; transition: all 0.2s; font-weight: 500; font-size: 14px; }
        .submenu-item i { font-size: 16px; width: 20px; }
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-mint); }
        .submenu-item.active { background: rgba(16,185,129,0.12); color: var(--primary-mint); font-weight: 600; }
        .badge-new { margin-left: auto; background: var(--gradient-peach); color: white; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 700; box-shadow: var(--shadow-sm); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px); }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        /* Main Content */
        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px 32px 8px; position: relative; z-index: 1; }
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 12px; letter-spacing: -0.02em; }
        .page-header h1 i { color: var(--primary-lavender); background: white; padding: 12px; border-radius: 20px; box-shadow: var(--shadow-clay); }
        .page-header p { color: var(--text-secondary); font-size: 15px; margin-top: 8px; margin-left: 60px; font-weight: 500; }

        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }
        .alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; }

        .content-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); margin-bottom: 24px; }
        .tabs-container { display: flex; gap: 4px; border-bottom: 1px solid var(--border-glass); background: transparent; padding: 8px 20px 0; }
        .tab-btn { padding: 14px 24px; font-weight: 600; font-size: 14px; color: var(--text-muted); background: transparent; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s; border-radius: 14px 14px 0 0; }
        .tab-btn i { font-size: 18px; }
        .tab-btn:hover { color: var(--primary-lavender); background: rgba(139,92,246,0.05); }
        .tab-btn.active { color: var(--primary-lavender); background: white; box-shadow: var(--shadow-sm); }
        .card-body { padding: 28px; }

        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 10px; }
        .form-label i { color: var(--primary-lavender); margin-right: 6px; }
        .form-control { width: 100%; padding: 14px 18px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; font-size: 14px; color: var(--text-primary); outline: none; box-shadow: var(--shadow-inner); }
        .form-control:focus { border-color: var(--primary-lavender); box-shadow: var(--shadow-sm), 0 0 0 3px rgba(139,92,246,0.1); }
        textarea.form-control { resize: vertical; min-height: 80px; }
        select.form-control { cursor: pointer; background: white; }

        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .logo-upload { display: flex; align-items: center; gap: 20px; }
        .logo-preview { width: 80px; height: 80px; border-radius: 16px; border: 2px solid white; box-shadow: var(--shadow-md); object-fit: cover; }
        .btn-outline { padding: 10px 20px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; color: var(--text-secondary); font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-sm); }
        .btn-outline:hover { border-color: var(--primary-lavender); color: var(--primary-lavender); }

        .action-buttons { display: flex; justify-content: flex-end; gap: 12px; padding-top: 24px; margin-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-secondary { padding: 14px 28px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; color: var(--text-secondary); font-weight: 600; font-size: 14px; cursor: pointer; box-shadow: var(--shadow-sm); }
        .btn-secondary:hover { border-color: var(--primary-lavender); color: var(--primary-lavender); }
        .btn-primary { padding: 14px 32px; background: var(--gradient-lavender); border: none; border-radius: 14px; color: white; font-weight: 600; font-size: 14px; cursor: pointer; box-shadow: var(--shadow-md), 0 4px 15px rgba(139,92,246,0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg), 0 8px 25px rgba(139,92,246,0.4); }

        .info-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 20px; }
        .info-card { background: white; border: 1px solid var(--border-glass); border-radius: 16px; padding: 18px; box-shadow: var(--shadow-sm); }
        .info-card .label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .info-card .value { font-size: 20px; font-weight: 700; color: var(--text-primary); }

        .toggle-container { display: flex; align-items: center; justify-content: space-between; }
        .toggle-label { color: var(--text-secondary); font-weight: 500; }
        .toggle-switch { position: relative; display: inline-block; width: 52px; height: 28px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--border-glass); border-radius: 34px; transition: .3s; }
        .toggle-slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 4px; bottom: 4px; background: white; border-radius: 50%; transition: .3s; box-shadow: var(--shadow-sm); }
        input:checked + .toggle-slider { background: var(--gradient-lavender); }
        input:checked + .toggle-slider:before { transform: translateX(24px); }

        .text-muted { color: var(--text-muted); font-size: 13px; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 1200px) { .grid-2 { grid-template-columns: 1fr; } .info-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; padding: 20px; } .info-grid { grid-template-columns: 1fr; } .tabs-container { flex-wrap: wrap; } .tab-btn { flex: 1; justify-content: center; } .action-buttons { flex-direction: column; } .btn-secondary, .btn-primary { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon"><i class="fas fa-cloud"></i></div>
        <h2>Schoolify</h2>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">Menu Utama</p>
        <a href="{{ route('admin.dashboard') }}" class="menu-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.students') }}" class="menu-item"><i class="fas fa-user-graduate"></i><span>Data Siswa</span></a>
        <a href="{{ route('admin.teachers') }}" class="menu-item"><i class="fas fa-chalkboard-user"></i><span>Data Guru</span></a>
        <a href="{{ route('admin.agendas.index') }}" class="menu-item"><i class="fas fa-calendar-alt"></i><span>Agenda</span></a>
        
        <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
            <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
            <i class="fas fa-chevron-right chevron"></i>
        </div>
        <div class="submenu" id="classesSubmenu">
            <a href="{{ route('admin.classes') }}" class="submenu-item"><i class="fas fa-list"></i><span>Daftar Kelas</span></a>
            <a href="{{ route('admin.classes.create') }}" class="submenu-item"><i class="fas fa-plus-circle"></i><span>Tambah Kelas</span><span class="badge-new">New</span></a>
        </div>
        
        <p class="menu-label">Lainnya</p>
        <a href="{{ route('admin.reports') }}" class="menu-item"><i class="fas fa-chart-bar"></i><span>Laporan</span></a>
        <a href="{{ route('admin.settings') }}" class="menu-item active"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
        <a href="{{ route('admin.profile') }}" class="menu-item"><i class="fas fa-user-circle"></i><span>Profil</span></a>
    </div>
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>
</div>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-cog"></i>Pengaturan Sistem</h1>
            <p>Kelola pengaturan aplikasi Schoolify</p>
        </div>

        @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>@endif

        <div class="content-card">
            <div class="tabs-container">
                <button class="tab-btn active"><i class="bx bx-cog"></i> Umum</button>
                <button class="tab-btn"><i class="bx bx-envelope"></i> Email</button>
                <button class="tab-btn"><i class="bx bx-lock"></i> Keamanan</button>
                <button class="tab-btn"><i class="bx bx-bell"></i> Notifikasi</button>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group"><label class="form-label"><i class="fas fa-school"></i> Nama Sekolah</label><input type="text" name="school_name" class="form-control" value="{{ $settings['school_name'] ?? 'SMA Negeri 1 Bandung' }}"></div>
                    <div class="form-group"><label class="form-label"><i class="fas fa-map-pin"></i> Alamat Sekolah</label><textarea name="school_address" class="form-control" rows="3">{{ $settings['school_address'] ?? 'Jl. Pendidikan No. 123, Bandung' }}</textarea></div>
                    <div class="grid-2">
                        <div class="form-group"><label class="form-label"><i class="fas fa-envelope"></i> Email Sekolah</label><input type="email" name="school_email" class="form-control" value="{{ $settings['school_email'] ?? 'sekolah@example.com' }}"></div>
                        <div class="form-group"><label class="form-label"><i class="fas fa-phone"></i> No. Telepon</label><input type="tel" name="school_phone" class="form-control" value="{{ $settings['school_phone'] ?? '+62-274-512345' }}"></div>
                    </div>
                    <div class="form-group"><label class="form-label"><i class="fas fa-image"></i> Logo Sekolah</label><div class="logo-upload"><img src="https://ui-avatars.com/api/?name=Schoolify&size=100&background=8B5CF6&color=fff&bold=true" alt="Logo" class="logo-preview"><button type="button" class="btn-outline"><i class="bx bx-upload"></i> Ubah Logo</button></div></div>
                    <div class="grid-2">
                        <div class="form-group"><label class="form-label"><i class="fas fa-calendar"></i> Tahun Ajaran</label><select name="academic_year" class="form-control"><option value="2024/2025" selected>2024/2025</option><option value="2023/2024">2023/2024</option><option value="2025/2026">2025/2026</option></select></div>
                        <div class="form-group"><label class="form-label"><i class="fas fa-toggle-on"></i> Status Aplikasi</label><select name="app_status" class="form-control"><option value="active" selected>Aktif</option><option value="maintenance">Maintenance</option><option value="closed">Closed</option></select></div>
                    </div>
                    <div class="action-buttons"><button type="reset" class="btn-secondary"><i class="bx bx-x"></i> Batal</button><button type="submit" class="btn-primary"><i class="bx bx-check"></i> Simpan Perubahan</button></div>
                </form>
            </div>
        </div>

        <div class="grid-2">
            <div class="content-card"><div class="card-body">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; display: flex; gap: 8px;"><i class="bx bx-data" style="color: var(--primary-lavender);"></i>💾 Backup Database</h3>
                <p class="text-muted" style="margin-bottom: 20px;">Buat backup otomatis data sistem</p>
                <div style="margin-bottom: 20px;"><p style="color: var(--text-secondary); font-size: 14px;">Terakhir backup: <strong style="color: var(--primary-lavender);">15 April 2024, 02:30</strong></p><p style="color: var(--text-secondary); font-size: 14px;">Ukuran backup: <strong style="color: var(--primary-lavender);">245 MB</strong></p></div>
                <button class="btn-primary" style="width: 100%; justify-content: center;" onclick="backupDatabase()"><i class="bx bx-cloud-download"></i> Backup Sekarang</button>
            </div></div>
            <div class="content-card"><div class="card-body">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; display: flex; gap: 8px;"><i class="bx bx-wrench" style="color: var(--primary-lavender);"></i>🔧 Mode Maintenance</h3>
                <p class="text-muted" style="margin-bottom: 20px;">Tutup aplikasi untuk pemeliharaan</p>
                <div class="toggle-container" style="margin-bottom: 20px;"><span class="toggle-label">Status Maintenance</span><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
                <div class="form-group"><label class="form-label">📝 Pesan Maintenance</label><textarea class="form-control" rows="3">Aplikasi sedang dalam pemeliharaan...</textarea></div>
            </div></div>
        </div>

        <div class="content-card"><div class="card-body">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; gap: 8px;"><i class="bx bx-info-circle" style="color: var(--primary-lavender);"></i>ℹ️ Informasi Sistem</h3>
            <div class="info-grid">
                <div class="info-card"><div class="label">Laravel Version</div><div class="value">{{ app()->version() }}</div></div>
                <div class="info-card"><div class="label">PHP Version</div><div class="value">{{ phpversion() }}</div></div>
                <div class="info-card"><div class="label">Database</div><div class="value">{{ config('database.default') == 'mysql' ? 'MySQL' : config('database.default') }}</div></div>
                <div class="info-card"><div class="label">Aplikasi Version</div><div class="value">1.0.0 🌟</div></div>
            </div>
        </div></div>
    </div>

    <script>
        function toggleSubmenu(e){const s=e.nextElementSibling;e.classList.toggle('expanded');s.classList.toggle('show');}
        function backupDatabase(){alert('🌅 Fitur backup database akan segera tersedia!');}
        document.querySelectorAll('.tab-btn').forEach(btn=>{btn.addEventListener('click',function(){document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));this.classList.add('active');});});
    </script>
</body>
</html>