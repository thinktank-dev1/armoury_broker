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
        Schema::create('orders', function (Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->float('cart_total');
            $table->float('fee');
            $table->float('total_shipping_fee')->nullable();
            $table->string('g_payment_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('short_reference')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
