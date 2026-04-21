<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'class_id', // ⬅️ penting untuk sistem pengumuman siswa
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting attributes
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke data student (jika ada tabel students)
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Relasi ke data teacher (jika ada tabel teachers)
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Relasi ke kelas (class siswa)
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Pengumuman yang dibuat oleh user (guru)
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'teacher_id');
    }

    /**
     * Chat yang dikirim user
     */
    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    /**
     * Chat yang diterima user
     */
    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }
}