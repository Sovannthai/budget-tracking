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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The customer who owns this income');
            $table->foreignId('income_type_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The income type associated with this income');
            $table->decimal('amount', 10, 2)->comment('The amount of income')->nullable();
            $table->date('date')->comment('The date of the income')->nullable();
            $table->string('description')->nullable()->comment('Description of the income');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
