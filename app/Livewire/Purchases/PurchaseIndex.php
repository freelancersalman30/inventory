<?php

namespace App\Livewire\Purchases;

use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockLedger;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Livewire\Component;

class PurchaseIndex extends Component
{
    public bool $showModal = false;
    public ?int $supplierId = null;
    public ?int $variantId = null;
    public float $quantity = 1.00;
    public float $purchasePrice = 0.00;
    public float $paidAmount = 0.00;
    public ?string $successMessage = null;

    public function openCreateModal()
    {
        $this->reset(['supplierId', 'variantId', 'quantity', 'purchasePrice', 'paidAmount']);
        $this->showModal = true;
    }

    public function createPurchase()
    {
        $this->validate([
            'variantId' => 'required|exists:product_variants,id',
            'quantity' => 'required|numeric|min:0.01',
            'purchasePrice' => 'required|numeric|min:0',
        ]);

        $variant = ProductVariant::findOrFail($this->variantId);
        $totalAmount = $this->quantity * $this->purchasePrice;
        $dueAmount = max(0, $totalAmount - $this->paidAmount);
        $invoiceNumber = 'PO-' . strtoupper(Str::random(6));

        $purchase = Purchase::create([
            'business_id' => auth()->user()?->business_id ?? 1,
            'supplier_id' => $this->supplierId,
            'invoice_number' => $invoiceNumber,
            'status' => 'received',
            'total_amount' => $totalAmount,
            'paid_amount' => $this->paidAmount,
            'due_amount' => $dueAmount,
            'purchase_date' => now()->toDateString(),
            'created_by' => auth()->id(),
        ]);

        PurchaseItem::create([
            'purchase_id' => $purchase->id,
            'product_variant_id' => $variant->id,
            'quantity' => $this->quantity,
            'purchase_price' => $this->purchasePrice,
            'selling_price' => $variant->selling_price,
            'subtotal' => $totalAmount,
        ]);

        // Increment variant stock quantity
        $newStock = $variant->stock_quantity + $this->quantity;
        $variant->update(['stock_quantity' => $newStock]);

        // Record stock ledger movement
        StockLedger::create([
            'business_id' => $purchase->business_id,
            'product_variant_id' => $variant->id,
            'type' => 'purchase',
            'quantity' => $this->quantity,
            'unit_cost' => $this->purchasePrice,
            'reference_type' => Purchase::class,
            'reference_id' => $purchase->id,
            'notes' => "Purchase order {$invoiceNumber}",
            'created_by' => auth()->id(),
        ]);

        $this->successMessage = "Purchase order {$invoiceNumber} created and stock updated!";
        $this->showModal = false;
    }

    public function deletePurchase(int $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        $this->successMessage = "Purchase order record deleted!";
    }

    public function render()
    {
        $purchases = Purchase::with(['supplier', 'creator', 'items.variant.product'])->latest('purchase_date')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $variants = ProductVariant::with('product')->get();

        return view('livewire.purchases.index', compact('purchases', 'suppliers', 'variants'))->layout('components.layouts.app');
    }
}
