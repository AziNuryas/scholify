<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Admin - Schoolify Modern</title>
    <!-- Font: Inter + Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-lavender: #8B5CF6; --primary-peach: #F97316; --primary-mint: #10B981; --primary-sky: #3B82F6;
            --primary-rose: #F43F5E; --primary-amber: #F59E0B; --primary-indigo: #6366F1;
            --bg-base: #F8FAFC; --bg-surface: #FFFFFF; --bg-glass: rgba(255, 255, 255, 0.75); --bg-glass-hover: rgba(255, 255, 255, 0.9);
            --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-light: rgba(255, 255, 255, 0.6); --border-glass: rgba(203, 213, 225, 0.5);
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0, 0, 0, 0.06), -5px -5px 15px rgba(255, 255, 255, 0.8);
            --shadow-clay: 6px 6px 12px rgba(0, 0, 0, 0.04), -4px -4px 8px rgba(255, 255, 255, 0.9);
            --shadow-inner: inset 2px 2px 5px rgba(0, 0, 0, 0.02), inset -2px -2px 5px rgba(255, 255, 255, 0.8);
            --sidebar-width: 280px;
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
            --gradient-amber: linear-gradient(145deg, #FBBF24 0%, #F59E0B 100%);
            --gradient-indigo: linear-gradient(145deg, #818CF8 0%, #6366F1 100%);
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
            top: -50%; 
            right: -20%; 
            width: 80%; 
            height: 150%; 
            background: radial-gradient(circle, rgba(168, 85, 247, 0.08) 0%, transparent 70%); 
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
            background: radial-gradient(circle, rgba(251, 146, 60, 0.06) 0%, transparent 70%); 
            pointer-events: none; 
            z-index: 0; 
        }

        /* Sidebar */
        .sidebar { 
            position: fixed; 
            left: 24px; 
            top: 24px; 
            bottom: 24px; 
            width: var(--sidebar-width); 
            background: var(--bg-glass); 
            backdrop-filter: blur(20px) saturate(180%); 
            -webkit-backdrop-filter: blur(20px) saturate(180%); 
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
        
        .sidebar-header .logo-icon { 
            width: 44px; 
            height: 44px; 
            background: var(--gradient-lavender); 
            border-radius: 16px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white; 
            box-shadow: var(--shadow-md), 0 4px 12px rgba(139, 92, 246, 0.3); 
        }
        
        .sidebar-header h2 { 
            font-size: 24px; 
            font-weight: 800; 
            font-family: 'Outfit', sans-serif; 
            background: var(--gradient-lavender); 
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
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            font-weight: 600; 
            font-size: 15px; 
            background: transparent; 
        }
        
        .menu-item i { 
            font-size: 20px; 
            width: 24px; 
            color: var(--text-muted); 
            transition: all 0.3s; 
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
            background: var(--gradient-indigo); 
            color: white; 
            box-shadow: var(--shadow-md), 0 6px 15px rgba(99, 102, 241, 0.3); 
        }
        
        .menu-item.active i { 
            color: white; 
        }
        
        .menu-item.has-submenu { 
            position: relative; 
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
            position: relative; 
            background: transparent; 
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
            background: rgba(139, 92, 246, 0.12); 
            color: var(--primary-lavender); 
            font-weight: 600; 
        }
        
        .submenu-item .badge-new { 
            margin-left: auto; 
            background: var(--gradient-peach); 
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
            background: rgba(248, 113, 113, 0.1); 
            color: var(--primary-rose); 
            border: 1px solid rgba(248, 113, 113, 0.2); 
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
            background: rgba(248, 113, 113, 0.2); 
            color: #E11D48; 
            border-color: rgba(248, 113, 113, 0.4); 
            box-shadow: var(--shadow-sm); 
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: calc(var(--sidebar-width) + 48px);
            position: relative;
            z-index: 1;
        }

        /* Hero Section - Background Gradient Only */
        .hero-section {
            position: relative;
            min-height: 450px;
            overflow: hidden;
            background: linear-gradient(180deg, 
                #0F172A 0%, 
                #1E293B 15%, 
                #334155 30%, 
                #475569 45%, 
                #64748B 60%, 
                #94A3B8 75%, 
                #CBD5E1 90%, 
                #F1F5F9 100%);
        }

        /* Geometric Pattern Overlay */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 60%);
            z-index: 1;
        }

        /* Animated Grid Pattern */
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 20s linear infinite;
            z-index: 1;
        }

        @keyframes gridMove {
            0% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(10px) translateX(5px); }
            100% { transform: translateY(0) translateX(0); }
        }

        /* Floating Particles */
        .particles-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatParticle 8s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; top: 20%; left: 15%; animation-delay: 0s; animation-duration: 6s; }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 60%; left: 80%; animation-delay: 2s; animation-duration: 8s; }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 40%; left: 50%; animation-delay: 4s; animation-duration: 7s; }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 80%; left: 30%; animation-delay: 1s; animation-duration: 9s; }
        .particle:nth-child(5) { width: 2px; height: 2px; top: 10%; left: 70%; animation-delay: 3s; animation-duration: 6.5s; }
        .particle:nth-child(6) { width: 7px; height: 7px; top: 50%; left: 10%; animation-delay: 5s; animation-duration: 7.5s; }

        @keyframes floatParticle {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.3; }
            25% { transform: translateY(-20px) translateX(10px) scale(1.5); opacity: 0.8; }
            50% { transform: translateY(-10px) translateX(-10px) scale(1); opacity: 0.5; }
            75% { transform: translateY(-30px) translateX(5px) scale(1.2); opacity: 0.7; }
        }

        /* Profile Info Overlay - Simple text on gradient */
        .profile-info-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            padding: 40px;
        }

        .profile-info-content {
            text-align: center;
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 35px;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .profile-info-content h2 {
            font-size: 32px;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-info-content .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-info-content .email-text {
            color: rgba(255, 255, 255, 0.8);
            margin-top: 12px;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Main Content */
        .main-content {
            padding: 48px 32px 32px 8px;
            position: relative;
            z-index: 5;
            margin-top: 0;
        }

        .page-header {
            margin-bottom: 32px;
            padding: 32px;
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-glass);
            border-radius: 28px;
            box-shadow: var(--shadow-lg), var(--shadow-diagonal);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }

        .page-header h1 i {
            color: var(--primary-indigo);
            background: white;
            padding: 12px;
            border-radius: 20px;
            box-shadow: var(--shadow-clay);
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 15px;
            margin-top: 8px;
            margin-left: 60px;
            font-weight: 500;
        }

        .alert {
            padding: 16px 24px;
            border-radius: 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(10px);
            font-weight: 500;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #059669;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #DC2626;
        }

        .content-card {
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 28px;
            border: 1px solid var(--border-glass);
            overflow: hidden;
            box-shadow: var(--shadow-lg), var(--shadow-diagonal);
            margin-bottom: 28px;
            position: relative;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
            pointer-events: none;
            border-radius: 28px 28px 0 0;
        }

        .card-body {
            padding: 28px;
            position: relative;
            z-index: 1;
        }

        .card-header {
            padding: 22px 28px;
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
            gap: 10px;
        }

        .card-header h3 i {
            color: var(--primary-indigo);
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            background: white;
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
            transition: all 0.2s;
            box-shadow: var(--shadow-inner);
        }

        .form-control:focus {
            border-color: var(--primary-indigo);
            box-shadow: var(--shadow-sm), 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .grid-inner-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .info-box {
            background: rgba(99, 102, 241, 0.06);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 18px;
            padding: 18px 20px;
        }

        .info-box p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }

        .info-box strong {
            color: var(--primary-indigo);
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 14px;
            padding-top: 24px;
            margin-top: 24px;
            border-top: 1px solid var(--border-glass);
        }

        .btn-secondary {
            padding: 12px 24px;
            background: white;
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: var(--bg-surface);
            border-color: var(--primary-indigo);
            color: var(--primary-indigo);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            padding: 12px 28px;
            background: var(--gradient-indigo);
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: var(--shadow-md), 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg), 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-primary-outline {
            width: 100%;
            margin-top: 20px;
            padding: 14px 20px;
            background: white;
            border: 1px solid var(--border-glass);
            border-radius: 18px;
            color: var(--primary-indigo);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary-outline:hover {
            background: var(--bg-glass-hover);
            border-color: var(--primary-indigo);
            box-shadow: var(--shadow-md);
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-glass);
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-info h4 {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 15px;
            margin-bottom: 6px;
        }

        .activity-info p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .activity-time {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            background: white;
            padding: 6px 14px;
            border-radius: 40px;
            box-shadow: var(--shadow-sm);
        }

        .activity-icon {
            width: 44px;
            height: 44px;
            background: var(--gradient-indigo);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 16px;
            box-shadow: var(--shadow-md);
        }

        .activity-left {
            display: flex;
            align-items: center;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }

        .logo-icon i {
            animation: float 3s ease-in-out infinite;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
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

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-120%); }
            .main-wrapper { margin-left: 24px; }
            .main-content { padding: 20px; }
            .grid-inner-2 { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .btn-secondary, .btn-primary { width: 100%; justify-content: center; }
            .page-header h1 { font-size: 26px; }
            .hero-section { min-height: 350px; }
            .profile-avatar-large { width: 100px; height: 100px; }
            .profile-info-content h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <!-- Sidebar dengan Submenu -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-cloud"></i></div>
            <h2>Schoolify</h2>
        </div>
        
        <div class="sidebar-menu">
            <p class="menu-label">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}" class="menu-item">
                <i class="fas fa-user-graduate"></i><span>Data Siswa</span>
            </a>
            <a href="{{ route('admin.teachers') }}" class="menu-item">
                <i class="fas fa-chalkboard-user"></i><span>Data Guru</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}" class="menu-item">
                <i class="fas fa-calendar-alt"></i><span>Agenda</span>
            </a>
            
            <!-- Manajemen Kelas dengan Submenu -->
            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
                <i class="fas fa-chevron-right chevron"></i>
            </div>
            
            <!-- Submenu Kelas -->
            <div class="submenu" id="classesSubmenu">
                <a href="{{ route('admin.classes') }}" class="submenu-item">
                    <i class="fas fa-list"></i><span>Daftar Kelas</span>
                </a>
                <a href="{{ route('admin.classes.create') }}" class="submenu-item">
                    <i class="fas fa-plus-circle"></i><span>Tambah Kelas</span>
                    <span class="badge-new">New</span>
                </a>
            </div>
            
            <p class="menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="menu-item">
                <i class="fas fa-chart-bar"></i><span>Laporan</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="menu-item">
                <i class="fas fa-cog"></i><span>Pengaturan</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="menu-item active">
                <i class="fas fa-user-circle"></i><span>Profil</span>
            </a>
        </div>

        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Hero Section with Gradient Background -->
        <div class="hero-section" id="heroSection">
            <!-- Floating Particles -->
            <div class="particles-container">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>

            <!-- Simple Profile Info Overlay -->
            <div class="profile-info-overlay">
                <div class="profile-info-content">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Administrator') }}&size=120&background=6366F1&color=fff&bold=true" alt="Profile" class="profile-avatar-large">
                    <h2>{{ auth()->user()->name ?? 'Administrator' }}</h2>
                    <p class="role-badge">
                        <i class="fas fa-crown"></i> Administrator
                    </p>
                    <p class="email-text">
                        <i class="fas fa-envelope"></i>
                        {{ auth()->user()->email ?? 'admin@schoolify.com' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1>
                    <i class="fas fa-edit"></i>
                    Kelola Profil
                </h1>
                <p>Ubah data pribadi dan keamanan akun Anda</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif

            <!-- Personal Information -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-user-edit"></i>Informasi Pribadi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="grid-inner-2">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? 'Administrator') }}" placeholder="Nama lengkap">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? 'admin@schoolify.com') }}" placeholder="Email">
                            </div>
                        </div>
                        <div class="grid-inner-2">
                            <div class="form-group">
                                <label class="form-label">No. Telepon</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '+62-812-3456789') }}" placeholder="Nomor telepon">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', '1990-01-15') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap">{{ old('address', auth()->user()->address ?? 'Jl. Admin No. 123, Bandung, Jawa Barat') }}</textarea>
                        </div>
                        <div class="action-buttons">
                            <button type="reset" class="btn-secondary"><i class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-shield-alt"></i>Keamanan Akun</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini">
                        </div>
                        <div class="grid-inner-2">
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                        <div class="info-box">
                            <p><strong>💡 Tips Keamanan:</strong> Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol minimal 8 karakter.</p>
                        </div>
                        <div class="action-buttons">
                            <button type="reset" class="btn-secondary"><i class="fas fa-times"></i> Batal</button>
                            <button type="submit" class="btn-primary"><i class="fas fa-key"></i> Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="content-card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i>Riwayat Login</h3>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="activity-left">
                            <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
                            <div class="activity-info">
                                <h4>Login Hari Ini</h4>
                                <p>127.0.0.1 • Chrome on Windows</p>
                            </div>
                        </div>
                        <span class="activity-time">09:30</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-left">
                            <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
                            <div class="activity-info">
                                <h4>Login Kemarin</h4>
                                <p>192.168.1.1 • Firefox on Ubuntu</p>
                            </div>
                        </div>
                        <span class="activity-time">14:20</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-left">
                            <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
                            <div class="activity-info">
                                <h4>Login 2 Hari Lalu</h4>
                                <p>192.168.0.5 • Safari on macOS</p>
                            </div>
                        </div>
                        <span class="activity-time">10:15</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Parallax Effect for Hero Section
        const heroSection = document.getElementById('heroSection');
        
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            const heroHeight = heroSection.offsetHeight;
            
            // Parallax effect pada hero section
            if (scrollPosition < heroHeight) {
                const parallaxSpeed = 0.3;
                heroSection.style.backgroundPosition = `center ${scrollPosition * parallaxSpeed}px`;
            }
        });

        // Sidebar Submenu Toggle
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            element.classList.toggle('expanded');
            submenu.classList.toggle('show');
        }

        // Auto-expand submenu jika ada item aktif
        document.addEventListener('DOMContentLoaded', function() {
            const activeSubmenuItem = document.querySelector('.submenu-item.active');
            if (activeSubmenuItem) {
                const submenu = activeSubmenuItem.closest('.submenu');
                const parentMenuItem = submenu.previousElementSibling;
                if (parentMenuItem && parentMenuItem.classList.contains('has-submenu')) {
                    parentMenuItem.classList.add('expanded');
                    submenu.classList.add('show');
                }
            }
        });
    </script>
</body>
</html>