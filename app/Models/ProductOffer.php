<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $fillable = [
        'title',
        'product_name',
        'discount_percentage',
        'product_id',
        'order',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
