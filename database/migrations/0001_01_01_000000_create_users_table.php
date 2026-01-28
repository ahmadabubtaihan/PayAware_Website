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

            $table->string('account_id', 6)->unique()->nullable();

            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');

            $table->string('owner_name')->nullable(); 
            $table->string('company_name')->nullable(); 

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable()->unique();
            $table->string('national_id')->nullable()->unique();
            $table->string('address')->nullable();

            $table->enum('role', ['admin', 'creditor', 'debtor'])->default('debtor');
            $table->enum('company_role', ['owner', 'editor', 'viewer'])->nullable();

            $table->integer('credit_score')->default(85);
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('low');
            $table->string('job_title')->nullable();
            $table->text('bio')->nullable();
            $table->string('work_place')->nullable();
            $table->string('study_place')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('two_factor_enabled')->default(false);
            $table->json('notification_preferences')->nullable();
            $table->string('avatar')->nullable();
            $table->string('google_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        // جداول التوكن والجلسات
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