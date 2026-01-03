<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to use raw SQL to modify ENUM
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('match', 'like', 'payment', 'verification', 'profile_suggestion', 'system', 'warning', 'info', 'success', 'error') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original ENUM values (if needed)
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('match', 'like', 'payment', 'verification', 'system', 'warning', 'info', 'success', 'error') NOT NULL");
    }
};
