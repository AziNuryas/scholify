<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Siswa - Schoolify Modern</title>
    <!-- Font: Inter + Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-peach: #F97316; --primary-mint: #10B981; --primary-rose: #F43F5E; --primary-sky: #3B82F6;
            --bg-glass: rgba(255, 255, 255, 0.75); --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5); --sidebar-width: 280px;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05); --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1); --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-diagonal: 8px 8px 20px rgba(0,0,0,0.06), -5px -5px 15px rgba(255,255,255,0.8);
            --shadow-clay: 6px 6px 12px rgba(0,0,0,0.04), -4px -4px 8px rgba(255,255,255,0.9);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            --gradient-peach: linear-gradient(145deg, #FB923C 0%, #F97316 100%);
            --gradient-lavender: linear-gradient(145deg, #A78BFA 0%, #8B5CF6 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(145deg, #F1F5F9 0%, #E2E8F0 100%); color: var(--text-primary); min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; top: -50%; right: -20%; width: 80%; height: 150%; background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%); pointer-events: none; z-index: 0; }
        body::after { content: ''; position: fixed; bottom: -30%; left: -10%; width: 70%; height: 120%; background: radial-gradient(circle, rgba(249,115,22,0.06) 0%, transparent 70%); pointer-events: none; z-index: 0; }

        /* Sidebar */
        .sidebar { position: fixed; left: 24px; top: 24px; bottom: 24px; width: var(--sidebar-width); background: var(--bg-glass); backdrop-filter: blur(20px) saturate(180%); border: 1px solid var(--border-glass); border-radius: 32px; z-index: 1000; padding: 24px 16px; display: flex; flex-direction: column; overflow-y: auto; box-shadow: var(--shadow-xl), var(--shadow-diagonal); }
        .sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 12px 32px; }
        .sidebar-header .logo-icon { width: 44px; height: 44px; background: var(--gradient-lavender); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: var(--shadow-md), 0 4px 12px rgba(139,92,246,0.3); }
        .sidebar-header h2 { font-size: 24px; font-weight: 800; font-family: 'Outfit', sans-serif; background: var(--gradient-lavender); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.02em; }
        .menu-label { font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin: 24px 12px 10px; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 6px; flex-grow: 1; }
        .menu-item { padding: 12px 16px; border-radius: 18px; display: flex; align-items: center; gap: 14px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s; font-weight: 600; font-size: 15px; background: transparent; }
        .menu-item i { font-size: 20px; width: 24px; color: var(--text-muted); }
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
        .badge-new { margin-left: auto; background: var(--gradient-peach); color: white; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 700; box-shadow: var(--shadow-sm); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; backdrop-filter: blur(10px); }
        .btn-logout:hover { background: rgba(248,113,113,0.2); color: #E11D48; border-color: rgba(248,113,113,0.4); box-shadow: var(--shadow-sm); }

        /* Main Content */
        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px 32px 8px; position: relative; z-index: 1; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-header-left h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 12px; }
        .page-header-left h1 i { color: var(--primary-peach); background: white; padding: 12px; border-radius: 20px; box-shadow: var(--shadow-clay); }
        .btn-back { padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; box-shadow: var(--shadow-sm); }
        .btn-back:hover { border-color: var(--primary-peach); color: var(--primary-peach); }

        /* Form Tabs */
        .form-tabs { display: flex; gap: 4px; margin-bottom: 24px; border-bottom: 1px solid var(--border-glass); padding-bottom: 4px; }
        .tab-btn { padding: 12px 24px; background: transparent; border: none; color: var(--text-muted); font-weight: 600; font-size: 14px; cursor: pointer; border-radius: 14px 14px 0 0; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
        .tab-btn i { font-size: 16px; }
        .tab-btn:hover { color: var(--primary-peach); background: rgba(249,115,22,0.05); }
        .tab-btn.active { color: var(--primary-peach); border-bottom: 3px solid var(--primary-peach); background: transparent; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .form-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg), var(--shadow-diagonal); }
        .form-header { padding: 24px 32px; border-bottom: 1px solid var(--border-glass); }
        .form-header h2 { font-size: 22px; font-weight: 700; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 10px; }
        .form-header h2 i { color: var(--primary-peach); }
        .form-body { padding: 32px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 10px; color: var(--text-primary); }
        .form-label i { color: var(--primary-peach); margin-right: 6px; }
        .form-control { width: 100%; padding: 14px 18px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; font-size: 14px; color: var(--text-primary); outline: none; box-shadow: var(--shadow-inner); }
        .form-control:focus { border-color: var(--primary-peach); box-shadow: var(--shadow-sm), 0 0 0 3px rgba(249,115,22,0.1); }
        .form-control::placeholder { color: var(--text-muted); }
        select.form-control { cursor: pointer; }
        .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
        .alert-error { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; display: flex; align-items: center; gap: 14px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-secondary { padding: 14px 28px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; box-shadow: var(--shadow-sm); }
        .btn-secondary:hover { border-color: var(--primary-peach); color: var(--primary-peach); }
        .btn-primary { padding: 14px 32px; background: var(--gradient-peach); border: none; border-radius: 16px; color: white; font-weight: 600; cursor: pointer; box-shadow: var(--shadow-md), 0 4px 15px rgba(249,115,22,0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg), 0 8px 25px rgba(249,115,22,0.4); }
        .btn-danger { padding: 14px 28px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 16px; color: #ef4444; font-weight: 600; cursor: pointer; margin-right: auto; }
        .btn-danger:hover { background: rgba(239,68,68,0.08); border-color: #ef4444; }

        @keyframes float { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-4px); } }
        .logo-icon i { animation: float 3s ease-in-out infinite; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-glass); border-radius: 10px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-120%); }
            .main-content { margin-left: 24px; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
            .form-tabs { flex-wrap: wrap; }
            .tab-btn { flex: 1; justify-content: center; }
            .form-actions { flex-direction: column; }
            .btn-secondary, .btn-primary, .btn-danger { width: 100%; justify-content: center; }
            .btn-danger { margin-right: 0; }
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
        <div class="page-header">
            <div class="page-header-left">
                <h1><i class="fas fa-edit"></i>Edit Siswa</h1>
            </div>
            <a href="{{ route('admin.students') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        @if($errors->any())
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> Mohon periksa kembali input Anda.</div>
        @endif

        <div class="form-card">
            <div class="form-header">
                <h2><i class="fas fa-user-graduate"></i>Form Edit Siswa - {{ $student->name }}</h2>
            </div>
            <div class="form-body">
                <!-- Tabs -->
                <div class="form-tabs">
                    <button type="button" class="tab-btn active" onclick="switchTab('account')"><i class="fas fa-user-circle"></i> Akun</button>
                    <button type="button" class="tab-btn" onclick="switchTab('personal')"><i class="fas fa-id-card"></i> Data Pribadi</button>
                    <button type="button" class="tab-btn" onclick="switchTab('academic')"><i class="fas fa-graduation-cap"></i> Akademik</button>
                </div>

                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Tab 1: Akun -->
                    <div id="tab-account" class="tab-content active">
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" placeholder="Nama lengkap siswa" required>
                                @error('name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Nama Depan</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" placeholder="Nama depan">
                                @error('first_name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Nama Belakang</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" placeholder="Nama belakang">
                                @error('last_name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-envelope"></i> Email <span style="color: #ef4444;">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}" placeholder="Email siswa" required>
                                @error('email')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-lock"></i> Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Data Pribadi -->
                    <div id="tab-personal" class="tab-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                <select name="gender" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('gender', $student->user->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $student->user->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-map-pin"></i> Tempat Lahir</label>
                                <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $student->birth_place) }}" placeholder="Kota/Kabupaten">
                                @error('birth_place')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}">
                                @error('birth_date')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-phone"></i> No. Telepon</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" placeholder="0812-3456-7890">
                                @error('phone')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap">{{ old('address', $student->address) }}</textarea>
                                @error('address')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Akademik -->
                    <div id="tab-academic" class="tab-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> NISN</label>
                                <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $student->nisn) }}" placeholder="Nomor Induk Siswa Nasional">
                                @error('nisn')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> NIS</label>
                                <input type="text" name="nis" class="form-control" value="{{ old('nis', $student->nis) }}" placeholder="Nomor Induk Sekolah">
                                @error('nis')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-door-open"></i> Kelas</label>
                                <select name="class_id" class="form-control">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->grade_level }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-danger" onclick="document.getElementById('deleteForm').submit();">
                            <i class="fas fa-trash"></i> Hapus Siswa
                        </button>
                        <a href="{{ route('admin.students') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                    </div>
                </form>
                
                <!-- Hidden Delete Form -->
                <form id="deleteForm" action="{{ route('admin.students.delete', $student->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Hapus siswa {{ $student->name }} secara permanen?')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle submenu
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            element.classList.toggle('expanded');
            submenu.classList.toggle('show');
        }

        // Switch tabs
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.closest('.tab-btn').classList.add('active');
        }

        // Auto-expand submenu if active
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