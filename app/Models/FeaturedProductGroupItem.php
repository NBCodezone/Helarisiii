<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProductGroupItem extends Model
{
    protected $fillable = [
        'group_id',
        'product_id',
        'order',
    ];

    public function group()
    {
        return $this->belongsTo(FeaturedProductGroup::class, 'group_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
