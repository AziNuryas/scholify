<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanGuru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_guru';

    protected $fillable = [
        'guru_id', 'siswa_id', 'kategori', 'judul', 'deskripsi',
        'tingkat_urgensi', 'status', 'tindak_lanjut',
        'ditangani_oleh', 'ditangani_at', 'bukti_pendukung',
    ];

    protected $casts = [
        'bukti_pendukung' => 'array',
        'ditangani_at'    => 'datetime',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // siswa_id = students.id (bukan users.id)
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    public function penanggungjawab()
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function scopeKritis($query)
    {
        return $query->where('tingkat_urgensi', 'kritis');
    }

    public function scopeTahunAjaran($query, $tahun)
    {
        return $query->whereYear('created_at', substr($tahun, 0, 4));
    }

    public function getLabelUrgensiAttribute(): string
    {
        return match ($this->tingkat_urgensi) {
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'kritis' => 'Kritis ⚠',
            default  => '-',
        };
    }

    public function getBadgeColorAttribute(): string
    {
        return match ($this->tingkat_urgensi) {
            'rendah' => 'success',
            'sedang' => 'warning',
            'tinggi' => 'danger',
            'kritis' => 'dark',
            default  => 'secondary',
        };
    }
}