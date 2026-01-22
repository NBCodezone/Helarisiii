<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class GenerateProductCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:generate-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate product codes for existing products that do not have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating product codes for existing products...');

        // Get all products without a product code, ordered by category and id
        $products = Product::whereNull('product_code')
            ->orWhere('product_code', '')
            ->orderBy('category_id')
            ->orderBy('id')
            ->get();

        if ($products->isEmpty()) {
            $this->info('All products already have product codes.');
            return 0;
        }

        $count = 0;
        foreach ($products as $product) {
            $productCode = Product::generateProductCode($product->category_id);
            $product->update(['product_code' => $productCode]);
            $this->line("Generated code {$productCode} for product: {$product->product_name}");
            $count++;
        }

        $this->info("Successfully generated {$count} product codes.");
        return 0;
    }
}
