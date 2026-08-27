<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Services\ProfitLossService;
use App\Services\StockService;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(ProfitLossService $pnlService, StockService $stockService)
    {
        $businessId = auth()->user()?->business_id;
        $today = now();

        // KPI Summary Metrics
        $todayReport = $pnlService->generateReport($today->copy()->startOfDay(), $today->copy()->endOfDay(), $businessId);
        $totalCustomers = Customer::count();
        $totalCustomerDue = Customer::sum('current_due');
        $lowStockCount = $stockService->getLowStockAlerts($businessId)->count();
        $recentSales = Sale::with(['customer', 'cashier'])
            ->completed()
            ->latest('sale_date')
            ->take(8)
            ->get();

        $valuation = $pnlService->getStockValuation($businessId);

        return view('livewire.dashboard', [
            'todayRevenue' => $todayReport['sales_summary']['total_revenue'],
            'todaySalesCount' => $todayReport['sales_summary']['total_count'],
            'todayGrossProfit' => $todayReport['gross_profit'],
            'todayNetProfit' => $todayReport['net_profit'],
            'todayExpenses' => $todayReport['operating_expenses'],
            'totalCustomers' => $totalCustomers,
            'totalCustomerDue' => $totalCustomerDue,
            'lowStockCount' => $lowStockCount,
            'recentSales' => $recentSales,
            'valuation' => $valuation,
        ])->layout('components.layouts.app');
    }
}
