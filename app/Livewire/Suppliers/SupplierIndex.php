<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class SupplierIndex extends Component
{
    public string $name = '';
    public string $companyName = '';
    public string $phone = '';
    public ?int $editingSupplierId = null;

    public ?string $successMessage = null;

    public function editSupplier(int $id)
    {
        $sup = Supplier::findOrFail($id);
        $this->editingSupplierId = $sup->id;
        $this->name = $sup->name;
        $this->companyName = $sup->company_name ?? '';
        $this->phone = $sup->phone ?? '';
    }

    public function cancelEdit()
    {
        $this->reset(['editingSupplierId', 'name', 'companyName', 'phone']);
    }

    public function saveSupplier()
    {
        $this->validate(['name' => 'required|string|max:255']);

        if ($this->editingSupplierId) {
            $sup = Supplier::findOrFail($this->editingSupplierId);
            $sup->update([
                'name' => $this->name,
                'company_name' => $this->companyName,
                'phone' => $this->phone,
            ]);
            $this->successMessage = 'Supplier details updated!';
        } else {
            Supplier::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'name' => $this->name,
                'company_name' => $this->companyName,
                'phone' => $this->phone,
            ]);
            $this->successMessage = 'Supplier added successfully!';
        }

        $this->reset(['editingSupplierId', 'name', 'companyName', 'phone']);
    }

    public function deleteSupplier(int $id)
    {
        Supplier::findOrFail($id)->delete();
        $this->successMessage = 'Supplier record deleted!';
    }

    public function render()
    {
        $suppliers = Supplier::all();
        return view('livewire.suppliers.index', compact('suppliers'))->layout('components.layouts.app');
    }
}
