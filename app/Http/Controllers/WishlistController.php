<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $wishlistItems = Auth::user()->wishlists()->with('product')->get();
        $wishlistCount = $wishlistItems->count();

        return view('user.wishlist', compact('wishlistItems', 'wishlistCount'));
    }

    /**
     * Add a product to the wishlist
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Check if product is already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
                         ->where('product_id', $productId)
                         ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully'
        ]);
    }

    /**
     * Remove a product from the wishlist
     */
    public function remove($productId)
    {
        $deleted = Wishlist::where('user_id', Auth::id())
                          ->where('product_id', $productId)
                          ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist'
        ], 404);
    }

    /**
     * Toggle product in wishlist (add if not exists, remove if exists)
     */
    public function toggle($productId)
    {
        $product = Product::findOrFail($productId);

        $wishlistItem = Wishlist::where('user_id', Auth::id())
                               ->where('product_id', $productId)
                               ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from wishlist'
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Product added to wishlist'
            ]);
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function check($productId)
    {
        $inWishlist = Wishlist::where('user_id', Auth::id())
                             ->where('product_id', $productId)
                             ->exists();

        return response()->json([
            'in_wishlist' => $inWishlist
        ]);
    }
}
