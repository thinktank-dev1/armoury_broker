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
            $table->string('dealer_stocking_type')->nullable()->after('allow_offers');
            $table->integer('dealer_id')->nullable()->after('dealer_stocking_type');
            $table->text('private_dealer_details')->nullable()->after('dealer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('dealer_stocking_type');
            $table->dropColumn('dealer_id');
            $table->dropColumn('private_dealer_details');
        });
    }
};
