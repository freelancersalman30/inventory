<?php

namespace App\Livewire;

use App\Services\StockService;
use Livewire\Component;

class StockAlerts extends Component
{
    public function render(StockService $stockService)
    {
        $lowStockVariants = $stockService->getLowStockAlerts(auth()->user()?->business_id);

        return view('livewire.stock-alerts', [
            'alerts' => $lowStockVariants,
        ])->layout('components.layouts.app');
    }
}
