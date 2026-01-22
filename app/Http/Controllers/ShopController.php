<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page with filters and search
     */
    public function index(Request $request)
    {
        // Start with base query
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by max price
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('product_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('category_name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Sorting
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // Paginate results
        $products = $query->paginate(9)->appends($request->query());

        // Get all categories with product count for sidebar
        $categories = Category::withCount('products')->get();

        // Get featured products for sidebar (latest 3 products)
        $featuredProducts = Product::with('category')
            ->latest()
            ->limit(3)
            ->get();

        // Get offers for the productsoffer component
        $offers = \App\Models\ProductOffer::with('product')
            ->orderBy('order')
            ->get();

        return view('shop', compact('products', 'categories', 'featuredProducts', 'offers'));
    }
}
