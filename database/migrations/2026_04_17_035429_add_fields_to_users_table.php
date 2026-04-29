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
    Schema::table('users', function (Blueprint $table) {
    $table->string('nisn')->nullable()->unique()->after('email');
    $table->string('nip')->nullable()->unique()->after('nisn');
    $table->string('phone')->nullable()->after('nip');
    $table->text('address')->nullable()->after('phone');
    $table->foreignId('class_id')->nullable()->after('address')->constrained('classes')->onDelete('set null');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
