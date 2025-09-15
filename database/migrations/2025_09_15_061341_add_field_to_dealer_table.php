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
        Schema::table('dealers', function (Blueprint $table) {
            $table->text('vat_number')->after('business_name')->nullable();
            $table->string('street')->after('license_number')->nullable();
            $table->string('suburb')->after('street')->nullable();
            $table->string('town')->after('suburb')->nullable();
            $table->string('postal_code')->after('town')->nullable();
            $table->string('province')->after('postal_code')->nullable();
            $table->string('billing_contact')->after('province')->nullable();
            $table->string('billing_email')->after('billing_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealers', function (Blueprint $table) {
            $table->dropColumn('vat_number');
            $table->dropColumn('street');
            $table->dropColumn('suburb');
            $table->dropColumn('town');
            $table->dropColumn('postal_code');
            $table->dropColumn('province');
            $table->dropColumn('billing_contact');
            $table->dropColumn('billing_email');
        });
    }
};
