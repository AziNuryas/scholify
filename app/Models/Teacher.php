<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'phone',
        'birth_place',
        'address',
        'avatar',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kelas yang diwalikan
     */
    public function homeroomClasses(): HasMany
    {
        return $this->hasMany(Classes::class, 'homeroom_teacher_id');
    }

    /**
     * Mendapatkan nama lengkap guru (dari tabel teachers atau users)
     */
    public function getFullNameAttribute(): string
    {
        return $this->name ?? $this->user->name ?? 'Tanpa Nama';
    }
}