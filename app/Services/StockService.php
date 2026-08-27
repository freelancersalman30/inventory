<?php

namespace App\Services;

use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentItem;
use App\Models\StockLedger;
use Illuminate\Support\Facades\DB;
use Exception;

class StockService
{
    /**
     * Record inventory movement into immutable stock_ledgers table and update stock levels.
     */
    public function recordMovement(
        ProductVariant $variant,
        ?ProductBatch $batch,
        string $type,
        float $quantity,
        float $unitCost = 0.00,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null,
        ?int $userId = null
    ): StockLedger {
        return DB::transaction(function () use ($variant, $batch, $type, $quantity, $unitCost, $referenceType, $referenceId, $notes, $userId) {
            // Update Variant Stock
            $variant->stock_quantity += $quantity;
            $variant->save();

            // Update Batch Stock if present
            if ($batch) {
                $batch->quantity += $quantity;
                $batch->save();
            }

            // Create Stock Ledger Audit Entry
            return StockLedger::create([
                'business_id' => $variant->product->business_id ?? null,
                'product_variant_id' => $variant->id,
                'batch_id' => $batch?->id,
                'type' => $type,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'notes' => $notes,
                'created_by' => $userId,
            ]);
        });
    }

    /**
     * Process Damage, Wastage, or Stock Adjustments.
     */
    public function createAdjustment(
        string $type, // 'damage', 'wastage', 'adjustment'
        array $items, // Array of ['variant_id', 'batch_id', 'quantity', 'unit_cost']
        ?string $reason = null,
        ?int $userId = null
    ): StockAdjustment {
        return DB::transaction(function () use ($type, $items, $reason, $userId) {
            $totalAmount = 0.00;
            foreach ($items as $item) {
                $totalAmount += ($item['quantity'] * $item['unit_cost']);
            }

            $adjustment = StockAdjustment::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'type' => $type,
                'reason' => $reason,
                'total_amount' => $totalAmount,
                'adjustment_date' => now()->toDateString(),
                'created_by' => $userId,
            ]);

            foreach ($items as $itemData) {
                $variant = ProductVariant::findOrFail($itemData['variant_id']);
                $batch = isset($itemData['batch_id']) ? ProductBatch::find($itemData['batch_id']) : null;
                $qty = -abs($itemData['quantity']); // Outgoing adjustment is negative

                StockAdjustmentItem::create([
                    'stock_adjustment_id' => $adjustment->id,
                    'product_variant_id' => $variant->id,
                    'batch_id' => $batch?->id,
                    'quantity' => abs($itemData['quantity']),
                    'unit_cost' => $itemData['unit_cost'],
                    'subtotal' => abs($itemData['quantity']) * $itemData['unit_cost'],
                ]);

                $this->recordMovement(
                    variant: $variant,
                    batch: $batch,
                    type: $type,
                    quantity: $qty,
                    unitCost: $itemData['unit_cost'],
                    referenceType: StockAdjustment::class,
                    referenceId: $adjustment->id,
                    notes: "Stock Adjustment ({$type}): {$reason}",
                    userId: $userId
                );
            }

            return $adjustment;
        });
    }

    /**
     * Get all variants below alert quantity threshold.
     */
    public function getLowStockAlerts(?int $businessId = null)
    {
        return ProductVariant::with(['product', 'batches'])
            ->when($businessId, fn($q) => $q->whereHas('product', fn($p) => $p->where('business_id', $businessId)))
            ->lowStock()
            ->get();
    }
}
