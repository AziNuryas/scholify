<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AgendaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Tidak perlu login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes (Harus login)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ========== API Agenda (bisa diakses semua role) ==========
    Route::get('/api/agendas', [AgendaController::class, 'calendarEvents'])->name('api.agendas');
    
    // ========== STUDENT AREA ==========
    Route::middleware(['checkRole:siswa'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/schedule', [StudentMenuController::class, 'schedule'])->name('schedule');
        Route::get('/assignments', [StudentMenuController::class, 'assignments'])->name('assignments');
        Route::get('/grades', [StudentMenuController::class, 'grades'])->name('grades');
        Route::get('/counseling', [StudentMenuController::class, 'counseling'])->name('counseling');
        Route::post('/counseling', [StudentMenuController::class, 'sendCounselingMessage'])->name('counseling.send');
        Route::get('/profile', [StudentMenuController::class, 'profile'])->name('profile');
        Route::post('/profile', [StudentMenuController::class, 'updateProfile'])->name('profile.update');
        Route::get('/appointments', [StudentMenuController::class, 'appointments'])->name('appointments');
        Route::post('/appointments', [StudentMenuController::class, 'storeAppointment'])->name('appointment.store');
        Route::get('/discipline', [StudentMenuController::class, 'discipline'])->name('discipline');
    });
    
    // ========== GURU AREA (BK & Mapel) ==========
    Route::middleware(['checkRole:guru,guru_bk'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [GuruBkController::class, 'index'])->name('dashboard');
        Route::get('/chats', [GuruBkController::class, 'chats'])->name('chats');
        Route::post('/chats/reply', [GuruBkController::class, 'reply'])->name('reply');
        Route::get('/profile', [GuruBkController::class, 'profile'])->name('profile');
        Route::post('/profile', [GuruBkController::class, 'updateProfile'])->name('profile.update');
        Route::get('/appointments', [GuruBkController::class, 'appointments'])->name('appointments');
        Route::post('/appointments/{id}/status', [GuruBkController::class, 'updateAppointmentStatus'])->name('appointment.status');
        Route::get('/discipline', [GuruBkController::class, 'discipline'])->name('discipline');
        Route::post('/discipline', [GuruBkController::class, 'storeDiscipline'])->name('discipline.store');
    });
    
    // ========== ADMIN AREA ==========
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Student Management
        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
        
        // Teacher Management
        Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
        Route::get('/teachers/create', [AdminController::class, 'createTeacher'])->name('teachers.create');
        Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [AdminController::class, 'editTeacher'])->name('teachers.edit');
        Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('teachers.update');
        Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('teachers.delete');
        
        // Agenda Management
       // Agenda Management
        Route::get('/agendas', [AgendaController::class, 'index'])->name('agendas.index');
        Route::get('/agendas/create', [AgendaController::class, 'create'])->name('agendas.create');
        Route::post('/agendas', [AgendaController::class, 'store'])->name('agendas.store');
        Route::get('/agendas/{id}/edit', [AgendaController::class, 'edit'])->name('agendas.edit');
        Route::put('/agendas/{id}', [AgendaController::class, '204'])->name('agendas.update');
        Route::delete('/agendas/{id}', [AgendaController::class, 'destroy'])->name('agendas.delete');
        Route::post('/agendas/{id}/toggle', [AgendaController::class, 'toggleActive'])->name('agendas.toggle');
        
        // Class Management
        Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
        Route::get('/classes/create', [AdminController::class, 'createClass'])->name('classes.create');
        Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
        Route::get('/classes/{id}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
        Route::put('/classes/{id}', [AdminController::class, 'updateClass'])->name('classes.update');
        Route::delete('/classes/{id}', [AdminController::class, 'deleteClass'])->name('classes.delete'); // ← PERBAIKAN
        
        // Class - Student Management
        Route::post('/classes/{class}/add-student', [AdminController::class, 'addStudentToClass'])->name('classes.add-student');
        Route::delete('/classes/{class}/remove-student/{student}', [AdminController::class, 'removeStudentFromClass'])->name('classes.remove-student');
        
        // Reports & Settings
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });
});

// API Routes
Route::middleware(['auth'])->prefix('api/chat')->name('api.chat.')->group(function () {
    Route::get('/fetch/{partnerId}', [ChatController::class, 'fetch'])->name('fetch');
    Route::post('/send', [ChatController::class, 'send'])->name('send');
    Route::get('/unread', [ChatController::class, 'unreadCount'])->name('unread');
});