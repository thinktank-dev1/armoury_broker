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
        Schema::table('products', function (Blueprint $table) {
            $table->string('sub_category_id')->nullable()->change();
            $table->string('brand_id')->nullable()->change();
            $table->string('condition')->nullable()->change();
            $table->string('service_fee_payer')->nullable()->change();
            $table->string('item_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sub_category_id')->nullable(false)->change();
            $table->string('brand_id')->nullable(false)->change();
            $table->string('condition')->nullable(false)->change();
            $table->string('service_fee_payer')->nullable(false)->change();
            $table->string('item_price')->nullable(false)->change();
        });
    }
};
