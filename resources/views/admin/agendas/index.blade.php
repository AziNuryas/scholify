<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda - Schoolify Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-indigo: #6366F1; --primary-rose: #F43F5E; --primary-mint: #10B981; --primary-amber: #F59E0B;
            --bg-glass: rgba(255, 255, 255, 0.75); --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5); --sidebar-width: 280px;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05); --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1); --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0,0,0,0.06), -5px -5px 15px rgba(255,255,255,0.8);
            --gradient-indigo: linear-gradient(145deg, #818CF8 0%, #6366F1 100%);
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .menu-label { font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 15px; }
        .menu-item i { font-size: 20px; width: 24px; }
        .menu-item:hover { background: rgba(255,255,255,0.9); color: var(--primary-indigo); }
        .menu-item.active { background: var(--gradient-indigo); color: white; }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; }

        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .page-header h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: var(--primary-indigo); background: white; padding: 12px; border-radius: 20px; box-shadow: var(--shadow-sm); }
        .btn-primary { padding: 14px 28px; background: var(--gradient-indigo); border: none; border-radius: 16px; color: white; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: var(--shadow-md); }

        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: var(--bg-glass); backdrop-filter: blur(16px); border-radius: 20px; padding: 20px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-sm); }
        .stat-card h3 { font-size: 13px; color: var(--text-muted); margin-bottom: 8px; }
        .stat-card .value { font-size: 32px; font-weight: 800; color: var(--primary-indigo); }

        .content-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg); }
        .table-wrapper { overflow-x: auto; padding: 0 8px 8px; }
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .data-table th { text-align: left; padding: 14px 20px; font-size: 11px; text-transform: uppercase; color: var(--text-muted); }
        .data-table td { padding: 16px 20px; background: white; border: 1px solid var(--border-glass); border-style: solid none; }
        .data-table td:first-child { border-left-style: solid; border-radius: 16px 0 0 16px; }
        .data-table td:last-child { border-right-style: solid; border-radius: 0 16px 16px 0; }

        .badge { padding: 4px 12px; border-radius: 30px; font-size: 11px; font-weight: 600; }
        .badge-ujian { background: rgba(239,68,68,0.12); color: #EF4444; }
        .badge-rapat { background: rgba(139,92,246,0.12); color: #8B5CF6; }
        .badge-libur { background: rgba(16,185,129,0.12); color: #10B981; }
        .badge-kegiatan { background: rgba(59,130,246,0.12); color: #3B82F6; }
        .badge-lainnya { background: rgba(100,116,139,0.12); color: #64748B; }
        .badge-active { background: rgba(16,185,129,0.12); color: #10B981; }
        .badge-inactive { background: rgba(100,116,139,0.12); color: #64748B; }
        .badge-ongoing { background: rgba(245,158,11,0.12); color: #F59E0B; }

        .action-buttons { display: flex; gap: 8px; }
        .btn-action { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: white; border: 1px solid var(--border-glass); color: var(--text-secondary); text-decoration: none; transition: all 0.2s; }
        .btn-action:hover { border-color: var(--primary-indigo); color: var(--primary-indigo); }
        .btn-delete { color: #EF4444; }
        .btn-delete:hover { border-color: #EF4444; background: rgba(239,68,68,0.08); }

        .pagination { display: flex; justify-content: center; padding: 20px; }
        .pagination nav { display: flex; gap: 8px; }
        .pagination a, .pagination span { padding: 8px 16px; border-radius: 10px; background: white; color: var(--text-secondary); text-decoration: none; border: 1px solid var(--border-glass); }
        .pagination .active { background: var(--gradient-indigo); color: white; border-color: transparent; }

        @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; } .stats-grid { grid-template-columns: 1fr; } .page-header { flex-direction: column; gap: 16px; align-items: flex-start; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header"><div class="logo-icon"><i class="fas fa-cloud"></i></div><h2>Schoolify</h2></div>
        <div class="sidebar-menu">
            <p class="menu-label">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="menu-item"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="{{ route('admin.students') }}" class="menu-item"><i class="fas fa-user-graduate"></i><span>Data Siswa</span></a>
            <a href="{{ route('admin.teachers') }}" class="menu-item"><i class="fas fa-chalkboard-user"></i><span>Data Guru</span></a>
            <a href="{{ route('admin.agendas.index') }}" class="menu-item active"><i class="fas fa-calendar-alt"></i><span>Agenda</span></a>
            <a href="{{ route('admin.classes') }}" class="menu-item"><i class="fas fa-door-open"></i><span>Manajemen Kelas</span></a>
            <p class="menu-label">Lainnya</p>
            <a href="{{ route('admin.reports') }}" class="menu-item"><i class="fas fa-chart-bar"></i><span>Laporan</span></a>
            <a href="{{ route('admin.settings') }}" class="menu-item"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
            <a href="{{ route('admin.profile') }}" class="menu-item"><i class="fas fa-user-circle"></i><span>Profil</span></a>
        </div>
        <div class="logout-container"><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button></form></div>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-calendar-alt"></i>Agenda</h1>
            <a href="{{ route('admin.agendas.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Agenda</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card"><h3><i class="fas fa-calendar"></i> Total Agenda</h3><div class="value">{{ $stats['total'] }}</div></div>
            <div class="stat-card"><h3><i class="fas fa-check-circle"></i> Agenda Aktif</h3><div class="value">{{ $stats['active'] }}</div></div>
            <div class="stat-card"><h3><i class="fas fa-clock"></i> Akan Datang</h3><div class="value">{{ $stats['upcoming'] }}</div></div>
            <div class="stat-card"><h3><i class="fas fa-play-circle"></i> Sedang Berlangsung</h3><div class="value">{{ $stats['ongoing'] }}</div></div>
        </div>

        <div class="content-card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agendas as $agenda)
                        <tr>
                            <td><strong>{{ $agenda->title }}</strong></td>
                            <td><span class="badge {{ $agenda->type_badge_class }}">{{ $agenda->type_label }}</span></td>
                            <td>{{ $agenda->formatted_date }}</td>
                            <td>{{ $agenda->formatted_time }}</td>
                            <td><span class="badge">{{ ucfirst($agenda->target_role) }}</span></td>
                            <td>
                                @if(!$agenda->is_active)
                                    <span class="badge badge-inactive"><i class="fas fa-pause"></i> Nonaktif</span>
                                @elseif($agenda->is_ongoing)
                                    <span class="badge badge-ongoing"><i class="fas fa-play"></i> Berlangsung</span>
                                @else
                                    <span class="badge badge-active"><i class="fas fa-check"></i> Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="btn-action"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.agendas.delete', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="text-align: center; padding: 40px;"><i class="fas fa-calendar" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i><p>Belum ada agenda. Klik "Tambah Agenda" untuk memulai.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($agendas->hasPages())
            <div class="pagination">{{ $agendas->links() }}</div>
            @endif
        </div>
    </div>
</body>
</html>