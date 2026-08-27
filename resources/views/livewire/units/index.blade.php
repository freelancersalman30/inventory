<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Measurement Units</h1>
                <p class="text-xs text-slate-400">Configure units of measurement (e.g. Piece, Kilogram, Box, Pack)</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-medium transition">&larr; Back to Dashboard</a>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-4 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl space-y-4">
                <h3 class="font-bold text-slate-100 text-base">Add New Unit</h3>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Unit Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Kilogram" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Short Code</label>
                    <input type="text" wire:model="shortCode" placeholder="e.g. kg, pcs, box" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
                <button wire:click="createUnit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition">Save Unit</button>
            </div>

            <div class="col-span-8 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                            <th class="p-3">Unit Name</th>
                            <th class="p-3">Short Code</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($units as $u)
                            <tr class="hover:bg-slate-800/50">
                                <td class="p-3 font-semibold text-slate-200">{{ $u->name }}</td>
                                <td class="p-3 text-indigo-400 font-mono font-bold">{{ $u->short_code }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
