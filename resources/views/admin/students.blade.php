<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Siswa - Schoolify Modern</title>
    <!-- Font: Inter + Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(249,115,22,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        /* Sidebar - Glassmorphism */
        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; }
        .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s; font-weight: 600; font-size: 15px; background: transparent; }
        .menu-item i { font-size: 20px; width: 24px; color: var(--text-muted); transition: all 0.3s; }
        .menu-item:hover { background: var(--bg-glass-hover); color: var(--primary-peach); box-shadow: var(--shadow-sm); }
        .menu-item:hover i { color: var(--primary-peach); }
        .menu-item.active { background: var(--gradient-peach); color: white; box-shadow: var(--shadow-md), 0 6px 15px rgba(249,115,22,0.3); }
        .menu-item.active i { color: white; }

        /* Submenu */
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
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-title h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 12px; letter-spacing: -0.02em; }
        .page-title h1 i { color: var(--primary-peach); background: white; padding: 12px; border-radius: 20px; box-shadow: var(--shadow-clay); }
        .page-title p { color: var(--text-secondary); font-size: 15px; margin-top: 8px; margin-left: 60px; font-weight: 500; }
        .user-actions { display: flex; align-items: center; gap: 20px; }
        .date-badge { padding: 10px 18px; background: white; border-radius: 40px; font-size: 14px; font-weight: 500; color: var(--text-secondary); box-shadow: var(--shadow-sm); }
        .user-avatar { width: 48px; height: 48px; background: var(--gradient-peach); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px; box-shadow: var(--shadow-md); }

        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }
        .alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 36px; }
        .stat-card { background: var(--bg-glass); backdrop-filter: blur(16px); border-radius: 24px; padding: 22px; border: 1px solid var(--border-glass); transition: all 0.3s; position: relative; overflow: hidden; box-shadow: var(--shadow-clay), var(--shadow-diagonal); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; }
        .stat-card:nth-child(1)::before { background: var(--gradient-peach); }
        .stat-card:nth-child(2)::before { background: var(--gradient-mint); }
        .stat-card:nth-child(3)::before { background: var(--gradient-sky); }
        .stat-card:nth-child(4)::before { background: var(--gradient-lavender); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-xl); }
        .stat-card-content { display: flex; align-items: center; justify-content: space-between; }
        .stat-info h3 { font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; margin-bottom: 6px; }
        .stat-number { font-size: 34px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .stat-icon { width: 52px; height: 52px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-clay); color: white; }
        .stat-card:nth-child(1) .stat-icon { background: var(--gradient-peach); }
        .stat-card:nth-child(2) .stat-icon { background: var(--gradient-mint); }
        .stat-card:nth-child(3) .stat-icon { background: var(--gradient-sky); }
        .stat-card:nth-child(4) .stat-icon { background: var(--gradient-lavender); }
        .stat-icon i { font-size: 26px; }

        .content-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); position: relative; }
        .content-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 100px; background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, transparent 100%); pointer-events: none; border-radius: 28px 28px 0 0; }
        .card-header { padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1; }
        .card-header h2 { font-size: 22px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .btn-primary { padding: 12px 24px; background: var(--gradient-peach); border: none; border-radius: 14px; color: white; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: var(--shadow-md), 0 4px 12px rgba(249,115,22,0.3); text-decoration: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg), 0 8px 20px rgba(249,115,22,0.4); }

        .search-container { padding: 20px 28px; background: transparent; border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1; }
        .search-box { position: relative; max-width: 360px; }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .search-box input { width: 100%; padding: 12px 16px 12px 46px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; font-size: 14px; color: var(--text-primary); outline: none; box-shadow: var(--shadow-inner); }
        .search-box input:focus { border-color: var(--primary-peach); box-shadow: var(--shadow-sm), 0 0 0 3px rgba(249,115,22,0.1); }

        .table-wrapper { overflow-x: auto; position: relative; z-index: 1; padding: 0 8px 8px; }
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .data-table th { text-align: left; padding: 14px 20px; font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em; }
        .data-table td { padding: 18px 20px; font-size: 14px; color: var(--text-primary); background: white; border: 1px solid var(--border-glass); border-style: solid none; }
        .data-table td:first-child { border-left-style: solid; border-top-left-radius: 18px; border-bottom-left-radius: 18px; }
        .data-table td:last-child { border-right-style: solid; border-top-right-radius: 18px; border-bottom-right-radius: 18px; }
        .data-table tbody tr:hover td { background: var(--bg-glass-hover); box-shadow: var(--shadow-sm); }

        .student-info { display: flex; align-items: center; gap: 14px; }
        .student-avatar { width: 44px; height: 44px; border-radius: 14px; border: 2px solid white; box-shadow: var(--shadow-sm); object-fit: cover; }
        .student-name { font-weight: 700; color: var(--text-primary); }
        .badge-active { padding: 6px 14px; border-radius: 40px; font-size: 12px; font-weight: 600; background: rgba(16,185,129,0.12); color: var(--primary-mint); border: 1px solid rgba(16,185,129,0.2); }

        .action-buttons { display: flex; gap: 8px; justify-content: center; }
        .btn-action { width: 38px; height: 38px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid var(--border-glass); background: white; color: var(--text-secondary); cursor: pointer; transition: 0.2s; box-shadow: var(--shadow-sm); text-decoration: none; }
        .btn-action:hover { border-color: var(--primary-peach); color: var(--primary-peach); background: var(--bg-glass-hover); }
        .btn-delete:hover { border-color: var(--primary-rose); color: var(--primary-rose); background: rgba(244,63,94,0.08); }

        .empty-state { text-align: center; padding: 60px; color: var(--text-muted); }
        .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.4; background: var(--gradient-peach); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .pagination { display: flex; justify-content: space-between; align-items: center; padding: 20px 28px; border-top: 1px solid var(--border-glass); }
        .pagination-info { color: var(--text-secondary); font-size: 14px; }
        .pagination-buttons { display: flex; gap: 10px; }
        .pagination-btn { padding: 10px 18px; border: 1px solid var(--border-glass); background: white; color: var(--text-secondary); border-radius: 12px; cursor: pointer; transition: all 0.2s; font-weight: 500; text-decoration: none; box-shadow: var(--shadow-sm); }
        .pagination-btn:hover:not(:disabled) { background: var(--gradient-peach); color: white; border-color: transparent; }
        .pagination-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; padding: 20px; } .stats-grid { grid-template-columns: 1fr; } .top-bar { flex-direction: column; gap: 16px; align-items: flex-start; } .card-header { flex-direction: column; gap: 16px; align-items: flex-start; } }
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
        <a href="{{ route('admin.students') }}" class="menu-item active"><i class="fas fa-user-graduate"></i><span>Data Siswa</span></a>
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

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1><i class="fas fa-user-graduate"></i>Data Siswa</h1>
                <p>Kelola data seluruh siswa sekolah dengan mudah</p>
            </div>
            <div class="user-actions">
                <span class="date-badge"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ date('l, d F Y') }}</span>
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info"><h3>Total Siswa</h3><div class="stat-number">{{ $students->total() ?? 0 }}</div></div>
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info"><h3>Siswa Aktif</h3><div class="stat-number">{{ $students->count() ?? 0 }}</div></div>
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info"><h3>Total Kelas</h3><div class="stat-number">{{ \App\Models\Classes::count() }}</div></div>
                    <div class="stat-icon"><i class="fas fa-door-open"></i></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info"><h3>Laporan Baru</h3><div class="stat-number">Buat</div></div>
                    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-list" style="margin-right: 10px; color: var(--primary-peach);"></i>Daftar Siswa</h2>
                <a href="{{ route('admin.students.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Siswa</a>
            </div>
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, NISN, atau email...">
                </div>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td style="font-weight: 600; color: var(--primary-peach);">{{ $student->nisn ?? '-' }}</td>
                            <td>
                                <div class="student-info">
                                    <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=F97316&color=fff&bold=true' }}" class="student-avatar">
                                    <span class="student-name">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td>{{ $student->user->email ?? '-' }}</td>
                            <td>{{ $student->schoolClass->name ?? '-' }}</td>
                            <td><span class="badge-active">✨ Aktif</span></td>
                            <td style="text-align: center;">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn-action"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" onsubmit="return confirm('Hapus siswa {{ $student->name }}?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-cloud"></i>
                                <p>Belum ada data siswa. Klik "Tambah Siswa" untuk memulai.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($students->hasPages())
            <div class="pagination">
                <div class="pagination-info">Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} dari {{ $students->total() }} siswa</div>
                <div class="pagination-buttons">
                    @if($students->onFirstPage())
                        <button class="pagination-btn" disabled>← Sebelumnya</button>
                    @else
                        <a href="{{ $students->previousPageUrl() }}" class="pagination-btn">← Sebelumnya</a>
                    @endif
                    
                    @if($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="pagination-btn">Berikutnya →</a>
                    @else
                        <button class="pagination-btn" disabled>Berikutnya →</button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <script>
        function toggleSubmenu(e) {
            const s = e.nextElementSibling;
            e.classList.toggle('expanded');
            s.classList.toggle('show');
        }
        
        document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
            let v = e.target.value.toLowerCase();
            document.querySelectorAll('.data-table tbody tr').forEach(r => {
                if (r.querySelector('.empty-state')) return;
                r.style.display = r.textContent.toLowerCase().includes(v) ? '' : 'none';
            });
        });
    </script>
</body>
</html>