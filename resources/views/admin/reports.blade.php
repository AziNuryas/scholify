<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan & Statistik - Schoolify</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            /* Color Variables - Sesuai Dashboard */
            --primary-lavender: #8B5CF6;
            --primary-peach: #F97316;
            --primary-mint: #10B981;
            --primary-sky: #3B82F6;
            --primary-rose: #F43F5E;
            --primary-amber: #F59E0B;
            --primary-indigo: #6366F1;
            
            /* Background Palette */
            --bg-base: #F8FAFC;
            --bg-surface: #FFFFFF;
            --bg-glass: rgba(255, 255, 255, 0.75);
            --bg-glass-hover: rgba(255, 255, 255, 0.9);
            --bg-dark: #0F172A;
            
            /* Text Colors */
            --text-primary: #0F172A;
            --text-secondary: #475569;
            --text-muted: #94A3B8;
            --text-light: #CBD5E1;
            
            /* Border & Shadow */
            --border-glass: rgba(203, 213, 225, 0.5);
            --border-light: rgba(203, 213, 225, 0.3);
            
            /* Shadows - Premium */
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0,0,0,0.06), -5px -5px 15px rgba(255,255,255,0.8);
            --shadow-clay: 6px 6px 12px rgba(0,0,0,0.04), -4px -4px 8px rgba(255,255,255,0.9);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            
            /* Gradients - Sesuai Dashboard */
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
            --gradient-amber: linear-gradient(145deg, #FBBF24 0%, #F59E0B 100%);
            --gradient-indigo: linear-gradient(135deg, #818CF8 0%, #6366F1 100%);
            
            /* Layout */
            --sidebar-width: 280px;
        }
        
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        html { 
            scroll-behavior: smooth; 
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated background elements */
        body::before { 
            content: ''; 
            position: fixed; 
            top: -50%; 
            right: -20%; 
            width: 80%; 
            height: 150%; 
            background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%);
            pointer-events: none; 
            z-index: 0;
        }
        
        body::after { 
            content: ''; 
            position: fixed; 
            bottom: -30%; 
            left: -10%; 
            width: 70%; 
            height: 120%; 
            background: radial-gradient(circle, rgba(251,146,60,0.06) 0%, transparent 70%);
            pointer-events: none; 
            z-index: 0;
        }

        /* ==================== SIDEBAR (DASHBOARD STYLE) ==================== */
        .sidebar { 
            position: fixed; 
            left: 24px; 
            top: 24px; 
            bottom: 24px; 
            width: var(--sidebar-width); 
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-glass);
            border-radius: 32px;
            z-index: 1000;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: var(--shadow-xl), var(--shadow-diagonal);
        }
        
        .sidebar-header { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 0 12px 32px;
        }
        
        .logo-icon { 
            width: 44px; 
            height: 44px; 
            background: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3);
            font-size: 20px;
        }
        
        .sidebar-header h2 { 
            font-size: 24px; 
            font-weight: 800; 
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }
        
        .menu-label { 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
            color: var(--text-muted);
            font-weight: 700;
            margin: 24px 12px 10px;
        }
        
        .sidebar-menu { 
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-grow: 1;
        }
        
        .menu-item { 
            padding: 12px 16px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 15px;
            background: transparent;
        }
        
        .menu-item i { 
            font-size: 20px;
            width: 24px;
            color: var(--text-muted);
        }
        
        .menu-item:hover { 
            background: var(--bg-glass-hover);
            color: var(--primary-lavender);
            box-shadow: var(--shadow-sm);
        }
        
        .menu-item:hover i { 
            color: var(--primary-lavender);
        }
        
        .menu-item.active { 
            background: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            color: white;
            box-shadow: var(--shadow-md), 0 6px 15px rgba(139,92,246,0.3);
        }
        
        .menu-item.active i { 
            color: white;
        }
        
        .menu-item.has-submenu { 
            cursor: pointer;
        }
        
        .menu-item.has-submenu .chevron { 
            margin-left: auto;
            font-size: 14px;
            transition: transform 0.3s;
        }
        
        .menu-item.has-submenu.expanded .chevron { 
            transform: rotate(90deg);
        }
        
        .submenu { 
            margin-left: 20px;
            padding-left: 16px;
            border-left: 2px solid var(--border-glass);
            display: none;
            flex-direction: column;
            gap: 4px;
            margin-top: 4px;
            margin-bottom: 4px;
        }
        
        .submenu.show { 
            display: flex;
        }
        
        .submenu-item { 
            padding: 10px 16px 10px 20px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 14px;
        }
        
        .submenu-item i { 
            font-size: 16px;
            width: 20px;
        }
        
        .submenu-item:hover { 
            background: var(--bg-glass);
            color: var(--primary-lavender);
        }
        
        .submenu-item.active { 
            background: rgba(139,92,246,0.12);
            color: var(--primary-lavender);
            font-weight: 600;
        }
        
        .badge-new { 
            margin-left: auto;
            background: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            color: white;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }
        
        .logout-container { 
            margin-top: auto;
            padding-top: 24px;
            border-top: 1px solid var(--border-glass);
        }
        
        .btn-logout { 
            width: 100%;
            padding: 14px;
            background: rgba(244,63,94,0.1);
            color: #F43F5E;
            border: 1px solid rgba(244,63,94,0.2);
            border-radius: 18px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            font-size: 15px;
            backdrop-filter: blur(10px);
        }
        
        .btn-logout:hover { 
            background: rgba(244,63,94,0.2);
            color: #E11D48;
            border-color: rgba(244,63,94,0.4);
            box-shadow: var(--shadow-sm);
        }
        
        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }

        /* ==================== MAIN CONTENT ==================== */
        .main-content { 
            margin-left: calc(var(--sidebar-width) + 48px);
            padding: 24px 32px 32px 8px;
            position: relative;
            z-index: 1;
        }
        
        .page-header { 
            margin-bottom: 40px;
        }
        
        .page-header h1 { 
            font-size: 32px;
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }
        
        .page-header h1 i { 
            color: var(--primary-lavender);
            background: white;
            padding: 12px;
            border-radius: 20px;
            box-shadow: var(--shadow-clay);
            font-size: 28px;
        }
        
        .page-header p { 
            color: var(--text-secondary);
            font-size: 15px;
            margin-top: 8px;
            margin-left: 60px;
            font-weight: 500;
        }

        /* ==================== STATS GRID ==================== */
        .stats-grid { 
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--bg-glass);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid var(--border-glass);
            border-radius: 28px;
            padding: 24px;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-clay), var(--shadow-diagonal);
        }
        
        .stat-card::before { 
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.4;
            pointer-events: none;
        }
        
        .stat-card:hover { 
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-xl);
            border-color: rgba(255,255,255,0.8);
        }
        
        .stat-card-content { 
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }
        
        .stat-info h3 { 
            font-size: 13px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .stat-number { 
            font-size: 36px;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
            line-height: 1;
        }
        
        .stat-trend { 
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
        }
        
        .stat-icon { 
            width: 56px;
            height: 56px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-clay);
            color: white;
            font-size: 26px;
            flex-shrink: 0;
        }
        
        .stat-card:nth-child(1) .stat-icon { 
            background: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
        }
        
        .stat-card:nth-child(2) .stat-icon { 
            background: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
        }
        
        .stat-card:nth-child(3) .stat-icon { 
            background: linear-gradient(145deg, #34D399 0%, #10B981 100%);
        }
        
        .stat-card:nth-child(4) .stat-icon { 
            background: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
        }
        
        .stat-card:nth-child(1) .stat-trend { 
            color: var(--primary-sky);
        }
        
        .stat-card:nth-child(2) .stat-trend { 
            color: var(--primary-peach);
        }
        
        .stat-card:nth-child(3) .stat-trend { 
            color: var(--primary-mint);
        }
        
        .stat-card:nth-child(4) .stat-trend { 
            color: var(--primary-rose);
        }

        /* ==================== GRID LAYOUT ==================== */
        .grid-2 { 
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
            margin-bottom: 28px;
        }
        
        .content-card { 
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-glass);
            border-radius: 32px;
            padding: 32px;
            box-shadow: var(--shadow-lg), var(--shadow-diagonal);
            position: relative;
            overflow: hidden;
            transition: all 0.4s;
        }
        
        .content-card::before { 
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, transparent 100%);
            pointer-events: none;
            border-radius: 32px 32px 0 0;
        }
        
        .content-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--border-glass);
        }
        
        .card-header { 
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-glass);
            position: relative;
            z-index: 1;
        }
        
        .card-header h3 { 
            font-size: 20px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .card-header h3 i { 
            color: var(--primary-lavender);
            font-size: 24px;
        }

        /* ==================== PROGRESS BARS ==================== */
        .progress-item { 
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
        }
        
        .progress-item:last-child { 
            margin-bottom: 0;
        }
        
        .progress-header { 
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .progress-label { 
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
        }
        
        .progress-value { 
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 700;
        }
        
        .progress-bar { 
            width: 100%;
            height: 8px;
            background: rgba(99, 102, 241, 0.08);
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }
        
        .progress-fill { 
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fill-indigo { 
            background: var(--gradient-indigo);
        }
        
        .fill-rose { 
            background: var(--gradient-rose);
        }
        
        .fill-amber { 
            background: var(--gradient-amber);
        }
        
        .fill-mint { 
            background: var(--gradient-mint);
        }

        /* ==================== ACTIVITY ==================== */
        .activity-item { 
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 0;
            border-bottom: 1px solid rgba(203, 213, 225, 0.2);
            position: relative;
            z-index: 1;
            transition: all 0.25s;
        }
        
        .activity-item:hover {
            padding-left: 8px;
        }
        
        .activity-item:last-child { 
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .activity-label { 
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
        }
        
        .activity-value { 
            color: var(--text-primary);
            font-weight: 800;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
        }

        /* ==================== RECENT ACTIVITY ==================== */
        .recent-item { 
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid rgba(203, 213, 225, 0.2);
            position: relative;
            z-index: 1;
            transition: all 0.25s;
        }
        
        .recent-item:hover {
            padding-left: 8px;
        }
        
        .recent-item:last-child { 
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .recent-icon { 
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: white;
            box-shadow: var(--shadow-md);
            font-size: 22px;
        }
        
        .icon-indigo { 
            background: var(--gradient-indigo);
        }
        
        .icon-rose { 
            background: var(--gradient-rose);
        }
        
        .icon-amber { 
            background: var(--gradient-amber);
        }
        
        .recent-content { 
            flex: 1;
            position: relative;
            z-index: 1;
        }
        
        .recent-title { 
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
            margin-bottom: 4px;
        }
        
        .recent-time { 
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ==================== EXPORT CARD ==================== */
        .export-card { 
            background: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            border-radius: 32px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: var(--shadow-lg);
        }
        
        .export-card::before { 
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 250px;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent 70%);
            pointer-events: none;
        }
        
        .export-card::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
            pointer-events: none;
        }
        
        .export-card h3 { 
            font-size: 28px;
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            color: white;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .export-card p { 
            color: rgba(255,255,255,0.9);
            font-size: 16px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }
        
        .export-buttons { 
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        
        .btn-export { 
            padding: 14px 28px;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.4);
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .btn-export:hover { 
            background: rgba(255,255,255,0.25);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }

        /* ==================== SCROLLBAR ==================== */
        ::-webkit-scrollbar { 
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track { 
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb { 
            background: var(--border-glass);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover { 
            background: var(--text-muted);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1440px) {
            .stats-grid { 
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .main-content {
                padding: 28px 32px;
            }

            .stats-grid { 
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-2 { 
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 280px;
                left: -110%;
                transition: left 0.3s;
            }

            .sidebar.active {
                left: 20px;
            }

            .main-content { 
                margin-left: 24px;
                padding: 20px 16px;
            }

            .stats-grid { 
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .grid-2 { 
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .export-card {
                padding: 24px;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .page-header p {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar - Original HD Version -->
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

            <div class="menu-item has-submenu" onclick="toggleSubmenu(event)">
                <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            <div class="submenu">
                <a href="{{ route('admin.classes') }}" class="submenu-item"><i class="fas fa-list"></i><span>Daftar Kelas</span></a>
                <a href="{{ route('admin.classes.create') }}" class="submenu-item"><i class="fas fa-plus-circle"></i><span>Tambah Kelas</span><span class="badge-new">New</span></a>
            </div>

            <p class="menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="menu-item active"><i class="fas fa-chart-bar"></i><span>Laporan</span></a>
            <a href="{{ route('admin.settings') }}" class="menu-item"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
            <a href="{{ route('admin.profile') }}" class="menu-item"><i class="fas fa-user-circle"></i><span>Profil</span></a>
        </div>

        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
    </div>

    <!-- Main Content - Premium Clean Design -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1><i class="fas fa-chart-bar"></i>Laporan & Statistik</h1>
            <p>Analisis mendalam tentang aktivitas sistem dan performa sekolah Anda</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Total Konsultasi</h3>
                        <div class="stat-number">{{ $data['totalConsultations'] ?? 456 }}</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +12%</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-comments"></i></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Catatan Disiplin</h3>
                        <div class="stat-number">{{ $data['disciplineRecords'] ?? 24 }}</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +5%</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Jadwal Temu</h3>
                        <div class="stat-number">{{ $data['appointments'] ?? 89 }}</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +8%</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Tingkat Kehadiran</h3>
                        <div class="stat-number">{{ $data['attendanceRate'] ?? 94 }}%</div>
                        <div class="stat-trend"><i class="fas fa-arrow-up"></i> +3%</div>
                    </div>
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid-2">
            <!-- Distribusi Pengguna -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-chart-pie"></i>Distribusi Pengguna</h3>
                </div>

                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Siswa</span>
                        <span class="progress-value">76%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill fill-indigo" style="width: 76%"></div></div>
                </div>

                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Guru</span>
                        <span class="progress-value">8%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill fill-rose" style="width: 8%"></div></div>
                </div>

                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Admin</span>
                        <span class="progress-value">1%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill fill-amber" style="width: 1%"></div></div>
                </div>

                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Lainnya</span>
                        <span class="progress-value">15%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill fill-mint" style="width: 15%"></div></div>
                </div>
            </div>

            <!-- Aktivitas Bulan Ini -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-check"></i>Aktivitas Bulan Ini</h3>
                </div>

                <div class="activity-item">
                    <span class="activity-label">Konsultasi Selesai</span>
                    <span class="activity-value">{{ $data['completedConsultations'] ?? 234 }}</span>
                </div>

                <div class="activity-item">
                    <span class="activity-label">Konsultasi Pending</span>
                    <span class="activity-value">{{ $data['pendingConsultations'] ?? 12 }}</span>
                </div>

                <div class="activity-item">
                    <span class="activity-label">Jadwal Temu Dikonfirmasi</span>
                    <span class="activity-value">{{ $data['approvedAppointments'] ?? 67 }}</span>
                </div>

                <div class="activity-item">
                    <span class="activity-label">Jadwal Temu Ditolak</span>
                    <span class="activity-value">8</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="content-card" style="margin-bottom: 32px;">
            <div class="card-header">
                <h3><i class="fas fa-history"></i>Aktivitas Terbaru</h3>
            </div>

            <div class="recent-item">
                <div class="recent-icon icon-indigo"><i class="fas fa-comments"></i></div>
                <div class="recent-content">
                    <div class="recent-title">Siswa Ahmad Rizki melakukan konsultasi</div>
                    <div class="recent-time">2 jam yang lalu</div>
                </div>
            </div>

            <div class="recent-item">
                <div class="recent-icon icon-rose"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="recent-content">
                    <div class="recent-title">Catatan disiplin ditambahkan untuk Budi Santoso</div>
                    <div class="recent-time">5 jam yang lalu</div>
                </div>
            </div>

            <div class="recent-item">
                <div class="recent-icon icon-amber"><i class="fas fa-calendar-alt"></i></div>
                <div class="recent-content">
                    <div class="recent-title">Jadwal temu baru dijadwalkan</div>
                    <div class="recent-time">1 hari yang lalu</div>
                </div>
            </div>
        </div>

        <!-- Export Card -->
        <div class="export-card">
            <h3>Ekspor Laporan</h3>
            <p>Unduh laporan dalam berbagai format untuk keperluan analisis dan dokumentasi</p>
            <div class="export-buttons">
                <button class="btn-export" onclick="exportReport('pdf')">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
                <button class="btn-export" onclick="exportReport('excel')">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
                <button class="btn-export" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleSubmenu(e) {
            const element = e.currentTarget || e;
            const submenu = element.nextElementSibling;
            element.classList.toggle('expanded');
            submenu.classList.toggle('show');
        }

        function exportReport(type) {
            const messages = {
                'pdf': 'Laporan PDF sedang disiapkan, mohon tunggu...',
                'excel': 'Laporan Excel sedang disiapkan, mohon tunggu...'
            };
            alert(messages[type] || 'Proses ekspor sedang berlangsung');
        }
    </script>
</body>
</html>