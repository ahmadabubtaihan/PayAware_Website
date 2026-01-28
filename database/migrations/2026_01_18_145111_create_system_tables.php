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
// سجلات النظام 
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('action'); // login, create_debt, delete_user
        $table->text('description')->nullable();
        $table->string('ip_address')->nullable();
        $table->timestamps();
    });


    //  تذاكر الدعم الفني 
    Schema::create('support_tickets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // مقدم الطلب
        $table->string('subject');
        $table->text('message');
        $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
        $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_tables');
    }
};
