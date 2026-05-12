<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Schoolify Modern</title>
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

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%; right: -20%;
            width: 80%; height: 150%;
            background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%);
            pointer-events: none; z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -30%; left: -10%;
            width: 70%; height: 120%;
            background: radial-gradient(circle, rgba(251,146,60,0.06) 0%, transparent 70%);
            pointer-events: none; z-index: 0;
        }

        /* ==================== SIDEBAR DESKTOP ==================== */
        .sidebar {
            position: fixed;
            left: 24px; top: 24px; bottom: 24px;
            width: var(--sidebar-width);
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-glass);
            border-radius: 32px;
            z-index: 1000;
            padding: 24px 16px;
            display: flex; flex-direction: column;
            overflow-y: auto;
            box-shadow: var(--shadow-xl), var(--shadow-diagonal);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            display: flex; align-items: center; gap: 12px;
            padding: 0 12px 32px;
        }

        .sidebar-header .logo-icon {
            width: 44px; height: 44px;
            background: var(--gradient-lavender);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3);
        }

        .sidebar-header h2 {
            font-size: 24px; font-weight: 800;
            font-family: 'Outfit', sans-serif;
            background: var(--gradient-lavender);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .menu-label {
            font-size: 11px; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-muted);
            font-weight: 700; margin: 24px 12px 10px;
        }

        .sidebar-menu {
            display: flex; flex-direction: column; gap: 6px; flex-grow: 1;
        }

        .menu-item {
            padding: 12px 16px; border-radius: 18px;
            display: flex; align-items: center; gap: 14px;
            color: var(--text-secondary); text-decoration: none;
            transition: all 0.3s; font-weight: 600; font-size: 15px;
            background: transparent; cursor: pointer;
        }

        .menu-item i { font-size: 20px; width: 24px; color: var(--text-muted); }
        .menu-item:hover { background: var(--bg-glass-hover); color: var(--primary-lavender); box-shadow: var(--shadow-sm); }
        .menu-item:hover i { color: var(--primary-lavender); }
        .menu-item.active { background: var(--gradient-lavender); color: white; box-shadow: var(--shadow-md), 0 6px 15px rgba(139,92,246,0.3); }
        .menu-item.active i { color: white; }
        .menu-item.has-submenu { cursor: pointer; }
        .menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }

        .submenu {
            margin-left: 20px; padding-left: 16px;
            border-left: 2px solid var(--border-glass);
            display: none; flex-direction: column; gap: 4px;
            margin-top: 4px; margin-bottom: 4px;
        }
        .submenu.show { display: flex; }

        .submenu-item {
            padding: 10px 16px 10px 20px; border-radius: 14px;
            display: flex; align-items: center; gap: 12px;
            color: var(--text-secondary); text-decoration: none;
            transition: all 0.2s; font-weight: 500; font-size: 14px;
        }
        .submenu-item i { font-size: 16px; width: 20px; }
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-lavender); }
        .submenu-item.active { background: rgba(139,92,246,0.12); color: var(--primary-lavender); font-weight: 600; }

        .badge-new {
            margin-left: auto;
            background: var(--gradient-peach); color: white;
            font-size: 10px; padding: 3px 8px; border-radius: 20px;
            font-weight: 700; box-shadow: var(--shadow-sm);
        }

        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }

        .btn-logout {
            width: 100%; padding: 14px;
            background: rgba(248,113,113,0.1); color: var(--primary-rose);
            border: 1px solid rgba(248,113,113,0.2); border-radius: 18px;
            font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px);
        }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        /* ==================== MOBILE NAVBAR ==================== */
        .mobile-navbar {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            height: 80px;
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border-top: 1px solid var(--border-glass);
            z-index: 999; padding: 12px 0;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }

        .mobile-navbar-content {
            display: flex; justify-content: space-around; align-items: center;
            height: 100%; padding: 0 8px;
        }

        .mobile-nav-item {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 8px 12px; border-radius: 16px;
            color: var(--text-muted); text-decoration: none;
            font-size: 11px; font-weight: 600;
            transition: all 0.3s ease; cursor: pointer;
            flex: 1; max-width: 60px;
        }
        .mobile-nav-item i { font-size: 24px; }
        .mobile-nav-item:hover, .mobile-nav-item.active { color: var(--primary-lavender); background: rgba(139,92,246,0.12); }

        .mobile-menu-toggle {
            width: 44px; height: 44px;
            background: var(--gradient-lavender); border: none;
            border-radius: 14px; color: white; font-size: 20px;
            cursor: pointer; display: none; align-items: center; justify-content: center;
            z-index: 1001; box-shadow: var(--shadow-md); transition: all 0.3s ease;
        }
        .mobile-menu-toggle:active { transform: scale(0.95); }

        /* ==================== MOBILE MENU PANEL ==================== */
        .mobile-menu-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.4); backdrop-filter: blur(8px);
            z-index: 998; display: none; opacity: 0; transition: opacity 0.3s ease;
        }
        .mobile-menu-overlay.show { display: block; opacity: 1; }

        .mobile-menu-panel {
            position: fixed; left: 0; top: 0; bottom: 0; width: 280px;
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border-right: 1px solid var(--border-glass);
            z-index: 999; padding: 20px 16px;
            display: flex; flex-direction: column;
            box-shadow: var(--shadow-xl);
            transform: translateX(-100%);
            transition: transform 0.3s ease; overflow-y: auto;
        }
        .mobile-menu-panel.show { transform: translateX(0); }

        .mobile-menu-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; padding-bottom: 16px;
            border-bottom: 1px solid var(--border-glass);
        }
        .mobile-menu-header-logo { display: flex; align-items: center; gap: 12px; }
        .mobile-menu-header-logo .logo-icon {
            width: 40px; height: 40px;
            background: var(--gradient-lavender); border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 18px;
        }
        .mobile-menu-header-logo h2 {
            font-size: 20px; font-weight: 800; font-family: 'Outfit', sans-serif;
            background: var(--gradient-lavender);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .mobile-menu-close {
            width: 36px; height: 36px; background: white;
            border: 1px solid var(--border-glass); border-radius: 10px;
            color: var(--text-secondary); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; transition: all 0.2s;
        }
        .mobile-menu-close:active { background: rgba(139,92,246,0.1); }

        .mobile-sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }

        .mobile-menu-label {
            font-size: 11px; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-muted);
            font-weight: 700; margin: 16px 12px 8px;
        }

        .mobile-menu-item {
            padding: 12px 16px; border-radius: 16px;
            display: flex; align-items: center; gap: 14px;
            color: var(--text-secondary); text-decoration: none;
            transition: all 0.2s; font-weight: 600; font-size: 14px; cursor: pointer;
        }
        .mobile-menu-item i { font-size: 18px; width: 24px; }
        .mobile-menu-item:active { background: var(--bg-glass-hover); }
        .mobile-menu-item.active { background: var(--gradient-lavender); color: white; }
        .mobile-menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .mobile-menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }

        .mobile-submenu {
            margin-left: 20px; padding-left: 16px;
            border-left: 2px solid var(--border-glass);
            display: none; flex-direction: column; gap: 4px;
            margin-top: 4px; margin-bottom: 4px;
        }
        .mobile-submenu.show { display: flex; }

        .mobile-submenu-item {
            padding: 10px 16px 10px 20px; border-radius: 12px;
            display: flex; align-items: center; gap: 12px;
            color: var(--text-secondary); text-decoration: none;
            transition: all 0.2s; font-weight: 500; font-size: 13px;
        }
        .mobile-submenu-item:active { background: rgba(139,92,246,0.1); }
        .mobile-submenu-item.active { color: var(--primary-lavender); font-weight: 600; }

        .mobile-logout-section { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-glass); }

        .mobile-btn-logout {
            width: 100%; padding: 12px;
            background: rgba(248,113,113,0.1); color: var(--primary-rose);
            border: 1px solid rgba(248,113,113,0.2); border-radius: 14px;
            font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: all 0.2s; font-size: 13px;
        }
        .mobile-btn-logout:active { background: rgba(248,113,113,0.2); }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: calc(var(--sidebar-width) + 48px);
            padding: 24px 32px 32px 8px;
            position: relative; z-index: 1;
        }

        .top-bar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 28px;
            background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%);
            padding: 18px 32px; border-radius: 28px;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-lg), var(--shadow-diagonal);
        }

        .page-title h1 { font-size: 28px; font-weight: 800; font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; color: var(--text-primary); }
        .page-title p { color: var(--text-secondary); font-size: 14px; margin-top: 4px; font-weight: 500; }

        .user-actions { display: flex; align-items: center; gap: 24px; }

        .date-badge {
            font-size: 14px; font-weight: 600; color: var(--text-secondary);
            background: white; padding: 10px 18px; border-radius: 40px;
            border: 1px solid var(--border-glass); box-shadow: var(--shadow-inner);
        }

        .user-avatar {
            width: 48px; height: 48px; background: var(--gradient-lavender);
            border-radius: 18px; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 18px; color: white;
            box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3);
        }

        .alert {
            padding: 16px 24px; border-radius: 20px; margin-bottom: 28px;
            display: flex; align-items: center; gap: 14px;
            backdrop-filter: blur(10px); font-weight: 500;
        }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }

        /* ==================== SLIDER — FIXED ==================== */
        .slider-container {
            margin-bottom: 36px;
            position: relative;
            border-radius: 32px;
        }

        .slider-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 28px;
        }

        .slider-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide-card {
            flex: 0 0 100%;
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 28px;
            /* KEY FIX: padding horizontal lebih besar agar tidak tertutup tombol nav */
            padding: 32px 80px;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-lg), var(--shadow-diagonal);
            position: relative;
            overflow: hidden;
            display: flex !important;
            flex-direction: row !important;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            min-height: 200px;
        }

        .slide-card::before {
            content: '';
            position: absolute;
            top: -30%; right: -10%;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* KEY FIX: min-width: 0 agar flex item tidak overflow */
        .slide-content {
            flex: 1;
            min-width: 0;
            position: relative;
            z-index: 1;
        }

        .slide-icon {
            width: 52px; height: 52px;
            background: var(--gradient-lavender);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .slide-icon i { font-size: 24px; color: white; }

        .slide-title {
            font-size: 20px; font-weight: 800;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .slide-description {
            font-size: 13px; color: var(--text-secondary);
            margin-bottom: 20px; line-height: 1.6;
            max-width: 100%;
        }

        .slide-stats {
            display: flex !important;
            flex-direction: row !important;
            gap: 32px !important;
            margin-top: 4px !important;
            flex-wrap: wrap;
        }

        .stat-item { text-align: left; }

        .stat-value {
            font-size: 24px; font-weight: 800;
            color: var(--primary-lavender);
            line-height: 1;
        }

        .stat-label {
            font-size: 11px; color: var(--text-muted);
            margin-top: 5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.03em;
        }

        .slide-image {
            position: relative; z-index: 1;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }

        .slide-image img {
            width: 110px; height: 110px;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.12));
        }

        /* Dots */
        .slider-dots {
            display: flex; justify-content: center; gap: 8px; margin-top: 16px;
        }

        .dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--text-muted); cursor: pointer; transition: all 0.3s;
        }
        .dot.active { width: 24px; border-radius: 10px; background: var(--primary-lavender); }
        .dot:hover { background: var(--primary-lavender); opacity: 0.7; }

        /* Nav arrows — KEY FIX: border + better sizing */
        .slider-nav {
            position: absolute;
            top: 50%; transform: translateY(-50%);
            width: 38px; height: 38px;
            background: white;
            border: 1px solid var(--border-glass);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 10;
            box-shadow: var(--shadow-md);
            transition: all 0.3s;
            color: var(--text-secondary);
            font-size: 14px;
        }
        .slider-nav:hover { background: var(--gradient-lavender); color: white; border-color: transparent; }
        .slider-nav.prev { left: 20px; }
        .slider-nav.next { right: 20px; }

        /* ==================== CALENDAR ==================== */
        .calendar-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 36px; }

        .calendar-card {
            background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%);
            border-radius: 28px; padding: 24px;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-clay), var(--shadow-diagonal);
            position: relative; overflow: hidden;
        }
        .calendar-card::before {
            content: ''; position: absolute; top: -30%; right: -20%;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-month-year { display: flex; align-items: baseline; gap: 8px; }
        .calendar-month { font-size: 24px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .calendar-year { font-size: 16px; font-weight: 500; color: var(--primary-lavender); background: rgba(139,92,246,0.1); padding: 4px 12px; border-radius: 30px; }
        .calendar-nav { display: flex; gap: 8px; }
        .calendar-nav-btn {
            width: 40px; height: 40px; border-radius: 14px; background: white;
            border: 1px solid var(--border-glass); color: var(--text-secondary);
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; box-shadow: var(--shadow-sm);
        }
        .calendar-nav-btn:hover { background: var(--gradient-lavender); color: white; border-color: transparent; box-shadow: var(--shadow-md); }

        .calendar-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin-bottom: 12px; }
        .calendar-weekday { text-align: center; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); padding: 8px 0; }

        .calendar-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .calendar-day {
            aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 500; color: var(--text-primary);
            background: transparent; border-radius: 14px; cursor: pointer;
            transition: all 0.2s; border: 1px solid transparent;
        }
        .calendar-day:hover { background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.3); }
        .calendar-day.today { background: var(--gradient-lavender); color: white; font-weight: 700; box-shadow: var(--shadow-md); }
        .calendar-day.other-month { color: var(--text-muted); opacity: 0.5; }
        .calendar-day.has-event { position: relative; font-weight: 600; }
        .calendar-day.has-event::after { content: ''; position: absolute; bottom: 6px; width: 6px; height: 6px; background: var(--primary-rose); border-radius: 50%; }
        .calendar-day.today.has-event::after { background: white; }

        /* Events Card */
        .events-card {
            background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%);
            border-radius: 28px; padding: 24px;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-clay), var(--shadow-diagonal);
            position: relative; overflow: hidden;
        }
        .events-card::before {
            content: ''; position: absolute; bottom: -20%; left: -10%;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(249,115,22,0.1) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        .events-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .events-header i { font-size: 24px; color: var(--primary-peach); background: white; padding: 10px; border-radius: 16px; box-shadow: var(--shadow-sm); }
        .events-header h3 { font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }

        .event-list { display: flex; flex-direction: column; gap: 12px; }

        .event-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 16px; background: white;
            border-radius: 18px; border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-sm); transition: all 0.2s;
        }
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

        /* Modal */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.6); backdrop-filter: blur(8px);
            z-index: 9999; display: none; align-items: center; justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        .modal-overlay.show { display: flex; }

        .modal-dialog {
            background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-glass); border-radius: 28px;
            padding: 0; width: 90%; max-width: 500px;
            box-shadow: var(--shadow-xl), 0 30px 60px rgba(0,0,0,0.2);
            animation: slideUp 0.3s ease-out; overflow: hidden;
        }

        .modal-header {
            padding: 24px 28px; border-bottom: 1px solid var(--border-glass);
            display: flex; justify-content: space-between; align-items: center; position: relative;
        }
        .modal-header::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 60px;
            background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, transparent 100%); pointer-events: none;
        }

        .modal-title {
            font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif;
            color: var(--text-primary); display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 1;
        }
        .modal-title i { color: var(--primary-lavender); background: white; padding: 8px; border-radius: 14px; box-shadow: var(--shadow-sm); }

        .btn-close {
            width: 38px; height: 38px; border-radius: 12px; background: white;
            border: 1px solid var(--border-glass); color: var(--text-secondary);
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; box-shadow: var(--shadow-sm); font-size: 16px;
        }
        .btn-close:hover { background: rgba(239,68,68,0.1); border-color: var(--primary-rose); color: var(--primary-rose); }

        .modal-body { padding: 24px 28px; max-height: 400px; overflow-y: auto; position: relative; z-index: 1; }

        .modal-event-item {
            display: flex; gap: 14px; padding: 16px; background: white;
            border-radius: 16px; border: 1px solid var(--border-glass);
            margin-bottom: 10px; transition: all 0.2s;
        }
        .modal-event-item:hover { box-shadow: var(--shadow-md); border-color: var(--primary-lavender); }
        .modal-event-item:last-child { margin-bottom: 0; }

        .modal-event-icon { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }

        .modal-event-content { flex: 1; }
        .modal-event-content h4 { font-weight: 700; color: var(--text-primary); font-size: 15px; margin-bottom: 4px; }
        .modal-event-content p { font-size: 13px; color: var(--text-secondary); }

        .modal-empty { text-align: center; padding: 30px; color: var(--text-muted); }
        .modal-empty i { font-size: 40px; margin-bottom: 12px; opacity: 0.4; display: block; }

        .modal-footer {
            padding: 20px 28px; border-top: 1px solid var(--border-glass);
            text-align: right; position: relative; z-index: 1;
            background: rgba(255,255,255,0.3);
        }

        .btn-add-agenda {
            padding: 10px 20px; background: var(--gradient-lavender);
            border: none; border-radius: 14px; color: white;
            font-weight: 600; font-size: 13px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s; box-shadow: var(--shadow-md); text-decoration: none;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }

        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 36px; }

        .stat-card {
            background: var(--bg-glass); backdrop-filter: blur(16px) saturate(180%);
            border-radius: 28px; padding: 24px;
            border: 1px solid var(--border-glass); transition: all 0.4s;
            position: relative; overflow: hidden;
            box-shadow: var(--shadow-clay), var(--shadow-diagonal);
            text-decoration: none; display: block; cursor: pointer;
        }
        .stat-card::before {
            content: ''; position: absolute; top: -50%; right: -30%;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
            border-radius: 50%; opacity: 0.4; pointer-events: none;
        }
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
        .content-card {
            background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%);
            border-radius: 32px; border: 1px solid var(--border-glass);
            overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal);
            position: relative; margin-bottom: 30px;
        }
        .content-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 120px;
            background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, transparent 100%);
            pointer-events: none; border-radius: 32px 32px 0 0;
        }

        .card-header {
            padding: 24px 32px; display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1;
        }
        .card-header h2 { font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 10px; }
        .card-header h2 i { color: var(--primary-lavender); }

        .btn-view-all {
            background: var(--gradient-lavender); color: white;
            padding: 10px 20px; border-radius: 40px; text-decoration: none;
            font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.3s; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.25);
        }
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

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1200px) {
            .calendar-wrapper { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-120%); }
            .main-content { margin-left: 24px; padding: 20px; padding-bottom: 100px; }
            .mobile-menu-toggle { display: flex; position: fixed; bottom: 24px; right: 24px; }
            .mobile-navbar { display: block; }
            .top-bar { padding: 16px 20px; }
            .page-title h1 { font-size: 24px; }
            .user-actions { gap: 16px; }
            .date-badge { font-size: 12px; padding: 8px 14px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .card-header { padding: 18px 24px; flex-direction: column; gap: 16px; align-items: flex-start; }
            .card-header h2 { font-size: 18px; }
            .modal-dialog { width: 95%; }
            /* Slider responsive */
            .slide-card { padding: 28px 60px; }
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 16px; padding-bottom: 100px; }
            .top-bar { flex-direction: column; gap: 16px; align-items: flex-start; }
            .page-title h1 { font-size: 22px; }
            .page-title p { font-size: 13px; }
            .user-actions { width: 100%; justify-content: space-between; }
            .stats-grid { grid-template-columns: 1fr; gap: 12px; }
            .stat-card { padding: 18px; }
            .stat-number { font-size: 28px; }
            .calendar-wrapper { grid-template-columns: 1fr; gap: 16px; }
            .calendar-card, .events-card { padding: 18px; }
            .calendar-month { font-size: 20px; }
            .event-item { gap: 12px; padding: 12px 14px; }
            .content-card { margin-bottom: 20px; }
            .card-header { padding: 16px 20px; }
            .data-table td { padding: 14px 16px; font-size: 13px; }
            .mobile-menu-toggle { width: 50px; height: 50px; font-size: 22px; }
            /* Slider mobile: kolom jadi atas-bawah */
            .slide-card {
                padding: 28px 52px;
                flex-direction: column !important;
                text-align: center;
                align-items: center;
                min-height: auto;
            }
            .slide-stats { justify-content: center; gap: 20px !important; }
            .stat-item { text-align: center; }
            .slide-image img { width: 80px; height: 80px; }
            .slide-title { font-size: 17px; }
        }

        @media (max-width: 480px) {
            .main-content { padding: 12px; padding-bottom: 100px; }
            .top-bar { padding: 14px 16px; }
            .page-title h1 { font-size: 20px; }
            .user-avatar { width: 40px; height: 40px; font-size: 16px; }
            .stats-grid { gap: 8px; }
            .stat-card { padding: 14px; }
            .stat-icon { width: 44px; height: 44px; }
            .stat-icon i { font-size: 20px; }
            .stat-number { font-size: 24px; }
            .stat-info h3 { font-size: 11px; }
            .calendar-card, .events-card { padding: 14px; }
            .calendar-weekday { font-size: 10px; }
            .calendar-day { font-size: 12px; }
            .event-day { font-size: 18px; }
            .event-title { font-size: 13px; }
            .data-table { border-spacing: 0 6px; }
            .data-table td { padding: 12px; font-size: 12px; }
            .mobile-navbar { height: 72px; padding: 8px 0; }
            .mobile-nav-item { max-width: 50px; font-size: 10px; }
            .mobile-nav-item i { font-size: 20px; }
            .mobile-menu-toggle { width: 44px; height: 44px; bottom: 20px; right: 20px; }
            /* Slider smallest */
            .slide-card { padding: 24px 48px; gap: 16px; }
            .slide-stats { gap: 14px !important; }
            .stat-value { font-size: 20px; }
            .slide-image img { width: 64px; height: 64px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR DESKTOP -->
        <!-- SIDEBAR DESKTOP -->
    <div class="sidebar" id="desktopSidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-cloud"></i></div>
            <h2>Schoolify</h2>
        </div>
        <div class="sidebar-menu">
            <p class="menu-label">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}" class="menu-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i><span>Data Siswa</span>
            </a>
            <a href="{{ route('admin.teachers') }}" class="menu-item {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-user"></i><span>Data Guru</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="menu-item {{ request()->routeIs('admin.agendas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i><span>Agenda</span>
            </a>

            <div class="menu-item has-submenu {{ request()->routeIs('admin.classes*') ? 'expanded' : '' }}" onclick="toggleSubmenu(this)">
                <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            <div class="submenu {{ request()->routeIs('admin.classes*') ? 'show' : '' }}">
                <a href="{{ route('admin.classes') }}" class="submenu-item {{ request()->routeIs('admin.classes') ? 'active' : '' }}">
                    <i class="fas fa-list"></i><span>Daftar Kelas</span>
                </a>
                <a href="{{ route('admin.classes.create') }}" class="submenu-item {{ request()->routeIs('admin.classes.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i><span>Tambah Kelas</span><span class="badge-new">New</span>
                </a>
            </div>

            <div class="menu-item has-submenu {{ request()->routeIs('admin.jadwal*') ? 'expanded' : '' }}" onclick="toggleSubmenu(this)">
                <i class="fas fa-calendar-week"></i><span>Jadwal</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            <div class="submenu {{ request()->routeIs('admin.jadwal*') ? 'show' : '' }}">
                <a href="{{ route('admin.jadwal.index') }}" class="submenu-item {{ request()->routeIs('admin.jadwal.index') ? 'active' : '' }}">
                    <i class="fas fa-table"></i><span>Jadwal Pelajaran</span>
                </a>
                <a href="{{ route('admin.jadwal.create') }}" class="submenu-item {{ request()->routeIs('admin.jadwal.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i><span>Tambah Jadwal</span>
                </a>
            </div>

            <p class="menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i><span>Laporan</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i><span>Pengaturan</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="menu-item {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i><span>Profil</span>
            </a>
        </div>
        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
    </div>

    <!-- MOBILE MENU OVERLAY -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- MOBILE MENU PANEL -->
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <div class="mobile-menu-header">
            <div class="mobile-menu-header-logo">
                <div class="logo-icon"><i class="fas fa-cloud"></i></div>
                <h2>Schoolify</h2>
            </div>
            <button class="mobile-menu-close" onclick="closeMobileMenu()"><i class="fas fa-times"></i></button>
        </div>
        <div class="mobile-sidebar-menu">
            <p class="mobile-menu-label">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}" class="mobile-menu-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i><span>Data Siswa</span>
            </a>
            <a href="{{ route('admin.teachers') }}" class="mobile-menu-item {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-user"></i><span>Data Guru</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="mobile-menu-item {{ request()->routeIs('admin.agendas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i><span>Agenda</span>
            </a>

            <div class="mobile-menu-item has-submenu {{ request()->routeIs('admin.classes*') ? 'expanded' : '' }}" onclick="toggleMobileSubmenu(this)">
                <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            <div class="mobile-submenu {{ request()->routeIs('admin.classes*') ? 'show' : '' }}" id="mobileClassesSubmenu">
                <a href="{{ route('admin.classes') }}" class="mobile-submenu-item {{ request()->routeIs('admin.classes') ? 'active' : '' }}">
                    <i class="fas fa-list"></i><span>Daftar Kelas</span>
                </a>
                <a href="{{ route('admin.classes.create') }}" class="mobile-submenu-item {{ request()->routeIs('admin.classes.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i><span>Tambah Kelas</span>
                </a>
            </div>

            <div class="mobile-menu-item has-submenu {{ request()->routeIs('admin.jadwal*') ? 'expanded' : '' }}" onclick="toggleMobileSubmenu(this)">
                <i class="fas fa-calendar-week"></i><span>Jadwal</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            <div class="mobile-submenu {{ request()->routeIs('admin.jadwal*') ? 'show' : '' }}" id="mobileJadwalSubmenu">
                <a href="{{ route('admin.jadwal.index') }}" class="mobile-submenu-item {{ request()->routeIs('admin.jadwal.index') ? 'active' : '' }}">
                    <i class="fas fa-table"></i><span>Jadwal Pelajaran</span>
                </a>
                <a href="{{ route('admin.jadwal.create') }}" class="mobile-submenu-item {{ request()->routeIs('admin.jadwal.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i><span>Tambah Jadwal</span>
                </a>
            </div>

            <p class="mobile-menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="mobile-menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i><span>Laporan</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="mobile-menu-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i><span>Pengaturan</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="mobile-menu-item {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i><span>Profil</span>
            </a>
        </div>
        <div class="mobile-logout-section">
            <form action="{{ route('logout') }}" method="POST" style="width:100%;">
                @csrf
                <button type="submit" class="mobile-btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
    </div>

    <!-- MOBILE TOGGLE BUTTON -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" onclick="openMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- MOBILE NAVBAR (BOTTOM) -->
    <div class="mobile-navbar" id="mobileNavbar">
        <div class="mobile-navbar-content">
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}" class="mobile-nav-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i><span>Siswa</span>
            </a>
            <a href="{{ route('admin.teachers') }}" class="mobile-nav-item {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-user"></i><span>Guru</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.agendas*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i><span>Agenda</span>
            </a>
            <button class="mobile-nav-item" onclick="openMobileMenu()" style="border:none;background:none;cursor:pointer;">
                <i class="fas fa-ellipsis-h"></i><span>Lebih</span>
            </button>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard Admin</h1>
                <p>Selamat datang kembali, Khoerul Paroid!</p>
            </div>
            <div class="user-actions">
                <span class="date-badge"><i class="far fa-calendar-alt" style="margin-right:8px;"></i>Monday, 11 May 2026</span>
                <div class="user-avatar">K</div>
            </div>
        </div>

        <!-- ==================== SLIDER ==================== -->
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slider-track" id="sliderTrack">

                    <!-- Slide 1 -->
                    <div class="slide-card">
                        <div class="slide-content">
                            <div class="slide-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3 class="slide-title">Statistik Akademik</h3>
                            <p class="slide-description">Ringkasan pencapaian akademik siswa secara real-time</p>
                            <div class="slide-stats">
                                <div class="stat-item">
                                    <div class="stat-value" id="avgGrade">85.6</div>
                                    <div class="stat-label">Rata-rata Nilai</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="passRate">92%</div>
                                    <div class="stat-label">Tingkat Kelulusan</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="honorStudents">28</div>
                                    <div class="stat-label">Siswa Berprestasi</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-image">
                            <img src="https://cdn-icons-png.flaticon.com/512/4178/4178543.png" alt="Statistics">
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="slide-card">
                        <div class="slide-content">
                            <div class="slide-icon" style="background: var(--gradient-peach);">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="slide-title">Tenaga Pendidik</h3>
                            <p class="slide-description">Informasi lengkap tentang guru dan aktivitas mengajar</p>
                            <div class="slide-stats">
                                <div class="stat-item">
                                    <div class="stat-value" id="totalTeachers">45</div>
                                    <div class="stat-label">Total Guru</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="activeTeachers">42</div>
                                    <div class="stat-label">Guru Aktif</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="certifiedTeachers">38</div>
                                    <div class="stat-label">Bersertifikat</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-image">
                            <img src="https://cdn-icons-png.flaticon.com/512/2947/2947075.png" alt="Teachers">
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="slide-card">
                        <div class="slide-content">
                            <div class="slide-icon" style="background: var(--gradient-mint);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3 class="slide-title">Kegiatan Mendatang</h3>
                            <p class="slide-description">Informasi agenda dan kegiatan sekolah terbaru</p>
                            <div class="slide-stats">
                                <div class="stat-item">
                                    <div class="stat-value" id="upcomingEventsSlide">5</div>
                                    <div class="stat-label">Acara Mendatang</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="thisMonthEvents">12</div>
                                    <div class="stat-label">Acara Bulan Ini</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="completedEvents">8</div>
                                    <div class="stat-label">Sudah Dilaksanakan</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-image">
                            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081955.png" alt="Calendar">
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="slide-card">
                        <div class="slide-content">
                            <div class="slide-icon" style="background: var(--gradient-rose);">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h3 class="slide-title">Prestasi Sekolah</h3>
                            <p class="slide-description">Penghargaan dan prestasi yang telah diraih</p>
                            <div class="slide-stats">
                                <div class="stat-item">
                                    <div class="stat-value" id="nationalAwards">15</div>
                                    <div class="stat-label">Prestasi Nasional</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="provincialAwards">23</div>
                                    <div class="stat-label">Prestasi Provinsi</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="internationalAwards">3</div>
                                    <div class="stat-label">Prestasi Internasional</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-image">
                            <img src="https://cdn-icons-png.flaticon.com/512/3159/3159176.png" alt="Achievements">
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="slide-card">
                        <div class="slide-content">
                            <div class="slide-icon" style="background: var(--gradient-sky);">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3 class="slide-title">Tingkat Kehadiran</h3>
                            <p class="slide-description">Statistik kehadiran siswa bulan ini</p>
                            <div class="slide-stats">
                                <div class="stat-item">
                                    <div class="stat-value" id="attendanceRate">94%</div>
                                    <div class="stat-label">Rata-rata Hadir</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="sickLeave">12</div>
                                    <div class="stat-label">Izin Sakit</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value" id="permitLeave">8</div>
                                    <div class="stat-label">Izin Lainnya</div>
                                </div>
                            </div>
                        </div>
                        <div class="slide-image">
                            <img src="https://cdn-icons-png.flaticon.com/512/2598/2598762.png" alt="Attendance">
                        </div>
                    </div>

                </div>

                <div class="slider-nav prev" onclick="prevSlide()">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="slider-nav next" onclick="nextSlide()">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
            <div class="slider-dots" id="sliderDots"></div>
        </div>
        <!-- END SLIDER -->

        <!-- Calendar + Events -->
        <div class="calendar-wrapper">
            <div class="calendar-card">
                <div class="calendar-header">
                    <div class="calendar-month-year">
                        <span class="calendar-month" id="currentMonth">Mei</span>
                        <span class="calendar-year" id="currentYear">2026</span>
                    </div>
                    <div class="calendar-nav">
                        <button class="calendar-nav-btn" onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                        <button class="calendar-nav-btn" onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="calendar-weekdays">
                    <span class="calendar-weekday">Min</span>
                    <span class="calendar-weekday">Sen</span>
                    <span class="calendar-weekday">Sel</span>
                    <span class="calendar-weekday">Rab</span>
                    <span class="calendar-weekday">Kam</span>
                    <span class="calendar-weekday">Jum</span>
                    <span class="calendar-weekday">Sab</span>
                </div>
                <div class="calendar-days" id="calendarDays"></div>
                <div style="margin-top:16px;text-align:right;">
                    <a href="#" style="color:var(--primary-lavender);font-size:13px;font-weight:600;text-decoration:none;">
                        <i class="fas fa-plus-circle"></i> Tambah Agenda
                    </a>
                </div>
            </div>

            <div class="events-card">
                <div class="events-header">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Agenda Mendatang</h3>
                    <a href="#" style="margin-left:auto;color:var(--primary-lavender);font-size:13px;font-weight:600;text-decoration:none;">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="event-list" id="upcomingEvents"></div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal-overlay" id="calendarModal">
            <div class="modal-dialog">
                <div class="modal-header">
                    <div class="modal-title">
                        <i class="fas fa-calendar-day"></i>
                        <span id="modalDateTitle">Tanggal</span>
                    </div>
                    <button class="btn-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body" id="modalEventList"></div>
                <div class="modal-footer">
                    <a href="#" class="btn-add-agenda" id="modalAddAgendaBtn">
                        <i class="fas fa-plus"></i> Tambah Agenda
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <a href="#" class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-info">
                    <h3>Total Siswa</h3>
                    <div class="stat-number">320</div>
                    <div class="stat-trend"><i class="fas fa-arrow-up"></i> +12%</div>
                </div>
            </a>
            <a href="#" class="stat-card">
                <div class="stat-icon"><i class="fas fa-chalkboard-user"></i></div>
                <div class="stat-info">
                    <h3>Total Guru</h3>
                    <div class="stat-number">45</div>
                    <div class="stat-trend"><i class="fas fa-arrow-up"></i> +5%</div>
                </div>
            </a>
            <a href="#" class="stat-card">
                <div class="stat-icon"><i class="fas fa-door-open"></i></div>
                <div class="stat-info">
                    <h3>Total Kelas</h3>
                    <div class="stat-number">18</div>
                    <div class="stat-trend"><i class="fas fa-arrow-up"></i> +3%</div>
                </div>
            </a>
            <a href="#" class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-info">
                    <h3>Total Agenda</h3>
                    <div class="stat-number">12</div>
                    <div class="stat-trend"><i class="fas fa-calendar-check"></i> Aktif</div>
                </div>
            </a>
        </div>

        <!-- Siswa Terbaru -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-user-graduate"></i> Siswa Terbaru</h2>
                <a href="#" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NISN</th><th>Nama Siswa</th><th>Email</th><th>Kelas</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight:600;color:var(--primary-sky);">1234567890</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=3B82F6&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">Andi Pratama</span></div></td>
                            <td>andi@sekolah.id</td><td>X-A</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:var(--primary-sky);">9876543210</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name=Sari+Dewi&background=3B82F6&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">Sari Dewi</span></div></td>
                            <td>sari@sekolah.id</td><td>XI-B</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:var(--primary-sky);">1122334455</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=3B82F6&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">Budi Santoso</span></div></td>
                            <td>budi@sekolah.id</td><td>XII-C</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Guru Terbaru -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-chalkboard-user"></i> Guru Terbaru</h2>
                <a href="#" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NIP</th><th>Nama Guru</th><th>Email</th><th>Mata Pelajaran</th><th>No. HP</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight:600;color:var(--primary-peach);">198501012010011001</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name=Pak+Hendra&background=F97316&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">Pak Hendra</span></div></td>
                            <td>hendra@sekolah.id</td><td>Matematika</td><td>0812-0000-0001</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                        </tr>
                        <tr>
                            <td style="font-weight:600;color:var(--primary-peach);">197803152005012002</td>
                            <td><div class="user-info-cell"><img src="https://ui-avatars.com/api/?name=Bu+Ratna&background=F97316&color=fff&bold=true" class="user-avatar-sm"><span class="user-name">Bu Ratna</span></div></td>
                            <td>ratna@sekolah.id</td><td>Bahasa Indonesia</td><td>0813-0000-0002</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- end main-content -->

    <script>
        // ==================== SIDEBAR ====================
        function toggleSubmenu(e) {
            const s = e.nextElementSibling;
            e.classList.toggle('expanded');
            s.classList.toggle('show');
        }

        // ==================== MOBILE MENU ====================
        function openMobileMenu() {
            document.getElementById('mobileMenuPanel').classList.add('show');
            document.getElementById('mobileMenuOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileMenu() {
            document.getElementById('mobileMenuPanel').classList.remove('show');
            document.getElementById('mobileMenuOverlay').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        function toggleMobileSubmenu(e) {
            const s = e.nextElementSibling;
            e.classList.toggle('expanded');
            s.classList.toggle('show');
        }
        document.getElementById('mobileMenuOverlay').addEventListener('click', closeMobileMenu);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { closeMobileMenu(); closeModal(); }
        });

        // ==================== SLIDER ====================
        let currentSlide = 0;
        let slideInterval;
        let totalSlides = 0;
        const track = document.getElementById('sliderTrack');

        function updateSlider() {
            if (!track || totalSlides === 0) return;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            document.querySelectorAll('.dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === currentSlide);
            });
        }

        function createDots() {
            const container = document.getElementById('sliderDots');
            if (!container) return;
            container.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.onclick = (function(idx) {
                    return function() { currentSlide = idx; updateSlider(); resetInterval(); };
                })(i);
                container.appendChild(dot);
            }
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider(); resetInterval();
        }
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider(); resetInterval();
        }
        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(function() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }, 3500);
        }

        function initSlider() {
            const slides = document.querySelectorAll('.slide-card');
            totalSlides = slides.length;
            if (totalSlides === 0) return;
            createDots();
            updateSlider();
            resetInterval();
        }

        // Pause on hover
        const sliderWrapper = document.querySelector('.slider-wrapper');
        if (sliderWrapper) {
            sliderWrapper.addEventListener('mouseenter', () => clearInterval(slideInterval));
            sliderWrapper.addEventListener('mouseleave', resetInterval);
        }

        // Swipe touch support
        let touchStartX = 0;
        if (sliderWrapper) {
            sliderWrapper.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
            sliderWrapper.addEventListener('touchend', e => {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 40) { diff > 0 ? nextSlide() : prevSlide(); }
            }, { passive: true });
        }

        // ==================== CALENDAR ====================
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let agendaEvents = [];

        const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const typeIcons = { ujian:'📝', uts:'📝', uas:'📚', rapat:'👥', libur:'🎉', kegiatan:'📌', lainnya:'📋' };
        const typeLabels = { ujian:'Ujian', uts:'UTS', uas:'UAS', rapat:'Rapat', libur:'Libur', kegiatan:'Kegiatan', lainnya:'Lainnya' };
        const typeColors = { ujian:'#EF4444', uts:'#EF4444', uas:'#EF4444', rapat:'#8B5CF6', libur:'#10B981', kegiatan:'#3B82F6', lainnya:'#64748B' };

        function openModal(dateStr) {
            const events = getEventsForDate(dateStr);
            const d = new Date(dateStr);
            document.getElementById('modalDateTitle').textContent =
                `${dayNames[d.getDay()]}, ${d.getDate()} ${monthNames[d.getMonth()]} ${d.getFullYear()}`;

            let html = '';
            if (events.length > 0) {
                events.forEach(ev => {
                    const icon = typeIcons[ev.type] || '📋';
                    const color = typeColors[ev.type] || '#64748B';
                    html += `<div class="modal-event-item">
                        <div class="modal-event-icon" style="background:${color}20;color:${color};">${icon}</div>
                        <div class="modal-event-content">
                            <h4>${ev.title}</h4>
                            <p><i class="far fa-clock" style="margin-right:4px;"></i>${ev.time || 'Seharian'}
                            ${ev.description ? `<br><small style="color:var(--text-muted);">${ev.description}</small>` : ''}</p>
                        </div>
                    </div>`;
                });
            } else {
                html = `<div class="modal-empty"><i class="far fa-calendar"></i>
                    <p style="font-weight:600;margin-bottom:4px;">Tidak ada agenda</p>
                    <p style="font-size:13px;">Klik "Tambah Agenda" untuk menambahkan agenda pada tanggal ini</p>
                </div>`;
            }

            document.getElementById('modalEventList').innerHTML = html;
            document.getElementById('calendarModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('calendarModal').classList.remove('show');
        }

        document.getElementById('calendarModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        async function fetchAgendas() {
            try {
                const r = await fetch('/api/agendas');
                agendaEvents = await r.json();
            } catch(e) {
                agendaEvents = [];
            }
            renderCalendar();
            renderUpcomingEvents();
        }

        function getEventsForDate(d) {
            return agendaEvents.filter(e => {
                const end = e.end || e.start;
                return d >= e.start && d <= end;
            });
        }

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const startDay = firstDay.getDay();
            const monthLen = lastDay.getDate();

            document.getElementById('currentMonth').textContent = monthNames[currentMonth];
            document.getElementById('currentYear').textContent = currentYear;

            const today = new Date();
            const todayStr = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;

            let days = '';
            const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
            const prevDays = startDay === 0 ? 6 : startDay - 1;
            for (let i = prevDays; i >= 0; i--) {
                days += `<div class="calendar-day other-month">${prevMonthLastDay - i}</div>`;
            }
            for (let i = 1; i <= monthLen; i++) {
                const dateStr = `${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                const isToday = dateStr === todayStr;
                const hasEvent = getEventsForDate(dateStr).length > 0;
                let cls = 'calendar-day' + (isToday ? ' today' : '') + (hasEvent ? ' has-event' : '');
                days += `<div class="${cls}" onclick="openModal('${dateStr}')">${i}</div>`;
            }
            const totalCells = Math.ceil((prevDays + monthLen) / 7) * 7;
            for (let i = 1; i <= totalCells - (prevDays + monthLen); i++) {
                days += `<div class="calendar-day other-month">${i}</div>`;
            }
            document.getElementById('calendarDays').innerHTML = days;
        }

        function renderUpcomingEvents() {
            const today = new Date().toISOString().split('T')[0];
            const up = agendaEvents.filter(e => e.start >= today).sort((a,b) => a.start.localeCompare(b.start)).slice(0,3);
            const c = document.getElementById('upcomingEvents');
            if (up.length === 0) {
                c.innerHTML = `<div style="text-align:center;padding:30px;color:var(--text-muted);">
                    <i class="fas fa-calendar" style="font-size:32px;margin-bottom:10px;opacity:0.5;display:block;"></i>
                    <p>Tidak ada agenda mendatang</p></div>`;
                return;
            }
            c.innerHTML = up.map(e => {
                const d = new Date(e.start);
                return `<div class="event-item" style="cursor:pointer;">
                    <div class="event-date">
                        <span class="event-day">${d.getDate()}</span>
                        <span class="event-month">${monthNames[d.getMonth()].substring(0,3)}</span>
                    </div>
                    <div class="event-info">
                        <div class="event-title">${typeIcons[e.type]||'📌'} ${e.title}</div>
                        <div class="event-time"><i class="far fa-clock"></i> ${e.time||'Seharian'}</div>
                    </div>
                    <span class="event-badge ${getBadge(e.type)}">${typeLabels[e.type]||e.type}</span>
                </div>`;
            }).join('');
        }

        function getBadge(t) {
            const b = { ujian:'badge-ujian', uts:'badge-ujian', uas:'badge-ujian', rapat:'badge-rapat', libur:'badge-libur', kegiatan:'badge-kegiatan' };
            return b[t] || 'badge-lainnya';
        }

        function changeMonth(d) {
            currentMonth += d;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            else if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderCalendar();
        }

        // ==================== INIT ====================
        document.addEventListener('DOMContentLoaded', function() {
            initSlider();
            renderCalendar();
            renderUpcomingEvents();
            fetchAgendas();
        });
    </script>
</body>
</html>