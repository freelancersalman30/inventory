<div class="p-6 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-100 flex items-center space-x-3">
                    <span class="p-2 bg-rose-500/20 text-rose-400 rounded-lg">⚠️</span>
                    <span>Low Stock Warning & Reorder Alerts</span>
                </h1>
                <p class="text-sm text-slate-400 mt-1">Real-time products falling below configured threshold level</p>
            </div>
            <span class="px-4 py-2 bg-rose-500/20 text-rose-300 font-bold rounded-xl border border-rose-500/30 text-sm">
                {{ $alerts->count() }} Products Requiring Reorder
            </span>
        </div>

        <div class="bg-slate-800 rounded-2xl border border-slate-700/80 overflow-hidden shadow-xl">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-850 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700">
                        <th class="p-4">SKU / Barcode</th>
                        <th class="p-4">Product Name</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Current Stock</th>
                        <th class="p-4">Alert Threshold</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/60">
                    @forelse ($alerts as $variant)
                        <tr class="hover:bg-slate-750/50 transition">
                            <td class="p-4 font-mono font-bold text-indigo-400">{{ $variant->sku }}</td>
                            <td class="p-4 font-semibold text-slate-200">
                                {{ $variant->product->name }}
                                @if ($variant->size || $variant->color)
                                    <span class="text-xs text-slate-400 font-normal">({{ $variant->size }} / {{ $variant->color }})</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-400">{{ $variant->product->category->name ?? 'Uncategorized' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-rose-500/20 text-rose-300 font-bold rounded-lg border border-rose-500/40">
                                    {{ number_format($variant->stock_quantity, 2) }} {{ $variant->product->unit->short_code ?? 'Pcs' }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-300">{{ number_format($variant->product->alert_quantity, 2) }}</td>
                            <td class="p-4 text-right">
                                <a href="#" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg text-xs shadow transition">
                                    + Create Purchase Order
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-500">
                                🎉 All products are adequately stocked! No threshold alerts.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
