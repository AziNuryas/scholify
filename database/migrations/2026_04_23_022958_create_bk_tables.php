<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =============================================
        // Tabel Laporan Guru terhadap Siswa Bermasalah
        // =============================================
        Schema::create('laporan_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('kategori', [
                'akademik',
                'kehadiran',
                'perilaku',
                'sosial',
                'keluarga',
                'lainnya'
            ]);
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('sedang');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditutup'])->default('baru');
            $table->text('tindak_lanjut')->nullable();
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users');
            $table->timestamp('ditangani_at')->nullable();
            $table->json('bukti_pendukung')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // =============================================
        // Tabel Form Asesmen Siswa
        // =============================================
        Schema::create('asesmen_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_asesmen', [
                'sosiometri',
                'minat_bakat',
                'gaya_belajar',
                'kesehatan_mental',
                'masalah_umum'
            ]);
            $table->string('tahun_ajaran');
            $table->string('semester')->default('ganjil');
            $table->json('jawaban');
            $table->json('hasil_analisis')->nullable();
            $table->enum('status', ['draft', 'selesai'])->default('draft');
            $table->timestamp('selesai_at')->nullable();
            $table->foreignId('ditinjau_oleh')->nullable()->constrained('users');
            $table->text('catatan_bk')->nullable();
            $table->timestamps();

            // Fix: nama index diperpendek agar tidak melebihi 64 karakter
            $table->unique(
                ['siswa_id', 'jenis_asesmen', 'tahun_ajaran', 'semester'],
                'asesmen_siswa_unique'
            );
        });

        // =============================================
        // Tabel Rekap Deteksi Dini Siswa
        // =============================================
        Schema::create('deteksi_dini_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->integer('skor_risiko')->default(0);
            $table->enum('kategori_risiko', ['aman', 'perhatian', 'berisiko', 'kritis'])->default('aman');
            $table->json('faktor_risiko')->nullable();
            $table->integer('total_laporan_guru')->default(0);
            $table->integer('laporan_urgensi_tinggi')->default(0);
            $table->boolean('asesmen_selesai')->default(false);
            $table->json('rekomendasi')->nullable();
            $table->timestamp('terakhir_diperbarui')->nullable();
            $table->timestamps();

            $table->unique(
                ['siswa_id', 'tahun_ajaran', 'semester'],
                'deteksi_dini_siswa_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deteksi_dini_siswa');
        Schema::dropIfExists('asesmen_siswa');
        Schema::dropIfExists('laporan_guru');
    }
};