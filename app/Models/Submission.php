<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $table = 'submissions';
    
    protected $fillable = [
        'assignment_id',
        'student_id',
        'file',          // sesuai database: file
        'note',          // sesuai database: note
        'status',
        'score',
        'submitted_at'
    ];
    
    protected $casts = [
        'submitted_at' => 'datetime',
        'score' => 'decimal:2'
    ];

    // Relasi ke Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Assignment
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
    
    // Helper: Cek apakah tugas terlambat
    public function isLate(): bool
    {
        if (!$this->assignment || !$this->assignment->due_date) {
            return false;
        }
        
        return $this->submitted_at > $this->assignment->due_date;
    }
}