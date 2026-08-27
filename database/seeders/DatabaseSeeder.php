<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\StockLedger;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Business Setting
        $business = BusinessSetting::create([
            'name' => 'DPCB General Store & Supermarket',
            'email' => 'contact@dpcbstore.com',
            'phone' => '+8801711223344',
            'address' => 'House 45, Road 12, Dhanmondi, Dhaka - 1209',
            'currency' => 'BDT',
            'currency_symbol' => '৳',
            'default_vat_rate' => 5.00,
            'invoice_footer_note' => 'Thank you for shopping with DPCB Store! Please retain receipt for returns within 7 days.',
        ]);

        // 2. Create Admin & Cashier Users
        $admin = User::create([
            'business_id' => $business->id,
            'name' => 'Admin Manager',
            'email' => 'admin@dpcbstore.com',
            'phone' => '01700000001',
            'password' => Hash::make('password'),
            'pin_code' => Hash::make('1234'),
            'theme_preference' => 'dark',
            'is_active' => true,
        ]);

        $cashier = User::create([
            'business_id' => $business->id,
            'name' => 'John Cashier',
            'email' => 'cashier@dpcbstore.com',
            'phone' => '01700000002',
            'password' => Hash::make('password'),
            'pin_code' => Hash::make('5678'),
            'theme_preference' => 'dark',
            'is_active' => true,
        ]);

        // 3. Create Categories & Units
        $catBeverages = Category::create(['business_id' => $business->id, 'name' => 'Beverages & Soft Drinks', 'slug' => 'beverages']);
        $catGroceries = Category::create(['business_id' => $business->id, 'name' => 'Grocery & Staples', 'slug' => 'grocery']);
        $catElectronics = Category::create(['business_id' => $business->id, 'name' => 'Electronics & Accessories', 'slug' => 'electronics']);

        $unitPcs = Unit::create(['business_id' => $business->id, 'name' => 'Pieces', 'short_code' => 'Pcs']);
        $unitKg = Unit::create(['business_id' => $business->id, 'name' => 'Kilogram', 'short_code' => 'Kg']);
        $unitBtl = Unit::create(['business_id' => $business->id, 'name' => 'Bottle', 'short_code' => 'Btl']);

        // 4. Create Customers & Suppliers
        $customer = Customer::create([
            'business_id' => $business->id,
            'name' => 'Rahim Chowdhury',
            'phone' => '01811223344',
            'email' => 'rahim@gmail.com',
            'credit_limit' => 10000.00,
            'current_due' => 0.00,
        ]);

        $supplier = Supplier::create([
            'business_id' => $business->id,
            'name' => 'Square Consumer Products Ltd',
            'company_name' => 'Square Group',
            'phone' => '01999887766',
            'email' => 'supply@square.com',
        ]);

        // 5. Create Sample Products & Variants with Initial Stock
        $p1 = Product::create([
            'business_id' => $business->id,
            'category_id' => $catBeverages->id,
            'unit_id' => $unitBtl->id,
            'name' => 'Coca-Cola 500ml Pet Bottle',
            'slug' => 'coca-cola-500ml',
            'sku' => 'PRD-COKE-500',
            'barcode' => '894110020011',
            'alert_quantity' => 10.00,
        ]);

        $v1 = ProductVariant::create([
            'product_id' => $p1->id,
            'sku' => 'SKU-COKE-500ML',
            'barcode' => '894110020011',
            'purchase_price' => 35.00,
            'selling_price' => 45.00,
            'stock_quantity' => 50.00,
        ]);

        $b1 = ProductBatch::create([
            'product_variant_id' => $v1->id,
            'batch_number' => 'BATCH-2026-A',
            'expiry_date' => now()->addMonths(6)->toDateString(),
            'quantity' => 50.00,
            'purchase_price' => 35.00,
            'selling_price' => 45.00,
        ]);

        StockLedger::create([
            'business_id' => $business->id,
            'product_variant_id' => $v1->id,
            'batch_id' => $b1->id,
            'type' => 'purchase',
            'quantity' => 50.00,
            'unit_cost' => 35.00,
            'notes' => 'Initial Stock Import',
            'created_by' => $admin->id,
        ]);

        // Low stock sample item
        $p2 = Product::create([
            'business_id' => $business->id,
            'category_id' => $catGroceries->id,
            'unit_id' => $unitKg->id,
            'name' => 'Miniket Premium Rice 5kg Pack',
            'slug' => 'miniket-rice-5kg',
            'sku' => 'PRD-RICE-5KG',
            'barcode' => '894110055001',
            'alert_quantity' => 15.00,
        ]);

        $v2 = ProductVariant::create([
            'product_id' => $p2->id,
            'sku' => 'SKU-RICE-5KG',
            'barcode' => '894110055001',
            'purchase_price' => 320.00,
            'selling_price' => 380.00,
            'stock_quantity' => 3.00, // Below alert threshold 15!
        ]);

        StockLedger::create([
            'business_id' => $business->id,
            'product_variant_id' => $v2->id,
            'type' => 'purchase',
            'quantity' => 3.00,
            'unit_cost' => 320.00,
            'notes' => 'Initial Stock',
            'created_by' => $admin->id,
        ]);
    }
}
