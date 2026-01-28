<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('warnings');

        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creditor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('debtor_id')->constrained('users')->onDelete('cascade');
            
            $table->string('type')->default('late_payment');
            $table->text('message');
            
            $table->string('status')->default('sent'); 
            
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};