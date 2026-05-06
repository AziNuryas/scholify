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
        // 0. Buat User Admin Utama (gunakan updateOrCreate untuk menghindari duplikasi)
        User::updateOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Root Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // 0a. Buat User Admin Khoerul Paroid
        User::updateOrCreate(
            ['email' => 'khoerulparoid@gmail.com'],
            [
                'name' => 'Khoerul Paroid',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // 1. Buat User Siswa & Guru Dummy
        $studentUser = User::updateOrCreate(
            ['email' => 'siswa@school.com'],
            [
                'name' => 'Siswa Example',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa'
            ]
        );

        $teacherUser = User::updateOrCreate(
            ['email' => 'guru@school.com'],
            [
                'name' => 'Bapak Guru Budi',
                'password' => Hash::make('guru123'),
                'role' => 'guru'
            ]
        );

        $bkUser = User::updateOrCreate(
            ['email' => 'azibk@gmail.com'],
            [
                'name' => 'Ibu Rina Cahyani, S.Psi',
                'password' => Hash::make('bk123'),
                'role' => 'guru_bk'
            ]
        );

        // 2. Buat Teacher Profile (cek dulu apakah sudah ada)
        $teacherId = DB::table('teachers')->where('user_id', $teacherUser->id)->value('id');
        if (!$teacherId) {
            $teacherId = DB::table('teachers')->insertGetId([
                'user_id' => $teacherUser->id,
                'nip' => '198201012010011015',
                'name' => 'Bapak Guru Budi, S.Pd',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $bkId = DB::table('teachers')->where('user_id', $bkUser->id)->value('id');
        if (!$bkId) {
            $bkId = DB::table('teachers')->insertGetId([
                'user_id' => $bkUser->id,
                'nip' => '198505122015022001',
                'name' => 'Ibu Rina Cahyani, S.Psi',
                'phone' => '087712344321',
                'avatar' => 'https://ui-avatars.com/api/?name=Rina+Cahyani&background=0D9488&color=fff',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Buat Kelas (cek dulu apakah sudah ada)
        $classId = DB::table('classes')->where('name', 'X RPL 1')->value('id');
        if (!$classId) {
            $classId = DB::table('classes')->insertGetId([
                'name' => 'X RPL 1',
                'grade_level' => '10',
                'homeroom_teacher_id' => $teacherId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Buat Profil Siswa (cek dulu apakah sudah ada)
        $studentId = DB::table('students')->where('user_id', $studentUser->id)->value('id');
        if (!$studentId) {
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
        }

        // 5. Buat Mata Pelajaran (Subjects) - cek dulu
        $mtkId = DB::table('subjects')->where('code', 'MTK01')->value('id');
        if (!$mtkId) {
            $mtkId = DB::table('subjects')->insertGetId([
                'name' => 'Matematika Lanjut', 
                'code' => 'MTK01', 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }

        $webId = DB::table('subjects')->where('code', 'RPL01')->value('id');
        if (!$webId) {
            $webId = DB::table('subjects')->insertGetId([
                'name' => 'Pemrograman Web', 
                'code' => 'RPL01', 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }

        // 6. Buat Jadwal (Schedules) - cek dulu
        $scheduleExists = DB::table('schedules')
            ->where('class_id', $classId)
            ->where('subject_id', $mtkId)
            ->exists();
        
        if (!$scheduleExists) {
            DB::table('schedules')->insert([
                ['class_id' => $classId, 'subject_id' => $mtkId, 'teacher_id' => $teacherId, 'day_of_week' => 'Senin', 'start_time' => '07:30:00', 'end_time' => '09:00:00', 'room' => 'Lab Komputer 1', 'created_at' => now(), 'updated_at' => now()],
                ['class_id' => $classId, 'subject_id' => $webId, 'teacher_id' => $teacherId, 'day_of_week' => 'Senin', 'start_time' => '09:00:00', 'end_time' => '10:30:00', 'room' => 'Lab RPL', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

    }
}