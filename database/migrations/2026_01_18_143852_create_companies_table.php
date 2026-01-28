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
Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('email')->nullable(); 
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            $table->string('plan')->default('basic'); 

            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('bio')->nullable();
            
            $table->string('currency')->default('USD');
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->text('invoice_footer_note')->nullable();
            
            $table->enum('status', ['active', 'suspended', 'pending'])->default('active');
            
            $table->timestamps();
            $table->softDeletes();
        });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
