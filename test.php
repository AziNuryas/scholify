<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = \App\Models\Student::with('schoolClass')->first();
$user = \App\Models\User::where('role', 'siswa')->first();

echo "User Name: " . ($user->name ?? 'null') . "\n";
echo "Student Name: " . ($student->name ?? 'null') . "\n";
echo "Student First Name: " . ($student->first_name ?? 'null') . "\n";
