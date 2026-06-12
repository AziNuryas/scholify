<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Cek dan tambah kolom assessment_type
            if (!Schema::hasColumn('grades', 'assessment_type')) {
                $table->enum('assessment_type', ['tugas', 'quiz', 'uts', 'uas', 'praktikum'])
                      ->default('tugas')
                      ->after('subject_id');
            }
            
            // Cek dan tambah kolom notes
            if (!Schema::hasColumn('grades', 'notes')) {
                $table->text('notes')->nullable()->after('score');
            }
            
            // Cek dan tambah kolom class_id
            if (!Schema::hasColumn('grades', 'class_id')) {
                $table->foreignId('class_id')->nullable()->after('student_id');
            }
            
            // Cek dan tambah kolom teacher_id
            if (!Schema::hasColumn('grades', 'teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->after('class_id');
            }
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['assessment_type', 'notes', 'class_id', 'teacher_id']);
        });
    }
};