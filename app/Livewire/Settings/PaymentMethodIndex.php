<?php

namespace App\Livewire\Settings;

use App\Models\PaymentGateway;
use Livewire\Component;

class PaymentMethodIndex extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $code = '';
    public string $type = 'mfs';
    public string $accountNumber = '';
    public float $chargePercentage = 0.00;
    public bool $isActive = true;
    public string $instructions = '';

    public function openModal(?int $id = null)
    {
        $this->resetValidation();
        $this->editingId = $id;

        if ($id) {
            $gateway = PaymentGateway::findOrFail($id);
            $this->name = $gateway->name;
            $this->code = $gateway->code;
            $this->type = $gateway->type;
            $this->accountNumber = $gateway->account_number ?? '';
            $this->chargePercentage = (float) $gateway->charge_percentage;
            $this->isActive = (bool) $gateway->is_active;
            $this->instructions = $gateway->instructions ?? '';
        } else {
            $this->reset(['name', 'code', 'type', 'accountNumber', 'chargePercentage', 'isActive', 'instructions']);
            $this->isActive = true;
            $this->type = 'mfs';
        }

        $this->showModal = true;
    }

    public function toggleStatus(int $id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->update(['is_active' => !$gateway->is_active]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_gateways,code,' . $this->editingId,
            'type' => 'required|in:cash,mfs,card,bank,online',
        ]);

        PaymentGateway::updateOrCreate(
            ['id' => $this->editingId],
            [
                'business_id' => auth()->user()?->business_id ?? 1,
                'name' => $this->name,
                'code' => strtolower(trim($this->code)),
                'type' => $this->type,
                'account_number' => $this->accountNumber,
                'charge_percentage' => $this->chargePercentage,
                'is_active' => $this->isActive,
                'instructions' => $this->instructions,
            ]
        );

        $this->showModal = false;
        $this->reset(['name', 'code', 'type', 'accountNumber', 'chargePercentage', 'isActive', 'instructions', 'editingId']);
    }

    public function render()
    {
        $gateways = PaymentGateway::orderBy('id')->get();
        return view('livewire.settings.payment-methods', compact('gateways'))->layout('components.layouts.app');
    }
}
