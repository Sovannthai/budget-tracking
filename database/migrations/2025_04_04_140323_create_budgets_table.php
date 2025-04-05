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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The customer who owns this budget');
            $table->decimal('amount', 10, 2)->comment('The budgeted amount');
            $table->decimal('balance', 10, 2)->comment('The remaining balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
