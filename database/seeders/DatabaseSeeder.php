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
        // 0. Buat User Admin
        User::create([
            'name' => 'Root Admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // 1. Buat User Siswa & Guru Dummy
        $studentUser = User::create([
            'name' => 'Siswa Example',
            'email' => 'siswa@school.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        $teacherUser = User::create([
            'name' => 'Bapak Guru Budi',
            'email' => 'guru@school.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        $bkUser = User::create([
            'name' => 'Ibu Rina Cahyani, S.Psi',
            'email' => 'azibk@gmail.com',
            'password' => Hash::make('bk123'),
            'role' => 'guru_bk'
        ]);

        // 2. Buat Teacher Profile
        $teacherId = DB::table('teachers')->insertGetId([
            'user_id' => $teacherUser->id,
            'nip' => '198201012010011015',
            'name' => 'Bapak Guru Budi, S.Pd',
            'phone' => '081234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bkId = DB::table('teachers')->insertGetId([
            'user_id' => $bkUser->id,
            'nip' => '198505122015022001',
            'name' => 'Ibu Rina Cahyani, S.Psi',
            'phone' => '087712344321',
            'avatar' => 'https://ui-avatars.com/api/?name=Rina+Cahyani&background=0D9488&color=fff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Buat Kelas
        $classId = DB::table('classes')->insertGetId([
            'name' => 'X RPL 1',
            'grade_level' => '10',
            'homeroom_teacher_id' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Buat Profil Siswa
        $studentId = DB::table('students')->insertGetId([
            'user_id' => $studentUser->id,
            'class_id' => $classId,
            'nisn' => '0051234567',
            'nis' => '10293847',
            'name' => 'Azi Wusto',
            'first_name' => 'Azi',
            'last_name' => 'Wusto',
            'birth_place' => 'Jakarta',
            'birth_date' => '2008-05-14',
            'address' => 'Jl. Merdeka No 12, Kota M',
            'phone' => '085812341234',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Buat Mata Pelajaran (Subjects)
        $mtkId = DB::table('subjects')->insertGetId(['name' => 'Matematika Lanjut', 'code' => 'MTK01', 'created_at' => now(), 'updated_at' => now()]);
        $webId = DB::table('subjects')->insertGetId(['name' => 'Pemrograman Web', 'code' => 'RPL01', 'created_at' => now(), 'updated_at' => now()]);

        // 6. Buat Jadwal (Schedules)
        DB::table('schedules')->insert([
            ['class_id' => $classId, 'subject_id' => $mtkId, 'teacher_id' => $teacherId, 'day_of_week' => 'Senin', 'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Lab Komputer 1', 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => $classId, 'subject_id' => $webId, 'teacher_id' => $teacherId, 'day_of_week' => 'Senin', 'start_time' => '09:00:00', 'end_time' => '10:30:00', 'room' => 'Lab RPL', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. Buat Tugas (Assignments)
        DB::table('assignments')->insert([
            ['class_id' => $classId, 'subject_id' => $mtkId, 'teacher_id' => $teacherId, 'title' => 'Latihan Soal Aljabar', 'description' => 'Kerjakan LKS Hal 12', 'type' => 'Homework', 'due_date' => Carbon::now()->addDays(2), 'created_at' => now(), 'updated_at' => now()],
            ['class_id' => $classId, 'subject_id' => $webId, 'teacher_id' => $teacherId, 'title' => 'Tugas Akhir Laravel', 'description' => 'Selesaikan layout blade', 'type' => 'Project', 'due_date' => Carbon::now()->addDays(5), 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // 8. Buat Nilai Dummy (Grades)
        DB::table('grades')->insert([
            ['student_id' => $studentId, 'subject_id' => $mtkId, 'type' => 'UTS', 'score' => 88, 'semester' => 'Ganjil', 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => $studentId, 'subject_id' => $webId, 'type' => 'UTS', 'score' => 95, 'semester' => 'Ganjil', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 9. Buat Pesan Dummy (Chats)
        DB::table('chats')->insert([
            ['sender_id' => $studentUser->id, 'receiver_id' => $bkUser->id, 'message' => 'Selamat pagi Ibu, saya ingin bercerita tentang masalah saya tidak fokus belajar.', 'is_read' => 0, 'created_at' => now()->subHours(2), 'updated_at' => now()],
            ['sender_id' => $bkUser->id, 'receiver_id' => $studentUser->id, 'message' => 'Selamat pagi Azi. Tentu, silakan datang ke ruang BK siang ini ya.', 'is_read' => 1, 'created_at' => now()->subHour(), 'updated_at' => now()],
        ]);
    }
}