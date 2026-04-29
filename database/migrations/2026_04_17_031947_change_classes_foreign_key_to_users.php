<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus foreign key lama
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['homeroom_teacher_id']);
        });

        // Tambah foreign key baru ke tabel users
        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('homeroom_teacher_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['homeroom_teacher_id']);
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('homeroom_teacher_id')
                  ->references('id')
                  ->on('teachers')
                  ->onDelete('set null');
        });
    }
};