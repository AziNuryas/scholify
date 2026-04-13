<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;

Route::get('/students', [StudentController::class, 'index']);

// Student Area
Route::middleware('web')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/schedule', [StudentMenuController::class, 'schedule'])->name('student.schedule');
    Route::get('/student/assignments', [StudentMenuController::class, 'assignments'])->name('student.assignments');
    Route::get('/student/grades', [StudentMenuController::class, 'grades'])->name('student.grades');
    Route::get('/student/counseling', [StudentMenuController::class, 'counseling'])->name('student.counseling');
    Route::post('/student/counseling', [StudentMenuController::class, 'sendCounselingMessage'])->name('student.counseling.send');
    
    // Rute Profil (View & Update)
    Route::get('/student/profile', [StudentMenuController::class, 'profile'])->name('student.profile');
    Route::post('/student/profile', [StudentMenuController::class, 'updateProfile'])->name('student.profile.update');
});

// Guru BK Area
Route::middleware('web')->group(function () {
    Route::get('/guru-bk/dashboard', [\App\Http\Controllers\GuruBkController::class, 'index'])->name('gurubk.dashboard');
    Route::get('/guru-bk/chats', [\App\Http\Controllers\GuruBkController::class, 'chats'])->name('gurubk.chats');
    Route::post('/guru-bk/chats/reply', [\App\Http\Controllers\GuruBkController::class, 'reply'])->name('gurubk.reply');
    
    Route::get('/guru-bk/profile', [\App\Http\Controllers\GuruBkController::class, 'profile'])->name('gurubk.profile');
    Route::post('/guru-bk/profile', [\App\Http\Controllers\GuruBkController::class, 'updateProfile'])->name('gurubk.profile.update');
});