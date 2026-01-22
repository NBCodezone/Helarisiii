<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingDiscountRule;
use App\Models\Region;
use App\Models\Product;
use Illuminate\Http\Request;

class ShippingDiscountRuleController extends Controller
{
    public function index()
    {
        $rules = ShippingDiscountRule::with(['region', 'riceProduct'])->latest()->paginate(10);
        return view('order-manager.shipping-discounts.index', compact('rules'));
    }

    public function create()
    {
        $regions = Region::all();
        $products = Product::all();
        return view('order-manager.shipping-discounts.create', compact('regions', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'min_order_amount' => 'required|numeric|min:0',
            'min_order_weight' => 'required|numeric|min:0',
            'rice_product_id' => 'nullable|exists:products,id',
            'rice_weight_per_unit' => 'required|numeric|min:0',
            'min_rice_count' => 'required|integer|min:0',
            'max_rice_count' => 'nullable|integer|min:0',
            'max_weight_limit' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'rule_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ShippingDiscountRule::create($validated);

        return redirect()->route('order-manager.shipping-discounts.index')
            ->with('success', 'Shipping discount rule created successfully!');
    }

    public function edit(string $id)
    {
        $rule = ShippingDiscountRule::findOrFail($id);
        $regions = Region::all();
        $products = Product::all();
        return view('order-manager.shipping-discounts.edit', compact('rule', 'regions', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $rule = ShippingDiscountRule::findOrFail($id);

        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'min_order_amount' => 'required|numeric|min:0',
            'min_order_weight' => 'required|numeric|min:0',
            'rice_product_id' => 'nullable|exists:products,id',
            'rice_weight_per_unit' => 'required|numeric|min:0',
            'min_rice_count' => 'required|integer|min:0',
            'max_rice_count' => 'nullable|integer|min:0',
            'max_weight_limit' => 'nullable|numeric|min:0',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'rule_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $rule->update($validated);

        return redirect()->route('order-manager.shipping-discounts.index')
            ->with('success', 'Shipping discount rule updated successfully!');
    }

    public function destroy(string $id)
    {
        $rule = ShippingDiscountRule::findOrFail($id);
        $rule->delete();

        return redirect()->route('order-manager.shipping-discounts.index')
            ->with('success', 'Shipping discount rule deleted successfully!');
    }
}
