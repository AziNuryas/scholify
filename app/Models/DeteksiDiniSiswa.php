<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeteksiDiniSiswa extends Model
{
    protected $table = 'deteksi_dini_siswa';

    protected $fillable = [
        'siswa_id', 'tahun_ajaran', 'semester', 'skor_risiko',
        'kategori_risiko', 'faktor_risiko', 'total_laporan_guru',
        'laporan_urgensi_tinggi', 'asesmen_selesai', 'rekomendasi',
        'terakhir_diperbarui',
    ];

    protected $casts = [
        'faktor_risiko'       => 'array',
        'rekomendasi'         => 'array',
        'asesmen_selesai'     => 'boolean',
        'terakhir_diperbarui' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function getBadgeColorAttribute(): string
    {
        return match ($this->kategori_risiko) {
            'aman'       => 'success',
            'perhatian'  => 'info',
            'berisiko'   => 'warning',
            'kritis'     => 'danger',
            default      => 'secondary',
        };
    }
}
