<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockAdjustment;
use Carbon\Carbon;

class ProfitLossService
{
    /**
     * Generate Comprehensive P&L Statement for a given date range.
     */
    public function generateReport(Carbon $startDate, Carbon $endDate, ?int $businessId = null): array
    {
        // 1. Sales & Revenue
        $salesQuery = Sale::completed()
            ->whereBetween('sale_date', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->when($businessId, fn($q) => $q->where('business_id', $businessId));

        $totalSalesCount = (clone $salesQuery)->count();
        $totalRevenue = (clone $salesQuery)->sum('grand_total');
        $totalDiscountGiven = (clone $salesQuery)->sum('discount_amount');
        $totalVatCollected = (clone $salesQuery)->sum('vat_amount');

        // 2. Cost of Goods Sold (COGS)
        $saleIds = (clone $salesQuery)->pluck('id');
        $cogs = SaleItem::whereIn('sale_id', $saleIds)
            ->join('product_variants', 'sale_items.product_variant_id', '=', 'product_variants.id')
            ->selectRaw('SUM(sale_items.quantity * product_variants.purchase_price) as total_cogs')
            ->value('total_cogs') ?? 0.00;

        // 3. Gross Profit
        $grossProfit = $totalRevenue - $cogs;

        // 4. Operating Expenses
        $totalExpenses = Expense::whereBetween('expense_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($businessId, fn($q) => $q->where('business_id', $businessId))
            ->sum('amount');

        // 5. Stock Adjustments / Damage & Wastage Loss
        $totalDamageLoss = StockAdjustment::whereBetween('adjustment_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($businessId, fn($q) => $q->where('business_id', $businessId))
            ->sum('total_amount');

        // 6. Net Profit
        $netProfit = $grossProfit - $totalExpenses - $totalDamageLoss;

        return [
            'period' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ],
            'sales_summary' => [
                'total_count' => $totalSalesCount,
                'total_revenue' => (float) $totalRevenue,
                'total_discount' => (float) $totalDiscountGiven,
                'total_vat' => (float) $totalVatCollected,
            ],
            'cogs' => (float) $cogs,
            'gross_profit' => (float) $grossProfit,
            'operating_expenses' => (float) $totalExpenses,
            'stock_damage_loss' => (float) $totalDamageLoss,
            'net_profit' => (float) $netProfit,
        ];
    }

    /**
     * Calculate Current Stock Valuation (Purchase Value vs Selling Value).
     */
    public function getStockValuation(?int $businessId = null): array
    {
        $query = ProductVariant::with('product')
            ->when($businessId, fn($q) => $q->whereHas('product', fn($p) => $p->where('business_id', $businessId)));

        $totalVariants = (clone $query)->count();
        $totalUnits = (clone $query)->sum('stock_quantity');
        
        $purchaseValuation = (clone $query)->selectRaw('SUM(stock_quantity * purchase_price) as val')->value('val') ?? 0.00;
        $sellingValuation = (clone $query)->selectRaw('SUM(stock_quantity * selling_price) as val')->value('val') ?? 0.00;
        $potentialProfit = $sellingValuation - $purchaseValuation;

        return [
            'total_variants' => $totalVariants,
            'total_units' => (float) $totalUnits,
            'purchase_value' => (float) $purchaseValuation,
            'selling_value' => (float) $sellingValuation,
            'potential_profit' => (float) $potentialProfit,
        ];
    }
}
