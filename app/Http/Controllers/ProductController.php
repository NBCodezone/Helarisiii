<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products on the frontend
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(9);
        return view('products', compact('products'));
    }

    /**
     * Display a single product page
     */
    public function show($id = null)
    {
        // If no ID provided, get the first product
        if ($id === null) {
            $product = Product::with(['category', 'images'])->first();
            if (!$product) {
                abort(404, 'No products found');
            }
        } else {
            $product = Product::with(['category', 'images'])->findOrFail($id);
        }

        // Get all categories with product count
        $categories = Category::withCount('products')->get();

        // Get featured products using rotation service
        $rotationService = new \App\Services\FeaturedProductRotationService();
        $allFeaturedProducts = $rotationService->getFeaturedProducts();
        $featuredProducts = $allFeaturedProducts->where('id', '!=', $product->id)->take(6);

        // Get related products from same category
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();

        return view('single', compact('product', 'categories', 'featuredProducts', 'relatedProducts'));
    }
}
