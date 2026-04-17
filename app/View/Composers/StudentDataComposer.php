<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Student;
use App\Models\Chat;

class StudentDataComposer
{
    /**
     * Bind data ke semua view yang menggunakan layout student.
     * Ini memastikan header (nama, kelas, avatar, unread) selalu real dari DB.
     */
    public function compose(View $view)
    {
        if (!auth()->check()) return;

        $user = auth()->user();

        // Ambil data student dari DB
        $studentModel = Student::with('schoolClass')
            ->where('user_id', $user->id)
            ->first();

        $currentStudent = [
            'name'   => $studentModel->name ?? $studentModel->first_name ?? $user->name,
            'class'  => $studentModel->schoolClass->name ?? 'Belum Diatur',
            'nis'    => $studentModel->nis ?? '-',
            'avatar' => $studentModel->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4318FF&color=fff&rounded=true',
        ];

        // Hitung unread messages dari Guru BK
        $unreadMessages = Chat::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        // Cek pengumuman terbaru (jika ada di tabel announcements)
        $latestAnnouncement = null;
        try {
            $latestAnnouncement = \Illuminate\Support\Facades\DB::table('announcements')
                ->whereIn('target', ['Semua', 'Siswa'])
                ->orderBy('created_at', 'desc')
                ->first();
        } catch (\Exception $e) {
            // Tabel belum ada atau kosong
        }

        $view->with(compact('currentStudent', 'unreadMessages', 'latestAnnouncement'));
    }
}
