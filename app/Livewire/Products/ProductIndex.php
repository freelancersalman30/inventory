<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockLedger;
use App\Models\Unit;
use Illuminate\Support\Str;
use Livewire\Component;

class ProductIndex extends Component
{
    public string $search = '';
    public bool $showModal = false;
    public ?int $editingProductId = null;

    public string $name = '';
    public string $sku = '';
    public ?int $categoryId = null;
    public ?int $unitId = null;
    public float $purchasePrice = 0.00;
    public float $sellingPrice = 0.00;
    public float $alertQuantity = 5.00;
    public float $initialStock = 0.00;

    public ?string $successMessage = null;

    public function openCreateModal()
    {
        $this->reset(['editingProductId', 'name', 'sku', 'categoryId', 'unitId', 'purchasePrice', 'sellingPrice', 'alertQuantity', 'initialStock']);
        $this->sku = 'PRD-' . strtoupper(Str::random(6));
        $this->showModal = true;
    }

    public function editProduct(int $id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->categoryId = $product->category_id;
        $this->unitId = $product->unit_id;
        $this->purchasePrice = (float) $product->purchase_price;
        $this->sellingPrice = (float) $product->selling_price;
        $this->alertQuantity = (float) $product->alert_quantity;
        
        $variant = $product->variants->first();
        $this->initialStock = $variant ? (float) $variant->stock_quantity : 0.00;

        $this->showModal = true;
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'purchasePrice' => 'required|numeric|min:0',
            'sellingPrice' => 'required|numeric|min:0',
        ]);

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update([
                'name' => $this->name,
                'sku' => $this->sku,
                'category_id' => $this->categoryId,
                'unit_id' => $this->unitId,
                'purchase_price' => $this->purchasePrice,
                'selling_price' => $this->sellingPrice,
                'alert_quantity' => $this->alertQuantity,
            ]);

            $variant = $product->variants()->first();
            if ($variant) {
                $variant->update([
                    'sku' => $this->sku,
                    'purchase_price' => $this->purchasePrice,
                    'selling_price' => $this->sellingPrice,
                    'stock_quantity' => $this->initialStock,
                    'alert_quantity' => $this->alertQuantity,
                ]);
            }
            $this->successMessage = "Product '{$this->name}' updated successfully!";
        } else {
            $product = Product::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'category_id' => $this->categoryId,
                'unit_id' => $this->unitId,
                'name' => $this->name,
                'slug' => Str::slug($this->name) . '-' . rand(100, 999),
                'sku' => $this->sku,
                'barcode' => $this->sku,
                'purchase_price' => $this->purchasePrice,
                'selling_price' => $this->sellingPrice,
                'alert_quantity' => $this->alertQuantity,
                'is_active' => true,
            ]);

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => 'Standard',
                'sku' => $this->sku,
                'barcode' => $this->sku,
                'purchase_price' => $this->purchasePrice,
                'selling_price' => $this->sellingPrice,
                'stock_quantity' => $this->initialStock,
                'alert_quantity' => $this->alertQuantity,
            ]);

            if ($this->initialStock > 0) {
                StockLedger::create([
                    'business_id' => $product->business_id,
                    'product_variant_id' => $variant->id,
                    'type' => 'adjustment',
                    'quantity' => $this->initialStock,
                    'unit_cost' => $this->purchasePrice,
                    'notes' => 'Opening stock initialization',
                    'created_by' => auth()->id(),
                ]);
            }

            $this->successMessage = "Product '{$this->name}' created successfully!";
        }

        $this->showModal = false;
    }

    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->successMessage = "Product deleted successfully!";
    }

    public function render()
    {
        $products = Product::with(['category', 'unit', 'variants'])
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('sku', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);

        $categories = Category::all();
        $units = Unit::all();

        return view('livewire.products.index', [
            'products' => $products,
            'categories' => $categories,
            'units' => $units,
        ])->layout('components.layouts.app');
    }
}
