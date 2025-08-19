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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(0);
            $table->string('business_name'); 
            $table->string('license_number'); 
            $table->string('business_street'); 
            $table->string('business_suburb');
            $table->string('business_city');
            $table->string('business_postal_code'); 
            $table->string('business_province');
            $table->string('dealer_stocking_fee')->default(1); 
            $table->string('ab_dealer_network_agreement')->default(1); 
            $table->string('license_agreement')->default(1);
            $table->string('fee_agreement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
