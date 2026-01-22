<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $fillable = [
        'region_id',
        'ken_name',
        'price_0_10kg',
        'price_10_24kg',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
