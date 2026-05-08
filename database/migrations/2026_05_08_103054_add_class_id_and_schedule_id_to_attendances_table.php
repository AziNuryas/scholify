<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'class_id')) {
                $table->foreignId('class_id')->nullable()->after('student_id')->constrained('classes')->onDelete('cascade');
            }
            if (!Schema::hasColumn('attendances', 'schedule_id')) {
                $table->foreignId('schedule_id')->nullable()->after('class_id')->constrained('schedules')->onDelete('cascade');
            }
            if (!Schema::hasColumn('attendances', 'recorded_by')) {
                $table->foreignId('recorded_by')->nullable()->after('schedule_id')->constrained('teachers')->onDelete('set null');
            }
            if (!Schema::hasColumn('attendances', 'recorded_at')) {
                $table->timestamp('recorded_at')->nullable()->after('recorded_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            $table->dropForeign(['schedule_id']);
            $table->dropColumn('schedule_id');
            $table->dropForeign(['recorded_by']);
            $table->dropColumn('recorded_by');
            $table->dropColumn('recorded_at');
        });
    }
};