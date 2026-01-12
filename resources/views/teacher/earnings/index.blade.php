<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Financial Overview 💰</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Track your revenue and withdrawal history</p>
            </div>
            <button class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-all shadow-lg">
                Withdraw Funds
            </button>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-emerald-500">
                <p class="text-sm text-gray-500 font-medium">Total Balance</p>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">$12,450.00</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Pending Clearances</p>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">$1,200.00</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 font-medium">Lifetime Earnings</p>
                <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">$45,890.00</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b dark:border-slate-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Recent Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 text-sm">
                        <tr>
                            <th class="p-4">Date</th>
                            <th class="p-4">Course</th>
                            <th class="p-4">Amount</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-slate-700">
                        <tr class="text-gray-700 dark:text-gray-300">
                            <td class="p-4 text-sm">Jan 07, 2026</td>
                            <td class="p-4 font-medium">Laravel Advanced Patterns</td>
                            <td class="p-4 text-emerald-600 font-bold">+$84.00</td>
                            <td class="p-4"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
