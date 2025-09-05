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
            $table->string('deliver_collection')->nullable()->after('shipping_id');
            $table->text('delivery_address')->nullable()->after('deliver_collection');
            $table->string('dealer_option')->nullable()->after('delivery_address');
            $table->integer('ab_dealer_id')->nullable()->after('dealer_option');
            $table->text('custom_dealer_details')->nullable()->after('ab_dealer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('deliver_collection');
            $table->dropColumn('delivery_address');
            $table->dropColumn('dealer_option');
            $table->dropColumn('ab_dealer_id');
            $table->dropColumn('custom_dealer_details');
        });
    }
};
