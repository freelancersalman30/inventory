<div class="p-8 bg-slate-950 min-h-screen text-slate-100 font-sans">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Sales Invoices & Control Center</h1>
                <p class="text-xs text-slate-400">Manage invoices, filter past sales, and print in 80mm Thermal or Standard A4 corporate formats</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        <div class="flex justify-between items-center">
            <input type="text" wire:model.live="search" placeholder="Search by Invoice Number or Customer..." class="w-80 bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
        </div>

        <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                        <th class="p-3">Invoice #</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Cashier</th>
                        <th class="p-3">Grand Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Sale Date</th>
                        <th class="p-3 text-right">Invoice Options</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-slate-800/50">
                            <td class="p-3 font-mono font-bold text-indigo-400">{{ $sale->invoice_number }}</td>
                            <td class="p-3 font-semibold text-slate-200">{{ $sale->customer->name ?? 'Walk-in Guest' }}</td>
                            <td class="p-3 text-slate-400 text-xs">{{ $sale->cashier->name ?? 'System' }}</td>
                            <td class="p-3 font-bold text-emerald-400">৳{{ number_format($sale->grand_total, 2) }}</td>
                            <td class="p-3"><span class="px-2.5 py-1 text-xs bg-emerald-500/20 text-emerald-300 font-bold rounded-full uppercase">{{ $sale->status }}</span></td>
                            <td class="p-3 text-slate-400 font-mono text-xs">{{ $sale->sale_date->format('Y-m-d H:i') }}</td>
                            <td class="p-3 text-right space-x-1">
                                <a href="{{ route('invoices.thermal', $sale->invoice_number) }}" target="_blank" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 rounded-lg text-xs font-bold transition inline-flex items-center space-x-1">
                                    <span>80mm Thermal 🖨️</span>
                                </a>
                                <a href="{{ route('invoices.standard', $sale->invoice_number) }}" target="_blank" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-bold transition inline-flex items-center space-x-1 shadow-md">
                                    <span>Standard A4 📄</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-500">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
