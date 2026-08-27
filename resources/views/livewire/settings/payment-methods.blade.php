<div class="p-8 bg-slate-950 min-h-screen text-slate-100 font-sans">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Payment Gateway & Method Settings</h1>
                <p class="text-xs text-slate-400">Configure Cash, Mobile Financial Services (bKash, Nagad, Rocket), POS Card Terminal, and Bank Gateways</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Dashboard</a>
                <button wire:click="openModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl shadow-lg transition flex items-center space-x-1">
                    <span>+ Add Payment Gateway</span>
                </button>
            </div>
        </div>

        <!-- Payment Gateways Grid -->
        <div class="grid grid-cols-3 gap-4">
            @foreach ($gateways as $gw)
                <div class="p-5 bg-slate-900 border border-slate-800 rounded-2xl flex flex-col justify-between space-y-4 shadow-xl relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase font-mono px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                {{ strtoupper($gw->type) }}
                            </span>
                            <h3 class="text-base font-bold text-slate-100 mt-2">{{ $gw->name }}</h3>
                            <p class="text-xs text-slate-400 font-mono">Code: {{ $gw->code }}</p>
                        </div>
                        <button wire:click="toggleStatus({{ $gw->id }})" class="px-2.5 py-1 text-xs font-bold rounded-full transition {{ $gw->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                            {{ $gw->is_active ? 'Active' : 'Disabled' }}
                        </button>
                    </div>

                    <div class="space-y-1 border-t border-slate-800 pt-3 text-xs">
                        @if ($gw->account_number)
                            <div class="flex justify-between text-slate-400">
                                <span>Account / Number:</span>
                                <strong class="text-slate-200 font-mono">{{ $gw->account_number }}</strong>
                            </div>
                        @endif
                        <div class="flex justify-between text-slate-400">
                            <span>Gateway Fee:</span>
                            <strong class="text-slate-200 font-mono">{{ number_format($gw->charge_percentage, 2) }}%</strong>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button wire:click="openModal({{ $gw->id }})" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-bold transition">
                            Edit Config ⚙️
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create / Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-slate-850 border border-slate-800 rounded-2xl p-6 w-full max-w-lg space-y-4 shadow-2xl">
                <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                    <h3 class="font-bold text-base text-slate-100">{{ $editingId ? 'Edit Payment Gateway' : 'Add New Payment Gateway' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Gateway Name *</label>
                        <input type="text" wire:model="name" placeholder="e.g. bKash Merchant" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none" />
                        @error('name') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Gateway Code *</label>
                        <input type="text" wire:model="code" placeholder="e.g. bkash" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm font-mono focus:outline-none" />
                        @error('code') <span class="text-rose-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Gateway Type *</label>
                        <select wire:model="type" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none">
                            <option value="cash">Cash 💵</option>
                            <option value="mfs">Mobile Financial Service (MFS) 📱</option>
                            <option value="card">Card / POS Terminal 💳</option>
                            <option value="bank">Bank Wire Transfer 🏦</option>
                            <option value="online">Online Payment Gateway 🌐</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Merchant / Account Number</label>
                        <input type="text" wire:model="accountNumber" placeholder="e.g. 01700000000" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm font-mono focus:outline-none" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Instruction / Notes for Cashier</label>
                    <textarea wire:model="instructions" rows="2" placeholder="e.g. Ask customer for 10-digit TxnID..." class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none"></textarea>
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <input type="checkbox" wire:model="isActive" id="gw_active" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-indigo-600 focus:ring-0" />
                    <label for="gw_active" class="text-xs font-semibold text-slate-300">Enable this payment gateway for POS checkout</label>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-800">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-800 text-slate-300 text-xs font-bold rounded-lg">Cancel</button>
                    <button wire:click="save" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-lg shadow-lg">Save Gateway</button>
                </div>
            </div>
        </div>
    @endif
</div>
