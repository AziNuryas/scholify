<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',          // untuk siswa
        'nip',           // untuk guru
        'gender',        // L / P
        'birth_place',   // tempat lahir
        'birth_date',    // tanggal lahir
        'phone',
        'address',
        'class_id',      // untuk siswa (relasi ke kelas)
        'subject',       // mata pelajaran (untuk guru mapel)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke data siswa (jika role = siswa)
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Relasi ke data guru (jika role = guru_bk atau guru)
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Relasi ke kelas (untuk siswa)
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relasi ke kelas yang diwalikan (untuk guru BK/wali kelas)
     */
    public function homeroomClass(): HasOne
    {
        return $this->hasOne(SchoolClass::class, 'homeroom_teacher_id');
    }

    /**
     * Relasi ke chat yang dikirim user
     */
    public function sentChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    /**
     * Relasi ke chat yang diterima user
     */
    public function receivedChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    /**
     * Semua chat user (gabungan sent & received)
     */
    public function chats(): HasMany
    {
        return $this->sentChats()->union($this->receivedChats());
    }

    /**
     * Pengumuman yang dibuat oleh user (guru)
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'teacher_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope untuk filter siswa
     */
    public function scopeSiswa(Builder $query): Builder
    {
        return $query->where('role', 'siswa');
    }

    /**
     * Scope untuk filter guru (BK & Mapel)
     */
    public function scopeGuru(Builder $query): Builder
    {
        return $query->whereIn('role', ['guru', 'guru_bk']);
    }

    /**
     * Scope untuk filter admin
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah guru BK
     */
    public function isGuruBK(): bool
    {
        return $this->role === 'guru_bk';
    }

    /**
     * Cek apakah user adalah guru Mapel
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Cek apakah user adalah siswa
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /**
     * Cek apakah user adalah guru (BK atau Mapel)
     */
    public function isTeacher(): bool
    {
        return in_array($this->role, ['guru', 'guru_bk']);
    }

    /**
     * Mendapatkan role label dalam bahasa Indonesia
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'guru' => 'Guru Mapel',
            'guru_bk' => 'Guru BK',
            'siswa' => 'Siswa',
            default => $this->role,
        };
    }

    /**
     * Cek apakah user memiliki akses ke fitur chat
     */
    public function canChat(): bool
    {
        return in_array($this->role, ['siswa', 'guru_bk']);
    }

    /**
     * Cek apakah user bisa membuat pengumuman
     */
    public function canCreateAnnouncement(): bool
    {
        return in_array($this->role, ['admin', 'guru', 'guru_bk']);
    }

    /**
     * Mendapatkan nama kelas (untuk siswa)
     */
    public function getClassNameAttribute(): ?string
    {
        return $this->class ? $this->class->name : null;
    }
}