<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProductRotationSetting extends Model
{
    protected $fillable = [
        'rotation_type',
        'rotation_interval',
        'is_enabled',
        'products_per_rotation',
        'current_offset',
        'product_order_by',
        'product_order_direction',
        'last_rotated_at',
        'current_group_id',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'last_rotated_at' => 'datetime',
    ];

    public function currentGroup()
    {
        return $this->belongsTo(FeaturedProductGroup::class, 'current_group_id');
    }

    public static function getSettings()
    {
        return static::first() ?? static::create([
            'rotation_type' => 'hours',
            'rotation_interval' => 6,
            'is_enabled' => true,
            'products_per_rotation' => 8,
            'current_offset' => 0,
            'product_order_by' => 'created_at',
            'product_order_direction' => 'asc',
        ]);
    }
}
