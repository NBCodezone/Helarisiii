<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("UPDATE categories SET image = REPLACE(image, 'categories/', 'category-images/') WHERE image LIKE 'categories/%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE categories SET image = REPLACE(image, 'category-images/', 'categories/') WHERE image LIKE 'category-images/%'");
    }
};
