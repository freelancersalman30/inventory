<?php

namespace App\Livewire\StockHistory;

use App\Models\StockLedger;
use Livewire\Component;

class StockHistoryIndex extends Component
{
    public function render()
    {
        $ledgers = StockLedger::with(['variant.product', 'batch', 'creator'])->latest()->paginate(15);
        return view('livewire.stock-history.index', compact('ledgers'))->layout('components.layouts.app');
    }
}
