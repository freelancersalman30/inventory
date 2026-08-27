<div class="h-screen bg-slate-950 text-slate-100 flex flex-col font-sans overflow-hidden">
    <!-- Top POS Header Bar -->
    <header class="h-14 bg-slate-900 border-b border-slate-800 px-6 flex items-center justify-between shrink-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="p-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition flex items-center space-x-1">
                <span>&larr; Exit to Dashboard</span>
            </a>
            <div class="h-5 w-px bg-slate-700"></div>
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <h1 class="font-extrabold text-slate-100 text-sm tracking-wide uppercase">POS Checkout Terminal</h1>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-xs text-slate-400 font-mono">Cashier: <strong class="text-slate-200">{{ auth()->user()->name ?? 'Cashier' }}</strong></span>
            <span class="text-xs text-indigo-400 font-bold bg-indigo-500/10 border border-indigo-500/30 px-2.5 py-1 rounded-md">Vat Rate: {{ $vatRate }}%</span>
        </div>
    </header>

    <div class="flex-1 flex overflow-hidden">
        <!-- Left: Product Catalog & Search (7 Cols) -->
        <div class="w-7/12 flex flex-col border-r border-slate-800 bg-slate-900 p-4 space-y-4 overflow-hidden">
            <!-- Search & Barcode Input -->
            <div class="relative">
                <svg class="w-5 h-5 absolute left-3.5 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" wire:model.live.debounce.150ms="searchQuery" placeholder="Search by Product Name, SKU, or Scan Barcode..." autofocus class="w-full bg-slate-800 border border-slate-700 text-slate-100 placeholder-slate-400 rounded-xl pl-11 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium shadow-inner" />
            </div>

            <!-- Category Pills Filter Bar -->
            <div class="flex space-x-2 overflow-x-auto pb-1 scrollbar-none">
                <button wire:click="selectCategory(null)" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition whitespace-nowrap {{ is_null($selectedCategoryId) ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-slate-200' }}">
                    All Items
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="selectCategory({{ $cat->id }})" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition whitespace-nowrap {{ $selectedCategoryId === $cat->id ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-slate-200' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <!-- Product Grid Cards -->
            <div class="flex-1 overflow-y-auto pr-1">
                <div class="grid grid-cols-3 gap-3">
                    @forelse ($searchResults as $variant)
                        <button wire:click="addToCart({{ $variant->id }})" class="p-3.5 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/50 rounded-xl transition text-left flex flex-col justify-between group shadow-lg h-32 relative overflow-hidden">
                            <div>
                                <span class="text-[10px] font-mono font-bold text-indigo-400 uppercase tracking-wider block truncate">{{ $variant->sku }}</span>
                                <h4 class="font-bold text-slate-200 text-xs mt-1 leading-snug line-clamp-2 group-hover:text-indigo-300 transition">{{ $variant->product->name }}</h4>
                            </div>

                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-800/80">
                                <span class="text-sm font-extrabold text-emerald-400">৳{{ number_format($variant->selling_price, 2) }}</span>
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $variant->stock_quantity <= $variant->alert_quantity ? 'bg-rose-500/20 text-rose-300' : 'bg-slate-800 text-slate-400' }}">
                                    Qty: {{ number_format($variant->stock_quantity, 0) }}
                                </span>
                            </div>
                        </button>
                    @empty
                        <div class="col-span-3 text-center py-16 text-slate-500 space-y-2">
                            <span class="text-4xl block">🔍</span>
                            <p class="text-sm font-medium">No products matching your search.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Interactive Order Cart & Checkout (5 Cols) -->
        <div class="w-5/12 flex flex-col bg-slate-850 p-4 space-y-3 overflow-hidden">
            <!-- Customer Selection Header -->
            <div class="flex space-x-2">
                <select wire:model="selectedCustomerId" class="flex-1 bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Walk-in Guest Customer</option>
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone ?? 'No Phone' }})</option>
                    @endforeach
                </select>
                <button wire:click="$set('showCustomerModal', true)" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-indigo-400 font-bold rounded-xl text-xs transition border border-slate-700">
                    + New
                </button>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 bg-slate-900 rounded-xl border border-slate-800 p-2 overflow-y-auto space-y-1.5">
                @forelse ($cart as $id => $item)
                    <div class="p-2.5 bg-slate-850 rounded-lg border border-slate-800 flex items-center justify-between text-xs">
                        <div class="flex-1 overflow-hidden pr-2">
                            <h5 class="font-bold text-slate-200 truncate">{{ $item['name'] }}</h5>
                            <span class="text-[10px] text-slate-400 font-mono">৳{{ number_format($item['unit_price'], 2) }} / unit</span>
                        </div>

                        <!-- Quantity Stepper Controls -->
                        <div class="flex items-center space-x-1 bg-slate-900 border border-slate-700 rounded-lg p-0.5">
                            <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="w-5 h-5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded flex items-center justify-center text-xs">-</button>
                            <span class="w-6 text-center font-bold text-slate-200 font-mono">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="w-5 h-5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded flex items-center justify-center text-xs">+</button>
                        </div>

                        <!-- Item Total Price -->
                        <div class="w-20 text-right font-bold text-emerald-400 font-mono pl-2">
                            ৳{{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                        </div>

                        <!-- Delete Button -->
                        <button wire:click="removeFromCart({{ $id }})" class="text-slate-500 hover:text-rose-400 pl-2 text-sm font-bold">&times;</button>
                    </div>
                @empty
                    <div class="text-center py-16 text-slate-600 space-y-2">
                        <span class="text-3xl block">🛒</span>
                        <p class="text-xs">Cart is empty. Click products to add items.</p>
                    </div>
                @endforelse
            </div>

            @if ($errorMessage)
                <div class="p-2.5 bg-rose-500/20 border border-rose-500/40 text-rose-300 rounded-xl text-xs font-bold">
                    ⚠️ {{ $errorMessage }}
                </div>
            @endif

            <!-- Order Totals Breakdown -->
            <div class="p-3 bg-slate-900 rounded-xl border border-slate-800 space-y-2 text-xs">
                <div class="flex justify-between text-slate-400">
                    <span>Subtotal</span>
                    <span class="font-mono text-slate-200">৳{{ number_format($this->subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between items-center text-slate-400">
                    <span>Order Discount (৳)</span>
                    <input type="number" step="0.01" wire:model.live="discountAmount" class="w-24 bg-slate-800 border border-slate-700 text-slate-200 text-right rounded px-2 py-1 font-mono focus:ring-1 focus:ring-indigo-500 focus:outline-none" />
                </div>

                <div class="flex justify-between text-slate-400">
                    <span>VAT Tax ({{ $vatRate }}%)</span>
                    <span class="font-mono text-slate-200">৳{{ number_format($this->vatAmount, 2) }}</span>
                </div>

                <div class="flex justify-between items-center pt-2 border-t border-slate-800 font-bold text-base">
                    <span class="text-slate-100">Grand Total</span>
                    <span class="text-emerald-400 font-mono text-xl">৳{{ number_format($this->grandTotal, 2) }}</span>
                </div>
            </div>

            <!-- Payment Method Selector -->
            <div class="grid grid-cols-3 gap-1.5">
                @foreach ($paymentGateways as $gw)
                    <button wire:click="$set('selectedPaymentMethod', '{{ $gw->code }}')" class="py-2 px-1 rounded-xl text-xs font-bold border transition text-center truncate {{ $selectedPaymentMethod === $gw->code ? 'bg-indigo-600 text-white border-indigo-500 shadow-md' : 'bg-slate-800 text-slate-400 border-slate-700 hover:bg-slate-700 hover:text-slate-200' }}">
                        {{ $gw->name }}
                    </button>
                @endforeach
            </div>

            @if ($selectedPaymentMethod !== 'cash')
                <div class="bg-slate-900 p-2 rounded-xl border border-slate-800">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase mb-1">Transaction Ref / Approval Code / TxnID</label>
                    <input type="text" wire:model="paymentRef" placeholder="e.g. TRX99823412" class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-xs rounded px-2.5 py-1 font-mono focus:outline-none" />
                </div>
            @endif

            <!-- Cash Tendered & Change Display -->
            <div class="flex space-x-2 items-center bg-slate-900 p-2.5 rounded-xl border border-slate-800">
                <div class="flex-1">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase">Paid Amount (৳)</label>
                    <input type="number" step="0.01" wire:model.live="tenderedAmount" class="w-full bg-slate-800 border border-slate-700 text-slate-100 font-bold text-sm rounded px-2.5 py-1 font-mono focus:outline-none" />
                </div>
                <button wire:click="setExactPayment" class="px-2.5 py-2 bg-slate-800 hover:bg-slate-700 text-indigo-400 text-xs font-bold rounded-lg border border-slate-700 transition">
                    Exact ৳
                </button>
                <div class="w-28 text-right">
                    <span class="block text-[10px] font-semibold text-slate-400 uppercase">Change Due</span>
                    <span class="font-mono text-sm font-bold text-indigo-400">৳{{ number_format($this->changeAmount, 2) }}</span>
                </div>
            </div>

            <!-- Action Buttons: Clear & Complete Checkout -->
            <div class="flex space-x-2">
                <button wire:click="clearCart" class="px-4 py-3 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 font-bold rounded-xl text-xs transition">
                    Clear Cart
                </button>
                <button wire:click="checkout" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold rounded-xl text-sm shadow-xl transition flex items-center justify-center space-x-2">
                    <span>Complete Checkout ⚡</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Add Customer Modal -->
    @if ($showCustomerModal)
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-700 rounded-2xl p-6 w-full max-w-md space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-700 pb-3">
                    <h3 class="font-bold text-sm text-slate-100">Quick Add Customer</h3>
                    <button wire:click="$set('showCustomerModal', false)" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Customer Name *</label>
                    <input type="text" wire:model="newCustomerName" placeholder="e.g. Shakib Al Hasan" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Phone Number</label>
                    <input type="text" wire:model="newCustomerPhone" placeholder="+8801700000000" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none" />
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-slate-700">
                    <button wire:click="$set('showCustomerModal', false)" class="px-3 py-2 bg-slate-800 text-slate-300 text-xs font-bold rounded-lg">Cancel</button>
                    <button wire:click="createQuickCustomer" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg shadow-lg">Save & Select</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Transaction Complete Success Modal -->
    @if ($showSuccessModal)
        <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-700 rounded-2xl p-6 w-full max-w-md text-center space-y-4 shadow-2xl">
                <div class="w-16 h-16 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto text-3xl">
                    ✓
                </div>
                <h3 class="font-extrabold text-xl text-slate-100">Transaction Successful!</h3>
                <p class="text-xs text-slate-400">Invoice Number: <strong class="text-indigo-400 font-mono text-sm">{{ $lastInvoiceNumber }}</strong></p>

                <div class="flex flex-col space-y-2 pt-2">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('invoices.thermal', $lastInvoiceNumber ?? '') }}" target="_blank" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-700 text-indigo-300 font-bold rounded-xl text-xs border border-slate-700 transition flex items-center justify-center space-x-1">
                            <span>Thermal 80mm 🖨️</span>
                        </a>
                        <a href="{{ route('invoices.standard', $lastInvoiceNumber ?? '') }}" target="_blank" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-xs shadow-lg transition flex items-center justify-center space-x-1">
                            <span>Standard A4 📄</span>
                        </a>
                    </div>
                    <button wire:click="$set('showSuccessModal', false)" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-slate-400 font-bold rounded-xl text-xs transition">
                        Start Next Sale &rarr;
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
