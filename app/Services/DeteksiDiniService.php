<?php

namespace App\Services;

use App\Models\LaporanGuru;
use App\Models\AsesmenSiswa;
use App\Models\DeteksiDiniSiswa;

class DeteksiDiniService
{
    /**
     * Hitung & simpan skor risiko siswa berdasarkan laporan + asesmen.
     * Dipanggil setiap kali ada laporan baru atau asesmen selesai.
     */
    public function hitungSkorRisiko(int $siswaId, string $tahunAjaran, string $semester): DeteksiDiniSiswa
    {
        $skor        = 0;
        $faktor      = [];
        $rekomendasi = [];

        // ─── 1. Analisis Laporan Guru ─────────────────────────────────────
        $laporan = LaporanGuru::where('siswa_id', $siswaId)
            ->whereYear('created_at', substr($tahunAjaran, 0, 4))
            ->get();

        $totalLaporan         = $laporan->count();
        $laporanKritis        = $laporan->where('tingkat_urgensi', 'kritis')->count();
        $laporanTinggi        = $laporan->where('tingkat_urgensi', 'tinggi')->count();
        $laporanKehadiran     = $laporan->where('kategori', 'kehadiran')->count();
        $laporanPerilaku      = $laporan->where('kategori', 'perilaku')->count();

        // Bobot skor dari laporan (maks ~60 poin)
        $skor += min($totalLaporan * 5, 20);

        if ($laporanKritis > 0) {
            $skor += $laporanKritis * 15;
            $faktor[]      = "Terdapat {$laporanKritis} laporan dengan urgensi KRITIS dari guru";
            $rekomendasi[] = 'Konseling segera, koordinasi wali kelas dan orang tua';
        }

        if ($laporanTinggi > 0) {
            $skor += $laporanTinggi * 8;
            $faktor[]      = "{$laporanTinggi} laporan urgensi tinggi dari guru";
            $rekomendasi[] = 'Jadwalkan konseling individu dalam waktu dekat';
        }

        if ($laporanKehadiran >= 3) {
            $skor += 10;
            $faktor[]      = "Absensi/kehadiran bermasalah ({$laporanKehadiran} laporan)";
            $rekomendasi[] = 'Monitoring kehadiran, hubungi orang tua jika berlanjut';
        }

        if ($laporanPerilaku >= 2) {
            $skor += 8;
            $faktor[]      = "Masalah perilaku terulang ({$laporanPerilaku} laporan)";
            $rekomendasi[] = 'Bimbingan kelompok atau konseling perilaku';
        }

        // ─── 2. Analisis Asesmen Siswa ────────────────────────────────────
        $asesmen = AsesmenSiswa::where('siswa_id', $siswaId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->where('status', 'selesai')
            ->get();

        $asesmenSelesai = $asesmen->count() > 0;

        // Asesmen kesehatan mental
        $asesmenKM = $asesmen->where('jenis_asesmen', 'kesehatan_mental')->first();
        if ($asesmenKM) {
            $indikatorMasalah = collect($asesmenKM->jawaban ?? [])
                ->filter(fn($j) => in_array($j, ['ya', 'sering', 'selalu']))
                ->count();

            if ($indikatorMasalah >= 7) {
                $skor += 15;
                $faktor[]      = 'Asesmen kesehatan mental menunjukkan indikator tinggi';
                $rekomendasi[] = 'Rujuk ke psikolog atau ahli kesehatan mental';
            } elseif ($indikatorMasalah >= 4) {
                $skor += 8;
                $faktor[]      = 'Asesmen kesehatan mental menunjukkan indikator sedang';
                $rekomendasi[] = 'Konseling suportif dan monitoring berkala';
            }
        }

        // DCM — Daftar Cek Masalah
        $dcm = $asesmen->where('jenis_asesmen', 'masalah_umum')->first();
        if ($dcm) {
            $totalMasalah = collect($dcm->jawaban ?? [])
                ->filter(fn($j) => $j === true || $j === 'ya')
                ->count();

            if ($totalMasalah >= 10) {
                $skor += 10;
                $faktor[]      = "DCM: {$totalMasalah} masalah dicentang siswa";
                $rekomendasi[] = 'Identifikasi masalah prioritas, konseling individual';
            }
        }

        if (!$asesmenSelesai) {
            $skor += 3;
            $faktor[]      = 'Belum menyelesaikan asesmen semester ini';
            $rekomendasi[] = 'Dorong siswa untuk mengisi form asesmen';
        }

        // ─── 3. Tentukan Kategori Risiko ─────────────────────────────────
        $skor = min($skor, 100);

        $kategori = match (true) {
            $skor >= 70 => 'kritis',
            $skor >= 40 => 'berisiko',
            $skor >= 20 => 'perhatian',
            default     => 'aman',
        };

        // ─── 4. Simpan / Update Record ────────────────────────────────────
        return DeteksiDiniSiswa::updateOrCreate(
            [
                'siswa_id'     => $siswaId,
                'tahun_ajaran' => $tahunAjaran,
                'semester'     => $semester,
            ],
            [
                'skor_risiko'            => $skor,
                'kategori_risiko'        => $kategori,
                'faktor_risiko'          => $faktor,
                'total_laporan_guru'     => $totalLaporan,
                'laporan_urgensi_tinggi' => $laporanKritis + $laporanTinggi,
                'asesmen_selesai'        => $asesmenSelesai,
                'rekomendasi'            => $rekomendasi,
                'terakhir_diperbarui'    => now(),
            ]
        );
    }
}