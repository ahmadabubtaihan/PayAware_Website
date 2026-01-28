<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }

            if (!Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(0);
            }

            if (!Schema::hasColumn('users', 'currency')) {
                $table->string('currency')->default('USD')->nullable();
            }

            if (!Schema::hasColumn('users', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(0)->nullable();
            }

            if (!Schema::hasColumn('users', 'invoice_footer_note')) {
                $table->text('invoice_footer_note')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['avatar', 'two_factor_enabled', 'currency', 'tax_rate', 'invoice_footer_note'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};