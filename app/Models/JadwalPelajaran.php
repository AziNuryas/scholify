<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'school_class_id',
        'guru_id',
        'mata_pelajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'semester',
        'tahun_ajaran',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'jam_mulai'   => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // ── Relasi ──────────────────────────────────────────────
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'guru_id');
    }

    // ── Helpers ─────────────────────────────────────────────
    public function getDurasiAttribute(): string
    {
        $start  = \Carbon\Carbon::parse($this->jam_mulai);
        $end    = \Carbon\Carbon::parse($this->jam_selesai);
        $menit  = $start->diffInMinutes($end);
        $jam    = intdiv($menit, 60);
        $sisa   = $menit % 60;

        if ($jam > 0 && $sisa > 0) return "{$jam} jam {$sisa} menit";
        if ($jam > 0)              return "{$jam} jam";
        return "{$sisa} menit";
    }

    public function getJamFormatAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5) . ' – ' . substr($this->jam_selesai, 0, 5);
    }

    // ── Scopes ──────────────────────────────────────────────
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }

    public function scopeByTahunAjaran($query, string $tahun)
    {
        return $query->where('tahun_ajaran', $tahun);
    }
}