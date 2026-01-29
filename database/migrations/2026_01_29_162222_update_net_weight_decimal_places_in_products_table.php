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
            // Change net_weight from decimal(8,2) to decimal(10,4) for more precision
            $table->decimal('net_weight', 10, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert back to decimal(8,2)
            $table->decimal('net_weight', 8, 2)->change();
        });
    }
};
