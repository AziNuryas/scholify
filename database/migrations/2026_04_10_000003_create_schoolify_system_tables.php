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
        // 1. Teachers
        if (!Schema::hasTable('teachers')) {
            Schema::create('teachers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('nip')->unique()->nullable();
                $table->string('name');
                $table->string('phone')->nullable();
                $table->string('birth_place')->nullable(); // Ditambahkan
                $table->text('address')->nullable();     // Ditambahkan
                $table->string('avatar')->nullable();      // Ditambahkan
                $table->timestamps();
            });
        }

        // 2. Classes
        if (!Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Contoh: X RPL 1
                $table->string('grade_level')->nullable(); // 10, 11, 12
                $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->timestamps();
            });
        }

        // 3. Students
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
                $table->string('nisn')->unique()->nullable();
                $table->string('nis')->unique()->nullable();
                $table->string('name');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('birth_place')->nullable();
                $table->date('birth_date')->nullable();
                $table->text('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        }

        // 4. Subjects
        if (!Schema::hasTable('subjects')) {
            Schema::create('subjects', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Matematika, B. Inggris
                $table->string('code')->unique()->nullable();
                $table->timestamps();
            });
        }

        // 5. Class_Teacher (Pivot)
        if (!Schema::hasTable('class_teacher')) {
            Schema::create('class_teacher', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
                $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        // 6. KKM (Kriteria Ketuntasan Minimal)
        if (!Schema::hasTable('kkm')) {
            Schema::create('kkm', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->integer('score')->default(75);
                $table->string('grade_level')->nullable(); // Berlaku untuk kelas berapa
                $table->timestamps();
            });
        }

        // 7. Schedules
        if (!Schema::hasTable('schedules')) {
            Schema::create('schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->string('day_of_week'); // Senin, Selasa, dst
                $table->time('start_time');
                $table->time('end_time');
                $table->string('room')->nullable();
                $table->timestamps();
            });
        }

        // 8. Assignments
        if (!Schema::hasTable('assignments')) {
            Schema::create('assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('type')->default('Tugas'); // PR, Project, Dll
                $table->dateTime('due_date')->nullable();
                $table->dateTime('deadline')->nullable(); // Alternatif
                $table->timestamps();
            });
        }

        // 9. Submissions
        if (!Schema::hasTable('submissions')) {
            Schema::create('submissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->string('file_url')->nullable();
                $table->text('notes')->nullable();
                $table->integer('score')->nullable();
                $table->string('status')->default('Submitted'); // Submitted, Graded, Late
                $table->timestamps();
            });
        }

        // 10. Grades
        if (!Schema::hasTable('grades')) {
            Schema::create('grades', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->string('type'); // UTS, UAS, Ulangan Harian
                $table->integer('score')->default(0);
                $table->string('semester')->nullable();
                $table->string('academic_year')->nullable();
                $table->timestamps();
            });
        }

        // 11. Payments
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->string('month'); // September 2026
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('status')->default('Belum Lunas'); // Lunas, Belum Lunas
                $table->date('payment_date')->nullable();
                $table->timestamps();
            });
        }

        // 12. Attendances
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->foreignId('schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
                $table->date('date');
                $table->string('status')->default('Hadir'); // Hadir, Izin, Sakit, Alpa
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        // 13. Announcements
        if (!Schema::hasTable('announcements')) {
            Schema::create('announcements', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content');
                $table->string('target')->default('Semua'); // Semua, Siswa, Guru, Orangtua
                $table->timestamps();
            });
        }

        // 14. Chats
        if (!Schema::hasTable('chats')) {
            Schema::create('chats', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        // 15. Notifications
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('title');
                $table->text('message');
                $table->string('type')->nullable(); // Tugas, Ujian, Umum
                $table->string('link')->nullable(); // URL tautan
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('kkm');
        Schema::dropIfExists('class_teacher');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('teachers');
    }
};
