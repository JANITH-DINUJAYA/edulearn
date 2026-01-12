<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Manage Course Library 📚</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-200">Course Info</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-200 text-center">Lessons</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 dark:text-gray-200 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-slate-700">
                    @foreach(auth()->user()->courses as $course)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="p-4">
                            <p class="font-bold text-gray-800 dark:text-white">{{ $course->title }}</p>
                            <p class="text-xs text-gray-500">Created: {{ $course->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                {{ $course->lessons_count }} Lessons
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('instructor.courses.edit', $course->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('⚠️ Warning: Deleting this course will permanently remove all associated videos and PDFs. Continue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
