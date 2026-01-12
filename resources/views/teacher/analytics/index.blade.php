<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-gray-800 dark:text-white">Analytics Dashboard 📊</h2>
        <p class="text-gray-500 dark:text-gray-400">Track your performance and student growth.</p>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Revenue</p>
                <h3 class="text-4xl font-black text-indigo-600 mt-1">${{ number_format($totalEarnings, 2) }}</h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Active Students</p>
                <h3 class="text-4xl font-black text-emerald-600 mt-1">{{ $totalStudents }}</h3>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Course Catalog</p>
                <h3 class="text-4xl font-black text-amber-500 mt-1">{{ $totalCourses }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b dark:border-slate-700">
                <h4 class="font-black text-lg dark:text-white">Top Performing Courses</h4>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th class="p-4 text-xs font-black uppercase text-gray-500">Course Title</th>
                        <th class="p-4 text-xs font-black uppercase text-gray-500">Students</th>
                        <th class="p-4 text-xs font-black uppercase text-gray-500">Revenue</th>
                        <th class="p-4 text-xs font-black uppercase text-gray-500">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-slate-700">
                    @foreach($topCourses as $course)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="p-4 font-bold dark:text-white">{{ $course->title }}</td>
                        <td class="p-4 dark:text-gray-300">{{ $course->enrollments_count }}</td>
                        <td class="p-4 text-emerald-600 font-bold">${{ number_format($course->enrollments_count * $course->price, 2) }}</td>
                        <td class="p-4">
                            <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded-lg text-xs font-bold">⭐ {{ $course->rating ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
