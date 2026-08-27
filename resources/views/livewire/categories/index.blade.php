<div class="p-8 bg-slate-900 min-h-screen text-slate-100">
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-100">Product Categories</h1>
                <p class="text-xs text-slate-400">Organize products into hierarchical categories</p>
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
            <div class="col-span-4 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl space-y-4">
                <h3 class="font-bold text-slate-100 text-base">{{ $editingCategoryId ? 'Edit Category' : 'Add New Category' }}</h3>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Category Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Electronics, Grocery" class="w-full bg-slate-800 border border-slate-700 text-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                </div>
                <div class="flex space-x-2">
                    @if ($editingCategoryId)
                        <button wire:click="cancelEdit" class="w-1/3 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl text-sm transition">Cancel</button>
                    @endif
                    <button wire:click="saveCategory" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition">
                        {{ $editingCategoryId ? 'Update Category' : 'Save Category' }}
                    </button>
                </div>
            </div>

            <div class="col-span-8 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-800 text-slate-400 uppercase text-xs border-b border-slate-700">
                            <th class="p-3">Category Name</th>
                            <th class="p-3">Slug</th>
                            <th class="p-3">Products Count</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach ($categories as $cat)
                            <tr class="hover:bg-slate-800/50">
                                <td class="p-3 font-semibold text-slate-200">{{ $cat->name }}</td>
                                <td class="p-3 text-slate-400 font-mono text-xs">{{ $cat->slug }}</td>
                                <td class="p-3 font-bold text-indigo-400">{{ $cat->products_count }} items</td>
                                <td class="p-3 text-right space-x-2">
                                    <button wire:click="editCategory({{ $cat->id }})" class="px-2 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded text-xs font-bold transition">Edit ✏️</button>
                                    <button wire:click="deleteCategory({{ $cat->id }})" wire:confirm="Delete this category?" class="px-2 py-1 bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 rounded text-xs font-bold transition">Delete 🗑️</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
