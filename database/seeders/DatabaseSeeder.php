<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Categories
        $electronics = Category::create(['category_name' => 'Electronics']);
        $clothing = Category::create(['category_name' => 'Clothing']);
        $books = Category::create(['category_name' => 'Books']);
        $home = Category::create(['category_name' => 'Home & Garden']);

        // Create Sample Products
        Product::create([
            'category_id' => $electronics->id,
            'category_name' => $electronics->category_name,
            'product_name' => 'Laptop Pro 15',
            'stock' => 25,
            'net_weight' => 2.5,
            'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'category_name' => $electronics->category_name,
            'product_name' => 'Wireless Headphones',
            'stock' => 50,
            'net_weight' => 0.3,
            'description' => 'Noise-cancelling wireless headphones with 30-hour battery life',
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'category_name' => $clothing->category_name,
            'product_name' => 'Cotton T-Shirt',
            'stock' => 100,
            'net_weight' => 0.2,
            'description' => '100% cotton comfortable t-shirt available in multiple colors',
        ]);

        Product::create([
            'category_id' => $books->id,
            'category_name' => $books->category_name,
            'product_name' => 'Programming in Laravel',
            'stock' => 30,
            'net_weight' => 0.8,
            'description' => 'Complete guide to Laravel PHP framework for modern web development',
        ]);

        Product::create([
            'category_id' => $home->id,
            'category_name' => $home->category_name,
            'product_name' => 'Garden Tool Set',
            'stock' => 15,
            'net_weight' => 3.5,
            'description' => 'Complete set of essential garden tools for home gardening',
        ]);
    }
}
