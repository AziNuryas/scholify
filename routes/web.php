<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {

    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/schedule', [StudentMenuController::class, 'schedule'])->name('schedule');
    Route::get('/assignments', [StudentMenuController::class, 'assignments'])->name('assignments');
    Route::get('/grades', [StudentMenuController::class, 'grades'])->name('grades');

    Route::get('/counseling', [StudentMenuController::class, 'counseling'])->name('counseling');
    Route::post('/counseling', [StudentMenuController::class, 'sendCounselingMessage'])->name('counseling.send');

    Route::get('/profile', [StudentMenuController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentMenuController::class, 'updateProfile'])->name('profile.update');

    Route::get('/appointments', [StudentMenuController::class, 'appointments'])->name('appointments');
    Route::post('/appointments', [StudentMenuController::class, 'storeAppointment'])->name('appointments.store');

    Route::get('/discipline', [StudentMenuController::class, 'discipline'])->name('discipline');

    // ✅ Pengumuman siswa
    Route::get('/announcements', [AnnouncementController::class, 'studentIndex'])
        ->name('announcements');
});


/*
|--------------------------------------------------------------------------
| GURU BK
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('guru-bk')->name('gurubk.')->group(function () {

    Route::get('/dashboard', [GuruBkController::class, 'index'])->name('dashboard');

    Route::get('/chats', [GuruBkController::class, 'chats'])->name('chats');
    Route::post('/chats/reply', [GuruBkController::class, 'reply'])->name('reply');

    Route::get('/profile', [GuruBkController::class, 'profile'])->name('profile');
    Route::post('/profile', [GuruBkController::class, 'updateProfile'])->name('profile.update');

    Route::get('/appointments', [GuruBkController::class, 'appointments'])->name('appointments');
    Route::post('/appointments/{id}/status', [GuruBkController::class, 'updateAppointmentStatus'])->name('appointments.status');

    Route::get('/discipline', [GuruBkController::class, 'discipline'])->name('discipline');
    Route::post('/discipline', [GuruBkController::class, 'storeDiscipline'])->name('discipline.store');
});


/*
|--------------------------------------------------------------------------
| GURU MAPEL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', fn() => view('guru.dashboard'))->name('dashboard');
    Route::get('/jadwal', fn() => view('guru.jadwal'))->name('jadwal');
    Route::get('/absensi', fn() => view('guru.absensi'))->name('absensi');

    Route::get('/nilai', [GradeController::class, 'index'])->name('nilai');
    Route::post('/nilai', [GradeController::class, 'store'])->name('nilai.store');

    Route::get('/raport', fn() => view('guru.raport'))->name('raport');
    Route::get('/tugas', fn() => view('guru.tugas'))->name('tugas');
    Route::get('/profil', fn() => view('guru.profil'))->name('profil');

    /*
    |--------------------------------------------------------------------------
    | ✅ PENGUMUMAN (FIX FINAL)
    |--------------------------------------------------------------------------
    */

    // halaman
    Route::get('/pengumuman', [AnnouncementController::class, 'guruIndex'])
        ->name('pengumuman');

    // simpan
    Route::post('/pengumuman', [AnnouncementController::class, 'store'])
        ->name('pengumuman.store');

    // hapus
    Route::delete('/pengumuman/{id}', [AnnouncementController::class, 'destroy'])
        ->name('pengumuman.destroy');
});


/*
|--------------------------------------------------------------------------
| CHAT API
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api/chat')->name('chat.')->group(function () {

    Route::get('/fetch/{partnerId}', [ChatController::class, 'fetch'])->name('fetch');
    Route::post('/send', [ChatController::class, 'send'])->name('send');
    Route::get('/unread', [ChatController::class, 'unreadCount'])->name('unread');
});