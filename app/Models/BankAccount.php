<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_holder_name',
        'account_number',
        'branch_name',
        'swift_code',
        'ifsc_code',
        'additional_info',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active bank account
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Set this account as active and deactivate others
     */
    public function setActive()
    {
        // Deactivate all accounts
        self::query()->update(['is_active' => false]);

        // Activate this account
        $this->update(['is_active' => true]);
    }
}
