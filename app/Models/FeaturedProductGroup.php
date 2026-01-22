<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProductGroup extends Model
{
    protected $fillable = [
        'name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(FeaturedProductGroupItem::class, 'group_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'featured_product_group_items', 'group_id', 'product_id')
            ->withPivot('order')
            ->orderBy('featured_product_group_items.order');
    }
}
