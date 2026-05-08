<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanSiswa extends Model
{
    protected $table = 'laporan_siswa';

    protected $fillable = [
        'student_id',
        'guru_id',
        'title',
        'description',
        'kategori',
        'tingkat_urgensi',
        'status',
        'resolution_notes',
        'catatan_bk',
        'bukti_pendukung',
        'processed_at',
        'completed_at',
        'processed_by',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'bukti_pendukung' => 'array',
    ];

    // ========== RELATIONS ==========
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Alias 'siswa' untuk kompatibilitas view
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ========== ACCESSORS ==========
    
    public function getJudulAttribute()
    {
        return $this->title;
    }

    public function getDeskripsiAttribute()
    {
        return $this->description;
    }

    public function getLabelUrgensiAttribute()
    {
        return match ($this->tingkat_urgensi) {
            'kritis' => 'Kritis',
            'tinggi' => 'Tinggi',
            'sedang' => 'Sedang',
            'rendah' => 'Rendah',
            default => 'Sedang',
        };
    }

    public function getLabelStatusAttribute()
    {
        return match ($this->status) {
            'pending' => 'Baru',
            'processed' => 'Diproses',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    // ========== SCOPES ==========
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}