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
    
    // Antrian Jadwal Temu & Catatan Disiplin (Student)
    Route::get('/student/appointments', [StudentMenuController::class, 'appointments'])->name('student.appointments');
    Route::post('/student/appointments', [StudentMenuController::class, 'storeAppointment'])->name('student.appointment.store');
    
    Route::get('/student/discipline', [StudentMenuController::class, 'discipline'])->name('student.discipline');
});

// Guru BK Area
Route::middleware('web')->group(function () {
    Route::get('/guru-bk/dashboard', [\App\Http\Controllers\GuruBkController::class, 'index'])->name('gurubk.dashboard');
    Route::get('/guru-bk/chats', [\App\Http\Controllers\GuruBkController::class, 'chats'])->name('gurubk.chats');
    Route::post('/guru-bk/chats/reply', [\App\Http\Controllers\GuruBkController::class, 'reply'])->name('gurubk.reply');
    
    Route::get('/guru-bk/profile', [\App\Http\Controllers\GuruBkController::class, 'profile'])->name('gurubk.profile');
    Route::post('/guru-bk/profile', [\App\Http\Controllers\GuruBkController::class, 'updateProfile'])->name('gurubk.profile.update');
    
    // Antrian Jadwal Temu & Catatan Disiplin
    Route::get('/guru-bk/appointments', [\App\Http\Controllers\GuruBkController::class, 'appointments'])->name('gurubk.appointments');
    Route::post('/guru-bk/appointments/{id}/status', [\App\Http\Controllers\GuruBkController::class, 'updateAppointmentStatus'])->name('gurubk.appointment.status');
    
    Route::get('/guru-bk/discipline', [\App\Http\Controllers\GuruBkController::class, 'discipline'])->name('gurubk.discipline');
    Route::post('/guru-bk/discipline', [\App\Http\Controllers\GuruBkController::class, 'storeDiscipline'])->name('gurubk.discipline.store');
});

// Chat API Routes (for AJAX)
Route::middleware('web')->group(function () {
    Route::get('/api/chat/fetch/{partnerId}', [\App\Http\Controllers\ChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/api/chat/send', [\App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/api/chat/unread', [\App\Http\Controllers\ChatController::class, 'unreadCount'])->name('chat.unread');
});