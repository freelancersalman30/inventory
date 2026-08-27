<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;

class UnitIndex extends Component
{
    public string $name = '';
    public string $shortCode = '';

    public function createUnit()
    {
        $this->validate([
            'name' => 'required|string',
            'shortCode' => 'required|string|max:10',
        ]);
        Unit::create([
            'name' => $this->name,
            'short_code' => strtolower($this->shortCode),
        ]);
        $this->reset(['name', 'shortCode']);
    }

    public function render()
    {
        $units = Unit::all();
        return view('livewire.units.index', compact('units'))->layout('components.layouts.app');
    }
}
