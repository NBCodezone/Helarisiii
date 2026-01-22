<?php

namespace App\Services;

use App\Models\FeaturedProductRotationSetting;
use App\Models\Product;
use Carbon\Carbon;

class FeaturedProductRotationService
{
    /**
     * Get featured products using sliding window approach
     * Shows 8 products starting from current_offset
     * Every rotation interval, offset moves forward by 1
     */
    public function getFeaturedProducts()
    {
        $settings = FeaturedProductRotationSetting::getSettings();

        // Check and perform rotation if needed
        if ($settings->is_enabled) {
            $this->checkAndRotateIfNeeded();
            // Refresh settings after potential rotation
            $settings = $settings->fresh();
        }

        // Get total product count
        $totalProducts = Product::count();

        if ($totalProducts === 0) {
            return collect();
        }

        $limit = $settings->products_per_rotation;
        $offset = $settings->current_offset ?? 0;

        // Get products with sliding window
        $products = Product::with(['category', 'offer'])
            ->orderBy($settings->product_order_by ?? 'created_at', $settings->product_order_direction ?? 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        // If we don't have enough products (near the end), wrap around to get more from the beginning
        if ($products->count() < $limit && $offset > 0) {
            $remaining = $limit - $products->count();
            $wrapProducts = Product::with(['category', 'offer'])
                ->orderBy($settings->product_order_by ?? 'created_at', $settings->product_order_direction ?? 'asc')
                ->limit($remaining)
                ->get();

            $products = $products->concat($wrapProducts);
        }

        return $products;
    }

    /**
     * Check if rotation is needed and perform it
     */
    public function checkAndRotateIfNeeded()
    {
        $settings = FeaturedProductRotationSetting::getSettings();

        if (!$settings->is_enabled) {
            return false;
        }

        // First time rotation
        if (!$settings->last_rotated_at) {
            $settings->update([
                'last_rotated_at' => Carbon::now(),
                'current_offset' => 0,
            ]);
            return true;
        }

        $nextRotation = $this->calculateNextRotation($settings);

        if (Carbon::now()->gte($nextRotation)) {
            return $this->slideWindow();
        }

        return false;
    }

    /**
     * Slide the window forward by 1 position
     */
    public function slideWindow()
    {
        $settings = FeaturedProductRotationSetting::getSettings();
        $totalProducts = Product::count();

        if ($totalProducts === 0) {
            return false;
        }

        // Calculate new offset (move forward by 1)
        $newOffset = ($settings->current_offset ?? 0) + 1;

        // If offset exceeds total products, wrap around to 0
        if ($newOffset >= $totalProducts) {
            $newOffset = 0;
        }

        $settings->update([
            'current_offset' => $newOffset,
            'last_rotated_at' => Carbon::now(),
        ]);

        return true;
    }

    /**
     * Force rotation (manual trigger from admin)
     */
    public function forceRotation()
    {
        return $this->slideWindow();
    }

    /**
     * Reset rotation to start from the beginning
     */
    public function resetRotation()
    {
        $settings = FeaturedProductRotationSetting::getSettings();

        $settings->update([
            'current_offset' => 0,
            'last_rotated_at' => Carbon::now(),
        ]);

        return true;
    }

    /**
     * Calculate when the next rotation should occur
     */
    protected function calculateNextRotation($settings)
    {
        if ($settings->rotation_type === 'hours') {
            return $settings->last_rotated_at->addHours($settings->rotation_interval);
        } else {
            return $settings->last_rotated_at->addDays($settings->rotation_interval);
        }
    }

    /**
     * Get the next rotation time
     */
    public function getNextRotationTime()
    {
        $settings = FeaturedProductRotationSetting::getSettings();

        if (!$settings->is_enabled || !$settings->last_rotated_at) {
            return null;
        }

        return $this->calculateNextRotation($settings);
    }

    /**
     * Get rotation status information
     */
    public function getRotationStatus()
    {
        $settings = FeaturedProductRotationSetting::getSettings();
        $totalProducts = Product::count();
        $limit = $settings->products_per_rotation;
        $offset = $settings->current_offset ?? 0;

        // Calculate which products are currently showing (1-indexed for display)
        $startProduct = $offset + 1;
        $endProduct = min($offset + $limit, $totalProducts);

        // Handle wrap-around display
        if ($offset + $limit > $totalProducts && $totalProducts > 0) {
            $wrapCount = ($offset + $limit) - $totalProducts;
            $endProduct = $wrapCount;
        }

        return [
            'is_enabled' => $settings->is_enabled,
            'rotation_type' => $settings->rotation_type,
            'rotation_interval' => $settings->rotation_interval,
            'products_per_rotation' => $limit,
            'current_offset' => $offset,
            'total_products' => $totalProducts,
            'showing_from' => $startProduct,
            'showing_to' => $endProduct,
            'last_rotated_at' => $settings->last_rotated_at,
            'next_rotation_at' => $this->getNextRotationTime(),
            'product_order_by' => $settings->product_order_by,
            'product_order_direction' => $settings->product_order_direction,
        ];
    }
}
