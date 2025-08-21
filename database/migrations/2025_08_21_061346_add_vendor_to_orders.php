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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('vendor_id')->nullable()->after('user_id');
            $table->integer('shipping_status')->default(0)->after('status')->nullable();
            $table->integer('receipt_status')->default(0)->after('shipping_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
            $table->dropColumn('shipping_status');
            $table->dropColumn('receipt_status');
        });
    }
};
