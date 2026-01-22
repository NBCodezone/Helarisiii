<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedProductRotationSetting;
use App\Models\FeaturedProductGroup;
use App\Models\FeaturedProductGroupItem;
use App\Models\Product;
use App\Services\FeaturedProductRotationService;
use Illuminate\Http\Request;

class FeaturedProductRotationController extends Controller
{
    protected $rotationService;

    public function __construct(FeaturedProductRotationService $rotationService)
    {
        $this->rotationService = $rotationService;
    }

    public function index()
    {
        $settings = FeaturedProductRotationSetting::getSettings();
        $rotationStatus = $this->rotationService->getRotationStatus();
        $nextRotation = $this->rotationService->getNextRotationTime();

        // Get current featured products for preview
        $currentProducts = $this->rotationService->getFeaturedProducts();

        // Get all products ordered by current setting for reference
        $allProducts = Product::with('category')
            ->orderBy($settings->product_order_by ?? 'created_at', $settings->product_order_direction ?? 'asc')
            ->get();

        return view('admin.featured-rotation.index', compact('settings', 'rotationStatus', 'nextRotation', 'currentProducts', 'allProducts'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'rotation_type' => 'required|in:hours,days',
            'rotation_interval' => 'required|integer|min:1',
            'is_enabled' => 'boolean',
            'products_per_rotation' => 'required|integer|min:1|max:50',
            'product_order_by' => 'required|in:created_at,product_name,price,id',
            'product_order_direction' => 'required|in:asc,desc',
        ]);

        $settings = FeaturedProductRotationSetting::getSettings();
        $settings->update($validated);

        return redirect()->route('admin.featured-rotation.index')
            ->with('success', 'Rotation settings updated successfully!');
    }

    public function resetRotation()
    {
        $this->rotationService->resetRotation();

        return redirect()->route('admin.featured-rotation.index')
            ->with('success', 'Rotation reset to start! Now showing products from the beginning.');
    }

    public function groups()
    {
        $groups = FeaturedProductGroup::withCount('items')
            ->orderBy('order')
            ->get();

        return view('admin.featured-rotation.groups', compact('groups'));
    }

    public function createGroup()
    {
        $products = Product::with('category')->orderBy('product_name')->get();

        return view('admin.featured-rotation.create-group', compact('products'));
    }

    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $group = FeaturedProductGroup::create([
            'name' => $validated['name'],
            'order' => $validated['order'],
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($validated['product_ids'] as $index => $productId) {
            FeaturedProductGroupItem::create([
                'group_id' => $group->id,
                'product_id' => $productId,
                'order' => $index,
            ]);
        }

        return redirect()->route('admin.featured-rotation.groups')
            ->with('success', 'Product group created successfully!');
    }

    public function editGroup($id)
    {
        $group = FeaturedProductGroup::with('items.product')->findOrFail($id);
        $products = Product::with('category')->orderBy('product_name')->get();

        return view('admin.featured-rotation.edit-group', compact('group', 'products'));
    }

    public function updateGroup(Request $request, $id)
    {
        $group = FeaturedProductGroup::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $group->update([
            'name' => $validated['name'],
            'order' => $validated['order'],
            'is_active' => $request->has('is_active'),
        ]);

        $group->items()->delete();

        foreach ($validated['product_ids'] as $index => $productId) {
            FeaturedProductGroupItem::create([
                'group_id' => $group->id,
                'product_id' => $productId,
                'order' => $index,
            ]);
        }

        return redirect()->route('admin.featured-rotation.groups')
            ->with('success', 'Product group updated successfully!');
    }

    public function destroyGroup($id)
    {
        $group = FeaturedProductGroup::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.featured-rotation.groups')
            ->with('success', 'Product group deleted successfully!');
    }

    public function forceRotation()
    {
        $this->rotationService->forceRotation();

        return redirect()->route('admin.featured-rotation.index')
            ->with('success', 'Products rotated successfully!');
    }
}
