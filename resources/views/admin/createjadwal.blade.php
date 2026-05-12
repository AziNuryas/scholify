<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Jadwal - Schoolify</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS SAMA SEPERTI YANG ANDA PUNYA UNTUK HALAMAN FORM */
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

        .main-content{margin-left:calc(var(--sidebar-width) + 48px);padding:24px 32px 32px 8px;position:relative;z-index:1;}
        .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;background:var(--bg-glass);backdrop-filter:blur(20px) saturate(180%);padding:18px 32px;border-radius:28px;border:1px solid var(--border-glass);box-shadow:var(--shadow-lg),var(--shadow-diagonal);}
        .page-title h1{font-size:28px;font-weight:800;font-family:'Outfit',sans-serif;letter-spacing:-0.02em;}
        .page-title p{color:var(--text-secondary);font-size:14px;margin-top:4px;font-weight:500;}
        .user-actions{display:flex;align-items:center;gap:16px;}
        .user-avatar{width:48px;height:48px;background:var(--gradient-lavender);border-radius:18px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;color:white;box-shadow:var(--shadow-md);}

        .alert{padding:16px 24px;border-radius:20px;margin-bottom:24px;display:flex;align-items:center;gap:14px;font-weight:500;}
        .alert-success{background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);color:#059669;}
        .alert-danger{background:rgba(244,63,94,0.12);border:1px solid rgba(244,63,94,0.3);color:#E11D48;}
        .alert-warning{background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.3);color:#F59E0B;}

        .form-card{background:var(--bg-glass);backdrop-filter:blur(20px) saturate(180%);border-radius:28px;border:1px solid var(--border-glass);overflow:hidden;box-shadow:var(--shadow-lg),var(--shadow-diagonal);margin-bottom:24px;}
        .card-header{padding:20px 28px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-glass);}
        .card-header h2{font-size:18px;font-weight:700;font-family:'Outfit',sans-serif;color:var(--text-primary);display:flex;align-items:center;gap:10px;}
        .card-header h2 i{color:var(--primary-lavender);}
        .form-body{padding:28px;}
        .form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
        .form-group{display:flex;flex-direction:column;gap:8px;}
        .form-group.full-width{grid-column:span 2;}
        .form-group label{font-size:13px;font-weight:600;color:var(--text-secondary);}
        .form-group label i{margin-right:6px;color:var(--primary-lavender);}
        .form-group label .required{color:var(--primary-rose);margin-left:4px;}
        .form-control{padding:12px 16px;border-radius:14px;border:1px solid var(--border-glass);background:white;font-size:14px;color:var(--text-primary);font-family:'Inter',sans-serif;outline:none;transition:all 0.2s;width:100%;}
        .form-control:focus{border-color:var(--primary-lavender);box-shadow:0 0 0 3px rgba(139,92,246,0.1);}
        select.form-control{cursor:pointer;}
        textarea.form-control{resize:vertical;min-height:80px;}
        .form-actions{display:flex;gap:12px;justify-content:flex-end;margin-top:24px;padding-top:24px;border-top:1px solid var(--border-glass);}
        .btn{padding:10px 24px;border-radius:14px;border:none;font-weight:600;font-size:14px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;text-decoration:none;font-family:'Inter',sans-serif;}
        .btn-primary{background:var(--gradient-lavender);color:white;box-shadow:var(--shadow-md),0 4px 12px rgba(139,92,246,0.25);}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg);}
        .btn-secondary{background:white;color:var(--text-secondary);border:1px solid var(--border-glass);}
        .btn-secondary:hover{background:var(--bg-glass-hover);}
        
        @media(max-width:992px){
            .sidebar{transform:translateX(-120%);}
            .main-content{margin-left:0;padding:16px;padding-bottom:80px;}
            .form-grid{grid-template-columns:1fr;}
            .form-group.full-width{grid-column:span 1;}
        }
        @media(max-width:576px){
            .form-row{flex-direction:column;gap:16px;}
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
            <a href="{{ route('admin.jadwal.index') }}" class="submenu-item"><i class="fas fa-table"></i><span>Jadwal Pelajaran</span></a>
            <a href="{{ route('admin.jadwal.create') }}" class="submenu-item active"><i class="fas fa-plus-circle"></i><span>Tambah Jadwal</span></a>
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
            <h1><i class="fas fa-plus-circle" style="color:var(--primary-lavender);margin-right:10px;"></i>Tambah Jadwal Pelajaran</h1>
            <p>Isi form berikut untuk menambahkan jadwal mengajar baru</p>
        </div>
        <div class="user-actions">
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
    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin-top:8px;margin-left:20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Form Tambah Jadwal --}}
    <div class="form-card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-plus"></i> Form Tambah Jadwal</h2>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="form-body">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-door-open"></i> Kelas <span class="required">*</span></label>
                        <select name="school_class_id" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($classes ?? [] as $class)
                            <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-chalkboard-user"></i> Guru <span class="required">*</span></label>
                        <select name="guru_id" class="form-control" required>
                            <option value="">Pilih Guru</option>
                            @foreach($teachers ?? [] as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('guru_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-book"></i> Mata Pelajaran <span class="required">*</span></label>
                        <select name="mata_pelajaran" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mapel ?? [] as $m)
                            <option value="{{ $m }}" {{ old('mata_pelajaran') == $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                            @endforeach
                            <option value="Lainnya" {{ old('mata_pelajaran') == 'Lainnya' ? 'selected' : '' }}>Lainnya (isi manual)</option>
                        </select>
                        <input type="text" name="mata_pelajaran_lain" class="form-control" placeholder="Atau ketik manual" style="margin-top:8px;display:none;" id="mapelLainInput">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-calendar-day"></i> Hari <span class="required">*</span></label>
                        <select name="hari" class="form-control" required>
                            <option value="">Pilih Hari</option>
                            @foreach($hari ?? [] as $h)
                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Jam Mulai <span class="required">*</span></label>
                        <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Jam Selesai <span class="required">*</span></label>
                        <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Ruangan</label>
                        <input type="text" name="ruangan" class="form-control" placeholder="Misal: Ruang 101, Lab Komputer" value="{{ old('ruangan') }}">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-layer-group"></i> Semester <span class="required">*</span></label>
                        <select name="semester" class="form-control" required>
                            <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                            <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Tahun Ajaran <span class="required">*</span></label>
                        <select name="tahun_ajaran" class="form-control" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranOptions ?? [] as $ta)
                            <option value="{{ $ta }}" {{ old('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-toggle-on"></i> Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label><i class="fas fa-info-circle"></i> Keterangan</label>
                        <textarea name="keterangan" class="form-control" placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleSubmenu(e){
        const s = e.nextElementSibling;
        e.classList.toggle('expanded');
        s.classList.toggle('show');
    }

    // Script untuk input mata pelajaran manual
    const mapelSelect = document.querySelector('select[name="mata_pelajaran"]');
    const mapelLainInput = document.getElementById('mapelLainInput');
    
    if(mapelSelect) {
        mapelSelect.addEventListener('change', function() {
            if(this.value === 'Lainnya') {
                mapelLainInput.style.display = 'block';
                mapelLainInput.setAttribute('name', 'mata_pelajaran');
                mapelLainInput.setAttribute('required', 'required');
                this.removeAttribute('name');
            } else {
                mapelLainInput.style.display = 'none';
                mapelLainInput.removeAttribute('name');
                mapelLainInput.removeAttribute('required');
                this.setAttribute('name', 'mata_pelajaran');
            }
        });
    }
</script>
</body>
</html>