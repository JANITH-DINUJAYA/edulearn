<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Course 📚</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the details to launch your new learning experience.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6">
                <h3 class="text-xl font-bold text-white">Course Information</h3>
            </div>

            <form action="{{ route('instructor.courses.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Title</label>
                    <input type="text" name="title" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-indigo-500" placeholder="e.g. Advanced Laravel Mastery">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                            <option>Development</option>
                            <option>Design</option>
                            <option>Business</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                        <input type="number" name="price" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="49.99">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white"></textarea>
                </div>

                <div class="flex justify-end gap-4 shadow-sm pt-4">
                    <button type="button" class="px-6 py-3 text-gray-600 dark:text-gray-400 font-semibold">Cancel</button>
                    <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
