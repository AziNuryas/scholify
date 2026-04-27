<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsesmenSiswa extends Model
{
    use HasFactory;

    protected $table = 'asesmen_siswa';

    protected $fillable = [
        'siswa_id', 'jenis_asesmen', 'tahun_ajaran', 'semester',
        'jawaban', 'hasil_analisis', 'status', 'selesai_at',
        'ditinjau_oleh', 'catatan_bk',
    ];

    protected $casts = [
        'jawaban'         => 'array',
        'hasil_analisis'  => 'array',
        'selesai_at'      => 'datetime',
    ];

    // ── Relasi ──────────────────────────────────────────────────────────────
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function peninjau()
    {
        return $this->belongsTo(User::class, 'ditinjau_oleh');
    }

    // ── Label Jenis Asesmen ─────────────────────────────────────────────────
    public function getLabelJenisAttribute(): string
    {
        return match ($this->jenis_asesmen) {
            'sosiometri'      => 'Sosiometri',
            'minat_bakat'     => 'Inventori Minat & Bakat',
            'gaya_belajar'    => 'Gaya Belajar (VAK)',
            'kesehatan_mental'=> 'Skrining Kesehatan Mental',
            'masalah_umum'    => 'Daftar Cek Masalah (DCM)',
            default           => $this->jenis_asesmen,
        };
    }

    // ── Analisis Hasil Gaya Belajar ─────────────────────────────────────────
    /**
     * Menghitung skor VAK dari jawaban gaya belajar.
     * Setiap jawaban: 'V' = visual, 'A' = auditori, 'K' = kinestetik
     */
    public function hitungGayaBelajar(): array
    {
        if ($this->jenis_asesmen !== 'gaya_belajar') return [];

        $skor = ['visual' => 0, 'auditori' => 0, 'kinestetik' => 0];
        foreach ($this->jawaban ?? [] as $jawaban) {
            if (isset($skor[strtolower($jawaban)])) {
                $skor[strtolower($jawaban)]++;
            }
        }

        $dominan = array_search(max($skor), $skor);
        return ['skor' => $skor, 'dominan' => $dominan];
    }

    // ── Analisis Minat Bakat (Holland RIASEC) ────────────────────────────────
    public function hitungMinatBakat(): array
    {
        if ($this->jenis_asesmen !== 'minat_bakat') return [];

        $kategori = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
        $labelHolland = [
            'R' => 'Realistik (Teknik/Alam)',
            'I' => 'Investigatif (Riset/Ilmiah)',
            'A' => 'Artistik (Seni/Kreatif)',
            'S' => 'Sosial (Membantu orang lain)',
            'E' => 'Enterprising (Wirausaha/Kepemimpinan)',
            'C' => 'Konvensional (Administrasi/Data)',
        ];

        foreach ($this->jawaban ?? [] as $jawaban) {
            if (isset($kategori[strtoupper($jawaban)])) {
                $kategori[strtoupper($jawaban)]++;
            }
        }

        arsort($kategori);
        $top3 = array_slice($kategori, 0, 3, true);

        return [
            'skor'     => $kategori,
            'top3'     => array_map(fn($k) => $labelHolland[$k], array_keys($top3)),
            'kode'     => implode('', array_keys($top3)),
        ];
    }
}
