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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The customer who owns this expense');
            $table->foreignId('expense_type_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The expense type associated with this expense');
            $table->decimal('amount', 10, 2)->comment('The amount of the expense')->nullable();
            $table->date('date')->comment('The date of the expense')->nullable();
            $table->string('description')->nullable()->comment('Description of the expense');
            $table->softDeletes()->comment('Soft delete timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
