<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Agenda - Schoolify Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-indigo: #6366F1; --primary-rose: #F43F5E; --primary-mint: #10B981;
            --bg-glass: rgba(255, 255, 255, 0.75); --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5); --sidebar-width: 280px;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05); --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1); --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            --gradient-indigo: linear-gradient(145deg, #818CF8 0%, #6366F1 100%);
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; box-shadow: var(--shadow-xl); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .menu-label { font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 15px; }
        .menu-item:hover { background: rgba(255,255,255,0.9); color: var(--primary-indigo); }
        .menu-item.active { background: var(--gradient-indigo); color: white; }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; }

        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .page-header h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: var(--primary-indigo); background: white; padding: 12px; border-radius: 20px; }
        .btn-back { padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; }

        .form-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg); }
        .form-header { padding: 24px 32px; border-bottom: 1px solid var(--border-glass); }
        .form-header h2 { font-size: 22px; font-weight: 700; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 10px; }
        .form-header h2 i { color: var(--primary-indigo); }
        .form-body { padding: 32px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 10px; }
        .form-label i { color: var(--primary-indigo); margin-right: 6px; }
        .form-control { width: 100%; padding: 14px 18px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; font-size: 14px; outline: none; box-shadow: var(--shadow-inner); }
        .form-control:focus { border-color: var(--primary-indigo); }
        select.form-control, textarea.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
        .form-hint { font-size: 12px; color: var(--text-muted); margin-top: 6px; }
        .alert-error { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; display: flex; align-items: center; gap: 14px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-secondary { padding: 14px 28px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; }
        .btn-primary { padding: 14px 32px; background: var(--gradient-indigo); border: none; border-radius: 16px; color: white; font-weight: 600; cursor: pointer; }
        .btn-danger { padding: 14px 28px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 16px; color: #ef4444; font-weight: 600; cursor: pointer; margin-right: auto; }
        .btn-danger:hover { background: rgba(239,68,68,0.08); }

        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; } .form-grid { grid-template-columns: 1fr; } .form-group.full-width { grid-column: span 1; } .form-actions { flex-direction: column; } .btn-secondary, .btn-primary, .btn-danger { width: 100%; justify-content: center; } .btn-danger { margin-right: 0; } }
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
            <h1><i class="fas fa-edit"></i>Edit Agenda</h1>
            <a href="{{ route('admin.agendas.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        @if($errors->any())
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> Mohon periksa kembali input Anda.</div>
        @endif

        <div class="form-card">
            <div class="form-header"><h2><i class="fas fa-calendar-edit"></i>Form Edit Agenda</h2></div>
            <div class="form-body">
                <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fas fa-heading"></i> Judul Agenda <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $agenda->title) }}" required>
                            @error('title')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-tag"></i> Tipe Agenda <span style="color: #ef4444;">*</span></label>
                            <select name="type" class="form-control" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="uts" {{ old('type', $agenda->type) == 'uts' ? 'selected' : '' }}>📝 UTS</option>
                                <option value="uas" {{ old('type', $agenda->type) == 'uas' ? 'selected' : '' }}>📚 UAS</option>
                                <option value="ujian" {{ old('type', $agenda->type) == 'ujian' ? 'selected' : '' }}>✏️ Ujian Sekolah</option>
                                <option value="rapat" {{ old('type', $agenda->type) == 'rapat' ? 'selected' : '' }}>👥 Rapat</option>
                                <option value="libur" {{ old('type', $agenda->type) == 'libur' ? 'selected' : '' }}>🎉 Libur</option>
                                <option value="kegiatan" {{ old('type', $agenda->type) == 'kegiatan' ? 'selected' : '' }}>📌 Kegiatan</option>
                                <option value="lainnya" {{ old('type', $agenda->type) == 'lainnya' ? 'selected' : '' }}>📋 Lainnya</option>
                            </select>
                            @error('type')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-users"></i> Target <span style="color: #ef4444;">*</span></label>
                            <select name="target_role" class="form-control" required>
                                <option value="semua" {{ old('target_role', $agenda->target_role) == 'semua' ? 'selected' : '' }}>🌍 Semua</option>
                                <option value="admin" {{ old('target_role', $agenda->target_role) == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                                <option value="guru" {{ old('target_role', $agenda->target_role) == 'guru' ? 'selected' : '' }}>👨‍🏫 Guru</option>
                                <option value="siswa" {{ old('target_role', $agenda->target_role) == 'siswa' ? 'selected' : '' }}>🎓 Siswa</option>
                            </select>
                            @error('target_role')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Mulai <span style="color: #ef4444;">*</span></label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $agenda->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $agenda->end_date ? $agenda->end_date->format('Y-m-d') : '') }}">
                            <p class="form-hint">Kosongkan jika hanya 1 hari</p>
                            @error('end_date')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-clock"></i> Jam Mulai</label>
                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $agenda->start_time) }}">
                            @error('start_time')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-clock"></i> Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $agenda->end_time) }}">
                            @error('end_time')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Lokasi</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $agenda->location) }}" placeholder="Contoh: Aula Sekolah">
                            @error('location')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi</label>
                            <textarea name="description" class="form-control" placeholder="Deskripsi atau catatan tambahan">{{ old('description', $agenda->description) }}</textarea>
                            @error('description')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $agenda->is_active) == '1' ? 'selected' : '' }}>✅ Aktif</option>
                                <option value="0" {{ old('is_active', $agenda->is_active) == '0' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-danger" onclick="document.getElementById('deleteForm').submit();"><i class="fas fa-trash"></i> Hapus Agenda</button>
                        <a href="{{ route('admin.agendas.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                    </div>
                </form>
                <form id="deleteForm" action="{{ route('admin.agendas.delete', $agenda->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Hapus agenda ini?')">@csrf @method('DELETE')</form>
            </div>
        </div>
    </div>
</body>
</html>