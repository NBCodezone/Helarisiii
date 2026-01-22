<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'whatsapp_number',
        'postal_code',
        'region_id',
        'ken_name',
        'city',
        'apartment',
        'payment_method',
        'payment_receipt',
        'delivery_date',
        'delivery_time_slot',
        'subtotal',
        'discount_amount',
        'delivery_charge',
        'frozen_charge',
        'tax_amount',
        'total_amount',
        'coins_earned',
        'status',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if order belongs to a guest
     */
    public function isGuest()
    {
        return $this->user_id === null;
    }

    /**
     * Check if order belongs to a registered user
     */
    public function isRegistered()
    {
        return $this->user_id !== null;
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
