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
        Schema::table('featured_product_rotation_settings', function (Blueprint $table) {
            $table->integer('current_offset')->default(0)->after('products_per_rotation');
            $table->string('product_order_by')->default('created_at')->after('current_offset');
            $table->string('product_order_direction')->default('asc')->after('product_order_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('featured_product_rotation_settings', function (Blueprint $table) {
            $table->dropColumn(['current_offset', 'product_order_by', 'product_order_direction']);
        });
    }
};
