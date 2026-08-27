<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockHistory extends Model
{
    use HasFactory;

    public $timestamps = false; // Uses created_at timestamp only

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'user_id',
        'movement_type',
        'quantity',
        'stock_after',
        'reference_type',
        'reference_id',
        'note',
        'created_at',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'stock_after' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
