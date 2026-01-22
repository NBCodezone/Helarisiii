<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'region_name',
    ];

    public function deliveryCharges()
    {
        return $this->hasMany(DeliveryCharge::class);
    }
}
