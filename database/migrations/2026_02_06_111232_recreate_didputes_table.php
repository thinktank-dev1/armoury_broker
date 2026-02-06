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
        Schema::dropIfExists('disputes');
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_1');
            $table->integer('user_2');
            $table->integer('order_id');
            $table->integer('item_id');
            $table->text('message');
            $table->integer('user_1_status')->nullable();
            $table->integer('user_2_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
