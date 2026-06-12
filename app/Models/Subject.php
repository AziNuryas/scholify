<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Relasi ke KKM
     */
    public function kkms(): HasMany
    {
        return $this->hasMany(Kkm::class);
    }

    /**
     * Relasi ke Grades (Nilai)
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }

    /**
     * Relasi ke Schedules (Jadwal)
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'subject_id');
    }

    /**
     * Relasi ke Assignments (Tugas)
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'subject_id');
    }
}