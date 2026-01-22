<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use App\Models\Region;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryCharges = DeliveryCharge::with('region')->latest()->paginate(15);
        return view('order-manager.delivery-charges.index', compact('deliveryCharges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::orderBy('region_name')->get();
        return view('order-manager.delivery-charges.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'ken_name' => 'required|string|max:255',
            'price_0_10kg' => 'required|numeric|min:0',
            'price_10_24kg' => 'required|numeric|min:0',
        ]);

        // Check for duplicate ken in same region
        $exists = DeliveryCharge::where('region_id', $validated['region_id'])
            ->where('ken_name', $validated['ken_name'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This ken already exists in the selected region!');
        }

        DeliveryCharge::create($validated);

        return redirect()->route('order-manager.delivery-charges.index')
            ->with('success', 'Delivery charge created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deliveryCharge = DeliveryCharge::findOrFail($id);
        $regions = Region::orderBy('region_name')->get();
        return view('order-manager.delivery-charges.edit', compact('deliveryCharge', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $deliveryCharge = DeliveryCharge::findOrFail($id);

        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'ken_name' => 'required|string|max:255',
            'price_0_10kg' => 'required|numeric|min:0',
            'price_10_24kg' => 'required|numeric|min:0',
        ]);

        // Check for duplicate ken in same region (excluding current record)
        $exists = DeliveryCharge::where('region_id', $validated['region_id'])
            ->where('ken_name', $validated['ken_name'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This ken already exists in the selected region!');
        }

        $deliveryCharge->update($validated);

        return redirect()->route('order-manager.delivery-charges.index')
            ->with('success', 'Delivery charge updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deliveryCharge = DeliveryCharge::findOrFail($id);
        $deliveryCharge->delete();

        return redirect()->route('order-manager.delivery-charges.index')
            ->with('success', 'Delivery charge deleted successfully!');
    }
}
