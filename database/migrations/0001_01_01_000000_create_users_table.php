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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('mobile_number')->unique();
            $table->string('national_id')->unique()->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->string('password');
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'banned',
                'pending',
                'deleted',
            ])->default('pending');
            $table->enum('type', [
                'user',
                'admin',
                'it',
                'tester',
                'employee',
            ])->default('user');
            $table->boolean('can_login')->default(true);
            $table->text('status_details')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role_id')->nullable();
            $table->text('fcm_token')->nullable();
            $table->uuid('qr_code')->unique();
            $table->rememberToken();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onDelete('set null');
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
