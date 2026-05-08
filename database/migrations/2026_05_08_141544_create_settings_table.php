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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Seed default values
        DB::table('settings')->insert([
            ['key' => 'school_name', 'value' => 'Scholify High School', 'group' => 'general'],
            ['key' => 'school_lat', 'value' => '-6.1950', 'group' => 'location'],
            ['key' => 'school_lng', 'value' => '106.8230', 'group' => 'location'],
            ['key' => 'absensi_radius', 'value' => '100', 'group' => 'location'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
