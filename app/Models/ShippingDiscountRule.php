<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDiscountRule extends Model
{
    protected $fillable = [
        'region_id',
        'min_order_amount',
        'min_order_weight',
        'rice_product_id',
        'rice_weight_per_unit',
        'min_rice_count',
        'max_rice_count',
        'max_weight_limit',
        'discount_percentage',
        'is_active',
        'rule_name',
        'description',
    ];

    protected $casts = [
        'min_order_amount' => 'decimal:2',
        'min_order_weight' => 'decimal:2',
        'rice_weight_per_unit' => 'decimal:2',
        'max_weight_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function riceProduct()
    {
        return $this->belongsTo(Product::class, 'rice_product_id');
    }
}
