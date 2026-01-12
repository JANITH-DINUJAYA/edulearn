<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Instructor Settings ⚙️</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your professional profile and account preferences</p>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="space-y-2">
                <a href="#" class="block px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-xl font-bold">Profile Information</a>
                <a href="#" class="block px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition-all">Payout Settings</a>
                <a href="#" class="block px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition-all">Email Notifications</a>
                <a href="#" class="block px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition-all">Security</a>
            </div>

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Public Instructor Profile</h3>

                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Display Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Professional Title</label>
                                <input type="text" placeholder="e.g. Senior Laravel Developer" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instructor Bio</label>
                            <textarea rows="4" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Tell your students about your experience..."></textarea>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold transition-all shadow-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-red-50 dark:bg-red-900/10 rounded-2xl p-6 border border-red-100 dark:border-red-900/30">
                    <h3 class="text-lg font-bold text-red-700 dark:text-red-400">Deactivate Account</h3>
                    <p class="text-sm text-red-600 dark:text-red-500/80 mb-4">This will hide your courses from the marketplace.</p>
                    <button class="text-red-700 dark:text-red-400 font-bold hover:underline">Learn more about deactivation</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
