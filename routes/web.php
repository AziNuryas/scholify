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
use App\Http\Controllers\DeteksiDiniController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\CatatanKonselingController;

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

        // PROFILE - menggunakan POST (bisa juga ditambahkan PUT jika perlu)
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');
        
        // Tambahkan route PUT untuk mendukung method PUT jika diperlukan
        Route::put('/profile', 'updateProfile')->name('profile.update.put');

        Route::get('/appointments', 'appointments')->name('appointments');
        Route::post('/appointments', 'storeAppointment')->name('appointments.store');

        Route::get('/discipline', 'discipline')->name('discipline');

        Route::get('/absensi', 'absensi')->name('absensi');
        Route::post('/absensi/store', 'storeAbsensi')->name('absensi.store');
        
        // Notifications
        Route::get('/notifications', 'notifications')->name('notifications');
        Route::get('/notifications/fetch', 'fetchNotifications')->name('notifications.fetch');
        Route::post('/notifications/{id}/read', 'markNotificationAsRead')->name('notifications.read');
    });


    // Asesmen mandiri siswa
    Route::prefix('asesmen')->name('asesmen.')->group(function () {
        Route::get('/',                  [AsesmenController::class, 'index'])->name('index');
        Route::get('/isi/{jenis}',       [AsesmenController::class, 'isi'])->name('isi');
        Route::post('/simpan/{asesmen}', [AsesmenController::class, 'simpan'])->name('simpan');
        Route::get('/hasil/{asesmen}',   [AsesmenController::class, 'hasil'])->name('hasil');
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

        // Catatan Konseling
        Route::resource('catatan-konseling', CatatanKonselingController::class);

        // Deteksi Dini & Asesmen
        Route::get('/deteksi-asesmen', 'deteksiAsesmen')->name('deteksi-asesmen.index');

        // Laporan dari Guru (BK menindaklanjuti)
        Route::get('/laporan', 'laporanIndex')->name('laporan.index');
        Route::patch('/laporan/{laporan}/proses', 'laporanProses')->name('laporan.proses');
    });
});


/*
|--------------------------------------------------------------------------
| GURU MAPEL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('guru')->name('guru.')->group(function () {

    Route::view('/dashboard', 'guru.dashboard')->name('dashboard');
    Route::view('/jadwal', 'guru.jadwal')->name('jadwal');
    Route::view('/absensi', 'guru.absensi')->name('absensi');
    Route::view('/raport', 'guru.raport')->name('raport');
    Route::view('/profil', 'guru.profil')->name('profil');

    Route::controller(GradeController::class)->group(function () {
        Route::get('/nilai', 'index')->name('nilai');
        Route::post('/nilai', 'store')->name('nilai.store');
    });

    Route::controller(AssignmentController::class)->group(function () {
        Route::get('/tugas', 'index')->name('tugas');
        Route::post('/tugas', 'store')->name('tugas.store');
        Route::put('/tugas/{id}', 'update')->name('tugas.update');
        Route::delete('/tugas/{id}', 'destroy')->name('tugas.destroy');
    });

    Route::controller(AnnouncementController::class)->group(function () {
        Route::get('/pengumuman', 'guruIndex')->name('pengumuman');
        Route::post('/pengumuman', 'store')->name('pengumuman.store');
        Route::delete('/pengumuman/{id}', 'destroy')->name('pengumuman.destroy');
    });

    // Laporan siswa bermasalah (guru mapel)
    Route::prefix('laporan-siswa')->name('laporan.')->group(function () {
        Route::get('/',          [LaporanSiswaController::class, 'index'])->name('index');
        Route::get('/buat',      [LaporanSiswaController::class, 'create'])->name('create');
        Route::post('/',         [LaporanSiswaController::class, 'store'])->name('store');
        Route::get('/{laporan}', [LaporanSiswaController::class, 'show'])->name('show');
    });
});


/*
|--------------------------------------------------------------------------
| BK / KONSELOR — Deteksi Dini & Asesmen
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('bk')->name('bk.')->group(function () {

    Route::prefix('deteksi-dini')->name('deteksi.')->group(function () {
        Route::get('/',                                   [DeteksiDiniController::class, 'index'])->name('index');
        Route::get('/siswa',                              [DeteksiDiniController::class, 'daftarSiswa'])->name('daftar-siswa');
        Route::get('/siswa/{siswaId}',                    [DeteksiDiniController::class, 'detailSiswa'])->name('detail-siswa');
        Route::get('/laporan',                            [DeteksiDiniController::class, 'daftarLaporan'])->name('laporan');
        Route::patch('/laporan/{laporan}/proses',         [DeteksiDiniController::class, 'prosesLaporan'])->name('laporan.proses');
        Route::get('/asesmen/{asesmen}',                  [DeteksiDiniController::class, 'detailAsesmen'])->name('asesmen.detail');
        Route::patch('/asesmen/{asesmen}/catatan',        [DeteksiDiniController::class, 'catatanAsesmen'])->name('asesmen.catatan');
        Route::post('/refresh-skor',                      [DeteksiDiniController::class, 'refreshSemuaSkor'])->name('refresh-skor');
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