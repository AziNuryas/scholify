<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_siswa', function (Blueprint $table) {
            // 1. Tambah tingkat_urgensi (untuk view)
            if (!Schema::hasColumn('laporan_siswa', 'tingkat_urgensi')) {
                $table->enum('tingkat_urgensi', ['rendah', 'sedang', 'tinggi', 'kritis'])
                      ->default('sedang')
                      ->after('description');
            }
            
            // 2. Tambah guru_id (foreign key ke user pembuat laporan)
            if (!Schema::hasColumn('laporan_siswa', 'guru_id')) {
                $table->foreignId('guru_id')
                      ->nullable()
                      ->after('student_id')
                      ->constrained('users')
                      ->onDelete('set null');
            }
            
            // 3. Tambah kategori (untuk jenis masalah)
            if (!Schema::hasColumn('laporan_siswa', 'kategori')) {
                $table->enum('kategori', [
                    'akademik',     // masalah belajar, nilai turun
                    'perilaku',     // pelanggaran tata tertib
                    'sosial',       // masalah pertemanan, bullying
                    'kesehatan',    // kesehatan mental, fisik
                    'keluarga',     // masalah keluarga
                    'lainnya'       // lainnya
                ])->default('akademik')
                  ->after('description');
            }
            
            // 4. Tambah catatan_bk (untuk Guru BK mencatat tindak lanjut)
            if (!Schema::hasColumn('laporan_siswa', 'catatan_bk')) {
                $table->text('catatan_bk')
                      ->nullable()
                      ->after('resolution_notes');
            }
            
            // 5. Tambah bukti_pendukung (opsional, untuk menyimpan file)
            if (!Schema::hasColumn('laporan_siswa', 'bukti_pendukung')) {
                $table->json('bukti_pendukung')
                      ->nullable()
                      ->after('catatan_bk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_siswa', function (Blueprint $table) {
            $columns = ['tingkat_urgensi', 'guru_id', 'kategori', 'catatan_bk', 'bukti_pendukung'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('laporan_siswa', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};