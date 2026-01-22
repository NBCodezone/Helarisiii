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
        Schema::table('delivery_charges', function (Blueprint $table) {
            // Rename the column from price_10_20kg to price_10_24kg
            $table->renameColumn('price_10_20kg', 'price_10_24kg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_charges', function (Blueprint $table) {
            // Rename back from price_10_24kg to price_10_20kg
            $table->renameColumn('price_10_24kg', 'price_10_20kg');
        });
    }
};
