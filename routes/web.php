<?php

use App\Livewire\Categories\CategoryIndex;
use App\Livewire\Customers\CustomerIndex;
use App\Livewire\Dashboard;
use App\Livewire\Expenses\ExpenseIndex;
use App\Livewire\Invoices\InvoiceIndex;
use App\Livewire\PosTerminal;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Purchases\PurchaseIndex;
use App\Livewire\Reports\ProfitLossReport;
use App\Livewire\ReturnsWastages\ReturnsWastagesIndex;
use App\Livewire\Settings\BusinessSettings;
use App\Livewire\Settings\PaymentMethodIndex;
use App\Livewire\StockAlerts;
use App\Livewire\StockHistory\StockHistoryIndex;
use App\Livewire\Suppliers\SupplierIndex;
use App\Livewire\Units\UnitIndex;
use App\Models\BusinessSetting;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/pos', PosTerminal::class)->name('pos');
Route::get('/products', ProductIndex::class)->name('products.index');
Route::get('/categories', CategoryIndex::class)->name('categories.index');
Route::get('/units', UnitIndex::class)->name('units.index');
Route::get('/suppliers', SupplierIndex::class)->name('suppliers.index');
Route::get('/purchases', PurchaseIndex::class)->name('purchases.index');
Route::get('/customers', CustomerIndex::class)->name('customers.index');
Route::get('/expenses', ExpenseIndex::class)->name('expenses.index');
Route::get('/stock-alerts', StockAlerts::class)->name('stock.alerts');
Route::get('/stock-history', StockHistoryIndex::class)->name('stock.history');
Route::get('/returns-wastages', ReturnsWastagesIndex::class)->name('returns.wastages');
Route::get('/invoices', InvoiceIndex::class)->name('invoices.index');
Route::get('/reports/profit-loss', ProfitLossReport::class)->name('reports.profit-loss');
Route::get('/settings/business', BusinessSettings::class)->name('settings.business');
Route::get('/settings/payment-methods', PaymentMethodIndex::class)->name('settings.payment-methods');

// 80mm POS Thermal Receipt Route
Route::get('/invoices/thermal/{invoiceNumber}', function ($invoiceNumber) {
    $sale = Sale::with(['items.variant.product', 'customer', 'cashier'])->where('invoice_number', $invoiceNumber)->firstOrFail();
    $business = BusinessSetting::first();
    return view('invoices.thermal-80mm', compact('sale', 'business'));
})->name('invoices.thermal');

// Standard Corporate A4 Invoice Route
Route::get('/invoices/standard/{invoiceNumber}', function ($invoiceNumber) {
    $sale = Sale::with(['items.variant.product', 'customer', 'cashier'])->where('invoice_number', $invoiceNumber)->firstOrFail();
    $business = BusinessSetting::first();
    return view('invoices.standard-a4', compact('sale', 'business'));
})->name('invoices.standard');
