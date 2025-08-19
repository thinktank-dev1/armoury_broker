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
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('shipping_id')->nullable()->after('promo_code');
            $table->integer('shipping_price')->nullable()->after('promo_code');
            $table->float('service_fee')->nullable()->after('shipping_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('shipping_id');
            $table->dropColumn('shipping_price');
            $table->dropColumn('service_fee');
        });
    }
};
