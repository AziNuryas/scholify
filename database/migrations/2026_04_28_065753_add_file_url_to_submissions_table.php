<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            // Tambahkan kolom file_url jika belum ada
            if (!Schema::hasColumn('submissions', 'file_url')) {
                $table->string('file_url')->nullable()->after('student_id');
            }
            
            // Tambahkan kolom notes jika belum ada
            if (!Schema::hasColumn('submissions', 'notes')) {
                $table->text('notes')->nullable()->after('file_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['file_url', 'notes']);
        });
    }
};