<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_sesi');
            $table->enum('jenis_konseling', [
                'konseling_individual',
                'konseling_karir',
                'konseling_akademik',
                'konseling_sosial_emosional',
                'tindak_lanjut_disiplin',
            ]);
            $table->text('masalah');
            $table->text('tindakan');
            $table->text('rencana_tindak_lanjut')->nullable();
            $table->enum('status', ['berjalan', 'tindak_lanjut', 'selesai'])->default('berjalan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_konseling');
    }
};