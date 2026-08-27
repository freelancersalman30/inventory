<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Business & Thermal Invoice Settings</h1>
                <p class="text-xs text-slate-400">Manage store info, default tax rates, currency, and receipt footer text</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        @if ($successMessage)
            <div class="p-4 bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 rounded-xl text-sm font-bold">
                ✅ {{ $successMessage }}
            </div>
        @endif

        <div class="bg-slate-850 p-8 rounded-2xl border border-slate-800 shadow-xl space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Business Store Name</label>
                    <input type="text" wire:model="name" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Store Email</label>
                    <input type="email" wire:model="email" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Contact Phone</label>
                    <input type="text" wire:model="phone" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Default VAT / Tax Rate (%)</label>
                    <input type="number" step="0.01" wire:model="defaultVatRate" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Store Physical Address</label>
                <textarea wire:model="address" rows="2" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Thermal Receipt Footer Note</label>
                <input type="text" wire:model="invoiceFooterNote" placeholder="e.g. Thank you for shopping with us! No return without receipt." class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>

            <button wire:click="updateSettings" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition">
                Save Business Profile & Settings
            </button>
        </div>
    </div>
</div>
