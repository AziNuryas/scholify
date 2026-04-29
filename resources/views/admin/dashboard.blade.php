<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Schoolify Modern</title>
    <!-- Font: Inter + Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-lavender: #8B5CF6;
            --primary-peach: #F97316;
            --primary-mint: #10B981;
            --primary-sky: #3B82F6;
            --primary-rose: #F43F5E;
            --primary-amber: #F59E0B;
            --primary-indigo: #6366F1;
            --bg-base: #F8FAFC;
            --bg-surface: #FFFFFF;
            --bg-glass: rgba(255, 255, 255, 0.75);
            --bg-glass-hover: rgba(255, 255, 255, 0.9);
            --text-primary: #0F172A;
            --text-secondary: #475569;
            --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5);
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0,0,0,0.06), -5px -5px 15px rgba(255,255,255,0.8);
            --shadow-clay: 6px 6px 12px rgba(0,0,0,0.04), -4px -4px 8px rgba(255,255,255,0.9);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            --sidebar-width: 280px;
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
            --gradient-amber: linear-gradient(145deg, #FBBF24 0%, #F59E0B 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(251,146,60,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        /* Sidebar */
        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; }
        .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s; font-weight: 600; font-size: 15px; background: transparent; }
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
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-lavender); }
        .submenu-item.active { background: rgba(139,92,246,0.12); color: var(--primary-lavender); font-weight: 600; }
        .badge-new { margin-left: auto; background: var(--gradient-peach); color: white; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 700; box-shadow: var(--shadow-sm); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px); }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        /* Main Content */
        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px 32px 8px; position: relative; z-index: 1; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); padding: 18px 32px; border-radius: 28px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-lg), var(--shadow-diagonal); }
        .page-title h1 { font-size: 28px; font-weight: 800; font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; color: var(--text-primary); }
        .page-title p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; font-weight: 500; }
        .user-actions { display: flex; align-items: center; gap: 24px; }
        .date-badge { font-size: 14px; font-weight: 600; color: var(--text-secondary); background: white; padding: 10px 18px; border-radius: 40px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-inner); }
        .user-avatar { width: 48px; height: 48px; background: var(--gradient-lavender); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }

        /* Alert */
        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }

        /* Calendar Section */
        .calendar-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 36px; }
        .calendar-card { background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%); border-radius: 28px; padding: 24px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-clay), var(--shadow-diagonal); position: relative; overflow: hidden; }
        .calendar-card::before { content: ''; position: absolute; top: -30%; right: -20%; width: 180px; height: 180px; background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-month-year { display: flex; align-items: baseline; gap: 8px; }
        .calendar-month { font-size: 24px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .calendar-year { font-size: 16px; font-weight: 500; color: var(--primary-lavender); background: rgba(139,92,246,0.1); padding: 4px 12px; border-radius: 30px; }
        .calendar-nav { display: flex; gap: 8px; }
        .calendar-nav-btn { width: 40px; height: 40px; border-radius: 14px; background: white; border: 1px solid var(--border-glass); color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: var(--shadow-sm); }
        .calendar-nav-btn:hover { background: var(--gradient-lavender); color: white; border-color: transparent; box-shadow: var(--shadow-md); }
        .calendar-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin-bottom: 12px; }
        .calendar-weekday { text-align: center; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); padding: 8px 0; }
        .calendar-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .calendar-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 500; color: var(--text-primary); background: transparent; border-radius: 14px; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; }
        .calendar-day:hover { background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.3); }
        .calendar-day.today { background: var(--gradient-lavender); color: white; font-weight: 700; box-shadow: var(--shadow-md); }
        .calendar-day.other-month { color: var(--text-muted); opacity: 0.5; }
        .calendar-day.has-event { position: relative; font-weight: 600; }
        .calendar-day.has-event::after { content: ''; position: absolute; bottom: 6px; width: 6px; height: 6px; background: var(--primary-rose); border-radius: 50%; }
        .calendar-day.today.has-event::after { background: white; }

        /* Events Card */
        .events-card { background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%); border-radius: 28px; padding: 24px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-clay), var(--shadow-diagonal); position: relative; overflow: hidden; }
        .events-card::before { content: ''; position: absolute; bottom: -20%; left: -10%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(249,115,22,0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
        .events-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .events-header i { font-size: 24px; color: var(--primary-peach); background: white; padding: 10px; border-radius: 16px; box-shadow: var(--shadow-sm); }
        .events-header h3 { font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .event-list { display: flex; flex-direction: column; gap: 12px; }
        .event-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: white; border-radius: 18px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-sm); transition: all 0.2s; }
        .event-item:hover { transform: translateX(4px); box-shadow: var(--shadow-md); border-color: var(--primary-peach); }
        .event-date { display: flex; flex-direction: column; align-items: center; min-width: 50px; }
        .event-day { font-size: 22px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--primary-peach); line-height: 1; }
        .event-month { font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 600; }
        .event-info { flex: 1; }
        .event-title { font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .event-time { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }
        .event-badge { padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 600; }
        .badge-ujian, .badge-uts, .badge-uas { background: rgba(239,68,68,0.12); color: #EF4444; }
        .badge-rapat { background: rgba(139,92,246,0.12); color: #8B5CF6; }
        .badge-libur { background: rgba(16,185,129,0.12); color: #10B981; }
        .badge-kegiatan { background: rgba(59,130,246,0.12); color: #3B82F6; }
        .badge-lainnya { background: rgba(100,116,139,0.12); color: #64748B; }

        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 36px; }
        .stat-card { background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%); border-radius: 28px; padding: 24px; border: 1px solid var(--border-glass); transition: all 0.4s; position: relative; overflow: hidden; box-shadow: var(--shadow-clay), var(--shadow-diagonal); text-decoration: none; display: block; cursor: pointer; }
        .stat-card::before { content: ''; position: absolute; top: -50%; right: -30%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%); border-radius: 50%; opacity: 0.4; pointer-events: none; }
        .stat-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: var(--shadow-xl); border-color: rgba(255,255,255,0.8); }
        .stat-icon { width: 56px; height: 56px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; box-shadow: var(--shadow-clay); }
        .stat-card:nth-child(1) .stat-icon { background: var(--gradient-sky); color: white; }
        .stat-card:nth-child(2) .stat-icon { background: var(--gradient-peach); color: white; }
        .stat-card:nth-child(3) .stat-icon { background: var(--gradient-mint); color: white; }
        .stat-card:nth-child(4) .stat-icon { background: var(--gradient-rose); color: white; }
        .stat-icon i { font-size: 26px; }
        .stat-info h3 { font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; margin-bottom: 8px; }
        .stat-number { font-size: 36px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); margin-bottom: 6px; letter-spacing: -0.02em; }
        .stat-trend { font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .stat-card:nth-child(1) .stat-trend { color: var(--primary-sky); }
        .stat-card:nth-child(2) .stat-trend { color: var(--primary-peach); }
        .stat-card:nth-child(3) .stat-trend { color: var(--primary-mint); }
        .stat-card:nth-child(4) .stat-trend { color: var(--primary-rose); }

        /* Content Card */
        .content-card { background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border-radius: 32px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); position: relative; margin-bottom: 30px; }
        .content-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 120px; background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, transparent 100%); pointer-events: none; border-radius: 32px 32px 0 0; }
        .card-header { padding: 24px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1; }
        .card-header h2 { font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 10px; }
        .card-header h2 i { color: var(--primary-lavender); }
        .btn-view-all { background: var(--gradient-lavender); color: white; padding: 10px 20px; border-radius: 40px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.25); }
        .btn-view-all:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg), 0 8px 20px rgba(139,92,246,0.35); }
        .table-wrapper { overflow-x: auto; position: relative; z-index: 1; padding: 0 8px 8px; }
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .data-table th { text-align: left; padding: 14px 24px; font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em; }
        .data-table td { padding: 18px 24px; font-size: 14px; color: var(--text-primary); background: white; border: 1px solid var(--border-glass); border-style: solid none; }
        .data-table td:first-child { border-left-style: solid; border-top-left-radius: 20px; border-bottom-left-radius: 20px; }
        .data-table td:last-child { border-right-style: solid; border-top-right-radius: 20px; border-bottom-right-radius: 20px; }
        .data-table tbody tr:hover td { background: var(--bg-glass-hover); box-shadow: var(--shadow-sm); border-color: rgba(255,255,255,0.8); }
        .user-info-cell { display: flex; align-items: center; gap: 14px; }
        .user-avatar-sm { width: 44px; height: 44px; border-radius: 16px; border: 2px solid white; box-shadow: var(--shadow-sm); object-fit: cover; }
        .user-name { font-weight: 700; color: var(--text-primary); }
        .badge { padding: 6px 14px; border-radius: 40px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-active { background: rgba(16,185,129,0.12); color: var(--primary-mint); border: 1px solid rgba(16,185,129,0.2); }
        .empty-state { text-align: center; padding: 60px; color: var(--text-muted); }
        .empty-state i { font-size: 48px; margin-bottom: 20px; opacity: 0.4; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 1200px) { .calendar-wrapper { grid-template-columns: 1fr; } .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; padding: 20px; } .stats-grid { grid-template-columns: 1fr; } .top-bar { flex-direction: column; gap: 16px; align-items: flex-start; } .card-header { flex-direction: column; gap: 16px; align-items: flex-start; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header"><div class="logo-icon"><i class="fas fa-cloud"></i></div><h2>Schoolify</h2></div>
        <div class="sidebar-menu">
            <p class="menu-label">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="menu-item active"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="{{ route('admin.students') }}" class="menu-item"><i class="fas fa-user-graduate"></i><span>Data Siswa</span></a>
            <a href="{{ route('admin.teachers') }}" class="menu-item"><i class="fas fa-chalkboard-user"></i><span>Data Guru</span></a>
            <a href="{{ route('admin.agendas.index') }}" class="menu-item"><i class="fas fa-calendar-alt"></i><span>Agenda</span></a>
            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)"><i class="fas fa-door-open"></i><span>Manajemen Kelas</span><i class="fas fa-chevron-right chevron"></i></div>
            <div class="submenu" id="classesSubmenu">
                <a href="{{ route('admin.classes') }}" class="submenu-item"><i class="fas fa-list"></i><span>Daftar Kelas</span></a>
                <a href="{{ route('admin.classes.create') }}" class="submenu-item"><i class="fas fa-plus-circle"></i><span>Tambah Kelas</span><span class="badge-new">New</span></a>
            </div>
            <p class="menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="menu-item"><i class="fas fa-chart-bar"></i><span>Laporan</span></a>
            <a href="{{ route('admin.settings') }}" class="menu-item"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
            <a href="{{ route('admin.profile') }}" class="menu-item"><i class="fas fa-user-circle"></i><span>Profil</span></a>
        </div>
        <div class="logout-container"><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button></form></div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title"><h1> Dashboard Admin</h1><p>Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}!</p></div>
            <div class="user-actions">
                <span class="date-badge"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ date('l, d F Y') }}</span>
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="calendar-wrapper">
            <div class="calendar-card">
                <div class="calendar-header">
                    <div class="calendar-month-year"><span class="calendar-month" id="currentMonth">April</span><span class="calendar-year" id="currentYear">2026</span></div>
                    <div class="calendar-nav">
                        <button class="calendar-nav-btn" onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                        <button class="calendar-nav-btn" onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="calendar-weekdays"><span class="calendar-weekday">Min</span><span class="calendar-weekday">Sen</span><span class="calendar-weekday">Sel</span><span class="calendar-weekday">Rab</span><span class="calendar-weekday">Kam</span><span class="calendar-weekday">Jum</span><span class="calendar-weekday">Sab</span></div>
                <div class="calendar-days" id="calendarDays"></div>
                <div style="margin-top: 16px; text-align: right;"><a href="{{ route('admin.agendas.create') }}" style="color: var(--primary-lavender); font-size: 13px; font-weight: 600; text-decoration: none;"><i class="fas fa-plus-circle"></i> Tambah Agenda</a></div>
            </div>
            <div class="events-card">
                <div class="events-header">
                    <i class="fas fa-calendar-check"></i><h3>Agenda Mendatang</h3>
                    <a href="{{ route('admin.agendas.index') }}" style="margin-left: auto; color: var(--primary-lavender); font-size: 13px; font-weight: 600; text-decoration: none;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="event-list" id="upcomingEvents"></div>
            </div>
        </div>

        <div class="stats-grid">
            <a href="{{ route('admin.students') }}" class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-info"><h3>Total Siswa</h3><div class="stat-number">{{ $data['totalStudents'] ?? 0 }}</div><div class="stat-trend"><i class="fas fa-arrow-up"></i> +12%</div></div>
            </a>
            <a href="{{ route('admin.teachers') }}" class="stat-card">
                <div class="stat-icon"><i class="fas fa-chalkboard-user"></i></div>
                <div class="stat-info"><h3>Total Guru</h3><div class="stat-number">{{ $data['totalTeachers'] ?? 0 }}</div><div class="stat-trend"><i class="fas fa-arrow-up"></i> +5%</div></div>
            </a>
            <a href="{{ route('admin.classes') }}" class="stat-card">
                <div class="stat-icon"><i class="fas fa-door-open"></i></div>
                <div class="stat-info"><h3>Total Kelas</h3><div class="stat-number">{{ $data['totalClasses'] ?? 0 }}</div><div class="stat-trend"><i class="fas fa-arrow-up"></i> +3%</div></div>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-info"><h3>Total Agenda</h3><div class="stat-number">{{ \App\Models\Agenda::count() ?? 0 }}</div><div class="stat-trend"><i class="fas fa-calendar-check"></i> Aktif</div></div>
            </a>
        </div>

        <div class="content-card">
            <div class="card-header"><h2><i class="fas fa-user-graduate"></i> ✨ Siswa Terbaru</h2><a href="{{ route('admin.students') }}" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a></div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead><tr><th>NISN</th><th>Nama Siswa</th><th>Email</th><th>Kelas</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($data['recentStudents'] ?? [] as $student)
                        <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.students') }}'">
                            <td style="font-weight: 600; color: var(--primary-sky);">{{ $student->nisn ?? '-' }}</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=3B82F6&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">{{ $student->name }}</span></div></td>
                            <td>{{ $student->user->email ?? $student->email ?? '-' }}</td>
                            <td>{{ $student->schoolClass->name ?? $student->class ?? '-' }}</td>
                            <td><span class="badge badge-active">🌟 Aktif</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="empty-state"><i class="fas fa-cloud"></i><p>Belum ada data siswa.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header"><h2><i class="fas fa-chalkboard-user"></i> 🌟 Guru Terbaru</h2><a href="{{ route('admin.teachers') }}" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a></div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead><tr><th>NIP</th><th>Nama Guru</th><th>Email</th><th>Mata Pelajaran</th><th>No. HP</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($data['recentTeachers'] ?? [] as $teacher)
                        <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.teachers') }}'">
                            <td style="font-weight: 600; color: var(--primary-peach);">{{ $teacher->nip ?? '-' }}</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=F97316&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">{{ $teacher->name }}</span></div></td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->subject ?? '-' }}</td>
                            <td>{{ $teacher->phone ?? '-' }}</td>
                            <td><span class="badge badge-active">✨ Aktif</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="empty-state"><i class="fas fa-cloud"></i><p>Belum ada data guru.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleSubmenu(e){const s=e.nextElementSibling;e.classList.toggle('expanded');s.classList.toggle('show');}
        
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let agendaEvents = [];
        const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const typeIcons = {'ujian':'📝','uts':'📝','uas':'📚','rapat':'👥','libur':'🎉','kegiatan':'📌','lainnya':'📋'};
        const typeLabels = {'ujian':'Ujian','uts':'UTS','uas':'UAS','rapat':'Rapat','libur':'Libur','kegiatan':'Kegiatan','lainnya':'Lainnya'};

        async function fetchAgendas(){
            try{
                const r = await fetch('/api/agendas');
                agendaEvents = await r.json();
                renderCalendar();
                renderUpcomingEvents();
            }catch(e){
                console.error('Error:', e);
                renderCalendar();
                renderUpcomingEvents();
            }
        }

        function getEventsForDate(d){
            return agendaEvents.filter(e => {
                const s = e.start;
                const end = e.end || e.start;
                return d >= s && d <= end;
            });
        }

        function renderCalendar(){
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const startDay = firstDay.getDay();
            const monthLen = lastDay.getDate();
            
            document.getElementById('currentMonth').textContent = monthNames[currentMonth];
            document.getElementById('currentYear').textContent = currentYear;
            
            let days = '';
            const today = new Date();
            const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
            
            const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
            const prevDays = startDay === 0 ? 6 : startDay - 1;
            for (let i = prevDays; i >= 0; i--) {
                days += `<div class="calendar-day other-month">${prevMonthLastDay - i}</div>`;
            }
            
            for (let i = 1; i <= monthLen; i++) {
                const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const isToday = dateStr === todayStr;
                const eventsOnDate = getEventsForDate(dateStr);
                const hasEvent = eventsOnDate.length > 0;
                
                let classes = 'calendar-day';
                if (isToday) classes += ' today';
                if (hasEvent) classes += ' has-event';
                
                let tooltip = '';
                if (hasEvent) {
                    tooltip = `title="${eventsOnDate.map(e => e.title).join('\n')}"`;
                }
                
                days += `<div class="${classes}" onclick="selectDate('${dateStr}')" ${tooltip}>${i}</div>`;
            }
            
            const totalCells = Math.ceil((prevDays + monthLen) / 7) * 7;
            const nextDays = totalCells - (prevDays + monthLen);
            for (let i = 1; i <= nextDays; i++) {
                days += `<div class="calendar-day other-month">${i}</div>`;
            }
            
            document.getElementById('calendarDays').innerHTML = days;
        }

        function renderUpcomingEvents(){
            const today = new Date().toISOString().split('T')[0];
            const up = agendaEvents.filter(e => e.start >= today).sort((a,b) => a.start.localeCompare(b.start)).slice(0, 3);
            const c = document.getElementById('upcomingEvents');
            
            if(up.length === 0){
                c.innerHTML = `<div style="text-align:center;padding:30px;color:var(--text-muted);"><i class="fas fa-calendar" style="font-size:32px;margin-bottom:10px;opacity:0.5;"></i><p>Tidak ada agenda mendatang</p></div>`;
                return;
            }
            
            c.innerHTML = up.map(e => {
                const d = new Date(e.start);
                return `<div class="event-item" style="cursor:pointer;" onclick="window.location='{{ route('admin.agendas.index') }}'">
                    <div class="event-date"><span class="event-day">${d.getDate()}</span><span class="event-month">${monthNames[d.getMonth()].substring(0,3)}</span></div>
                    <div class="event-info"><div class="event-title">${typeIcons[e.type]||'📌'} ${e.title}</div><div class="event-time"><i class="far fa-clock"></i> ${e.time||'Seharian'}</div></div>
                    <span class="event-badge ${getBadge(e.type)}">${typeLabels[e.type] || e.type}</span>
                </div>`;
            }).join('');
        }

        function getBadge(t){
            const b = {'ujian':'badge-ujian','uts':'badge-ujian','uas':'badge-ujian','rapat':'badge-rapat','libur':'badge-libur','kegiatan':'badge-kegiatan'};
            return b[t] || 'badge-lainnya';
        }
        
        function changeMonth(d){
            currentMonth += d;
            if(currentMonth < 0){ currentMonth = 11; currentYear--; }
            else if(currentMonth > 11){ currentMonth = 0; currentYear++; }
            renderCalendar();
        }
        
        function selectDate(d){
            const e = getEventsForDate(d);
            if(e.length > 0){
                alert(`📅 Agenda ${d}:\n\n${e.map(ev => `• ${typeIcons[ev.type]||'📌'} ${ev.title} ${ev.time?'('+ev.time+')':''}`).join('\n')}`);
            } else {
                window.location.href = `{{ route('admin.agendas.create') }}?date=${d}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function(){
            renderCalendar();
            renderUpcomingEvents();
            fetchAgendas();
            
            const a = document.querySelector('.submenu-item.active');
            if(a){
                const s = a.closest('.submenu');
                const p = s.previousElementSibling;
                p && p.classList.contains('has-submenu') && (p.classList.add('expanded'), s.classList.add('show'));
            }
        });
    </script>
</body>
</html>