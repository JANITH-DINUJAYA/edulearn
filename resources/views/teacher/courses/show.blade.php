<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Manage {{ $course->title }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('instructor.courses.edit', $course->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition">
                    Edit Details
                </a>
                <a href="{{ route('instructor.dashboard') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Course Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
                    <h3 class="text-xl font-bold mb-4 dark:text-white">Course Overview</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $course->description }}</p>
                </div>

                {{-- Lessons List --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold dark:text-white">Lessons</h3>
                        <a href="{{ route('instructor.content.upload') }}" class="text-indigo-600 hover:underline text-sm">+ Add Lesson</a>
                    </div>

                    <div class="space-y-3">
                        @forelse($course->lessons as $lesson)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <span class="dark:text-white">{{ $lesson->title }}</span>
                                <span class="text-xs text-gray-500 uppercase">{{ $lesson->type }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No lessons added yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right: Stats --}}
            <div class="space-y-6">
                <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                    <h4 class="text-indigo-100 text-sm font-medium mb-1">Total Rating</h4>
                    <p class="text-4xl font-bold">{{ number_format($course->rating, 1) }} ⭐</p>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6">
                    <h4 class="text-gray-500 text-sm font-medium mb-4 uppercase">Linked Quizzes</h4>
                    <div class="space-y-3">
                        @forelse($course->quizzes as $quiz)
                            <div class="p-3 border dark:border-slate-700 rounded-lg dark:text-white">
                                {{ $quiz->title }}
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No quizzes linked.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
