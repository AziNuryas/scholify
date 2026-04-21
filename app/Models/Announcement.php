<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
        'content',
        'target',
        'class_id',
        'file',
        'status',
    ];

    /**
     * Relasi ke user (guru pembuat)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relasi ke kelas
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Scope: ambil pengumuman untuk siswa
     */
    public function scopeForStudent($query, $user)
    {
        return $query->where('target', 'all')
            ->orWhere(function ($q) use ($user) {
                $q->where('target', 'class')
                  ->where('class_id', $user->class_id);
            });
    }
}