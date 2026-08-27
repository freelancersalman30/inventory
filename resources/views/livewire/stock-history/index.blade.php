<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Stock Ledgers & Audit History</h1>
                <p class="text-xs text-slate-400">Complete immutable movement log of purchases, sales, returns, adjustments, and wastage</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        <div class="bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                        <th class="p-3">Product</th>
                        <th class="p-3">Movement Type</th>
                        <th class="p-3">Quantity</th>
                        <th class="p-3">Unit Cost</th>
                        <th class="p-3">Reference / Notes</th>
                        <th class="p-3">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($ledgers as $led)
                        <tr class="hover:bg-slate-800/50">
                            <td class="p-3 font-semibold text-slate-200">{{ $led->variant->product->name ?? 'N/A' }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-xs rounded-full uppercase font-bold {{ str_contains($led->type, 'in') || str_contains($led->type, 'purchase') ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                    {{ $led->type }}
                                </span>
                            </td>
                            <td class="p-3 font-bold font-mono {{ $led->quantity >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $led->quantity > 0 ? '+' : '' }}{{ number_format($led->quantity, 2) }}
                            </td>
                            <td class="p-3 font-bold text-indigo-300 font-mono">৳{{ number_format($led->unit_cost, 2) }}</td>
                            <td class="p-3 text-slate-400 text-xs">{{ $led->notes ?? '-' }}</td>
                            <td class="p-3 text-slate-400 font-mono text-xs">{{ $led->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-500">No stock ledger history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
