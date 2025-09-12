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
        Schema::table('dealers', function (Blueprint $table) {
            $table->dropColumn(['business_street', 'business_suburb', 'business_postal_code', 'business_city', 'business_province']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->string('business_street')->nullable();
            $table->string('business_postal_code')->nullable();
            $table->string('business_suburb')->nullable();
            $table->string('business_city')->nullable();
            $table->string('business_province')->nullable();
        });
    }
};
