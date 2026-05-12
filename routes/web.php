<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentMenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DeteksiDiniController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\CatatanKonselingController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JadwalPelajaranController; // <-- PERBAIKAN: nama controller yang benar
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/api/agendas', [AgendaController::class, 'calendarEvents'])->name('api.agendas');
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->controller(NotificationController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/fetch', 'fetch')->name('fetch');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::delete('/delete-all', 'destroyAll')->name('delete-all');
        Route::post('/mark-all-read', 'markAllRead')->name('mark-all-read');
    });
    
    // STUDENT AREA
    Route::middleware([CheckRole::class . ':siswa'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/schedule', [StudentMenuController::class, 'schedule'])->name('schedule');
        Route::get('/assignments', [StudentMenuController::class, 'assignments'])->name('assignments');
        Route::post('/assignments/submit', [StudentMenuController::class, 'submitAssignment'])->name('assignments.submit');
        Route::get('/grades', [StudentMenuController::class, 'grades'])->name('grades');
        Route::get('/counseling', [StudentMenuController::class, 'counseling'])->name('counseling');
        Route::post('/counseling', [StudentMenuController::class, 'sendCounselingMessage'])->name('counseling.send');
        Route::get('/profile', [StudentMenuController::class, 'profile'])->name('profile');
        Route::post('/profile', [StudentMenuController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile', [StudentMenuController::class, 'updateProfile'])->name('profile.update.put');
        Route::get('/settings', [StudentMenuController::class, 'settings'])->name('settings');
        Route::post('/settings', [StudentMenuController::class, 'updateSettings'])->name('settings.update');
        Route::get('/materials', [StudentMenuController::class, 'materials'])->name('materials');
        Route::get('/agenda', [StudentMenuController::class, 'agenda'])->name('agenda');
        Route::get('/appointments', [StudentMenuController::class, 'appointments'])->name('appointments');
        Route::post('/appointments', [StudentMenuController::class, 'storeAppointment'])->name('appointments.store');
        Route::get('/discipline', [StudentMenuController::class, 'discipline'])->name('discipline');
        Route::get('/absensi', [StudentMenuController::class, 'absensi'])->name('absensi');
        Route::post('/absensi/store', [StudentMenuController::class, 'storeAbsensi'])->name('absensi.store');
        Route::get('/notifications', [StudentMenuController::class, 'notifications'])->name('notifications');
        Route::get('/notifications/fetch', [StudentMenuController::class, 'fetchNotifications'])->name('notifications.fetch');
        Route::post('/notifications/{id}/read', [StudentMenuController::class, 'markNotificationAsRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [StudentMenuController::class, 'deleteNotification'])->name('notifications.delete');
        Route::delete('/notifications/delete-all', [StudentMenuController::class, 'deleteAllNotifications'])->name('notifications.delete-all');
        Route::post('/notifications/mark-all-read', [StudentMenuController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
        
        Route::prefix('asesmen')->name('asesmen.')->group(function () {
            Route::get('/', [AsesmenController::class, 'index'])->name('index');
            Route::get('/isi/{jenis}', [AsesmenController::class, 'isi'])->name('isi');
            Route::post('/simpan/{asesmen}', [AsesmenController::class, 'simpan'])->name('simpan');
            Route::get('/hasil/{asesmen}', [AsesmenController::class, 'hasil'])->name('hasil');
        });
    });
    
    // GURU BK AREA
    Route::middleware('auth')->prefix('guru-bk')->name('gurubk.')->group(function () {

        Route::controller(GuruBkController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
    
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile', 'updateProfile')->name('profile.update');
    
            Route::get('/appointments', 'appointments')->name('appointments');
            Route::post('/appointments/{id}/status', 'updateAppointmentStatus')->name('appointments.status');
    
            Route::get('/discipline', 'discipline')->name('discipline');
            Route::post('/discipline', 'storeDiscipline')->name('discipline.store');
    
            // Catatan Konseling
            Route::resource('catatan-konseling', CatatanKonselingController::class);
    
            // Deteksi Dini & Asesmen
            Route::get('/deteksi-asesmen', 'deteksiAsesmen')->name('deteksi-asesmen.index');
    
            // Laporan dari Guru (BK menindaklanjuti)
            Route::get('/laporan', 'laporanIndex')->name('laporan.index');
            Route::patch('/laporan/{laporan}/proses', 'laporanProses')->name('laporan.proses');
        });
    });
    
    // GURU MAPEL AREA (VERSI GABUNGAN)
    Route::middleware([CheckRole::class . ':guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::controller(GuruController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/jadwal', 'jadwal')->name('jadwal');
            Route::get('/absensi', 'absensi')->name('absensi');
            Route::post('/absensi/store', 'absensiStore')->name('absensi.store');
            Route::get('/raport', 'raport')->name('raport');
            Route::get('/profil', 'profil')->name('profil');
            Route::post('/profil/update', 'profilUpdate')->name('profil.update');
            Route::post('/nilai/update', 'nilaiUpdate')->name('nilai.update');
        });

        Route::controller(GradeController::class)->group(function () {
            Route::get('/nilai', 'index')->name('nilai');
            Route::post('/nilai', 'store')->name('nilai.store');
        });

        Route::controller(AssignmentController::class)->group(function () {
            Route::get('/tugas', 'index')->name('tugas');
            Route::get('/tugas/create', 'create')->name('tugas.create');
            Route::post('/tugas', 'store')->name('tugas.store');
            Route::get('/tugas/{id}/edit', 'edit')->name('tugas.edit');
            Route::put('/tugas/{id}', 'update')->name('tugas.update');
            Route::delete('/tugas/{id}', 'destroy')->name('tugas.destroy');
            Route::post('/tugas/{id}/toggle', 'toggleComplete')->name('tugas.toggle');
        });

        Route::controller(AnnouncementController::class)->group(function () {
            Route::get('/pengumuman', 'guruIndex')->name('pengumuman');
            Route::post('/pengumuman', 'store')->name('pengumuman.store');
            Route::delete('/pengumuman/{id}', 'destroy')->name('pengumuman.destroy');
            Route::get('/pengumuman/download/{id}', 'download')->name('pengumuman.download');
        });

        Route::prefix('laporan-siswa')->name('laporan.')->group(function () {
            Route::get('/', [LaporanSiswaController::class, 'index'])->name('index');
            Route::get('/buat', [LaporanSiswaController::class, 'create'])->name('create');
            Route::post('/', [LaporanSiswaController::class, 'store'])->name('store');
            Route::get('/{laporan}', [LaporanSiswaController::class, 'show'])->name('show');
        });
    });
    
    // ADMIN AREA
    Route::middleware([CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Student Management
        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{id}', [AdminController::class, 'showStudent'])->name('students.show');
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
        Route::get('/agendas', [AgendaController::class, 'index'])->name('agendas.index');
        Route::get('/agendas/create', [AgendaController::class, 'create'])->name('agendas.create');
        Route::post('/agendas', [AgendaController::class, 'store'])->name('agendas.store');
        Route::get('/agendas/{id}/edit', [AgendaController::class, 'edit'])->name('agendas.edit');
        Route::put('/agendas/{id}', [AgendaController::class, 'update'])->name('agendas.update');
        Route::delete('/agendas/{id}', [AgendaController::class, 'destroy'])->name('agendas.delete');
        Route::post('/agendas/{id}/toggle', [AgendaController::class, 'toggleActive'])->name('agendas.toggle');
        
        // Class Management
        Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
        Route::get('/classes/create', [AdminController::class, 'createClass'])->name('classes.create');
        Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
        Route::get('/classes/{id}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
        Route::put('/classes/{id}', [AdminController::class, 'updateClass'])->name('classes.update');
        Route::delete('/classes/{id}', [AdminController::class, 'deleteClass'])->name('classes.delete');
        Route::post('/classes/{class}/add-student', [AdminController::class, 'addStudentToClass'])->name('classes.add-student');
        Route::delete('/classes/{class}/remove-student/{student}', [AdminController::class, 'removeStudentFromClass'])->name('classes.remove-student');
        
        // ==================== JADWAL PELAJARAN MANAGEMENT ====================
        Route::resource('jadwal', JadwalPelajaranController::class);
        Route::get('/jadwal/export-pdf', [JadwalPelajaranController::class, 'exportPdf'])->name('jadwal.export-pdf');
        Route::get('/jadwal/export-excel', [JadwalPelajaranController::class, 'exportExcel'])->name('jadwal.export-excel');
        Route::post('/jadwal/{id}/toggle-status', [JadwalPelajaranController::class, 'toggleStatus'])->name('jadwal.toggle-status');
        
        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/export-pdf', [AdminController::class, 'exportPdf'])->name('reports.export-pdf');
        Route::get('/reports/export-excel', [AdminController::class, 'exportExcel'])->name('reports.export-excel');
        
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });
    
    // BK / KONSELOR - Deteksi Dini & Asesmen
    Route::middleware([CheckRole::class . ':guru_bk'])->prefix('bk')->name('bk.')->group(function () {
        Route::prefix('deteksi-dini')->name('deteksi.')->group(function () {
            Route::get('/', [DeteksiDiniController::class, 'index'])->name('index');
            Route::get('/siswa', [DeteksiDiniController::class, 'daftarSiswa'])->name('daftar-siswa');
            Route::get('/siswa/{siswaId}', [DeteksiDiniController::class, 'detailSiswa'])->name('detail-siswa');
            Route::get('/laporan', [DeteksiDiniController::class, 'daftarLaporan'])->name('laporan');
            Route::patch('/laporan/{laporan}/proses', [DeteksiDiniController::class, 'prosesLaporan'])->name('laporan.proses');
            Route::get('/asesmen/{asesmen}', [DeteksiDiniController::class, 'detailAsesmen'])->name('asesmen.detail');
            Route::patch('/asesmen/{asesmen}/catatan', [DeteksiDiniController::class, 'catatanAsesmen'])->name('asesmen.catatan');
            Route::post('/refresh-skor', [DeteksiDiniController::class, 'refreshSemuaSkor'])->name('refresh-skor');
        });
    });
});