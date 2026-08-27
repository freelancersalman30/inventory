<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Purchase Orders & Stock Restocking</h1>
                <p class="text-xs text-slate-400">Track vendor purchase orders, inventory restocking, and payable balances</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg flex items-center space-x-2 transition">
                    <span>+ Create Purchase Order</span>
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

        <div class="bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                        <th class="p-3">Reference #</th>
                        <th class="p-3">Supplier</th>
                        <th class="p-3">Grand Total</th>
                        <th class="p-3">Paid / Due</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Date</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($purchases as $p)
                        <tr class="hover:bg-slate-800/50">
                            <td class="p-3 font-mono font-bold text-indigo-400">{{ $p->invoice_number }}</td>
                            <td class="p-3 font-semibold text-slate-200">{{ $p->supplier->name ?? 'Direct Purchase' }}</td>
                            <td class="p-3 font-bold text-emerald-400">৳{{ number_format($p->total_amount, 2) }}</td>
                            <td class="p-3 text-xs">
                                <span class="text-emerald-400">৳{{ number_format($p->paid_amount, 2) }}</span>
                                @if ($p->due_amount > 0)
                                    <span class="text-rose-400 font-bold ml-1">(Due: ৳{{ number_format($p->due_amount, 2) }})</span>
                                @endif
                            </td>
                            <td class="p-3"><span class="px-2.5 py-1 text-xs bg-emerald-500/20 text-emerald-300 font-bold rounded-full uppercase">{{ $p->status }}</span></td>
                            <td class="p-3 text-slate-400 font-mono text-xs">{{ $p->purchase_date->format('Y-m-d') }}</td>
                            <td class="p-3 text-right">
                                <button wire:click="deletePurchase({{ $p->id }})" wire:confirm="Delete this purchase record?" class="px-2 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 rounded text-xs font-bold transition">Delete 🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-500">No purchase records found. Click "+ Create Purchase Order" to restock.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Purchase Order Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-700 rounded-2xl p-6 w-full max-w-lg space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-700 pb-3">
                    <h3 class="font-bold text-lg text-slate-100">Create Purchase Order & Restock</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Select Supplier</label>
                    <select wire:model="supplierId" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Select Supplier...</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->company_name ?? 'Individual' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Select Product *</label>
                    <select wire:model="variantId" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Select Product Variant...</option>
                        @foreach ($variants as $v)
                            <option value="{{ $v->id }}">{{ $v->product->name }} (SKU: {{ $v->sku }}) - Current Stock: {{ $v->stock_quantity }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Quantity *</label>
                        <input type="number" step="0.01" wire:model="quantity" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Purchase Unit Cost (৳) *</label>
                        <input type="number" step="0.01" wire:model="purchasePrice" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Amount Paid (৳)</label>
                        <input type="number" step="0.01" wire:model="paidAmount" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-3 border-t border-slate-700">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-sm transition">Cancel</button>
                    <button wire:click="createPurchase" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg transition">Submit Purchase & Restock</button>
                </div>
            </div>
        </div>
    @endif
</div>
