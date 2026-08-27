<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomerIndex extends Component
{
    public string $search = '';
    public bool $showModal = false;
    public ?int $editingCustomerId = null;

    public string $name = '';
    public ?string $phone = null;
    public ?string $email = null;
    public ?string $address = null;
    public float $creditLimit = 0.00;

    public ?string $successMessage = null;

    public function openCreateModal()
    {
        $this->reset(['editingCustomerId', 'name', 'phone', 'email', 'address', 'creditLimit']);
        $this->showModal = true;
    }

    public function editCustomer(int $id)
    {
        $cust = Customer::findOrFail($id);
        $this->editingCustomerId = $cust->id;
        $this->name = $cust->name;
        $this->phone = $cust->phone;
        $this->email = $cust->email;
        $this->address = $cust->address;
        $this->creditLimit = (float) $cust->credit_limit;
        $this->showModal = true;
    }

    public function saveCustomer()
    {
        $this->validate(['name' => 'required|string|max:255']);

        if ($this->editingCustomerId) {
            $cust = Customer::findOrFail($this->editingCustomerId);
            $cust->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'credit_limit' => $this->creditLimit,
            ]);
            $this->successMessage = "Customer updated successfully!";
        } else {
            Customer::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'credit_limit' => $this->creditLimit,
                'current_due' => 0.00,
            ]);
            $this->successMessage = "Customer registered successfully!";
        }

        $this->showModal = false;
    }

    public function deleteCustomer(int $id)
    {
        Customer::findOrFail($id)->delete();
        $this->successMessage = "Customer deleted successfully!";
    }

    public function render()
    {
        $customers = Customer::when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('phone', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->get();

        return view('livewire.customers.index', compact('customers'))->layout('components.layouts.app');
    }
}
