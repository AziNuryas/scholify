<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ensure announcements table has all required columns.
     */
    public function up(): void
    {
        // If table doesn't exist yet, create it with full schema
        if (!Schema::hasTable('announcements')) {
            Schema::create('announcements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('title');
                $table->text('content');
                $table->string('target')->default('all'); // all | class
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
                $table->string('file')->nullable();
                $table->string('status')->default('terkirim');
                $table->timestamps();
            });
            return;
        }

        // If table exists but is missing columns (from old simple migration), add them
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('announcements', 'title')) {
                $table->string('title')->default('Pengumuman');
            }
            if (!Schema::hasColumn('announcements', 'content')) {
                $table->text('content')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'target')) {
                $table->string('target')->default('all');
            }
            if (!Schema::hasColumn('announcements', 'class_id')) {
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            }
            if (!Schema::hasColumn('announcements', 'file')) {
                $table->string('file')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'status')) {
                $table->string('status')->default('terkirim');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
