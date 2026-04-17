<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GradeController;

/*
|--------------------------------------------------------------------------
| Web Routes - School Management System (Schoolify)
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Utama (Auto-redirect based on role)
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| STUDENT AREA (AREA SISWA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('student')->group(function () {
    
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/schedule', [StudentMenuController::class, 'schedule'])->name('student.schedule');
    Route::get('/assignments', [StudentMenuController::class, 'assignments'])->name('student.assignments');
    Route::get('/grades', [StudentMenuController::class, 'grades'])->name('student.grades');

    // Menu Konsultasi & Chat (Siswa)
    Route::get('/counseling', [StudentMenuController::class, 'counseling'])->name('student.counseling');
    Route::post('/counseling', [StudentMenuController::class, 'sendCounselingMessage'])->name('student.counseling.send');

    // Profil
    Route::get('/profile', [StudentMenuController::class, 'profile'])->name('student.profile');
    Route::post('/profile', [StudentMenuController::class, 'updateProfile'])->name('student.profile.update');

    // Janji Temu BK
    Route::get('/appointments', [StudentMenuController::class, 'appointments'])->name('student.appointments');
    Route::post('/appointments', [StudentMenuController::class, 'storeAppointment'])->name('student.appointment.store');

    // Kedisiplinan & Pengumuman
    Route::get('/discipline', [StudentMenuController::class, 'discipline'])->name('student.discipline');
    Route::get('/announcements', [StudentMenuController::class, 'announcements'])->name('student.announcements');
});

/*
|--------------------------------------------------------------------------
| GURU BK AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('guru-bk')->group(function () {

    Route::get('/dashboard', [GuruBkController::class, 'index'])->name('gurubk.dashboard');
    
    // Chat & Konsultasi
    Route::get('/chats', [GuruBkController::class, 'chats'])->name('gurubk.chats');
    Route::post('/chats/reply', [GuruBkController::class, 'reply'])->name('gurubk.reply');

    // Profil Guru BK
    Route::get('/profile', [GuruBkController::class, 'profile'])->name('gurubk.profile');
    Route::post('/profile', [GuruBkController::class, 'updateProfile'])->name('gurubk.profile.update');

    // Janji Temu
    Route::get('/appointments', [GuruBkController::class, 'appointments'])->name('gurubk.appointments');
    Route::post('/appointments/{id}/status', [GuruBkController::class, 'updateAppointmentStatus'])->name('gurubk.appointment.status');

    // Kedisiplinan
    Route::get('/discipline', [GuruBkController::class, 'discipline'])->name('gurubk.discipline');
    Route::post('/discipline', [GuruBkController::class, 'storeDiscipline'])->name('gurubk.discipline.store');
});

/*
|--------------------------------------------------------------------------
| GURU MATA PELAJARAN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', fn() => view('guru.dashboard'))->name('dashboard');
    Route::get('/jadwal', fn() => view('guru.jadwal'))->name('jadwal');
    Route::get('/absensi', fn() => view('guru.absensi'))->name('absensi');

    // Nilai & Raport
    Route::get('/nilai', [GradeController::class, 'index'])->name('nilai');
    Route::post('/nilai', [GradeController::class, 'store'])->name('nilai.store');
    Route::get('/raport', fn() => view('guru.raport'))->name('raport');

    // Materi & Tugas
    Route::get('/tugas', fn() => view('guru.tugas'))->name('tugas');
    Route::get('/profil', fn() => view('guru.profil'))->name('profil');

    // --- BAGIAN PENGUMUMAN (FIX UNTUK ERROR 500) ---
    Route::get('/pengumuman', fn() => view('guru.pengumuman'))->name('pengumuman');
    // Rute ini menangani action="{{ route('guru.announcement.store') }}"
    Route::post('/pengumuman', [StudentMenuController::class, 'storeAnnouncement'])->name('announcement.store');
});

/*
|--------------------------------------------------------------------------
| SHARED CHAT API
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('api/chat')->group(function () {
    Route::get('/fetch/{partnerId}', [ChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/unread', [ChatController::class, 'unreadCount'])->name('chat.unread');
});