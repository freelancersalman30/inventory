<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'currency',
        'currency_symbol',
        'default_vat_rate',
        'logo',
        'invoice_footer_note',
    ];

    protected $casts = [
        'default_vat_rate' => 'decimal:2',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'business_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'business_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'business_id');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'business_id');
    }
}
