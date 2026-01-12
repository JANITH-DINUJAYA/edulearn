<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Student Assignments 📝</h2>
           <a href="{{ route('instructor.assignments.create') }}" class="...">Create New</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($assignments->isEmpty())
            {{-- This is your existing "Empty State" code --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 text-center border-2 border-dashed border-gray-200 dark:border-slate-700">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">📤</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">No Assignments Created</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Create an assignment to start receiving student work.</p>
                <a href="{{ route('instructor.courses.manage') }}" class="inline-block px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold transition-all">
                    Go to Course Manager
                </a>
            </div>
        @else
            {{-- This is the Table that shows when data exists --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 dark:bg-slate-700">
                        <tr>
                            <th class="p-4 text-gray-600 dark:text-gray-300">Assignment Title</th>
                            <th class="p-4 text-gray-600 dark:text-gray-300">Course</th>
                            <th class="p-4 text-gray-600 dark:text-gray-300">Submissions</th>
                            <th class="p-4 text-gray-600 dark:text-gray-300 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-slate-700">
                        @foreach($assignments as $assignment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="p-4 text-gray-800 dark:text-white font-medium">{{ $assignment->title }}</td>
                            <td class="p-4 text-gray-500">{{ $assignment->course->title }}</td>
                            <td class="p-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $assignment->submissions_count }} Submitted
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="#" class="text-purple-600 font-bold hover:underline">View All</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
