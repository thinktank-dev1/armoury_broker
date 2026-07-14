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
        Schema::create('pudo_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->integer('length');
            $table->integer('max_weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pudo_sizes');
    }
};
