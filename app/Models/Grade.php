<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'type',
        'score',
        'semester',
        'academic_year'
    ];

    // Relasi ke student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke subject (mata pelajaran)
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}