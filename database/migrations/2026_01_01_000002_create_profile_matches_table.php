<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Profile suggestions sent by admin to users
        Schema::create('profile_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User receiving suggestion
            $table->foreignId('suggested_user_id')->constrained('users')->onDelete('cascade'); // Suggested profile
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'suggested_user_id']);
        });

        // Matches when both users accept each other
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending_payment', 'payment_submitted', 'verified', 'completed'])->default('pending_payment');
            $table->timestamps();
            
            $table->unique(['user1_id', 'user2_id']);
        });

        // Payments for matches
        Schema::create('match_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['full', 'half']); // Full if mutual, half if one-sided
            $table->string('payment_screenshot')->nullable();
            $table->enum('status', ['pending', 'submitted', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->unique(['match_id', 'user_id']);
        });

        // Couples - finalized matches after payment verification
        Schema::create('couples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->boolean('whatsapp_shared')->default(false);
            $table->timestamp('coupled_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couples');
        Schema::dropIfExists('match_payments');
        Schema::dropIfExists('matches');
        Schema::dropIfExists('profile_suggestions');
    }
};
