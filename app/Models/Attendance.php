<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    
    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'status',
        'notes',
        'recorded_by',
        'recorded_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'date',
        'recorded_at' => 'datetime',
    ];

    // Relasi ke Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Class
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    
    // Relasi ke guru yang merekam
    public function recordedBy()
    {
        return $this->belongsTo(Teacher::class, 'recorded_by');
    }
}