<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add 'suspended' to users status enum
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'active', 'matched', 'blocked', 'suspended') DEFAULT 'pending'");
        
        // Add 'viewed' column to profile_suggestions to track if user has seen the suggestion
        Schema::table('profile_suggestions', function (Blueprint $table) {
            $table->boolean('viewed')->default(false)->after('status');
            $table->timestamp('viewed_at')->nullable()->after('viewed');
        });
    }

    public function down(): void
    {
        // Remove 'suspended' from users status enum
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'active', 'matched', 'blocked') DEFAULT 'pending'");
        
        Schema::table('profile_suggestions', function (Blueprint $table) {
            $table->dropColumn(['viewed', 'viewed_at']);
        });
    }
};
