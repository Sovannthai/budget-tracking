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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('contact_id')->nullable()->after('id');
            $table->enum('gender',['male','female','other'])->nullable()->after('last_name');
            $table->date('dob')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('contact_id');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
        });
    }
};
