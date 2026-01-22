<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'category_name',
        'product_name',
        'product_code',
        'stock',
        'net_weight',
        'price',
        'image',
        'description',
        'is_frozen',
    ];

    /**
     * Generate a unique product code based on category
     * Format: XX### where XX is first 2 letters of category, ### is sequential number
     * Each category gets a range of 100 numbers (100-199, 200-299, etc.)
     */
    public static function generateProductCode($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return null;
        }

        // Get first 2 letters of category name (uppercase)
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->category_name), 0, 2));

        // Get all categories ordered by id to determine the base number for each category
        $categories = Category::orderBy('id')->pluck('id')->toArray();
        $categoryIndex = array_search($categoryId, $categories);

        // Each category gets a range starting at (index + 1) * 100
        // Category 1: 100-199, Category 2: 200-299, etc.
        $baseNumber = ($categoryIndex + 1) * 100;
        $maxNumber = $baseNumber + 99;

        // Find the highest existing product code number for this category
        $lastProduct = self::where('category_id', $categoryId)
            ->whereNotNull('product_code')
            ->orderByRaw('CAST(SUBSTRING(product_code, 3) AS UNSIGNED) DESC')
            ->first();

        if ($lastProduct && $lastProduct->product_code) {
            // Extract the number from the last product code
            $lastNumber = (int) substr($lastProduct->product_code, 2);
            $nextNumber = $lastNumber + 1;

            // Check if we've exceeded the range
            if ($nextNumber > $maxNumber) {
                // Range exhausted, find any gaps or use overflow
                $nextNumber = $maxNumber;
            }
        } else {
            // First product in this category
            $nextNumber = $baseNumber;
        }

        return $prefix . $nextNumber;
    }

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the active offer for this product
     */
    public function offer()
    {
        return $this->hasOne(ProductOffer::class);
    }

    /**
     * Get the additional images for this product
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get the discounted price if an offer exists
     */
    public function getDiscountedPriceAttribute()
    {
        $offer = $this->offer;
        if ($offer && $offer->discount_percentage > 0) {
            return round($this->price * (1 - $offer->discount_percentage / 100));
        }
        return $this->price;
    }

    /**
     * Check if product has an active discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->offer && $this->offer->discount_percentage > 0;
    }

    /**
     * Get the discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        return $this->offer ? $this->offer->discount_percentage : 0;
    }
}
