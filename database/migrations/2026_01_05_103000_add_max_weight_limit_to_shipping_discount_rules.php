<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds max_weight_limit field to shipping_discount_rules table
     * This limits free shipping to orders under this weight.
     * For orders exceeding this weight, free shipping applies to the first portion,
     * and excess weight is charged at regular rates.
     */
    public function up(): void
    {
        Schema::table('shipping_discount_rules', function (Blueprint $table) {
            // Maximum weight (in kg) for free shipping eligibility
            // null means no limit, e.g., 24 means free shipping only for first 24kg
            $table->decimal('max_weight_limit', 8, 2)->nullable()->after('max_rice_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_discount_rules', function (Blueprint $table) {
            $table->dropColumn('max_weight_limit');
        });
    }
};
