<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal Pelajaran - Schoolify</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS SAMA SEPERTI YANG ANDA PUNYA UNTUK HALAMAN DAFTAR JADWAL */
        :root {
            --primary-lavender:#8B5CF6; --primary-peach:#F97316; --primary-mint:#10B981;
            --primary-sky:#3B82F6; --primary-rose:#F43F5E; --primary-amber:#F59E0B;
            --bg-glass:rgba(255,255,255,0.75); --bg-glass-hover:rgba(255,255,255,0.9);
            --text-primary:#0F172A; --text-secondary:#475569; --text-muted:#94A3B8;
            --border-glass:rgba(203,213,225,0.5);
            --shadow-sm:0 4px 6px -1px rgba(0,0,0,0.05);
            --shadow-md:0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg:0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-xl:0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal:8px 8px 20px rgba(0,0,0,0.06),-5px -5px 15px rgba(255,255,255,0.8);
            --shadow-clay:6px 6px 12px rgba(0,0,0,0.04),-4px -4px 8px rgba(255,255,255,0.9);
            --sidebar-width:280px;
            --gradient-lavender:linear-gradient(145deg,#A78BFA 0%,#8B5CF6 100%);
            --gradient-peach:linear-gradient(145deg,#FB923C 0%,#F97316 100%);
            --gradient-mint:linear-gradient(145deg,#34D399 0%,#10B981 100%);
            --gradient-sky:linear-gradient(145deg,#60A5FA 0%,#3B82F6 100%);
            --gradient-rose:linear-gradient(145deg,#FB7185 0%,#F43F5E 100%);
            --gradient-amber:linear-gradient(145deg,#FBBF24 0%,#F59E0B 100%);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:linear-gradient(145deg,#F1F5F9 0%,#E2E8F0 100%);color:var(--text-primary);min-height:100vh;position:relative;}
        body::before{content:'';position:fixed;top:-50%;right:-20%;width:80%;height:150%;background:radial-gradient(circle,rgba(168,85,247,0.08) 0%,transparent 70%);pointer-events:none;z-index:0;}
        body::after{content:'';position:fixed;bottom:-30%;left:-10%;width:70%;height:120%;background:radial-gradient(circle,rgba(251,146,60,0.06) 0%,transparent 70%);pointer-events:none;z-index:0;}

        /* Sidebar */
        .sidebar{position:fixed;left:24px;top:24px;bottom:24px;width:var(--sidebar-width);background:var(--bg-glass);backdrop-filter:blur(20px) saturate(180%);border:1px solid var(--border-glass);border-radius:32px;z-index:1000;padding:24px 16px;display:flex;flex-direction:column;overflow-y:auto;box-shadow:var(--shadow-xl),var(--shadow-diagonal);}
        .sidebar-header{display:flex;align-items:center;gap:12px;padding:0 12px 32px;}
        .sidebar-header .logo-icon{width:44px;height:44px;background:var(--gradient-lavender);border-radius:16px;display:flex;align-items:center;justify-content:center;color:white;box-shadow:var(--shadow-md),0 4px 12px rgba(139,92,246,0.3);}
        .sidebar-header h2{font-size:24px;font-weight:800;font-family:'Outfit',sans-serif;background:var(--gradient-lavender);-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:-0.02em;}
        .menu-label{font-size:11px;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);font-weight:700;margin:24px 12px 10px;}
        .sidebar-menu{display:flex;flex-direction:column;gap:6px;flex-grow:1;}
        .menu-item{padding:12px 16px;border-radius:18px;display:flex;align-items:center;gap:14px;color:var(--text-secondary);text-decoration:none;transition:all 0.3s;font-weight:600;font-size:15px;background:transparent;cursor:pointer;}
        .menu-item i{font-size:20px;width:24px;color:var(--text-muted);}
        .menu-item:hover{background:var(--bg-glass-hover);color:var(--primary-lavender);}
        .menu-item:hover i{color:var(--primary-lavender);}
        .menu-item.active{background:var(--gradient-lavender);color:white;}
        .menu-item.active i{color:white;}
        .menu-item.has-submenu .chevron{margin-left:auto;font-size:14px;transition:transform 0.3s;}
        .menu-item.has-submenu.expanded .chevron{transform:rotate(90deg);}
        .submenu{margin-left:20px;padding-left:16px;border-left:2px solid var(--border-glass);display:none;flex-direction:column;gap:4px;margin-top:4px;margin-bottom:4px;}
        .submenu.show{display:flex;}
        .submenu-item{padding:10px 16px 10px 20px;border-radius:14px;display:flex;align-items:center;gap:12px;color:var(--text-secondary);text-decoration:none;transition:all 0.2s;font-weight:500;font-size:14px;}
        .submenu-item:hover{background:var(--bg-glass);color:var(--primary-lavender);}
        .submenu-item.active{background:rgba(139,92,246,0.12);color:var(--primary-lavender);font-weight:600;}
        .badge-new{margin-left:auto;background:var(--gradient-peach);color:white;font-size:10px;padding:3px 8px;border-radius:20px;font-weight:700;}
        .logout-container{margin-top:auto;padding-top:24px;border-top:1px solid var(--border-glass);}
        .btn-logout{width:100%;padding:14px;background:rgba(248,113,113,0.1);color:var(--primary-rose);border:1px solid rgba(248,113,113,0.2);border-radius:18px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:all 0.2s;font-size:15px;}
        .btn-logout:hover{background:rgba(248,113,113,0.2);}

        /* Main */
        .main-content{margin-left:calc(var(--sidebar-width) + 48px);padding:24px 32px 32px 8px;position:relative;z-index:1;}
        .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;background:var(--bg-glass);backdrop-filter:blur(20px) saturate(180%);padding:18px 32px;border-radius:28px;border:1px solid var(--border-glass);box-shadow:var(--shadow-lg),var(--shadow-diagonal);}
        .page-title h1{font-size:28px;font-weight:800;font-family:'Outfit',sans-serif;letter-spacing:-0.02em;}
        .page-title p{color:var(--text-secondary);font-size:14px;margin-top:4px;font-weight:500;}
        .user-actions{display:flex;align-items:center;gap:16px;}
        .user-avatar{width:48px;height:48px;background:var(--gradient-lavender);border-radius:18px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:white;box-shadow:var(--shadow-md);}

        /* Alert */
        .alert{padding:16px 24px;border-radius:20px;margin-bottom:24px;display:flex;align-items:center;gap:14px;font-weight:500;}
        .alert-success{background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);color:#059669;}
        .alert-danger{background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.3);color:#E11D48;}

        /* Stats */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:28px;}
        .stat-card{background:var(--bg-glass);backdrop-filter:blur(16px) saturate(180%);border-radius:24px;padding:20px;border:1px solid var(--border-glass);box-shadow:var(--shadow-clay),var(--shadow-diagonal);position:relative;overflow:hidden;}
        .stat-card::before{content:'';position:absolute;top:-50%;right:-30%;width:120px;height:120px;background:radial-gradient(circle,rgba(255,255,255,0.8) 0%,transparent 70%);border-radius:50%;opacity:0.4;pointer-events:none;}
        .stat-card .s-icon{width:48px;height:48px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;}
        .stat-card .s-icon i{font-size:22px;color:white;}
        .stat-card h3{font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;font-weight:700;margin-bottom:6px;}
        .stat-card .s-num{font-size:30px;font-weight:800;font-family:'Outfit',sans-serif;letter-spacing:-0.02em;}
        .s-icon-total{background:var(--gradient-lavender);}
        .s-icon-aktif{background:var(--gradient-mint);}
        .s-icon-nonaktif{background:var(--gradient-rose);}
        .s-icon-hari{background:var(--gradient-amber);}

        /* Filter Card */
        .filter-card{background:var(--bg-glass);backdrop-filter:blur(16px) saturate(180%);border-radius:24px;padding:20px 24px;border:1px solid var(--border-glass);box-shadow:var(--shadow-clay);margin-bottom:24px;}
        .filter-row{display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;}
        .filter-group{display:flex;flex-direction:column;gap:6px;flex:1;min-width:160px;}
        .filter-group label{font-size:12px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.04em;}
        .form-select,.form-input{padding:10px 14px;border-radius:14px;border:1px solid var(--border-glass);background:white;font-size:14px;color:var(--text-primary);font-family:'Inter',sans-serif;outline:none;transition:all 0.2s;width:100%;}
        .form-select:focus,.form-input:focus{border-color:var(--primary-lavender);box-shadow:0 0 0 3px rgba(139,92,246,0.1);}
        .btn{padding:10px 20px;border-radius:14px;border:none;font-weight:600;font-size:14px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;text-decoration:none;font-family:'Inter',sans-serif;}
        .btn-primary{background:var(--gradient-lavender);color:white;box-shadow:var(--shadow-md),0 4px 12px rgba(139,92,246,0.25);}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
        .btn-secondary{background:white;color:var(--text-secondary);border:1px solid var(--border-glass);}
        .btn-secondary:hover{background:var(--bg-glass-hover);}
        .btn-danger{background:rgba(244,63,94,0.1);color:var(--primary-rose);border:1px solid rgba(244,63,94,0.2);}
        .btn-danger:hover{background:rgba(244,63,94,0.2);}
        .btn-sm{padding:7px 14px;font-size:12px;border-radius:10px;}
        .btn-icon{width:34px;height:34px;padding:0;border-radius:10px;justify-content:center;}

        /* Content Card */
        .content-card{background:var(--bg-glass);backdrop-filter:blur(20px) saturate(180%);border-radius:28px;border:1px solid var(--border-glass);overflow:hidden;box-shadow:var(--shadow-lg),var(--shadow-diagonal);margin-bottom:24px;}
        .card-header{padding:20px 28px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-glass);}
        .card-header h2{font-size:18px;font-weight:700;font-family:'Outfit',sans-serif;color:var(--text-primary);display:flex;align-items:center;gap:10px;}
        .card-header h2 i{color:var(--primary-lavender);}

        /* Table */
        .table-wrapper{overflow-x:auto;padding:0 8px 8px;}
        .data-table{width:100%;border-collapse:separate;border-spacing:0 8px;}
        .data-table th{text-align:left;padding:12px 20px;font-size:11px;text-transform:uppercase;color:var(--text-muted);font-weight:700;letter-spacing:0.05em;}
        .data-table td{padding:16px 20px;font-size:14px;color:var(--text-primary);background:white;border:1px solid var(--border-glass);border-style:solid none;}
        .data-table td:first-child{border-left-style:solid;border-top-left-radius:18px;border-bottom-left-radius:18px;}
        .data-table td:last-child{border-right-style:solid;border-top-right-radius:18px;border-bottom-right-radius:18px;}
        .data-table tbody tr:hover td{background:var(--bg-glass-hover);box-shadow:var(--shadow-sm);}
        .data-table .action-cell{display:flex;gap:6px;align-items:center;}

        /* Badges */
        .badge{padding:4px 12px;border-radius:30px;font-size:11px;font-weight:600;display:inline-block;}
        .badge-aktif{background:rgba(16,185,129,0.12);color:#10B981;border:1px solid rgba(16,185,129,0.2);}
        .badge-nonaktif{background:rgba(100,116,139,0.12);color:#64748B;border:1px solid rgba(100,116,139,0.2);}
        .badge-hari{padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;}
        .hari-senin{background:rgba(59,130,246,0.12);color:#3B82F6;}
        .hari-selasa{background:rgba(16,185,129,0.12);color:#10B981;}
        .hari-rabu{background:rgba(139,92,246,0.12);color:#8B5CF6;}
        .hari-kamis{background:rgba(249,115,22,0.12);color:#F97316;}
        .hari-jumat{background:rgba(244,63,94,0.12);color:#F43F5E;}
        .hari-sabtu{background:rgba(245,158,11,0.12);color:#F59E0B;}

        /* Jam visual */
        .jam-cell{display:flex;flex-direction:column;gap:2px;}
        .jam-main{font-weight:700;font-size:14px;color:var(--text-primary);}
        .jam-durasi{font-size:11px;color:var(--text-muted);}

        /* Kelas + guru cell */
        .kelas-guru-cell{display:flex;flex-direction:column;gap:3px;}
        .kelas-name{font-weight:700;color:var(--text-primary);}
        .guru-name{font-size:12px;color:var(--text-muted);}

        /* Empty */
        .empty-state{text-align:center;padding:60px;color:var(--text-muted);}
        .empty-state i{font-size:48px;margin-bottom:16px;display:block;opacity:0.3;}

        /* Pagination */
        .pagination-wrap{padding:16px 28px;border-top:1px solid var(--border-glass);display:flex;justify-content:space-between;align-items:center;}
        .pagination{display:flex;gap:6px;}
        .page-item .page-link{padding:8px 14px;border-radius:10px;background:white;border:1px solid var(--border-glass);color:var(--text-secondary);text-decoration:none;font-size:13px;font-weight:600;transition:all 0.2s;}
        .page-item.active .page-link{background:var(--gradient-lavender);color:white;border-color:transparent;}
        .page-item .page-link:hover{background:var(--bg-glass-hover);}
        .page-info{font-size:13px;color:var(--text-muted);}

        /* Delete modal */
        .modal-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(8px);z-index:9999;display:none;align-items:center;justify-content:center;}
        .modal-overlay.show{display:flex;}
        .modal-box{background:var(--bg-glass);backdrop-filter:blur(20px);border:1px solid var(--border-glass);border-radius:28px;padding:32px;width:90%;max-width:420px;box-shadow:var(--shadow-xl);text-align:center;animation:slideUp 0.3s ease-out;}
        .modal-box .modal-icon{width:64px;height:64px;background:rgba(244,63,94,0.1);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;color:var(--primary-rose);}
        .modal-box h3{font-size:20px;font-weight:700;font-family:'Outfit',sans-serif;margin-bottom:8px;}
        .modal-box p{color:var(--text-secondary);font-size:14px;margin-bottom:24px;}
        .modal-actions{display:flex;gap:12px;justify-content:center;}
        @keyframes slideUp{from{opacity:0;transform:translateY(20px) scale(0.95)}to{opacity:1;transform:translateY(0) scale(1)}}
        ::-webkit-scrollbar{width:6px;height:6px;}
        ::-webkit-scrollbar-thumb{background:var(--border-glass);border-radius:10px;}

        @media(max-width:992px){
            .sidebar{transform:translateX(-120%);}
            .main-content{margin-left:0;padding:16px;padding-bottom:80px;}
            .stats-grid{grid-template-columns:repeat(2,1fr);}
        }
        @media(max-width:576px){
            .stats-grid{grid-template-columns:1fr 1fr;}
            .filter-row{flex-direction:column;}
            .top-bar{flex-direction:column;gap:12px;align-items:flex-start;}
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
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
        <div class="menu-item has-submenu expanded" onclick="toggleSubmenu(this)">
            <i class="fas fa-door-open"></i><span>Manajemen Kelas</span><i class="fas fa-chevron-right chevron"></i>
        </div>
        <div class="submenu show">
            <a href="{{ route('admin.classes') }}" class="submenu-item"><i class="fas fa-list"></i><span>Daftar Kelas</span></a>
        </div>
        <div class="menu-item has-submenu expanded" onclick="toggleSubmenu(this)">
            <i class="fas fa-calendar-week"></i><span>Jadwal</span><i class="fas fa-chevron-right chevron"></i>
        </div>
        <div class="submenu show">
            <a href="{{ route('admin.jadwal.index') }}" class="submenu-item active"><i class="fas fa-table"></i><span>Jadwal Pelajaran</span></a>
            <a href="{{ route('admin.jadwal.create') }}" class="submenu-item"><i class="fas fa-plus-circle"></i><span>Tambah Jadwal</span></a>
        </div>
        <p class="menu-label">Lainnya</p>
        <a href="{{ route('admin.reports') }}" class="menu-item"><i class="fas fa-chart-bar"></i><span>Laporan</span></a>
        <a href="{{ route('admin.settings') }}" class="menu-item"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
        <a href="{{ route('admin.profile') }}" class="menu-item"><i class="fas fa-user-circle"></i><span>Profil</span></a>
    </div>
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST">@csrf
            <button class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>
</div>

{{-- MAIN --}}
<div class="main-content">

    {{-- Top Bar --}}
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-calendar-week" style="color:var(--primary-lavender);margin-right:10px;"></i>Jadwal Pelajaran</h1>
            <p>Kelola jadwal mengajar seluruh kelas</p>
        </div>
        <div class="user-actions">
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
            <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="s-icon s-icon-total"><i class="fas fa-calendar-week"></i></div>
            <h3>Total Jadwal</h3>
            <div class="s-num">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="s-icon s-icon-aktif"><i class="fas fa-check-circle"></i></div>
            <h3>Aktif</h3>
            <div class="s-num" style="color:var(--primary-mint);">{{ $stats['aktif'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="s-icon s-icon-nonaktif"><i class="fas fa-times-circle"></i></div>
            <h3>Nonaktif</h3>
            <div class="s-num" style="color:var(--primary-rose);">{{ $stats['nonaktif'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="s-icon s-icon-hari"><i class="fas fa-sun"></i></div>
            <h3>Jadwal Hari Ini</h3>
            <div class="s-num" style="color:var(--primary-amber);">{{ $stats['hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form action="{{ route('admin.jadwal.index') }}" method="GET">
            <div class="filter-row">
                <div class="filter-group" style="max-width:240px;">
                    <label><i class="fas fa-search" style="margin-right:4px;"></i> Cari</label>
                    <input type="text" name="search" class="form-input" placeholder="Nama guru, mapel, ruangan..." value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <label>Hari</label>
                    <select name="hari" class="form-select">
                        <option value="">Semua Hari</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Kelas</label>
                    <select name="kelas" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($classes ?? [] as $k)
                        <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Guru</label>
                    <select name="guru" class="form-select">
                        <option value="">Semua Guru</option>
                        @foreach($teachers ?? [] as $g)
                        <option value="{{ $g->id }}" {{ request('guru') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select">
                        <option value="">Semua</option>
                        @foreach($tahunAjaranList ?? [] as $ta)
                        <option value="{{ $ta }}" {{ request('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end;padding-bottom:0;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary"><i class="fas fa-redo"></i></a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="content-card">
        <div class="card-header">
            <h2><i class="fas fa-table"></i> Daftar Jadwal ({{ $jadwal->total() ?? 0 }})</h2>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas / Guru</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal ?? [] as $j)
                    <tr>
                        <td style="font-weight:700;color:var(--text-muted);">{{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $loop->index + 1 }}</td>
                        <td>
                            <span class="badge-hari hari-{{ strtolower($j->hari) }}">{{ $j->hari }}</span>
                        </td>
                        <td>
                            <div class="jam-cell">
                                <span class="jam-main">{{ substr($j->jam_mulai,0,5) }} – {{ substr($j->jam_selesai,0,5) }}</span>
                                <span class="jam-durasi">{{ $j->durasi }}</span>
                            </div>
                        </td>
                        <td style="font-weight:600;">{{ $j->mata_pelajaran }}</td>
                        <td>
                            <div class="kelas-guru-cell">
                                <span class="kelas-name">{{ $j->schoolClass->name ?? '-' }}</span>
                                <span class="guru-name"><i class="fas fa-chalkboard-user" style="margin-right:4px;"></i>{{ $j->guru->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ $j->ruangan ?? '-' }}</td>
                        <td style="text-align:center;">{{ $j->semester }}</td>
                        <td>{{ $j->tahun_ajaran }}</td>
                        <td>
                            <span class="badge badge-{{ $j->status }}">{{ ucfirst($j->status) }}</span>
                        </td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('admin.jadwal.show', $j) }}" class="btn btn-sm btn-icon btn-secondary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.jadwal.edit', $j) }}" class="btn btn-sm btn-icon" style="background:rgba(59,130,246,0.1);color:var(--primary-sky);border:1px solid rgba(59,130,246,0.2);" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button onclick="confirmDelete({{ $j->id }}, '{{ $j->mata_pelajaran }} - {{ $j->hari }}')"
                                    class="btn btn-sm btn-icon btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <p style="font-weight:600;margin-bottom:6px;">Belum ada jadwal pelajaran</p>
                                <p style="font-size:13px;margin-bottom:16px;">Klik tombol "Tambah Jadwal" untuk mulai menambahkan jadwal.</p>
                                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jadwal</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($jadwal) && $jadwal->hasPages())
        <div class="pagination-wrap">
            <span class="page-info">
                Menampilkan {{ $jadwal->firstItem() }}–{{ $jadwal->lastItem() }} dari {{ $jadwal->total() }} data
            </span>
            <div class="pagination">
                @if($jadwal->onFirstPage())
                    <span class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></span>
                @else
                    <span class="page-item"><a class="page-link" href="{{ $jadwal->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></span>
                @endif

                @foreach($jadwal->getUrlRange(max(1, $jadwal->currentPage()-2), min($jadwal->lastPage(), $jadwal->currentPage()+2)) as $page => $url)
                    <span class="page-item {{ $page == $jadwal->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </span>
                @endforeach

                @if($jadwal->hasMorePages())
                    <span class="page-item"><a class="page-link" href="{{ $jadwal->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></span>
                @else
                    <span class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Jadwal?</h3>
        <p id="deleteModalDesc">Jadwal ini akan dihapus permanen dan tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button onclick="closeDeleteModal()" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</button>
            <form id="deleteForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleSubmenu(e){
        const s=e.nextElementSibling;
        e.classList.toggle('expanded');
        s.classList.toggle('show');
    }
    function confirmDelete(id, label){
        document.getElementById('deleteModalDesc').textContent =
            `Jadwal "${label}" akan dihapus permanen.`;
        document.getElementById('deleteForm').action = `/admin/jadwal/${id}`;
        document.getElementById('deleteModal').classList.add('show');
    }
    function closeDeleteModal(){
        document.getElementById('deleteModal').classList.remove('show');
    }
    document.getElementById('deleteModal').addEventListener('click', function(e){
        if(e.target===this) closeDeleteModal();
    });
</script>
</body>
</html>