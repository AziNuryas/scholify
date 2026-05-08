<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            // Tambahkan kolom yang kurang
            if (!Schema::hasColumn('chats', 'is_replied')) {
                $table->boolean('is_replied')->default(false)->after('message');
            }
            
            if (!Schema::hasColumn('chats', 'reply')) {
                $table->text('reply')->nullable()->after('message');
            }
            
            if (!Schema::hasColumn('chats', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('is_replied');
            }
            
            if (!Schema::hasColumn('chats', 'replied_by')) {
                $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null')->after('replied_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['is_replied', 'reply', 'replied_at', 'replied_by']);
        });
    }
};