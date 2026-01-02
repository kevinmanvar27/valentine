<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('whatsapp_number', 15);
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('location');
            $table->string('instagram_id')->nullable();
            $table->text('bio')->nullable();
            $table->json('keywords')->nullable(); // User's qualities
            $table->text('expectation')->nullable(); // What user is looking for in a partner
            $table->json('expected_keywords')->nullable(); // Qualities user wants in partner
            $table->integer('preferred_age_min')->default(18);
            $table->integer('preferred_age_max')->default(35);
            $table->string('preferred_location')->nullable();
            $table->string('live_image')->nullable(); // Identity verification image (camera capture)
            $table->json('gallery_images')->nullable(); // Additional photos
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->enum('status', ['pending', 'active', 'matched', 'blocked'])->default('pending');
            $table->boolean('registration_paid')->default(false);
            $table->string('registration_payment_screenshot')->nullable();
            $table->boolean('registration_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
