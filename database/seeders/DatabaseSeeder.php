<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Schoolify',
            'email' => 'admin@school.com',
            'password' => Hash::make('admin123'), // Ganti password sesuai keinginan
            'email_verified_at' => now(),
        ]);
    }
}