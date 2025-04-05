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
        Schema::create('income_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->comment('The customer who owns this income type');
            $table->string('name')->unique();
            $table->string('icon')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_types');
    }
};
