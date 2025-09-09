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
            $table->integer('promo_code_id')->nullable()->after('total_shipping_fee');
            $table->float('discount_amount')->nullable()->after('promo_code_id');
            $table->string('promo_code')->nullable()->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('promo_code_id');
            $table->dropColumn('discount_amount');
            $table->dropColumn('promo_code');
        });
    }
};
