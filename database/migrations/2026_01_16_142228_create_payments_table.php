<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();

            $table->foreignId('debt_id')->nullable()->constrained('debts')->onDelete('set null');
            
            $table->foreignId('creditor_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('company_id')->nullable()->constrained('companies'); 
            
            $table->foreignId('debtor_id')->constrained('users'); // من دفع
            
            $table->foreignId('collected_by')->nullable()->constrained('users'); // الموظف المستلم

            $table->decimal('amount', 12, 2);
            
            // طريقة الدفع
            $table->string('method')->default('cash'); 
            $table->string('reference_number')->nullable(); 
            $table->string('proof_image')->nullable(); 
            $table->text('notes')->nullable(); 
            
            $table->dateTime('paid_at'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};