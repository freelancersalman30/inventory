<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'code',
        'type',
        'account_number',
        'charge_percentage',
        'is_active',
        'instructions',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'charge_percentage' => 'float',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
