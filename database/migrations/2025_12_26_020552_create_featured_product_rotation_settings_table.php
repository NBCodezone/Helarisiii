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
        Schema::create('featured_product_rotation_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('rotation_type', ['hours', 'days'])->default('days');
            $table->integer('rotation_interval')->default(1);
            $table->boolean('is_enabled')->default(true);
            $table->integer('products_per_rotation')->default(8);
            $table->timestamp('last_rotated_at')->nullable();
            $table->unsignedBigInteger('current_group_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_product_rotation_settings');
    }
};
