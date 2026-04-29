<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKonseling extends Model
{
    use HasFactory;

    protected $table = 'catatan_konseling';

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
        'tanggal_sesi',
        'jenis_konseling',
        'masalah',
        'tindakan',
        'rencana_tindak_lanjut',
        'status',
    ];

    protected $casts = [
        'tanggal_sesi' => 'date',
    ];

    // Label jenis konseling
    public static array $jenisLabels = [
        'konseling_individual'      => 'Konseling individual',
        'konseling_karir'           => 'Konseling karir',
        'konseling_akademik'        => 'Konseling akademik',
        'konseling_sosial_emosional'=> 'Konseling sosial-emosional',
        'tindak_lanjut_disiplin'    => 'Tindak lanjut disiplin',
    ];

    // Label status
    public static array $statusLabels = [
        'berjalan'      => 'Berjalan',
        'tindak_lanjut' => 'Tindak lanjut',
        'selesai'       => 'Selesai',
    ];

    public function getJenisLabelAttribute(): string
    {
        return self::$jenisLabels[$this->jenis_konseling] ?? $this->jenis_konseling;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? $this->status;
    }

    // Relasi ke tabel students
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    // Relasi ke tabel users (guru BK)
    public function guruBk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }
}