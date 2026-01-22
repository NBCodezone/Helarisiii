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
        Schema::create('shipping_discount_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->decimal('min_order_weight', 8, 2)->default(0);
            $table->foreignId('rice_product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->decimal('rice_weight_per_unit', 8, 2)->default(5.0);
            $table->integer('min_rice_count')->default(0);
            $table->integer('max_rice_count')->nullable();
            $table->integer('discount_percentage')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('rule_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_discount_rules');
    }
};
