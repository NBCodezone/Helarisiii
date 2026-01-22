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
            // Drop the old status column and recreate it with new enum values
            $table->dropColumn('status');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            // Add the status column with updated enum values including 'completed'
            $table->enum('status', ['pending', 'approved', 'shipped', 'delivered', 'completed', 'cancelled'])->default('pending')->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            // Restore the old enum values without 'completed'
            $table->enum('status', ['pending', 'approved', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending')->after('total_amount');
        });
    }
};
