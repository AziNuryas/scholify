<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Guru - Schoolify Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-sky: #3B82F6; --primary-rose: #F43F5E; --primary-mint: #10B981; --primary-amber: #F59E0B;
            --bg-glass: rgba(255, 255, 255, 0.75); --text-primary: #0F172A; --text-secondary: #475569; --text-muted: #94A3B8;
            --border-glass: rgba(203, 213, 225, 0.5); --sidebar-width: 280px;
            --shadow-sm: 0 4px 6px -1px rgba(0,0,0,0.05); --shadow-md: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1); --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-inner: inset 2px 2px 5px rgba(0,0,0,0.02), inset -2px -2px 5px rgba(255,255,255,0.8);
            --gradient-sky: linear-gradient(145deg, #60A5FA 0%, #3B82F6 100%);
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
        .menu-item:hover { background: rgba(255,255,255,0.9); color: var(--primary-sky); }
        .menu-item.active { background: var(--gradient-sky); color: white; }
        .menu-item.has-submenu { cursor: pointer; }
        .menu-item.has-submenu .chevron { margin-left: auto; font-size: 14px; transition: transform 0.3s; }
        .menu-item.has-submenu.expanded .chevron { transform: rotate(90deg); }
        .submenu { margin-left: 20px; padding-left: 16px; border-left: 2px solid var(--border-glass); display: none; flex-direction: column; gap: 4px; margin-top: 4px; margin-bottom: 4px; }
        .submenu.show { display: flex; }
        .submenu-item { padding: 10px 16px 10px 20px; border-radius: 14px; display: flex; align-items: center; gap: 12px; color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 14px; }
        .submenu-item:hover { background: var(--bg-glass); color: var(--primary-sky); }
        .badge-new { margin-left: auto; background: linear-gradient(145deg, #FB923C 0%, #F97316 100%); color: white; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 700; box-shadow: var(--shadow-sm); }
        .logout-container { margin-top: auto; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-logout { width: 100%; padding: 14px; background: rgba(248,113,113,0.1); color: var(--primary-rose); border: 1px solid rgba(248,113,113,0.2); border-radius: 18px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; }
        
        .main-content { margin-left: calc(var(--sidebar-width) + 48px); padding: 24px 32px; position: relative; z-index: 1; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-header-left h1 { font-size: 32px; font-weight: 800; font-family: 'Outfit', sans-serif; display: flex; align-items: center; gap: 12px; }
        .page-header-left h1 i { color: var(--primary-sky); background: white; padding: 12px; border-radius: 20px; }
        .btn-back { padding: 12px 24px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; }
        .btn-back:hover { border-color: var(--primary-sky); color: var(--primary-sky); }
        
        .form-card { background: var(--bg-glass); backdrop-filter: blur(20px); border-radius: 28px; border: 1px solid var(--border-glass); overflow: hidden; box-shadow: var(--shadow-lg); }
        .form-header { padding: 24px 32px; border-bottom: 1px solid var(--border-glass); }
        .form-header h2 { font-size: 22px; font-weight: 700; font-family: 'Outfit', sans-serif; }
        .form-body { padding: 32px; }
        
        .form-tabs { display: flex; gap: 4px; margin-bottom: 24px; border-bottom: 1px solid var(--border-glass); padding-bottom: 4px; }
        .tab-btn { padding: 12px 24px; background: transparent; border: none; color: var(--text-muted); font-weight: 600; font-size: 14px; cursor: pointer; border-radius: 14px 14px 0 0; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
        .tab-btn i { font-size: 16px; }
        .tab-btn:hover { color: var(--primary-sky); background: rgba(59,130,246,0.05); }
        .tab-btn.active { color: var(--primary-sky); border-bottom: 3px solid var(--primary-sky); background: transparent; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 10px; }
        .form-label i { color: var(--primary-sky); margin-right: 6px; }
        .form-control { width: 100%; padding: 14px 18px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; font-size: 14px; outline: none; box-shadow: var(--shadow-inner); }
        .form-control:focus { border-color: var(--primary-sky); }
        select.form-control { cursor: pointer; }
        .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
        .alert { padding: 16px 24px; border-radius: 20px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px; }
        .alert-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #DC2626; }
        .info-box { background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.15); border-radius: 16px; padding: 16px 20px; margin-bottom: 24px; }
        .info-box p { color: var(--text-secondary); font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .info-box i { color: var(--primary-sky); font-size: 18px; }
        
        .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-glass); }
        .btn-secondary { padding: 14px 28px; background: white; border: 1px solid var(--border-glass); border-radius: 16px; color: var(--text-secondary); font-weight: 600; text-decoration: none; }
        .btn-primary { padding: 14px 32px; background: var(--gradient-sky); border: none; border-radius: 16px; color: white; font-weight: 600; cursor: pointer; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-danger { padding: 14px 28px; background: transparent; border: 1px solid rgba(239,68,68,0.4); border-radius: 16px; color: #ef4444; font-weight: 600; cursor: pointer; margin-right: auto; }
        .btn-danger:hover { background: rgba(239,68,68,0.08); }
        
        @media (max-width: 768px) { .sidebar { transform: translateX(-120%); } .main-content { margin-left: 24px; } .form-grid { grid-template-columns: 1fr; } .form-group.full-width { grid-column: span 1; } .form-tabs { flex-wrap: wrap; } .tab-btn { flex: 1; justify-content: center; } }
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
        <a href="{{ route('admin.teachers') }}" class="menu-item active"><i class="fas fa-chalkboard-user"></i><span>Data Guru</span></a>
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
            <div class="page-header-left"><h1><i class="fas fa-edit"></i>Edit Guru</h1></div>
            <a href="{{ route('admin.teachers') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        @if($errors->any())<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Mohon periksa kembali input Anda.</div>@endif

        <div class="form-card">
            <div class="form-header"><h2><i class="fas fa-chalkboard-user" style="margin-right: 10px; color: var(--primary-sky);"></i>Form Edit Guru - {{ $teacher->name }}</h2></div>
            <div class="form-body">
                <!-- Tabs -->
                <div class="form-tabs">
                    <button type="button" class="tab-btn active" onclick="switchTab('account')"><i class="fas fa-user-circle"></i> Akun & Role</button>
                    <button type="button" class="tab-btn" onclick="switchTab('personal')"><i class="fas fa-id-card"></i> Data Pribadi</button>
                    <button type="button" class="tab-btn" onclick="switchTab('professional')"><i class="fas fa-briefcase"></i> Profesional</button>
                </div>

                <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <!-- Tab 1: Akun & Role -->
                    <div id="tab-account" class="tab-content active">
                        <div class="info-box">
                            <p><i class="fas fa-info-circle"></i> Pilih jenis guru dan status wali kelas. Guru BK tidak memerlukan mata pelajaran.</p>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
                                @error('name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-envelope"></i> Email <span style="color: #ef4444;">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
                                @error('email')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user-tag"></i> Jenis Guru <span style="color: #ef4444;">*</span></label>
                                <select name="role" id="role" class="form-control" required onchange="toggleSubjectField()">
                                    <option value="">-- Pilih Jenis Guru --</option>
                                    <option value="guru" {{ old('role', $teacher->role) == 'guru' ? 'selected' : '' }}>👨‍🏫 Guru Mata Pelajaran</option>
                                    <option value="guru_bk" {{ old('role', $teacher->role) == 'guru_bk' ? 'selected' : '' }}>💬 Guru BK (Bimbingan Konseling)</option>
                                </select>
                                @error('role')<p class="error-text">{{ $message }}</p>@enderror
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
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-user-tie"></i> Status Wali Kelas</label>
                                <select name="is_homeroom" id="is_homeroom" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="1" {{ $teacher->homeroomClass ? 'selected' : '' }}>✅ Ya, menjadi Wali Kelas</option>
                                    <option value="0" {{ !$teacher->homeroomClass ? 'selected' : '' }}>❌ Tidak menjadi Wali Kelas</option>
                                </select>
                                <p class="form-hint" style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">
                                    <i class="fas fa-info-circle"></i> Jika dipilih "Ya", Anda dapat mengatur kelas yang diwalikan di halaman Manajemen Kelas.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Data Pribadi -->
                    <div id="tab-personal" class="tab-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> NIP</label>
                                <input type="text" name="nip" class="form-control" value="{{ old('nip', $teacher->nip) }}">
                                @error('nip')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                <select name="gender" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('gender', $teacher->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $teacher->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-map-pin"></i> Tempat Lahir</label>
                                <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $teacher->birth_place) }}">
                                @error('birth_place')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $teacher->birth_date ? $teacher->birth_date->format('Y-m-d') : '') }}">
                                @error('birth_date')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-phone"></i> No. Telepon</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
                                @error('phone')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-pray"></i> Agama</label>
                                <select name="religion" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" {{ old('religion', $teacher->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('religion', $teacher->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('religion', $teacher->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('religion', $teacher->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('religion', $teacher->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('religion', $teacher->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Profesional -->
                    <div id="tab-professional" class="tab-content">
                        <div class="form-grid">
                            <div id="subject-field" class="form-group full-width" style="display: {{ old('role', $teacher->role) == 'guru' ? 'block' : 'none' }};">
                                <label class="form-label"><i class="fas fa-book"></i> Mata Pelajaran <span style="color: #ef4444;" id="subject-required">*</span></label>
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $teacher->subject) }}" placeholder="Contoh: Matematika, Bahasa Indonesia, dll">
                                @error('subject')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div id="subject-group-field" class="form-group" style="display: {{ old('role', $teacher->role) == 'guru' ? 'block' : 'none' }};">
                                <label class="form-label"><i class="fas fa-layer-group"></i> Kelompok Mata Pelajaran</label>
                                <select name="subject_group" class="form-control">
                                    <option value="">-- Pilih Kelompok --</option>
                                    <option value="IPA" {{ old('subject_group', $teacher->subject_group) == 'IPA' ? 'selected' : '' }}>IPA (Ilmu Pengetahuan Alam)</option>
                                    <option value="IPS" {{ old('subject_group', $teacher->subject_group) == 'IPS' ? 'selected' : '' }}>IPS (Ilmu Pengetahuan Sosial)</option>
                                    <option value="Bahasa" {{ old('subject_group', $teacher->subject_group) == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                    <option value="Umum" {{ old('subject_group', $teacher->subject_group) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-graduation-cap"></i> Pendidikan Terakhir</label>
                                <select name="education_level" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="D3" {{ old('education_level', $teacher->education_level) == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('education_level', $teacher->education_level) == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('education_level', $teacher->education_level) == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('education_level', $teacher->education_level) == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-building"></i> Universitas/Institusi</label>
                                <input type="text" name="university" class="form-control" value="{{ old('university', $teacher->university) }}" placeholder="Nama universitas">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar-check"></i> Tahun Lulus</label>
                                <input type="number" name="graduation_year" class="form-control" value="{{ old('graduation_year', $teacher->graduation_year) }}" placeholder="Contoh: 2010" min="1970" max="2030">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-briefcase"></i> Status Kepegawaian</label>
                                <select name="employment_status" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="PNS" {{ old('employment_status', $teacher->employment_status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK" {{ old('employment_status', $teacher->employment_status) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                    <option value="Honorer" {{ old('employment_status', $teacher->employment_status) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                                    <option value="Kontrak" {{ old('employment_status', $teacher->employment_status) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar-plus"></i> Tahun Mulai Bertugas</label>
                                <input type="number" name="start_year" class="form-control" value="{{ old('start_year', $teacher->start_year) }}" placeholder="Contoh: 2015" min="1970" max="2030">
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-certificate"></i> Sertifikasi</label>
                                <input type="text" name="certification" class="form-control" value="{{ old('certification', $teacher->certification) }}" placeholder="Contoh: Sertifikat Pendidik, Pelatihan BK, dll">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-danger" onclick="document.getElementById('deleteForm').submit();"><i class="fas fa-trash"></i> Hapus Guru</button>
                        <a href="{{ route('admin.teachers') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                    </div>
                </form>
                <form id="deleteForm" action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Hapus guru {{ $teacher->name }}?')">@csrf @method('DELETE')</form>
            </div>
        </div>
    </div>

    <script>
        function toggleSubmenu(element) {
            const submenu = element.nextElementSibling;
            element.classList.toggle('expanded');
            submenu.classList.toggle('show');
        }
        
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.closest('.tab-btn').classList.add('active');
        }
        
        function toggleSubjectField() {
            const role = document.getElementById('role').value;
            const subjectField = document.getElementById('subject-field');
            const subjectGroupField = document.getElementById('subject-group-field');
            const subjectRequired = document.getElementById('subject-required');
            
            if (role === 'guru') {
                subjectField.style.display = 'block';
                subjectGroupField.style.display = 'block';
                if (subjectRequired) subjectRequired.style.display = 'inline';
            } else {
                subjectField.style.display = 'none';
                subjectGroupField.style.display = 'none';
                if (subjectRequired) subjectRequired.style.display = 'none';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            toggleSubjectField();
            
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