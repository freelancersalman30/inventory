<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Expense Management</h1>
                <p class="text-xs text-slate-400">Record, edit, and track operational costs, rent, utilities, and salaries</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        @if ($successMessage)
            <div class="p-4 bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 rounded-xl text-sm font-bold flex justify-between items-center">
                <span>✅ {{ $successMessage }}</span>
                <button wire:click="$set('successMessage', null)" class="text-emerald-400 font-bold">&times;</button>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6">
            <!-- Add / Edit Expense Form -->
            <div class="col-span-4 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl space-y-4">
                <h3 class="font-bold text-slate-100 text-base">{{ $editingExpenseId ? 'Edit Expense Log' : 'Record New Expense' }}</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Expense Category</label>
                    <select wire:model="categoryId" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Select Category...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Amount (৳)</label>
                    <input type="number" step="0.01" wire:model="amount" placeholder="0.00" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Payment Method</label>
                    <select wire:model="paymentMethod" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bkash">bKash</option>
                        <option value="nagad">Nagad</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Description / Notes</label>
                    <textarea wire:model="description" rows="3" placeholder="Additional details..." class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <div class="flex space-x-2">
                    @if ($editingExpenseId)
                        <button wire:click="cancelEdit" class="w-1/3 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-sm transition">Cancel</button>
                    @endif
                    <button wire:click="saveExpense" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition">
                        {{ $editingExpenseId ? 'Update Expense' : 'Save Expense Log' }}
                    </button>
                </div>
            </div>

            <!-- Expense History List -->
            <div class="col-span-8 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl">
                <h3 class="font-bold text-slate-100 text-base mb-4">Expense Logs History</h3>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-800 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                            <th class="p-3">Date</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Method</th>
                            <th class="p-3">Amount</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse ($expenses as $exp)
                            <tr class="hover:bg-slate-800/50 transition">
                                <td class="p-3 text-slate-300 font-mono text-xs">{{ $exp->expense_date->format('Y-m-d') }}</td>
                                <td class="p-3 font-semibold text-slate-200">{{ $exp->category->name ?? 'General' }}</td>
                                <td class="p-3 text-slate-400 uppercase text-xs">{{ $exp->payment_method }}</td>
                                <td class="p-3 font-bold text-rose-400">৳{{ number_format($exp->amount, 2) }}</td>
                                <td class="p-3 text-right space-x-2">
                                    <button wire:click="editExpense({{ $exp->id }})" class="px-2 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded text-xs font-bold transition">Edit ✏️</button>
                                    <button wire:click="deleteExpense({{ $exp->id }})" wire:confirm="Delete this expense record?" class="px-2 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 rounded text-xs font-bold transition">Delete 🗑️</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-500">No expenses recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
