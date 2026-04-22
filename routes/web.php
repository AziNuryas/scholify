<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin')->name('login');
    Route::get('/login', 'showLogin');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {

    Route::controller(StudentDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(StudentMenuController::class)->group(function () {
        Route::get('/schedule', 'schedule')->name('schedule');
        Route::get('/assignments', 'assignments')->name('assignments');
        Route::post('/assignments/submit', 'submitAssignment')->name('assignments.submit');
        Route::get('/grades', 'grades')->name('grades');

        Route::get('/counseling', 'counseling')->name('counseling');
        Route::post('/counseling', 'sendCounselingMessage')->name('counseling.send');

        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');

        Route::get('/appointments', 'appointments')->name('appointments');
        Route::post('/appointments', 'storeAppointment')->name('appointments.store');

        Route::get('/discipline', 'discipline')->name('discipline');
        
        // ✅ TAMBAHKAN ROUTE ABSENSI DI SINI
        Route::get('/absensi', 'absensi')->name('absensi');
        Route::post('/absensi/store', 'storeAbsensi')->name('absensi.store');
    });


});


/*
|--------------------------------------------------------------------------
| GURU BK
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('guru-bk')->name('gurubk.')->group(function () {

    Route::controller(GuruBkController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');

        Route::get('/chats', 'chats')->name('chats');
        Route::post('/chats/reply', 'reply')->name('reply');

        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');

        Route::get('/appointments', 'appointments')->name('appointments');
        Route::post('/appointments/{id}/status', 'updateAppointmentStatus')->name('appointments.status');

        Route::get('/discipline', 'discipline')->name('discipline');
        Route::post('/discipline', 'storeDiscipline')->name('discipline.store');
    });
});


/*
|--------------------------------------------------------------------------
| GURU MAPEL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('guru')->name('guru.')->group(function () {

    /*
    |----------------------------------
    | Dashboard & Static Pages
    |----------------------------------
    */
    Route::view('/dashboard', 'guru.dashboard')->name('dashboard');
    Route::view('/jadwal', 'guru.jadwal')->name('jadwal');
    Route::view('/absensi', 'guru.absensi')->name('absensi');
    Route::view('/raport', 'guru.raport')->name('raport');
    Route::view('/profil', 'guru.profil')->name('profil');

    /*
    |----------------------------------
    | NILAI
    |----------------------------------
    */
    Route::controller(GradeController::class)->group(function () {
        Route::get('/nilai', 'index')->name('nilai');
        Route::post('/nilai', 'store')->name('nilai.store');
    });

    /*
    |----------------------------------
    | TUGAS (CORE FEATURE 🔥)
    |----------------------------------
    */
    Route::controller(AssignmentController::class)->group(function () {
        Route::get('/tugas', 'index')->name('tugas');
        Route::post('/tugas', 'store')->name('tugas.store');
        Route::put('/tugas/{id}', 'update')->name('tugas.update'); // ✅ TAMBAHKAN INI
        Route::delete('/tugas/{id}', 'destroy')->name('tugas.destroy');
    });

    /*
    |----------------------------------
    | PENGUMUMAN
    |----------------------------------
    */
    Route::controller(AnnouncementController::class)->group(function () {
        Route::get('/pengumuman', 'guruIndex')->name('pengumuman');
        Route::post('/pengumuman', 'store')->name('pengumuman.store');
        Route::delete('/pengumuman/{id}', 'destroy')->name('pengumuman.destroy');
    });
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