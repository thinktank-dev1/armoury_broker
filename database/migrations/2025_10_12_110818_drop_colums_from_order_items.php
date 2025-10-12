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
            $table->dropColumn(['collection_free_shipping', 'shipping_id', 'delivery_address']);
            $table->string('shiping_service')->nullable()->after('deliver_collection');
            $table->string('tracking_number')->nullable()->after('shiping_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('collection_free_shipping')->nullable();
            $table->integer('shipping_id')->nullable();
            $table->text('delivery_address')->nullable();

            $table->dropColumn(['shiping_service', 'tracking_number']);
        });
    }
};
