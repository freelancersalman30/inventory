<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Customer Ledgers & Due Tracking</h1>
                <p class="text-xs text-slate-400">Track customer credit limits, transaction history, and receivables</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg flex items-center space-x-2 transition">
                    <span>+ Add New Customer</span>
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
            <input type="text" wire:model.live="search" placeholder="Search by Customer Name or Phone..." class="w-80 bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
        </div>

        <div class="bg-slate-850 rounded-2xl border border-slate-800 overflow-hidden shadow-xl">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">Phone Number</th>
                        <th class="p-4">Credit Limit</th>
                        <th class="p-4">Current Due</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($customers as $cust)
                        <tr class="hover:bg-slate-800/50 transition">
                            <td class="p-4 font-semibold text-slate-200">{{ $cust->name }}</td>
                            <td class="p-4 text-slate-400 font-mono">{{ $cust->phone ?? 'N/A' }}</td>
                            <td class="p-4 font-bold text-slate-300">৳{{ number_format($cust->credit_limit, 2) }}</td>
                            <td class="p-4 font-bold {{ $cust->current_due > 0 ? 'text-rose-400' : 'text-emerald-400' }}">
                                ৳{{ number_format($cust->current_due, 2) }}
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <button wire:click="editCustomer({{ $cust->id }})" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-lg text-xs font-bold transition">Edit ✏️</button>
                                <button wire:click="deleteCustomer({{ $cust->id }})" wire:confirm="Are you sure you want to delete this customer?" class="px-2.5 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 rounded-lg text-xs font-bold transition">Delete 🗑️</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-500">No customers registered yet. Click "+ Add New Customer" to register.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-700 rounded-2xl p-6 w-full max-w-lg space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-700 pb-3">
                    <h3 class="font-bold text-lg text-slate-100">{{ $editingCustomerId ? 'Edit Customer' : 'Add New Customer' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Customer Full Name *</label>
                    <input type="text" wire:model="name" placeholder="e.g. Rahul Sharma" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="e.g. +8801711223344" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Allowed Credit Limit (৳)</label>
                        <input type="number" step="0.01" wire:model="creditLimit" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Email Address</label>
                    <input type="email" wire:model="email" placeholder="customer@example.com" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Physical Address</label>
                    <textarea wire:model="address" rows="2" placeholder="Street address..." class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-3 border-t border-slate-700">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-sm transition">Cancel</button>
                    <button wire:click="saveCustomer" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm shadow-lg transition">Save Customer</button>
                </div>
            </div>
        </div>
    @endif
</div>
