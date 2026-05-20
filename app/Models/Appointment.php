<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Apakah appointment ini dibuat oleh BK (bukan siswa)
     */
    public function isInitiatedByTeacher(): bool
    {
        return $this->initiated_by === 'teacher';
    }
}