<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use Illuminate\Support\Facades\DB;
use Exception;

class PosCheckoutService
{
    public function __construct(protected StockService $stockService) {}

    /**
     * Process checkout transaction from POS terminal.
     */
    public function checkout(
        array $items, // [['variant_id' => 1, 'batch_id' => 2, 'quantity' => 2, 'unit_price' => 150.00, 'discount' => 0, 'vat' => 0]]
        array $payments, // [['method' => 'cash', 'amount' => 300.00, 'ref' => '']]
        ?int $customerId = null,
        ?int $cashierId = null,
        float $discountAmount = 0.00,
        float $vatRate = 0.00,
        string $status = 'completed',
        ?string $notes = null
    ): Sale {
        return DB::transaction(function () use ($items, $payments, $customerId, $cashierId, $discountAmount, $vatRate, $status, $notes) {
            $customer = $customerId ? Customer::find($customerId) : null;
            $subtotal = 0.00;
            $vatAmount = 0.00;

            // Step 1: Validate stock & calculate subtotal
            foreach ($items as $itemData) {
                $variant = ProductVariant::with('product')->findOrFail($itemData['variant_id']);
                
                if ($status === 'completed' && $variant->stock_quantity < $itemData['quantity']) {
                    throw new Exception("Insufficient stock for product SKU: {$variant->sku}. Required: {$itemData['quantity']}, Available: {$variant->stock_quantity}");
                }

                $itemSubtotal = ($itemData['quantity'] * $itemData['unit_price']) - ($itemData['discount'] ?? 0);
                $subtotal += $itemSubtotal;
            }

            // Calculate VAT & Grand Total
            if ($vatRate > 0) {
                $vatAmount = ($subtotal - $discountAmount) * ($vatRate / 100);
            }
            $grandTotal = max(0, ($subtotal - $discountAmount) + $vatAmount);

            // Calculate total payments received
            $totalPaid = 0.00;
            if ($status === 'completed') {
                foreach ($payments as $pay) {
                    $totalPaid += $pay['amount'];
                }
            }

            $dueAmount = max(0, $grandTotal - $totalPaid);
            $paymentStatus = 'due';
            if ($totalPaid >= $grandTotal) {
                $paymentStatus = 'paid';
            } elseif ($totalPaid > 0) {
                $paymentStatus = 'partial';
            }

            // Credit Limit Check for Customer
            if ($customer && $dueAmount > 0) {
                if ($customer->credit_limit > 0 && ($customer->current_due + $dueAmount) > $customer->credit_limit) {
                    throw new Exception("Customer credit limit exceeded! Max limit: {$customer->credit_limit}, Current due + new due: " . ($customer->current_due + $dueAmount));
                }
            }

            // Step 2: Create Sale Header
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            $sale = Sale::create([
                'business_id' => auth()->user()?->business_id ?? 1,
                'customer_id' => $customer?->id,
                'cashier_id' => $cashierId ?? auth()->id(),
                'invoice_number' => $invoiceNumber,
                'status' => $status,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'vat_amount' => $vatAmount,
                'grand_total' => $grandTotal,
                'paid_amount' => $totalPaid,
                'due_amount' => $dueAmount,
                'payment_status' => $paymentStatus,
                'notes' => $notes,
                'sale_date' => now(),
            ]);

            // Step 3: Create Sale Items & Deduct Stock if Completed
            foreach ($items as $itemData) {
                $variant = ProductVariant::findOrFail($itemData['variant_id']);
                $batch = isset($itemData['batch_id']) ? ProductBatch::find($itemData['batch_id']) : null;
                $itemTotal = ($itemData['quantity'] * $itemData['unit_price']) - ($itemData['discount'] ?? 0);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_variant_id' => $variant->id,
                    'batch_id' => $batch?->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_amount' => $itemData['discount'] ?? 0,
                    'vat_amount' => 0.00,
                    'total' => $itemTotal,
                ]);

                if ($status === 'completed') {
                    $this->stockService->recordMovement(
                        variant: $variant,
                        batch: $batch,
                        type: 'sale',
                        quantity: -$itemData['quantity'], // Negative for sale
                        unitCost: $variant->purchase_price,
                        referenceType: Sale::class,
                        referenceId: $sale->id,
                        notes: "POS Invoice #{$invoiceNumber}",
                        userId: $cashierId ?? auth()->id()
                    );
                }
            }

            // Step 4: Record Payments & Update Customer Due
            if ($status === 'completed') {
                foreach ($payments as $pay) {
                    if ($pay['amount'] > 0) {
                        SalePayment::create([
                            'sale_id' => $sale->id,
                            'payment_method' => $pay['method'],
                            'amount' => $pay['amount'],
                            'reference_number' => $pay['ref'] ?? null,
                            'notes' => 'POS Payment',
                            'payment_date' => now(),
                            'created_by' => $cashierId ?? auth()->id(),
                        ]);
                    }
                }

                if ($customer && $dueAmount > 0) {
                    $customer->increment('current_due', $dueAmount);
                }
            }

            return $sale;
        });
    }
}
