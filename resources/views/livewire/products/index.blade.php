<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Product Catalog & Inventory</h1>
                <p class="text-xs text-slate-400">Manage products, variants, SKUs, purchase/selling pricing & stock control</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg flex items-center space-x-2 transition">
                    <span>+ Add New Product</span>
                </button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
            </div>
        </div>

        @if ($successMessage)
            <div class="p-4 bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 rounded-xl text-sm font-bold flex justify-between items-center">
                <span>✅ {{ $successMessage }}</span>
                <button wire:click="$set('successMessage', null)" class="text-emerald-400 font-bold">&times;</button>
            </div>
        @endif

        <div class="flex justify-between items-center">
            <input type="text" wire:model.live="search" placeholder="Search by Product Name or SKU..." class="w-80 bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
        </div>

        <div class="bg-slate-850 rounded-2xl border border-slate-800 overflow-hidden shadow-xl">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                        <th class="p-4">SKU</th>
                        <th class="p-4">Product Name</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Purchase Price</th>
                        <th class="p-4">Selling Price</th>
                        <th class="p-4">Stock Qty</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($products as $prod)
                        <tr class="hover:bg-slate-800/50 transition">
                            <td class="p-4 font-mono font-bold text-indigo-400">{{ $prod->sku }}</td>
                            <td class="p-4 font-semibold text-slate-200">{{ $prod->name }}</td>
                            <td class="p-4 text-slate-400">{{ $prod->category->name ?? 'Uncategorized' }}</td>
                            <td class="p-4 text-slate-300">৳{{ number_format($prod->purchase_price, 2) }}</td>
                            <td class="p-4 font-bold text-emerald-400">৳{{ number_format($prod->selling_price, 2) }}</td>
                            <td class="p-4 font-bold text-indigo-300">
                                {{ number_format($prod->variants->sum('stock_quantity'), 0) }} {{ $prod->unit->short_code ?? 'Pcs' }}
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button wire:click="editProduct({{ $prod->id }})" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-lg text-xs font-bold transition">Edit ✏️</button>
                                <button wire:click="deleteProduct({{ $prod->id }})" wire:confirm="Are you sure you want to delete this product?" class="px-2.5 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 rounded-lg text-xs font-bold transition">Delete 🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-500">No products found. Click "+ Add New Product" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Product Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-700 rounded-2xl p-6 w-full max-w-2xl space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-700 pb-3">
                    <h3 class="font-bold text-lg text-slate-100">{{ $editingProductId ? 'Edit Product' : 'Add New Product' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Product Name *</label>
                        <input type="text" wire:model="name" placeholder="e.g. Wireless Mouse" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">SKU / Code *</label>
                        <input type="text" wire:model="sku" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Category</label>
                        <select wire:model="categoryId" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Select Category...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Unit of Measure</label>
                        <select wire:model="unitId" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">Select Unit...</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->short_code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Purchase Cost (৳) *</label>
                        <input type="number" step="0.01" wire:model="purchasePrice" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Retail Selling Price (৳) *</label>
                        <input type="number" step="0.01" wire:model="sellingPrice" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Stock Quantity</label>
                        <input type="number" step="1" wire:model="initialStock" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-3 border-t border-slate-700">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-sm transition">Cancel</button>
                    <button wire:click="saveProduct" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg transition">Save Product</button>
                </div>
            </div>
        </div>
    @endif
</div>
