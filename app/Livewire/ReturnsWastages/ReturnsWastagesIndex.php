<?php

namespace App\Livewire\ReturnsWastages;

use App\Models\ReturnAndWastage;
use Livewire\Component;

class ReturnsWastagesIndex extends Component
{
    public function render()
    {
        $records = ReturnAndWastage::with(['variant.product', 'creator'])->latest()->get();
        return view('livewire.returns-wastages.index', compact('records'))->layout('components.layouts.app');
    }
}
