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
// جدول الملاحظات
    Schema::create('notes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('creditor_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('debtor_id')->constrained('users')->onDelete('cascade');
        $table->text('content');
        $table->timestamps();
    });

    // جدول التحذيرات
    Schema::create('warnings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('creditor_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('debtor_id')->constrained('users')->onDelete('cascade');
        
        $table->string('type')->default('manual'); // يدوي أو تلقائي
        $table->text('message'); // نص التحذير
        $table->date('trigger_date')->nullable(); // تاريخ التفعيل (للتنبيهات المجدولة)
        $table->boolean('is_sent')->default(false);
        
        $table->timestamps();
    });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_warnings');
    }
};
