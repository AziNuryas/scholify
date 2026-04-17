<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // 0. USERS — Admin, Siswa, Guru, Guru BK
        // ============================================================
        User::create([
            'name' => 'Root Admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        $studentUser1 = User::create([
            'name' => 'Azi Nuryas',
            'email' => 'siswa@school.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        $studentUser2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@school.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        $studentUser3 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@school.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        $teacherUser = User::create([
            'name' => 'Bapak Guru Budi',
            'email' => 'guru@school.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        $teacherUser2 = User::create([
            'name' => 'Ibu Sari Dewi, S.Pd',
            'email' => 'sari@school.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        $bkUser = User::create([
            'name' => 'Ibu Rina Cahyani, S.Psi',
            'email' => 'azibk@gmail.com',
            'password' => Hash::make('bk123'),
            'role' => 'guru_bk'
        ]);

        // ============================================================
        // 1. TEACHERS
        // ============================================================
        $teacherId1 = DB::table('teachers')->insertGetId([
            'user_id' => $teacherUser->id,
            'nip' => '198201012010011015',
            'name' => 'Bapak Guru Budi, S.Pd',
            'phone' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $teacherId2 = DB::table('teachers')->insertGetId([
            'user_id' => $teacherUser2->id,
            'nip' => '199003152018012001',
            'name' => 'Ibu Sari Dewi, S.Pd',
            'phone' => '087654321098',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bkTeacherId = DB::table('teachers')->insertGetId([
            'user_id' => $bkUser->id,
            'nip' => '198505122015022001',
            'name' => 'Ibu Rina Cahyani, S.Psi',
            'phone' => '087712344321',
            'avatar' => 'https://ui-avatars.com/api/?name=Rina+Cahyani&background=0D9488&color=fff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================================
        // 2. CLASSES
        // ============================================================
        $classId = DB::table('classes')->insertGetId([
            'name' => 'X RPL 1',
            'grade_level' => '10',
            'homeroom_teacher_id' => $teacherId1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $classId2 = DB::table('classes')->insertGetId([
            'name' => 'X RPL 2',
            'grade_level' => '10',
            'homeroom_teacher_id' => $teacherId2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================================
        // 3. STUDENTS
        // ============================================================
        $studentId1 = DB::table('students')->insertGetId([
            'user_id' => $studentUser1->id,
            'class_id' => $classId,
            'nisn' => '0051234567',
            'nis' => '10293847',
            'name' => 'Azi Nuryas',
            'first_name' => 'Azi',
            'last_name' => 'Nuryas',
            'birth_place' => 'Jakarta',
            'birth_date' => '2008-05-14',
            'address' => 'Jl. Merdeka No 12, Kota M',
            'phone' => '085812341234',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studentId2 = DB::table('students')->insertGetId([
            'user_id' => $studentUser2->id,
            'class_id' => $classId,
            'nisn' => '0051234568',
            'nis' => '10293848',
            'name' => 'Siti Nurhaliza',
            'first_name' => 'Siti',
            'last_name' => 'Nurhaliza',
            'birth_place' => 'Bandung',
            'birth_date' => '2008-08-22',
            'address' => 'Jl. Pahlawan No 5, Kota B',
            'phone' => '085898765432',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studentId3 = DB::table('students')->insertGetId([
            'user_id' => $studentUser3->id,
            'class_id' => $classId,
            'nisn' => '0051234569',
            'nis' => '10293849',
            'name' => 'Budi Santoso',
            'first_name' => 'Budi',
            'last_name' => 'Santoso',
            'birth_place' => 'Surabaya',
            'birth_date' => '2008-12-01',
            'address' => 'Jl. Sudirman No 8, Kota S',
            'phone' => '085877889900',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================================
        // 4. SUBJECTS (7 Mata Pelajaran)
        // ============================================================
        $mtkId  = DB::table('subjects')->insertGetId(['name' => 'Matematika',       'code' => 'MTK01', 'created_at' => now(), 'updated_at' => now()]);
        $webId  = DB::table('subjects')->insertGetId(['name' => 'Pemrograman Web',  'code' => 'RPL01', 'created_at' => now(), 'updated_at' => now()]);
        $indId  = DB::table('subjects')->insertGetId(['name' => 'Bahasa Indonesia', 'code' => 'IND01', 'created_at' => now(), 'updated_at' => now()]);
        $engId  = DB::table('subjects')->insertGetId(['name' => 'Bahasa Inggris',   'code' => 'ENG01', 'created_at' => now(), 'updated_at' => now()]);
        $pknId  = DB::table('subjects')->insertGetId(['name' => 'PKN',              'code' => 'PKN01', 'created_at' => now(), 'updated_at' => now()]);
        $fisId  = DB::table('subjects')->insertGetId(['name' => 'Fisika',           'code' => 'FIS01', 'created_at' => now(), 'updated_at' => now()]);
        $ddbId  = DB::table('subjects')->insertGetId(['name' => 'Basis Data',       'code' => 'RPL02', 'created_at' => now(), 'updated_at' => now()]);

        // ============================================================
        // 5. SCHEDULES — Jadwal 5 hari (Senin-Jumat)
        // ============================================================
        $schedules = [
            // SENIN
            ['class_id' => $classId, 'subject_id' => $mtkId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Senin',  'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Kelas X-1'],
            ['class_id' => $classId, 'subject_id' => $webId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Senin',  'start_time' => '09:15:00', 'end_time' => '10:45:00', 'room' => 'Lab Komputer 1'],
            ['class_id' => $classId, 'subject_id' => $indId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Senin',  'start_time' => '11:00:00', 'end_time' => '12:30:00', 'room' => 'Kelas X-1'],
            // SELASA
            ['class_id' => $classId, 'subject_id' => $engId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Selasa', 'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Kelas X-1'],
            ['class_id' => $classId, 'subject_id' => $fisId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Selasa', 'start_time' => '09:15:00', 'end_time' => '10:45:00', 'room' => 'Lab IPA'],
            ['class_id' => $classId, 'subject_id' => $pknId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Selasa', 'start_time' => '11:00:00', 'end_time' => '12:30:00', 'room' => 'Kelas X-1'],
            // RABU
            ['class_id' => $classId, 'subject_id' => $ddbId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Rabu',   'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Lab Komputer 2'],
            ['class_id' => $classId, 'subject_id' => $mtkId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Rabu',   'start_time' => '09:15:00', 'end_time' => '10:45:00', 'room' => 'Kelas X-1'],
            ['class_id' => $classId, 'subject_id' => $engId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Rabu',   'start_time' => '11:00:00', 'end_time' => '12:30:00', 'room' => 'Kelas X-1'],
            // KAMIS
            ['class_id' => $classId, 'subject_id' => $webId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Kamis',  'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Lab Komputer 1'],
            ['class_id' => $classId, 'subject_id' => $indId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Kamis',  'start_time' => '09:15:00', 'end_time' => '10:45:00', 'room' => 'Kelas X-1'],
            ['class_id' => $classId, 'subject_id' => $fisId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Kamis',  'start_time' => '11:00:00', 'end_time' => '12:30:00', 'room' => 'Lab IPA'],
            // JUMAT
            ['class_id' => $classId, 'subject_id' => $pknId,  'teacher_id' => $teacherId2, 'day_of_week' => 'Jumat',  'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Kelas X-1'],
            ['class_id' => $classId, 'subject_id' => $ddbId,  'teacher_id' => $teacherId1, 'day_of_week' => 'Jumat',  'start_time' => '09:15:00', 'end_time' => '10:45:00', 'room' => 'Lab Komputer 2'],
        ];

        foreach ($schedules as $s) {
            $s['created_at'] = now();
            $s['updated_at'] = now();
            DB::table('schedules')->insert($s);
        }

        // ============================================================
        // 6. ASSIGNMENTS (6 Tugas dengan variasi)
        // ============================================================
        $assign1 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $mtkId, 'teacher_id' => $teacherId1,
            'title' => 'Latihan Soal Aljabar Linear', 'description' => 'Kerjakan LKS Halaman 12-15, soal no 1-20',
            'type' => 'Homework', 'due_date' => Carbon::now()->addDays(2),
            'created_at' => now(), 'updated_at' => now()
        ]);

        $assign2 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $webId, 'teacher_id' => $teacherId1,
            'title' => 'Project Akhir Laravel', 'description' => 'Buat sistem CRUD sederhana dengan Laravel + MySQL',
            'type' => 'Project', 'due_date' => Carbon::now()->addDays(7),
            'created_at' => now(), 'updated_at' => now()
        ]);

        $assign3 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $indId, 'teacher_id' => $teacherId2,
            'title' => 'Esai Analisis Cerpen', 'description' => 'Analisis unsur intrinsik cerpen "Senyum Karyamin" oleh Ahmad Tohari',
            'type' => 'Tugas', 'due_date' => Carbon::now()->addDays(3),
            'created_at' => now(), 'updated_at' => now()
        ]);

        $assign4 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $engId, 'teacher_id' => $teacherId2,
            'title' => 'Grammar Exercise - Tenses', 'description' => 'Complete exercises on Present Perfect and Past Perfect Tense',
            'type' => 'Homework', 'due_date' => Carbon::now()->addDays(1),
            'created_at' => now(), 'updated_at' => now()
        ]);

        $assign5 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $ddbId, 'teacher_id' => $teacherId1,
            'title' => 'Desain ERD Perpustakaan', 'description' => 'Buat Entity Relationship Diagram untuk sistem perpustakaan digital',
            'type' => 'Project', 'due_date' => Carbon::now()->addDays(5),
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Tugas yang sudah lewat deadline (untuk testing overdue)
        $assign6 = DB::table('assignments')->insertGetId([
            'class_id' => $classId, 'subject_id' => $fisId, 'teacher_id' => $teacherId1,
            'title' => 'Laporan Praktikum Optik', 'description' => 'Tulis laporan praktikum tentang pembiasan cahaya',
            'type' => 'Tugas', 'due_date' => Carbon::now()->subDays(2),
            'created_at' => now()->subDays(7), 'updated_at' => now()
        ]);

        // ============================================================
        // 7. SUBMISSIONS (beberapa tugas sudah dikumpulkan oleh siswa 1)
        // ============================================================
        DB::table('submissions')->insert([
            [
                'assignment_id' => $assign1, 'student_id' => $studentId1,
                'file_url' => null, 'notes' => 'Sudah dikerjakan semua pak',
                'score' => 85, 'status' => 'Graded',
                'created_at' => now()->subDays(1), 'updated_at' => now()
            ],
            [
                'assignment_id' => $assign6, 'student_id' => $studentId1,
                'file_url' => null, 'notes' => 'Maaf terlambat pak',
                'score' => 70, 'status' => 'Late',
                'created_at' => now()->subDays(1), 'updated_at' => now()
            ],
        ]);

        // ============================================================
        // 8. GRADES — Nilai UTS + UAS untuk siswa 1
        // ============================================================
        $gradeData = [
            // Semester Ganjil - UTS
            ['student_id' => $studentId1, 'subject_id' => $mtkId,  'type' => 'UTS', 'score' => 88, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $webId,  'type' => 'UTS', 'score' => 95, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $indId,  'type' => 'UTS', 'score' => 78, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $engId,  'type' => 'UTS', 'score' => 82, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $pknId,  'type' => 'UTS', 'score' => 90, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $fisId,  'type' => 'UTS', 'score' => 75, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $ddbId,  'type' => 'UTS', 'score' => 92, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            // Semester Ganjil - UAS
            ['student_id' => $studentId1, 'subject_id' => $mtkId,  'type' => 'UAS', 'score' => 90, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $webId,  'type' => 'UAS', 'score' => 97, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $indId,  'type' => 'UAS', 'score' => 80, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $engId,  'type' => 'UAS', 'score' => 85, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            // Semester Genap - UTS (data untuk test filter)
            ['student_id' => $studentId1, 'subject_id' => $mtkId,  'type' => 'UTS', 'score' => 92, 'semester' => 'Genap', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId1, 'subject_id' => $webId,  'type' => 'UTS', 'score' => 98, 'semester' => 'Genap', 'academic_year' => '2026/2027'],
            // Nilai siswa 2 (untuk data guru)
            ['student_id' => $studentId2, 'subject_id' => $mtkId,  'type' => 'UTS', 'score' => 76, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
            ['student_id' => $studentId2, 'subject_id' => $webId,  'type' => 'UTS', 'score' => 84, 'semester' => 'Ganjil', 'academic_year' => '2026/2027'],
        ];

        foreach ($gradeData as $g) {
            $g['created_at'] = now();
            $g['updated_at'] = now();
            DB::table('grades')->insert($g);
        }

        // ============================================================
        // 9. PAYMENTS — SPP
        // ============================================================
        $months = ['Januari 2026', 'Februari 2026', 'Maret 2026', 'April 2026'];
        foreach ($months as $i => $month) {
            DB::table('payments')->insert([
                'student_id' => $studentId1,
                'month' => $month,
                'amount' => 350000,
                'status' => $i < 3 ? 'Lunas' : 'Belum Lunas', // April belum lunas
                'payment_date' => $i < 3 ? Carbon::create(2026, $i + 1, 10) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================================
        // 10. CHATS — Percakapan BK
        // ============================================================
        DB::table('chats')->insert([
            ['sender_id' => $studentUser1->id, 'receiver_id' => $bkUser->id, 'message' => 'Selamat pagi Ibu, saya ingin bercerita tentang masalah saya tidak fokus belajar.', 'is_read' => 1, 'created_at' => now()->subHours(3), 'updated_at' => now()],
            ['sender_id' => $bkUser->id, 'receiver_id' => $studentUser1->id, 'message' => 'Selamat pagi Azi. Tentu, bisa ceritakan lebih detail apa yang membuat kamu sulit fokus?', 'is_read' => 1, 'created_at' => now()->subHours(2), 'updated_at' => now()],
            ['sender_id' => $studentUser1->id, 'receiver_id' => $bkUser->id, 'message' => 'Saya merasa terlalu banyak tugas dan tidak tahu mana yang harus didahulukan Bu.', 'is_read' => 1, 'created_at' => now()->subHours(1), 'updated_at' => now()],
            ['sender_id' => $bkUser->id, 'receiver_id' => $studentUser1->id, 'message' => 'Baik Azi, mari kita atur jadwal konsultasi langsung. Bagaimana kalau besok jam 10 pagi di ruang BK?', 'is_read' => 0, 'created_at' => now()->subMinutes(30), 'updated_at' => now()],
        ]);

        // ============================================================
        // 11. ANNOUNCEMENTS
        // ============================================================
        DB::table('announcements')->insert([
            [
                'title' => 'Ujian Tengah Semester',
                'content' => 'Ujian Tengah Semester (UTS) akan dilaksanakan mulai tanggal 5 Mei 2026. Persiapkan diri kalian dengan baik. Materi ujian mencakup seluruh bab yang telah dipelajari.',
                'target' => 'Siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rapat Guru Semester Genap',
                'content' => 'Seluruh guru wajib menghadiri rapat koordinasi semester genap pada Senin, 28 April 2026 di Aula Utama.',
                'target' => 'Guru',
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ]
        ]);

        // ============================================================
        // 12. DISCIPLINARY RECORDS (contoh catatan disiplin)
        // ============================================================
        DB::table('disciplinary_records')->insert([
            'student_id' => $studentId1,
            'teacher_id' => $bkUser->id,
            'date' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'violation_type' => 'Terlambat Masuk Kelas',
            'description' => 'Terlambat 15 menit saat jam pertama pelajaran Matematika.',
            'points' => 5,
            'created_at' => now()->subDays(5),
            'updated_at' => now(),
        ]);
    }
}