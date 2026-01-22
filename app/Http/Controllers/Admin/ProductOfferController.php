<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = ProductOffer::with('product')->orderBy('order')->paginate(10);
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = \App\Models\Product::orderBy('product_name')->get();
        return view('admin.offers.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'product_id' => 'required|exists:products,id',
            'order' => 'nullable|integer',
        ]);

        ProductOffer::create($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Product offer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductOffer $offer)
    {
        $products = \App\Models\Product::orderBy('product_name')->get();
        return view('admin.offers.edit', compact('offer', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOffer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'product_id' => 'required|exists:products,id',
            'order' => 'nullable|integer',
        ]);

        $offer->update($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Product offer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOffer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', 'Product offer deleted successfully!');
    }
}
