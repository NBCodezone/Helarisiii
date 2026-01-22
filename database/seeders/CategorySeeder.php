<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Electronics'],
            ['category_name' => 'Clothing'],
            ['category_name' => 'Food & Beverages'],
            ['category_name' => 'Home & Garden'],
            ['category_name' => 'Sports & Outdoors'],
            ['category_name' => 'Books & Media'],
            ['category_name' => 'Toys & Games'],
            ['category_name' => 'Health & Beauty'],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['category_name' => $categoryData['category_name']],
                $categoryData
            );
        }
    }
}
