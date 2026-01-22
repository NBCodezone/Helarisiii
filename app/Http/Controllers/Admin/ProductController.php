<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Services\BackgroundRemovalService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly BackgroundRemovalService $backgroundRemovalService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search by product code or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_code', 'like', '%' . $search . '%')
                  ->orWhere('product_name', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest()->paginate(10);
        $products->appends($request->query());

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Increase execution time for image processing (background removal can take time)
        set_time_limit(600); // 10 minutes for multiple images

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'net_weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'is_frozen' => 'required|boolean',
        ]);

        // Get category name
        $category = Category::find($validated['category_id']);
        $validated['category_name'] = $category->category_name;

        // Generate product code automatically
        $validated['product_code'] = Product::generateProductCode($validated['category_id']);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('products');

            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $imageName);
            $relativePath = 'products/' . $imageName;
            $this->backgroundRemovalService->handle(public_path($relativePath));
            $validated['image'] = $relativePath;
        }

        // Remove gallery_images from validated data before creating product
        unset($validated['gallery_images']);

        $product = Product::create($validated);

        // Handle gallery images upload (up to 4 additional images)
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $request->file('gallery_images');
            $sortOrder = 1;

            foreach ($galleryImages as $galleryImage) {
                if ($sortOrder > 4) break; // Maximum 4 additional images

                $galleryImageName = time() . '_' . $sortOrder . '_' . $galleryImage->getClientOriginalName();
                $destination = public_path('products');

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                $galleryImage->move($destination, $galleryImageName);
                $galleryRelativePath = 'products/' . $galleryImageName;
                $this->backgroundRemovalService->handle(public_path($galleryRelativePath));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryRelativePath,
                    'sort_order' => $sortOrder,
                ]);

                $sortOrder++;
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Increase execution time for image processing (background removal can take time)
        set_time_limit(600); // 10 minutes for multiple images

        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'net_weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_gallery_images' => 'nullable|array',
            'delete_gallery_images.*' => 'integer|exists:product_images,id',
            'description' => 'nullable|string',
            'is_frozen' => 'required|boolean',
        ]);

        // Get category name
        $category = Category::find($validated['category_id']);
        $validated['category_name'] = $category->category_name;

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('products');

            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $imageName);
            $relativePath = 'products/' . $imageName;
            $this->backgroundRemovalService->handle(public_path($relativePath));
            $validated['image'] = $relativePath;
        }

        // Handle gallery image deletions
        if ($request->has('delete_gallery_images')) {
            foreach ($request->delete_gallery_images as $imageId) {
                $galleryImage = ProductImage::find($imageId);
                if ($galleryImage && $galleryImage->product_id == $product->id) {
                    // Delete file
                    if (file_exists(public_path($galleryImage->image_path))) {
                        unlink(public_path($galleryImage->image_path));
                    }
                    $galleryImage->delete();
                }
            }
        }

        // Remove non-product fields from validated data
        unset($validated['gallery_images']);
        unset($validated['delete_gallery_images']);

        $product->update($validated);

        // Handle new gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = $request->file('gallery_images');
            $existingCount = $product->images()->count();
            $maxSortOrder = $product->images()->max('sort_order') ?? 0;
            $sortOrder = $maxSortOrder + 1;

            foreach ($galleryImages as $galleryImage) {
                // Check if we already have 4 gallery images
                if ($existingCount >= 4) break;

                $galleryImageName = time() . '_' . $sortOrder . '_' . $galleryImage->getClientOriginalName();
                $destination = public_path('products');

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                $galleryImage->move($destination, $galleryImageName);
                $galleryRelativePath = 'products/' . $galleryImageName;
                $this->backgroundRemovalService->handle(public_path($galleryRelativePath));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryRelativePath,
                    'sort_order' => $sortOrder,
                ]);

                $sortOrder++;
                $existingCount++;
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete main image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Delete gallery images
        foreach ($product->images as $galleryImage) {
            if (file_exists(public_path($galleryImage->image_path))) {
                unlink(public_path($galleryImage->image_path));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
