<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanGuru extends Model
{
    use SoftDeletes;
    
    protected $table = 'laporan_guru';
    
    protected $fillable = [
        'guru_id',
        'siswa_id',
        'kategori',
        'judul',
        'deskripsi',
        'tingkat_urgensi',
        'status',
        'tindak_lanjut',
        'ditangani_oleh',
        'ditangani_at',
        'bukti_pendukung',
    ];
    
    protected $casts = [
        'ditangani_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'bukti_pendukung' => 'array',
    ];
    
    // ========== RELATIONS ==========
    
    // Relasi ke siswa (field siswa_id)
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }
    
    // Alias student untuk kompatibilitas
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }
    
    // Relasi ke guru pembuat laporan
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    
    // Relasi ke BK yang menangani
    public function ditanganiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
    
    // Alias untuk processedBy
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
    
    // Alias untuk penanggungjawab (untuk kompatibilitas dengan LaporanSiswaController)
    public function penanggungjawab(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
    
    // ========== ACCESSORS ==========
    
    // Untuk kompatibilitas view
    public function getTitleAttribute()
    {
        return $this->judul;
    }
    
    public function getDescriptionAttribute()
    {
        return $this->deskripsi;
    }
    
    public function getResolutionNotesAttribute()
    {
        return $this->tindak_lanjut;
    }
    
    public function getProcessedAtAttribute()
    {
        return $this->ditangani_at;
    }
    
    public function getProcessedByAttribute()
    {
        return $this->ditangani_oleh;
    }
    
    // Label urgensi
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
    
    // Label status
    public function getLabelStatusAttribute()
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditutup' => 'Ditutup',
            default => $this->status,
        };
    }
    
    // Warna untuk badge status
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'baru' => 'amber',
            'diproses' => 'blue',
            'selesai' => 'emerald',
            'ditutup' => 'gray',
            default => 'gray',
        };
    }
    
    // Warna untuk badge urgensi
    public function getUrgensiColorAttribute()
    {
        return match ($this->tingkat_urgensi) {
            'kritis' => 'red',
            'tinggi' => 'amber',
            'sedang' => 'blue',
            'rendah' => 'green',
            default => 'gray',
        };
    }
    
    // ========== SCOPES ==========
    
    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }
    
    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }
    
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}