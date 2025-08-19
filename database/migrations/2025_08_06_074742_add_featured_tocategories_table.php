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
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('featured')->nullable()->after('category_image');
            $table->integer('status')->default(1)->after('featured');
            $table->integer('regulated')->nullable()->after('status');
            $table->string('measurement_type')->nullable()->after('regulated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('featured');
            $table->dropColumn('status');
            $table->dropColumn('regulated');
            $table->dropColumn('measurement_type');

        });
    }
};
