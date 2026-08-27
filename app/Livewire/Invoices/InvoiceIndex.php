<?php

namespace App\Livewire\Invoices;

use App\Models\Sale;
use Livewire\Component;

class InvoiceIndex extends Component
{
    public string $search = '';

    public function render()
    {
        $sales = Sale::with(['customer', 'cashier'])
            ->when($this->search, fn($q) => $q->where('invoice_number', 'like', "%{$this->search}%"))
            ->latest('sale_date')
            ->paginate(15);

        return view('livewire.invoices.index', compact('sales'))->layout('components.layouts.app');
    }
}
