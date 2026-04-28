<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Assignment extends Model
{
    protected $table = 'assignments';
    
    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'title',
        'description',
        'file',
        'type',
        'due_date',
        'is_completed',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean'
    ];

    protected $dates = [
        'due_date',
        'completed_at',
        'created_at',
        'updated_at'
    ];

    // RELASI
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assignment_id');
    }

    // Accessor untuk status text
    public function getStatusTextAttribute(): string
    {
        return $this->is_completed ? 'Selesai' : 'Belum Selesai';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute(): string
    {
        return $this->is_completed ? 'green' : 'orange';
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_completed) {
            return '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>';
        }
        return '<span class="badge badge-warning"><i class="fas fa-clock"></i> Belum Selesai</span>';
    }

    // Scope untuk tugas yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    // Scope untuk tugas yang belum selesai
    public function scopeActive($query)
    {
        return $query->where('is_completed', false);
    }

    // Scope untuk tugas berdasarkan tipe
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk tugas berdasarkan kelas
    public function scopeInClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    // Scope untuk tugas yang deadline-nya sudah lewat
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                     ->where('is_completed', false);
    }
}