<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Siswa - Schoolify Modern</title>
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
            --gradient-indigo: linear-gradient(145deg, #818CF8 0%, #6366F1 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(249,115,22,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

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
        .menu-item.has-submenu { cursor: pointer; }
        .menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }
        .submenu { margin-left: 20px; padding-left: 16px; border-left: 2px solid var(--border-glass); display: none; flex-direction: column; gap: 4px; margin-top: 4px; margin-bottom: 4px; }
        .submenu.show { display: flex; }
        .submenu-item { padding: 10px 16px 10px 20px; border-radius: 14px; display: flex; align-items: center; gap: 12px; color: var(--text-secondary); text-decoration: none; transition: all 0.2s; font-weight: 500; font-size: 14px; }
        .submenu-item i { font-size: 16px; width: 20px; }
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-mint); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px); }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px 32px 8px; position: relative; z-index: 1; }
        .breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 14px; color: var(--text-muted); }
        .breadcrumb a { color: var(--primary-peach); text-decoration: none; font-weight: 600; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb i { font-size: 12px; }
        .profile-header { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); padding: 32px; margin-bottom: 28px; box-shadow: var(--shadow-lg), var(--shadow-diagonal); display: flex; gap: 28px; align-items: start; }
        .profile-avatar-large { width: 120px; height: 120px; border-radius: 28px; border: 4px solid white; box-shadow: var(--shadow-xl); object-fit: cover; }
        .profile-info { flex: 1; }
        .profile-name { font-size: 28px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); margin-bottom: 4px; }
        .profile-nisn { color: var(--primary-peach); font-weight: 600; font-size: 14px; margin-bottom: 12px; }
        .profile-meta { display: flex; gap: 16px; flex-wrap: wrap; }
        .profile-meta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-secondary); background: white; padding: 6px 14px; border-radius: 40px; border: 1px solid var(--border-glass); }
        .profile-meta-item i { color: var(--primary-peach); font-size: 14px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 28px; }
        .content-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); position: relative; }
        .content-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 80px; background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, transparent 100%); pointer-events: none; border-radius: 28px 28px 0 0; }
        .card-header { padding: 22px 28px; border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1; display: flex; align-items: center; gap: 10px; }
        .card-header h3 { font-size: 18px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); }
        .card-header i { color: var(--primary-peach); font-size: 20px; }
        .card-body { padding: 24px 28px; position: relative; z-index: 1; }
        .info-list { display: flex; flex-direction: column; gap: 0; }
        .info-item { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid var(--border-glass); }
        .info-item:last-child { border-bottom: none; }
        .info-label { font-size: 14px; color: var(--text-secondary); font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .info-label i { color: var(--primary-peach); width: 20px; font-size: 14px; }
        .info-value { font-weight: 700; color: var(--text-primary); font-size: 14px; text-align: right; }

        .kkm-table { width: 100%; border-collapse: separate; border-spacing: 0 6px; }
        .kkm-table th { text-align: left; padding: 10px 16px; font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.05em; background: transparent; }
        .kkm-table td { padding: 14px 16px; font-size: 14px; color: var(--text-primary); background: white; border: 1px solid var(--border-glass); border-style: solid none; }
        .kkm-table td:first-child { border-left-style: solid; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
        .kkm-table td:last-child { border-right-style: solid; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }
        .kkm-table tbody tr:hover td { background: var(--bg-glass-hover); }
        .score-badge { padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 13px; display: inline-block; }
        .score-high { background: rgba(16,185,129,0.12); color: #059669; }
        .score-medium { background: rgba(245,158,11,0.12); color: #D97706; }
        .score-low { background: rgba(239,68,68,0.12); color: #DC2626; }

        .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; color: var(--text-secondary); font-weight: 600; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-sm); margin-bottom: 24px; }
        .btn-back:hover { border-color: var(--primary-peach); color: var(--primary-peach); }
        .btn-edit { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: var(--gradient-peach); border: none; border-radius: 14px; color: white; font-weight: 600; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-md); font-size: 14px; }
        .btn-edit:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
        .empty-state { text-align: center; padding: 40px; color: var(--text-muted); }
        .empty-state i { font-size: 40px; margin-bottom: 12px; opacity: 0.4; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 1200px) { .grid-2 { grid-template-columns: 1fr; } .grid-3 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; padding: 20px; } .profile-header { flex-direction: column; align-items: center; text-align: center; } .profile-meta { justify-content: center; } .grid-2, .grid-3 { grid-template-columns: 1fr; } }
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
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.students') }}">Data Siswa</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $student->name }}</span>
        </div>

        <a href="{{ route('admin.students') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
        </a>

        <div class="profile-header">
            <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=120&background=F97316&color=fff&bold=true' }}" alt="{{ $student->name }}" class="profile-avatar-large">
            <div class="profile-info">
                <h1 class="profile-name">{{ $student->name }}</h1>
                <p class="profile-nisn">NISN: {{ $student->nisn ?? '-' }} | NIS: {{ $student->nis ?? '-' }}</p>
                <div class="profile-meta">
                    <span class="profile-meta-item"><i class="fas fa-graduation-cap"></i> {{ $student->schoolClass->name ?? 'Belum ada kelas' }}</span>
                    <span class="profile-meta-item"><i class="fas fa-venus-mars"></i> {{ $student->gender ?? '-' }}</span>
                    <span class="profile-meta-item"><i class="fas fa-envelope"></i> {{ $student->user->email ?? '-' }}</span>
                    <span class="profile-meta-item"><i class="fas fa-phone"></i> {{ $student->phone ?? '-' }}</span>
                </div>
                <div style="margin-top: 16px;">
                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit Data Siswa</a>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="content-card">
                <div class="card-header">
                    <i class="fas fa-user"></i>
                    <h3>Informasi Pribadi</h3>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-id-card"></i> Nama Lengkap</span>
                            <span class="info-value">{{ $student->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-user-tag"></i> Nama Depan</span>
                            <span class="info-value">{{ $student->first_name ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-user-tag"></i> Nama Belakang</span>
                            <span class="info-value">{{ $student->last_name ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-barcode"></i> NISN</span>
                            <span class="info-value">{{ $student->nisn ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-barcode"></i> NIS</span>
                            <span class="info-value">{{ $student->nis ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</span>
                            <span class="info-value">{{ $student->gender ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</span>
                            <span class="info-value">{{ $student->birth_place ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-calendar"></i> Tanggal Lahir</span>
                            <span class="info-value">{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d F Y') : '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-map-pin"></i> Alamat</span>
                            <span class="info-value">{{ $student->address ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-phone"></i> Telepon</span>
                            <span class="info-value">{{ $student->phone ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                            <span class="info-value">{{ $student->user->email ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-clock"></i> Terdaftar Sejak</span>
                            <span class="info-value">{{ $student->created_at ? $student->created_at->format('d F Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <i class="fas fa-chart-line"></i>
                    <h3>Data KKM (Kriteria Ketuntasan Minimal)</h3>
                </div>
                <div class="card-body">
                    @if($kkmData && count($kkmData) > 0)
                        <div style="overflow-x: auto;">
                            <table class="kkm-table">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>KKM</th>
                                        <th>Tingkat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kkmData as $kkm)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $kkm->subject->name ?? 'Mapel #'.$kkm->subject_id }}</td>
                                        <td>
                                            <span class="score-badge 
                                                @if($kkm->score >= 80) score-high
                                                @elseif($kkm->score >= 70) score-medium
                                                @else score-low
                                                @endif">
                                                {{ $kkm->score }}
                                            </span>
                                        </td>
                                        <td>{{ $kkm->grade_level ?? '-' }}</td>
                                        <td>
                                            @if($kkm->score >= 80)
                                                <span style="color: #059669; font-weight: 600;">✓ Tuntas</span>
                                            @elseif($kkm->score >= 70)
                                                <span style="color: #D97706; font-weight: 600;">⚠ Perbaikan</span>
                                            @else
                                                <span style="color: #DC2626; font-weight: 600;">✗ Belum Tuntas</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 20px; padding: 16px; background: rgba(16,185,129,0.06); border-radius: 16px; border: 1px solid rgba(16,185,129,0.15);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="font-size: 13px; color: var(--text-secondary); font-weight: 600;">Rata-rata KKM</p>
                                    <p style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--primary-mint);">
                                        {{ number_format($kkmData->avg('score'), 1) }}
                                    </p>
                                </div>
                                <div>
                                    <p style="font-size: 13px; color: var(--text-secondary); font-weight: 600;">Total Mapel</p>
                                    <p style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary);">
                                        {{ $kkmData->count() }}
                                    </p>
                                </div>
                                <div>
                                    <p style="font-size: 13px; color: var(--text-secondary); font-weight: 600;">Status</p>
                                    <p style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; color: {{ $kkmData->avg('score') >= 75 ? 'var(--primary-mint)' : 'var(--primary-rose)' }};">
                                        {{ $kkmData->avg('score') >= 75 ? 'Tuntas' : 'Belum Tuntas' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-chart-bar"></i>
                            <p>Belum ada data KKM untuk siswa ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid-3">
            <div class="content-card">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 36px; margin-bottom: 8px;">📚</div>
                    <h3 style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif;">{{ $kkmData->count() ?? 0 }}</h3>
                    <p style="color: var(--text-secondary); font-size: 14px;">Mata Pelajaran</p>
                </div>
            </div>
            <div class="content-card">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 36px; margin-bottom: 8px;">📊</div>
                    <h3 style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif;">{{ $kkmData ? number_format($kkmData->avg('score'), 1) : 0 }}</h3>
                    <p style="color: var(--text-secondary); font-size: 14px;">Rata-rata Nilai KKM</p>
                </div>
            </div>
            <div class="content-card">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 36px; margin-bottom: 8px;">🏆</div>
                    <h3 style="font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif;">{{ $kkmData ? $kkmData->where('score', '>=', 80)->count() : 0 }}</h3>
                    <p style="color: var(--text-secondary); font-size: 14px;">Mapel Tuntas</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSubmenu(e) {
            const s = e.nextElementSibling;
            e.classList.toggle('expanded');
            s.classList.toggle('show');
        }
    </script>
</body>
</html>