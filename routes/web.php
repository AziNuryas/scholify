<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// 🔥 FIX UTAMA: Tambahkan GET /login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']); // penting!
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard global (optional)
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| STUDENT AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('student')->group(function () {

    Route::get('/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

    Route::get('/schedule', [StudentMenuController::class, 'schedule'])
        ->name('student.schedule');

    Route::get('/assignments', [StudentMenuController::class, 'assignments'])
        ->name('student.assignments');

    Route::get('/grades', [StudentMenuController::class, 'grades'])
        ->name('student.grades');

    Route::get('/counseling', [StudentMenuController::class, 'counseling'])
        ->name('student.counseling');

    Route::post('/counseling', [StudentMenuController::class, 'sendCounselingMessage'])
        ->name('student.counseling.send');

    Route::get('/profile', [StudentMenuController::class, 'profile'])
        ->name('student.profile');

    Route::post('/profile', [StudentMenuController::class, 'updateProfile'])
        ->name('student.profile.update');

    Route::get('/appointments', [StudentMenuController::class, 'appointments'])
        ->name('student.appointments');

    Route::post('/appointments', [StudentMenuController::class, 'storeAppointment'])
        ->name('student.appointment.store');

    Route::get('/discipline', [StudentMenuController::class, 'discipline'])
        ->name('student.discipline');
});


/*
|--------------------------------------------------------------------------
| GURU BK AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('guru-bk')->group(function () {

    Route::get('/dashboard', [GuruBkController::class, 'index'])
        ->name('gurubk.dashboard');

    Route::get('/chats', [GuruBkController::class, 'chats'])
        ->name('gurubk.chats');

    Route::post('/chats/reply', [GuruBkController::class, 'reply'])
        ->name('gurubk.reply');

    Route::get('/profile', [GuruBkController::class, 'profile'])
        ->name('gurubk.profile');

    Route::post('/profile', [GuruBkController::class, 'updateProfile'])
        ->name('gurubk.profile.update');

    Route::get('/appointments', [GuruBkController::class, 'appointments'])
        ->name('gurubk.appointments');

    Route::post('/appointments/{id}/status', [GuruBkController::class, 'updateAppointmentStatus'])
        ->name('gurubk.appointment.status');

    Route::get('/discipline', [GuruBkController::class, 'discipline'])
        ->name('gurubk.discipline');

    Route::post('/discipline', [GuruBkController::class, 'storeDiscipline'])
        ->name('gurubk.discipline.store');
});


/*
|--------------------------------------------------------------------------
| GURU NON BK (SIDEBAR KAMU 🔥)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('guru')->group(function () {

    Route::get('/dashboard', fn() => view('guru.dashboard'))
        ->name('guru.dashboard');

    Route::get('/jadwal', fn() => view('guru.jadwal'))
        ->name('guru.jadwal');

    Route::get('/absensi', fn() => view('guru.absensi'))
        ->name('guru.absensi');

    Route::get('/nilai', fn() => view('guru.nilai'))
        ->name('guru.nilai');

    Route::get('/raport', fn() => view('guru.raport'))
        ->name('guru.raport');

    Route::get('/pengumuman', fn() => view('guru.pengumuman'))
        ->name('guru.pengumuman');
});


/*
|--------------------------------------------------------------------------
| CHAT API
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('api/chat')->group(function () {

    Route::get('/fetch/{partnerId}', [ChatController::class, 'fetch'])
        ->name('chat.fetch');

    Route::post('/send', [ChatController::class, 'send'])
        ->name('chat.send');

    Route::get('/unread', [ChatController::class, 'unreadCount'])
        ->name('chat.unread');
});