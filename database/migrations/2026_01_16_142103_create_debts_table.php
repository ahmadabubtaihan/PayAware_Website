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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            
            $table->string('transaction_id')->nullable(); 

            $table->foreignId('creditor_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            
            $table->foreignId('debtor_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->decimal('amount', 12, 2);
            $table->decimal('remaining_amount', 12, 2);
            
            $table->string('type')->default('product'); // product, service, loan
            $table->text('description')->nullable(); 
            $table->text('notes')->nullable(); 
            
            $table->date('due_date')->nullable();
            $table->date('next_payment_date')->nullable(); 

            $table->json('installment_plan')->nullable();

            $table->enum('status', ['pending', 'active', 'paid', 'overdue', 'partial', 'bad_debt'])->default('active'); // ✅ أضفنا pending

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};