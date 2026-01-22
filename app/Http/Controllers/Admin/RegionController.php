<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::withCount('deliveryCharges')->latest()->paginate(10);
        return view('order-manager.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order-manager.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_name' => 'required|string|max:255|unique:regions,region_name',
        ]);

        Region::create($validated);

        return redirect()->route('order-manager.regions.index')
            ->with('success', 'Region created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
        return view('order-manager.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $region = Region::findOrFail($id);

        $validated = $request->validate([
            'region_name' => 'required|string|max:255|unique:regions,region_name,' . $id,
        ]);

        $region->update($validated);

        return redirect()->route('order-manager.regions.index')
            ->with('success', 'Region updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);

        if ($region->deliveryCharges()->count() > 0) {
            return redirect()->route('order-manager.regions.index')
                ->with('error', 'Cannot delete region with existing delivery charges!');
        }

        $region->delete();

        return redirect()->route('order-manager.regions.index')
            ->with('success', 'Region deleted successfully!');
    }
}
