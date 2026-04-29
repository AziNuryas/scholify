<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Kelas - Schoolify Modern</title>
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
            --gradient-amber: linear-gradient(145deg, #FBBF24 0%, #F59E0B 100%);
            --gradient-mint: linear-gradient(145deg, #34D399 0%, #10B981 100%);
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
            --gradient-rose: linear-gradient(145deg, #FB7185 0%, #F43F5E 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(16,185,129,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; }
        .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s; font-weight: 600; font-size: 15px; }
        .menu-item i { font-size: 20px; width: 24px; color: var(--text-muted); }
        .menu-item:hover { background: var(--bg-glass-hover); color: var(--primary-amber); box-shadow: var(--shadow-sm); }
        .menu-item:hover i { color: var(--primary-amber); }
        .menu-item.active { background: var(--gradient-amber); color: white; box-shadow: var(--shadow-md), 0 6px 15px rgba(245,158,11,0.3); }
        .menu-item.active i { color: white; }
        .menu-item.has-submenu { cursor: pointer; }
        .menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }
        .submenu { margin-left: 20px; padding-left: 16px; border-left: 2px solid var(--border-glass); display: none; flex-direction: column; gap: 4px; margin-top: 4px; margin-bottom: 4px; }
        .submenu.show { display: flex; }
        .submenu-item { padding: 10px 16px 10px 20px; border-radius: 14px; display: flex; align-items: center; gap: 12px; color: var(--text-secondary); text-decoration: none; transition: all 0.2s; font-weight: 500; font-size: 14px; }
        .submenu-item i { font-size: 16px; width: 20px; }
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-amber); }
        .submenu-item.active { background: rgba(245,158,11,0.12); color: var(--primary-amber); font-weight: 600; }
        .badge-new { margin-left: auto; background: var(--gradient-peach); color: white; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 700; box-shadow: var(--shadow-sm); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px); }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px 32px 8px; position: relative; z-index: 1; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-header-left h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 12px; letter-spacing: -0.02em; }
        .page-header-left h1 i { color: var(--primary-amber); background: white; padding: 12px; border-radius: 20px; box-shadow: var(--shadow-clay); }
        .page-header-left p { color: var(--text-secondary); font-size: 15px; margin-top: 8px; margin-left: 60px; font-weight: 500; }
        .btn-back { padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; transition: all 0.2s; text-decoration: none; box-shadow: var(--shadow-sm); }
        .btn-back:hover { border-color: var(--primary-amber); color: var(--primary-amber); box-shadow: var(--shadow-md); }

        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; backdrop-filter: blur(10px); font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #059669; }
        .alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
        
        .form-card { background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); position: relative; }
        .form-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 100px; background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, transparent 100%); pointer-events: none; border-radius: 28px 28px 0 0; }
        .form-header { padding: 20px 28px; border-bottom: 1px solid var(--border-glass); position: relative; z-index: 1; }
        .form-header h2 { font-size: 20px; font-weight: 700; font-family: 'Outfit', sans-serif; color: var(--text-primary); display: flex; align-items: center; gap: 10px; }
        .form-header h2 i { color: var(--primary-amber); }
        .form-header p { color: var(--text-muted); font-size: 13px; margin-top: 4px; }
        .form-body { padding: 24px; position: relative; z-index: 1; }

        .class-info-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25); border-radius: 40px; padding: 6px 16px; margin-bottom: 20px; }
        .class-info-badge i { color: var(--primary-amber); }
        .class-info-badge span { color: var(--text-primary); font-weight: 600; }

        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-group { margin-bottom: 0; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
        .form-label i { color: var(--primary-amber); margin-right: 6px; }
        .form-control { width: 100%; padding: 12px 16px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; font-size: 14px; color: var(--text-primary); outline: none; transition: all 0.2s; box-shadow: var(--shadow-inner); }
        .form-control:focus { border-color: var(--primary-amber); box-shadow: var(--shadow-sm), 0 0 0 3px rgba(245,158,11,0.1); }
        select.form-control { cursor: pointer; background: white; }
        .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }

        .info-box { background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.15); border-radius: 16px; padding: 14px 18px; margin-bottom: 20px; }
        .info-box p { color: var(--text-secondary); font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .info-box i { color: var(--primary-amber); font-size: 16px; }

        .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-glass); }
        .btn-secondary { padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 14px; color: var(--text-secondary); font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; text-decoration: none; box-shadow: var(--shadow-sm); }
        .btn-secondary:hover { border-color: var(--primary-amber); color: var(--primary-amber); box-shadow: var(--shadow-md); }
        .btn-primary { padding: 12px 28px; background: var(--gradient-amber); border: none; border-radius: 14px; color: white; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: var(--shadow-md), 0 4px 15px rgba(245,158,11,0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg), 0 8px 25px rgba(245,158,11,0.4); }
        .btn-danger { padding: 12px 24px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 14px; color: #ef4444; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; margin-right: auto; }
        .btn-danger:hover { background: rgba(239,68,68,0.08); border-color: #ef4444; }

        /* Add Student Section */
        .add-student-section { background: white; border-radius: 16px; padding: 20px; margin-bottom: 20px; border: 1px solid var(--border-glass); }
        .add-student-title { font-weight: 600; color: var(--text-primary); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .add-student-title i { color: var(--primary-mint); }
        .add-student-form { display: flex; gap: 12px; align-items: flex-end; }
        .add-student-form .form-group { flex: 1; margin-bottom: 0; }
        .btn-add { padding: 12px 24px; background: var(--gradient-mint); border: none; border-radius: 14px; color: white; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-sm); white-space: nowrap; }
        .btn-add:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* Student List */
        .student-list { display: flex; flex-direction: column; gap: 8px; max-height: 280px; overflow-y: auto; }
        .student-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: white; border-radius: 14px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-sm); }
        .student-info { display: flex; align-items: center; gap: 12px; }
        .student-avatar { width: 36px; height: 36px; border-radius: 10px; border: 2px solid white; box-shadow: var(--shadow-sm); object-fit: cover; }
        .student-detail h4 { font-weight: 700; color: var(--text-primary); font-size: 14px; margin-bottom: 2px; }
        .student-detail p { font-size: 11px; color: var(--text-muted); }
        .btn-remove-student { width: 32px; height: 32px; border-radius: 8px; background: transparent; border: 1px solid var(--border-glass); color: var(--primary-rose); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-remove-student:hover { background: rgba(239,68,68,0.08); border-color: #ef4444; }
        .empty-students { text-align: center; padding: 30px 20px; color: var(--text-muted); }
        .student-count { font-size: 13px; color: var(--text-muted); margin-top: 12px; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 1200px) { .grid-2 { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-120%); }
            .main-content { margin-left: 24px; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
            .add-student-form { flex-direction: column; align-items: stretch; }
            .btn-add { justify-content: center; }
        }
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
        
        <div class="menu-item has-submenu expanded">
            <i class="fas fa-door-open"></i><span>Manajemen Kelas</span>
            <i class="fas fa-chevron-right chevron"></i>
        </div>
        <div class="submenu show">
            <a href="{{ route('admin.classes') }}" class="submenu-item"><i class="fas fa-list"></i><span>Daftar Kelas</span></a>
            <a href="{{ route('admin.classes.create') }}" class="submenu-item"><i class="fas fa-plus-circle"></i><span>Tambah Kelas</span><span class="badge-new">New</span></a>
            <a href="{{ route('admin.classes.edit', $class->id) }}" class="submenu-item active"><i class="fas fa-edit"></i><span>Edit Kelas</span></a>
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
        <div class="page-header">
            <div class="page-header-left"><h1><i class="fas fa-edit"></i>Edit Kelas</h1><p>Perbarui data kelas dan kelola siswa</p></div>
            <a href="{{ route('admin.classes') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
        </div>

        @if($errors->any())
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Mohon periksa kembali input Anda.</div>
        @endif

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="grid-2">
            <!-- Kolom Kiri: Form Edit Kelas -->
            <div class="form-card">
                <div class="form-header"><h2><i class="fas fa-door-open"></i>Informasi Kelas</h2><p>Perbarui data kelas</p></div>
                <div class="form-body">
                    <div class="class-info-badge">
                        <i class="fas fa-hashtag"></i><span>ID: {{ $class->id }}</span>
                        <span style="margin: 0 8px; color: var(--border-glass);">|</span>
                        <i class="fas fa-calendar"></i><span>{{ $class->created_at->format('d/m/Y') }}</span>
                        <span style="margin: 0 8px; color: var(--border-glass);">|</span>
                        <i class="fas fa-users"></i><span>{{ $classStudents->count() }} Siswa</span>
                    </div>
                    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag"></i> Nama Kelas <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}" required>
                                @error('name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-layer-group"></i> Tingkat <span style="color: #ef4444;">*</span></label>
                                <select name="grade" class="form-control" required>
                                    @foreach($grades as $grade)<option value="{{ $grade }}" {{ old('grade', $class->grade_level) == $grade ? 'selected' : '' }}>Kelas {{ $grade }}</option>@endforeach
                                </select>
                                @error('grade')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-chalkboard-teacher"></i> Wali Kelas</label>
                                <select name="homeroom_teacher_id" class="form-control">
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('homeroom_teacher_id', $class->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-danger" onclick="document.getElementById('deleteForm').submit();"><i class="fas fa-trash"></i> Hapus</button>
                            <a href="{{ route('admin.classes') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
                            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                    <form id="deleteForm" action="{{ route('admin.classes.delete', $class->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Hapus kelas {{ $class->name }}?')">@csrf @method('DELETE')</form>
                </div>
            </div>

            <!-- Kolom Kanan: Kelola Siswa -->
            <div class="form-card">
                <div class="form-header"><h2><i class="fas fa-users"></i>Kelola Siswa</h2><p>Siswa di kelas {{ $class->name }}</p></div>
                <div class="form-body">
                    <!-- Form Tambah Siswa -->
                    <div class="add-student-section">
                        <div class="add-student-title"><i class="fas fa-user-plus"></i> Tambah Siswa ke Kelas</div>
                        <form action="{{ route('admin.classes.add-student', $class->id) }}" method="POST" class="add-student-form">
                            @csrf
                            <div class="form-group">
                                <select name="student_id" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nisn ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn-add"><i class="fas fa-plus"></i> Tambah</button>
                        </form>
                    </div>

                    <!-- Daftar Siswa -->
                    <div style="font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-list" style="color: var(--primary-amber);"></i> 
                        Daftar Siswa ({{ $classStudents->count() }})
                    </div>
                    <div class="student-list">
                        @forelse($classStudents as $student)
                        <div class="student-item">
                            <div class="student-info">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=F59E0B&color=fff&bold=true" class="student-avatar">
                                <div class="student-detail">
                                    <h4>{{ $student->name }}</h4>
                                    <p>{{ $student->nisn ?? 'NISN: -' }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.classes.remove-student', [$class->id, $student->id]) }}" method="POST" onsubmit="return confirm('Keluarkan {{ $student->name }} dari kelas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-remove-student"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                        @empty
                        <div class="empty-students">
                            <i class="fas fa-users" style="font-size: 36px; opacity: 0.3; margin-bottom: 8px;"></i>
                            <p>Belum ada siswa. Tambahkan siswa di atas.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.has-submenu').forEach(item => { item.addEventListener('click', function() { this.classList.toggle('expanded'); this.nextElementSibling.classList.toggle('show'); }); });
    </script>
</body>
</html>