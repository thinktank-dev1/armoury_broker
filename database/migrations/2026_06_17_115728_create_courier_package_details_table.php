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
        Schema::create('courier_package_details', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('terminal_id')->nullable();
            $table->string('street')->nullable();
            $table->string('local_area')->nullable(); 
            $table->string('suburb')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable(); 
            $table->string('province')->nullable();
            $table->string('type')->nullable();
            $table->string('longitude')->nullable(); 
            $table->string('latitude')->nullable();
            $table->string('length_cm'); 
            $table->string('width_cm');
            $table->string('height_cm'); 
            $table->string('weight_kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_package_details');
    }
};
