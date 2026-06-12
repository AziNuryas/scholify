<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    
    protected $fillable = [
        'student_id',
        'subject_id',
        'assessment_type',
        'score',
        'class_id',
        'teacher_id',
        'notes',
        'semester',
        'academic_year'
    ];

    /**
     * Relasi ke Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relasi ke Subject (Mata Pelajaran)
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relasi ke Teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Relasi ke Class
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}