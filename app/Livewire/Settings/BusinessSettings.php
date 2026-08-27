<?php

namespace App\Livewire\Settings;

use App\Models\BusinessSetting;
use Livewire\Component;

class BusinessSettings extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $currency = 'BDT';
    public string $currencySymbol = '৳';
    public float $defaultVatRate = 0.00;
    public string $invoiceFooterNote = '';
    public ?string $successMessage = null;

    public function mount()
    {
        $setting = BusinessSetting::first();
        if ($setting) {
            $this->name = $setting->name;
            $this->email = $setting->email ?? '';
            $this->phone = $setting->phone ?? '';
            $this->address = $setting->address ?? '';
            $this->currency = $setting->currency;
            $this->currencySymbol = $setting->currency_symbol;
            $this->defaultVatRate = (float) $setting->default_vat_rate;
            $this->invoiceFooterNote = $setting->invoice_footer_note ?? '';
        }
    }

    public function updateSettings()
    {
        $setting = BusinessSetting::first();
        if ($setting) {
            $setting->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'currency' => $this->currency,
                'currency_symbol' => $this->currencySymbol,
                'default_vat_rate' => $this->defaultVatRate,
                'invoice_footer_note' => $this->invoiceFooterNote,
            ]);
        }
        $this->successMessage = 'Business Settings updated successfully!';
    }

    public function render()
    {
        return view('livewire.settings.business-settings')->layout('components.layouts.app');
    }
}
