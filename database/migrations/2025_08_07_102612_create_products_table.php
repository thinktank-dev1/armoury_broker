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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('user_id');
            $table->integer('brand_id');
            $table->integer('category_id'); 
            $table->integer('sub_category_id'); 
            $table->integer('sub_sub_category_id')->nullable(); 
            $table->string('listing_type');
            $table->string('item_name');
            $table->string('model_number')->nullable(); 
            $table->text('item_description'); 
            $table->string('condition');
            $table->integer('quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('service_fee_payer');
            $table->double('item_price');
            $table->integer('allow_offers')->nullable();
            $table->integer('acknowledgement')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
