<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Profit & Loss Financial Statement</h1>
                <p class="text-xs text-slate-400">Comprehensive calculation of Gross Profit, COGS, Operating Expenses, and Net Profit</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        <div class="flex space-x-4 items-center bg-slate-850 p-4 rounded-xl border border-slate-800">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">From Date</label>
                <input type="date" wire:model.live="startDate" class="bg-slate-800 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 text-sm" />
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">To Date</label>
                <input type="date" wire:model.live="endDate" class="bg-slate-800 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 text-sm" />
            </div>
        </div>

        <div class="bg-slate-850 p-8 rounded-2xl border border-slate-800 shadow-2xl space-y-6">
            <div class="border-b border-slate-700 pb-4 flex justify-between items-center">
                <span class="font-bold text-lg text-slate-200">Financial Performance Overview</span>
                <span class="text-xs text-slate-400 font-mono">{{ $report['period']['start'] }} to {{ $report['period']['end'] }}</span>
            </div>

            <div class="space-y-4 text-base">
                <div class="flex justify-between items-center py-2 border-b border-slate-800">
                    <span class="text-slate-300 font-semibold">Total Revenue (Grand Total Sales)</span>
                    <span class="font-bold text-emerald-400 text-lg">৳{{ number_format($report['sales_summary']['total_revenue'], 2) }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-slate-800">
                    <span class="text-slate-400">Cost of Goods Sold (COGS)</span>
                    <span class="font-semibold text-rose-400">-৳{{ number_format($report['cogs'], 2) }}</span>
                </div>

                <div class="flex justify-between items-center py-3 bg-slate-900/60 px-4 rounded-xl font-bold text-lg">
                    <span class="text-indigo-300">Gross Profit</span>
                    <span class="text-indigo-400">৳{{ number_format($report['gross_profit'], 2) }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-slate-800">
                    <span class="text-slate-400">Operating Expenses</span>
                    <span class="font-semibold text-rose-400">-৳{{ number_format($report['operating_expenses'], 2) }}</span>
                </div>

                <div class="flex justify-between items-center py-2 border-b border-slate-800">
                    <span class="text-slate-400">Stock Wastage & Damage Loss</span>
                    <span class="font-semibold text-rose-400">-৳{{ number_format($report['stock_damage_loss'], 2) }}</span>
                </div>

                <div class="flex justify-between items-center py-4 bg-emerald-500/20 px-6 rounded-2xl font-extrabold text-2xl border border-emerald-500/40 mt-6">
                    <span class="text-emerald-300">Net Profit</span>
                    <span class="text-emerald-400">৳{{ number_format($report['net_profit'], 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
