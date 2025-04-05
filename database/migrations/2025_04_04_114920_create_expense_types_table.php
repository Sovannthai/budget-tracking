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
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The customer who owns this expense type');
            $table->string('name')->unique()->comment('The name of the expense type');
            $table->string('icon')->nullable()->comment('The icon associated with the expense type');
            $table->string('description')->nullable()->comment('Description of the expense type');
            $table->softDeletes()->comment('Soft delete timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_types');
    }
};
