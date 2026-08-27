<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Customer;
use App\Models\ProductVariant;
use App\Services\PosCheckoutService;
use Livewire\Component;

class PosTerminal extends Component
{
    public string $searchQuery = '';
    public $selectedCategoryId = null;
    public $selectedCustomerId = null;
    public $discountAmount = 0.00;
    public $vatRate = 0.00;
    public $tenderedAmount = 0.00;
    
    public array $cart = [];
    public string $selectedPaymentMethod = 'cash';
    public ?string $paymentRef = null;

    public ?string $errorMessage = null;
    public ?string $successMessage = null;
    public ?string $lastInvoiceNumber = null;
    public bool $showSuccessModal = false;

    // Quick Add Customer Modal
    public bool $showCustomerModal = false;
    public string $newCustomerName = '';
    public string $newCustomerPhone = '';

    public function mount()
    {
        $this->vatRate = (float) (auth()->user()?->business?->default_vat_rate ?? 0.00);
    }

    public function updatedSearchQuery()
    {
        // Auto-add product if barcode/SKU exact match
        if (trim($this->searchQuery) !== '') {
            $exactVariant = ProductVariant::where('sku', trim($this->searchQuery))
                ->orWhere('barcode', trim($this->searchQuery))
                ->first();

            if ($exactVariant) {
                $this->addToCart($exactVariant->id);
                $this->searchQuery = '';
            }
        }
    }

    public function selectCategory($catId = null)
    {
        $this->selectedCategoryId = $catId ? (int) $catId : null;
    }

    public function addToCart(int $variantId)
    {
        $variant = ProductVariant::with(['product', 'batches'])->find($variantId);
        if (!$variant) return;

        if (isset($this->cart[$variantId])) {
            $this->cart[$variantId]['quantity'] += 1;
        } else {
            $this->cart[$variantId] = [
                'variant_id' => $variant->id,
                'name' => $variant->product->name . ($variant->size ? " ({$variant->size})" : ''),
                'sku' => $variant->sku,
                'unit_price' => (float) $variant->selling_price,
                'quantity' => 1,
                'discount' => 0.00,
                'stock' => (float) $variant->stock_quantity,
                'batch_id' => $variant->batches->first()?->id,
            ];
        }

        $this->updateTendered();
    }

    public function updateQuantity(int $variantId, $qty)
    {
        $numericQty = (float) $qty;
        if ($numericQty <= 0) {
            $this->removeFromCart($variantId);
            return;
        }

        if (isset($this->cart[$variantId])) {
            $this->cart[$variantId]['quantity'] = $numericQty;
        }

        $this->updateTendered();
    }

    public function removeFromCart(int $variantId)
    {
        unset($this->cart[$variantId]);
        $this->updateTendered();
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->discountAmount = 0.00;
        $this->tenderedAmount = 0.00;
        $this->errorMessage = null;
    }

    public function getSubtotalProperty(): float
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);
        }, 0.00);
    }

    public function getVatAmountProperty(): float
    {
        $discount = (float) ($this->discountAmount ?? 0);
        $vatRate = (float) ($this->vatRate ?? 0);
        return max(0, $this->subtotal - $discount) * ($vatRate / 100);
    }

    public function getGrandTotalProperty(): float
    {
        $discount = (float) ($this->discountAmount ?? 0);
        return max(0, ($this->subtotal - $discount) + $this->vatAmount);
    }

    public function getChangeAmountProperty(): float
    {
        $tendered = (float) ($this->tenderedAmount ?? 0);
        return max(0, $tendered - $this->grandTotal);
    }

    public function updateTendered()
    {
        $this->tenderedAmount = $this->grandTotal;
    }

    public function setExactPayment()
    {
        $this->tenderedAmount = $this->grandTotal;
    }

    public function createQuickCustomer()
    {
        $this->validate(['newCustomerName' => 'required|string|max:255']);
        $cust = Customer::create([
            'business_id' => auth()->user()?->business_id ?? 1,
            'name' => $this->newCustomerName,
            'phone' => $this->newCustomerPhone,
        ]);
        $this->selectedCustomerId = $cust->id;
        $this->reset(['newCustomerName', 'newCustomerPhone', 'showCustomerModal']);
    }

    public function checkout(PosCheckoutService $checkoutService, string $status = 'completed')
    {
        $this->errorMessage = null;
        $this->successMessage = null;

        if (empty($this->cart)) {
            $this->errorMessage = 'Cart is empty! Select products first.';
            return;
        }

        $tendered = (float) ($this->tenderedAmount ?? 0);
        $discount = (float) ($this->discountAmount ?? 0);
        $vatRate = (float) ($this->vatRate ?? 0);

        $payments = [
            [
                'method' => $this->selectedPaymentMethod,
                'amount' => min($tendered, $this->grandTotal),
                'ref' => $this->paymentRef ?? ''
            ]
        ];

        try {
            $sale = $checkoutService->checkout(
                items: array_values($this->cart),
                payments: $payments,
                customerId: $this->selectedCustomerId ? (int) $this->selectedCustomerId : null,
                cashierId: auth()->id(),
                discountAmount: $discount,
                vatRate: $vatRate,
                status: $status
            );

            $this->lastInvoiceNumber = $sale->invoice_number;
            $this->successMessage = "Invoice {$sale->invoice_number} successfully processed!";
            $this->showSuccessModal = true;
            $this->clearCart();
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $products = ProductVariant::with(['product', 'batches'])
            ->whereHas('product', fn($q) => $q->active())
            ->when($this->selectedCategoryId, function ($q) {
                $q->whereHas('product', fn($p) => $p->where('category_id', $this->selectedCategoryId));
            })
            ->when($this->searchQuery, function ($q) {
                $q->where('sku', 'like', "%{$this->searchQuery}%")
                  ->orWhere('barcode', 'like', "%{$this->searchQuery}%")
                  ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$this->searchQuery}%"));
            })
            ->take(18)
            ->get();

        $categories = Category::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $paymentGateways = \App\Models\PaymentGateway::active()->get();

        return view('livewire.pos-terminal', [
            'searchResults' => $products,
            'categories' => $categories,
            'customers' => $customers,
            'paymentGateways' => $paymentGateways,
        ])->layout('components.layouts.app');
    }
}
