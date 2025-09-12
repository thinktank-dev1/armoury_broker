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
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['tel', 'email', 'street', 'postal_code', 'country']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
        });
    }
};
