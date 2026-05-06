<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Schoolify - {{ $generatedAt ?? date('Y-m-d') }}</title>
    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }

        /* CONTAINER */
        .wrapper {
            max-width: 1000px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* KOP SURAT */
        .kop-surat {
            padding: 20px 40px;
            border-bottom: 3px solid #3a4a6b;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kop-left {
            flex: 1;
        }

        .kop-left h2 {
            font-size: 20px;
            font-weight: bold;
            color: #3a4a6b;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-left p {
            font-size: 12px;
            color: #666;
            margin-bottom: 2px;
            line-height: 1.4;
        }

        .kop-right {
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        .kop-right p {
            margin-bottom: 2px;
            line-height: 1.4;
        }

        .kop-right strong {
            color: #3a4a6b;
        }

        /* HEADER */
        .header {
            background-color: #3a4a6b;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header p {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .header-date {
            font-size: 12px;
            opacity: 0.9;
        }

        /* CONTENT */
        .content {
            padding: 40px;
        }

        /* SECTION */
        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #3a4a6b;
            border-bottom: 2px solid #3a4a6b;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* STATS TABLE */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .stats-table td {
            background-color: #f0f2f5;
            border: 1px solid #d0d5dd;
            padding: 20px;
            text-align: center;
            width: 25%;
        }

        .stats-table .stat-label {
            font-size: 12px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
            padding-bottom: 8px;
            display: block;
        }

        .stats-table .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #3a4a6b;
            line-height: 1;
            display: block;
        }

        /* TABLE */
        .table-box {
            border: 1px solid #d0d5dd;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background-color: #3a4a6b;
            color: white;
        }

        th {
            padding: 12px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            border-right: 1px solid #555;
        }

        th:last-child {
            border-right: none;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 13px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f2f5;
        }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .badge-primary {
            background-color: #cfe9f3;
            color: #004085;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }

        /* FOOTER */
        .footer {
            background-color: #f0f2f5;
            border-top: 1px solid #d0d5dd;
            padding: 25px 30px;
            text-align: center;
            font-size: 11px;
            color: #666;
            line-height: 1.7;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .footer p:last-child {
            font-style: italic;
            margin-top: 10px;
        }

        /* CENTER TEXT */
        .text-center {
            text-align: center;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .content {
                padding: 20px;
            }

            .header {
                padding: 25px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .stats {
                flex-direction: column;
                gap: 10px;
            }

            .stat {
                min-width: 100%;
            }

            th, td {
                padding: 10px;
                font-size: 12px;
            }

            th {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="kop-left">
                <h2>Sekolah Menengah Atas Negeri 1</h2>
                <p>Jalan Pendidikan No. 123, Kota, Provinsi 12345</p>
                <p>Telepon: (021) 123-4567 | Email: info@sekolah.sch.id</p>
            </div>
            <div class="kop-right">
                <p><strong>NPSN:</strong> {{ $schoolNPSN ?? '20123456' }}</p>
                <p><strong>NSS:</strong> {{ $schoolNSS ?? '30.1.15.1.0001.5' }}</p>
                <p><strong>Tahun Ajaran:</strong> {{ $academicYear ?? '2024/2025' }}</p>
            </div>
        </div>

        <!-- HEADER -->
        <div class="header">
            <h1>LAPORAN SCHOOLIFY</h1>
            <p>Ringkasan Data Sekolah</p>
            <div class="header-date">Periode: {{ $generatedAt ?? date('Y-m-d') }}</div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <!-- STATISTIK UTAMA -->
            <div class="section">
                <h2 class="section-title">Statistik Utama</h2>
                <table class="stats-table">
                    <tr>
                        <td>
                            <span class="stat-label">Total Siswa</span>
                            <span class="stat-number">{{ $totalStudents ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="stat-label">Total Guru</span>
                            <span class="stat-number">{{ $totalTeachers ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="stat-label">Total Kelas</span>
                            <span class="stat-number">{{ $totalClasses ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="stat-label">Tingkat Kehadiran</span>
                            <span class="stat-number">{{ $attendanceRate ?? 0 }}%</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- AKTIVITAS BULAN INI -->
            <div class="section">
                <h2 class="section-title">Aktivitas Bulan Ini</h2>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>Jenis Aktivitas</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Konsultasi</td>
                                <td class="text-center"><strong>{{ $totalConsultations ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-primary">Aktif</span></td>
                            </tr>
                            <tr>
                                <td>Konsultasi Selesai</td>
                                <td class="text-center"><strong>{{ $completedConsultations ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>Konsultasi Pending</td>
                                <td class="text-center"><strong>{{ $pendingConsultations ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Catatan Disiplin</td>
                                <td class="text-center"><strong>{{ $disciplineRecords ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-secondary">Tercatat</span></td>
                            </tr>
                            <tr>
                                <td>Jadwal Temu</td>
                                <td class="text-center"><strong>{{ $appointments ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-primary">Terjadwal</span></td>
                            </tr>
                            <tr>
                                <td>Jadwal Temu Dikonfirmasi</td>
                                <td class="text-center"><strong>{{ $approvedAppointments ?? 0 }}</strong></td>
                                <td class="text-center"><span class="badge badge-success">Dikonfirmasi</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SISWA TERBARU -->
            @if(isset($recentStudents) && count($recentStudents) > 0)
            <div class="section">
                <h2 class="section-title">Siswa Terbaru</h2>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentStudents as $student)
                            <tr>
                                <td><strong>{{ $student->nisn ?? '-' }}</strong></td>
                                <td>{{ $student->name ?? '-' }}</td>
                                <td>{{ $student->user->email ?? '-' }}</td>
                                <td><span class="badge badge-primary">{{ $student->schoolClass->name ?? '-' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- GURU TERBARU -->
            @if(isset($recentTeachers) && count($recentTeachers) > 0)
            <div class="section">
                <h2 class="section-title">Guru Terbaru</h2>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Guru</th>
                                <th>Email</th>
                                <th>Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTeachers as $teacher)
                            <tr>
                                <td><strong>{{ $teacher->nip ?? '-' }}</strong></td>
                                <td>{{ $teacher->name ?? '-' }}</td>
                                <td>{{ $teacher->email ?? '-' }}</td>
                                <td><span class="badge badge-success">{{ $teacher->subject ?? '-' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>© {{ date('Y') }} Schoolify</strong></p>
            <p>Laporan ini digenerate secara otomatis pada {{ $generatedAt ?? date('Y-m-d H:i:s') }}</p>
            <p>Dokumen ini bersifat rahasia dan hanya untuk penggunaan internal.</p>
        </div>
    </div>
</body>
</html>