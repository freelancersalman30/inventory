<div class="min-h-screen bg-slate-900 text-slate-100 flex font-sans">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-850 border-r border-slate-800 flex flex-col shrink-0">
        <div class="h-16 flex items-center px-6 border-b border-slate-800 space-x-3">
            <div class="p-2 bg-indigo-600 rounded-lg shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h1 class="font-bold text-base text-slate-100 leading-none">DPCB Inventory</h1>
                <span class="text-xs text-indigo-400 font-medium">POS & ERP Suite</span>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <div class="px-3 py-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">Main Workspace</div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2 bg-indigo-600/20 text-indigo-400 font-semibold rounded-xl border border-indigo-500/30 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard Overview</span>
            </a>

            <a href="{{ route('pos') }}" class="flex items-center space-x-3 px-3.5 py-2 text-emerald-400 hover:bg-slate-800 rounded-xl transition font-semibold text-sm">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <span>POS Terminal ⚡</span>
            </a>

            <div class="px-3 py-1 pt-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Inventory & Stock</div>

            <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Products Catalog</span>
            </a>

            <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h7M13 11h7M13 15h7M4 6h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"></path></svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('units.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                <span>Units of Measure</span>
            </a>

            <a href="{{ route('stock.alerts') }}" class="flex items-center justify-between px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Low Stock Alerts</span>
                </div>
                @if ($lowStockCount > 0)
                    <span class="px-2 py-0.5 text-xs bg-rose-500/20 text-rose-300 font-bold rounded-full border border-rose-500/40">{{ $lowStockCount }}</span>
                @endif
            </a>

            <a href="{{ route('stock.history') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span>Stock Movement History</span>
            </a>

            <a href="{{ route('returns.wastages') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Damage & Returns</span>
            </a>

            <div class="px-3 py-1 pt-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Purchases & Vendors</div>

            <a href="{{ route('suppliers.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>Suppliers Directory</span>
            </a>

            <a href="{{ route('purchases.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                <span>Purchase Orders</span>
            </a>

            <div class="px-3 py-1 pt-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">People & Finance</div>

            <a href="{{ route('customers.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Customers & Dues</span>
            </a>

            <a href="{{ route('expenses.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                <span>Expense Manager</span>
            </a>

            <a href="{{ route('invoices.index') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Sales Invoices</span>
            </a>

            <div class="px-3 py-1 pt-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Analytics & Settings</div>

            <a href="{{ route('reports.profit-loss') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Profit & Loss Statement</span>
            </a>

            <a href="{{ route('settings.payment-methods') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <span>Payment Gateways</span>
            </a>

            <a href="{{ route('settings.business') }}" class="flex items-center space-x-3 px-3.5 py-2 text-slate-400 hover:bg-slate-800 hover:text-slate-200 rounded-xl transition text-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Store Settings</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <div class="p-3 bg-slate-800 rounded-xl flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="font-semibold text-xs text-slate-200 truncate">{{ auth()->user()->name ?? 'Admin User' }}</h4>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@dpcb.com' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Dashboard Body -->
    <main class="flex-1 overflow-y-auto">
        <!-- Top Navbar -->
        <header class="h-16 bg-slate-850 border-b border-slate-800 px-8 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-lg font-bold text-slate-100">Enterprise Operations Control</h2>
                <p class="text-xs text-slate-400">Complete multi-module inventory, POS, purchases & financial control</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('pos') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-sm shadow-lg flex items-center space-x-2 transition">
                    <span>⚡ Open POS Terminal</span>
                </a>
            </div>
        </header>

        <div class="p-8 space-y-8 max-w-7xl mx-auto">
            <!-- 4 Top KPI Cards Grid -->
            <div class="grid grid-cols-4 gap-6">
                <!-- Today's Revenue -->
                <div class="p-6 bg-slate-850 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition"></div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Today's Sales Revenue</span>
                        <h3 class="text-3xl font-extrabold text-emerald-400 mt-2">৳{{ number_format($todayRevenue, 2) }}</h3>
                        <p class="text-xs text-slate-400 mt-1 font-medium">{{ $todaySalesCount }} Total Orders</p>
                    </div>
                    <div class="p-3 bg-emerald-500/20 text-emerald-400 rounded-xl border border-emerald-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Today's Net Profit -->
                <div class="p-6 bg-slate-850 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition"></div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Today's Net Profit</span>
                        <h3 class="text-3xl font-extrabold text-indigo-400 mt-2">৳{{ number_format($todayNetProfit, 2) }}</h3>
                        <p class="text-xs text-slate-400 mt-1 font-medium">Gross: ৳{{ number_format($todayGrossProfit, 2) }}</p>
                    </div>
                    <div class="p-3 bg-indigo-500/20 text-indigo-400 rounded-xl border border-indigo-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>

                <!-- Customer Dues -->
                <div class="p-6 bg-slate-850 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition"></div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Customer Due</span>
                        <h3 class="text-3xl font-extrabold text-amber-400 mt-2">৳{{ number_format($totalCustomerDue, 2) }}</h3>
                        <p class="text-xs text-slate-400 mt-1 font-medium">{{ $totalCustomers }} Registered Customers</p>
                    </div>
                    <div class="p-3 bg-amber-500/20 text-amber-400 rounded-xl border border-amber-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Low Stock Alert Warning -->
                <div class="p-6 bg-slate-850 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/20 transition"></div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Low Stock Warnings</span>
                        <h3 class="text-3xl font-extrabold text-rose-400 mt-2">{{ $lowStockCount }} Items</h3>
                        <a href="{{ route('stock.alerts') }}" class="text-xs text-rose-400 hover:text-rose-300 font-semibold mt-1 inline-block">View Reorder List &rarr;</a>
                    </div>
                    <div class="p-3 bg-rose-500/20 text-rose-400 rounded-xl border border-rose-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Complete All Available Module Quick Action Grid (12 Modules) -->
            <div class="space-y-3">
                <h3 class="font-bold text-slate-200 text-base">All Operations & Feature Modules</h3>
                <div class="grid grid-cols-6 gap-4">
                    <a href="{{ route('pos') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-emerald-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">⚡</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-emerald-400">POS Terminal</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-indigo-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📦</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-indigo-400">Products</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-cyan-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📁</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-cyan-400">Categories</span>
                    </a>
                    <a href="{{ route('units.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-amber-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📏</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-amber-400">Units</span>
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-sky-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">🏢</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-sky-400">Suppliers</span>
                    </a>
                    <a href="{{ route('purchases.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-teal-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">🛒</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-teal-400">Purchases</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-amber-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">👥</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-amber-400">Customers</span>
                    </a>
                    <a href="{{ route('expenses.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-rose-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">💸</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-rose-400">Expenses</span>
                    </a>
                    <a href="{{ route('stock.history') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-purple-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📜</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-purple-400">Stock History</span>
                    </a>
                    <a href="{{ route('returns.wastages') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-rose-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">🗑️</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-rose-400">Damage & Return</span>
                    </a>
                    <a href="{{ route('invoices.index') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-blue-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📄</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-blue-400">Invoices</span>
                    </a>
                    <a href="{{ route('reports.profit-loss') }}" class="p-4 bg-slate-850 hover:bg-slate-800 border border-slate-800 hover:border-emerald-500/50 rounded-xl transition text-center flex flex-col items-center justify-center space-y-2 group shadow-lg">
                        <span class="text-2xl">📊</span>
                        <span class="text-xs font-bold text-slate-200 group-hover:text-emerald-400">P&L Report</span>
                    </a>
                </div>
            </div>

            <!-- Middle Section: Recent Sales & Stock Valuation -->
            <div class="grid grid-cols-12 gap-6">
                <!-- Recent Sales Table (8 Cols) -->
                <div class="col-span-8 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-slate-100 text-base">Recent Sales Transactions</h3>
                            <a href="{{ route('invoices.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold">View All Invoices &rarr;</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="text-xs uppercase text-slate-400 border-b border-slate-700/80">
                                        <th class="py-3 px-2">Invoice #</th>
                                        <th class="py-3 px-2">Customer</th>
                                        <th class="py-3 px-2">Grand Total</th>
                                        <th class="py-3 px-2">Paid / Due</th>
                                        <th class="py-3 px-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/50">
                                    @forelse ($recentSales as $sale)
                                        <tr class="hover:bg-slate-800/60 transition">
                                            <td class="py-3 px-2 font-mono text-xs font-bold text-indigo-400">{{ $sale->invoice_number }}</td>
                                            <td class="py-3 px-2 font-medium text-slate-200">{{ $sale->customer->name ?? 'Walk-in Guest' }}</td>
                                            <td class="py-3 px-2 font-bold text-emerald-400">৳{{ number_format($sale->grand_total, 2) }}</td>
                                            <td class="py-3 px-2 text-xs">
                                                <span class="text-emerald-400">৳{{ number_format($sale->paid_amount, 2) }}</span>
                                                @if ($sale->due_amount > 0)
                                                    <span class="text-rose-400 font-bold ml-1">(Due: ৳{{ number_format($sale->due_amount, 2) }})</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-2 text-right">
                                                <a href="{{ route('invoices.thermal', $sale->invoice_number) }}" target="_blank" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md text-xs">Receipt 🖨️</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-8 text-slate-500">No sales transactions found today.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Inventory Stock Valuation Card (4 Cols) -->
                <div class="col-span-4 bg-slate-850 p-6 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-100 text-base mb-4">Inventory Stock Valuation</h3>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-900/60 rounded-xl border border-slate-800">
                                <span class="text-xs text-slate-400">Total Purchase Cost Value</span>
                                <h4 class="text-2xl font-bold text-slate-200 mt-1">৳{{ number_format($valuation['purchase_value'], 2) }}</h4>
                            </div>

                            <div class="p-4 bg-slate-900/60 rounded-xl border border-slate-800">
                                <span class="text-xs text-slate-400">Total Potential Retail Selling Value</span>
                                <h4 class="text-2xl font-bold text-emerald-400 mt-1">৳{{ number_format($valuation['selling_value'], 2) }}</h4>
                            </div>

                            <div class="p-4 bg-indigo-900/20 rounded-xl border border-indigo-500/30">
                                <span class="text-xs text-indigo-300 font-semibold">Expected Profit Margin Potential</span>
                                <h4 class="text-xl font-bold text-indigo-400 mt-1">৳{{ number_format($valuation['potential_profit'], 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-800 text-xs text-slate-400 flex justify-between">
                        <span>Total Variants: {{ $valuation['total_variants'] }}</span>
                        <span>Total Units: {{ number_format($valuation['total_units'], 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
