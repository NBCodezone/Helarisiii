<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const STATUS_LIVE = 'live';
    public const STATUS_MAINTENANCE = 'maintenance';

    protected $fillable = [
        'status',
        'maintenance_message',
        'maintenance_enabled_at',
    ];

    protected $casts = [
        'maintenance_enabled_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => self::STATUS_LIVE,
    ];

    /**
     * Retrieve (or create) the singleton site setting record.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'status' => self::STATUS_LIVE,
            'maintenance_message' => 'We are performing scheduled maintenance. Please check back soon.',
        ]);
    }

    /**
     * Check if the site is currently in maintenance mode.
     */
    public function isMaintenanceMode(): bool
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }
}
