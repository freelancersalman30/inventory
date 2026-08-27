<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Damage, Wastage & Returns</h1>
                <p class="text-xs text-slate-400">Track damaged stock write-offs, customer returns, and supplier returns</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        <div class="bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                        <th class="p-3">Product</th>
                        <th class="p-3">Entry Type</th>
                        <th class="p-3">Quantity</th>
                        <th class="p-3">Loss Value</th>
                        <th class="p-3">Reason</th>
                        <th class="p-3">Logged Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($records as $rec)
                        <tr class="hover:bg-slate-800/50">
                            <td class="p-3 font-semibold text-slate-200">{{ $rec->variant->product->name ?? 'N/A' }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-xs rounded-full uppercase font-bold {{ $rec->type === 'damage' ? 'bg-rose-500/20 text-rose-300' : 'bg-amber-500/20 text-amber-300' }}">
                                    {{ $rec->type }}
                                </span>
                            </td>
                            <td class="p-3 font-bold font-mono text-slate-200">{{ number_format($rec->quantity, 2) }}</td>
                            <td class="p-3 font-bold text-rose-400">৳{{ number_format($rec->total_loss_value, 2) }}</td>
                            <td class="p-3 text-slate-400 text-xs">{{ $rec->reason ?? '-' }}</td>
                            <td class="p-3 text-slate-400 font-mono text-xs">{{ $rec->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-500">No damage or return entries recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
