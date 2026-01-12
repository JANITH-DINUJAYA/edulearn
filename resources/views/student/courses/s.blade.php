
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            {{-- Left Side: Lesson List --}}
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow p-6">
                    <h3 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Course Content</h3>
                    <div class="space-y-3">
                        @foreach($course->lessons as $lesson)
                            <a href="{{ route('lessons.show', $lesson->id) }}" class="flex items-center justify-between p-4 border dark:border-slate-700 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                <div class="flex items-center gap-3">
                                    <span class="text-indigo-500 font-bold">#{{ $loop->iteration }}</span>
                                    <span class="dark:text-white">{{ $lesson->title }}</span>
                                </div>
                                <span class="text-sm text-gray-500">Video & Reading</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Side: Quizzes & Stats --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow p-6 border-t-4 border-indigo-500">
                    <h3 class="text-xl font-bold mb-4 dark:text-white text-gray-800">Assessments</h3>
                    <div class="space-y-3">
                        @forelse($course->quizzes as $quiz)
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                                <p class="font-bold dark:text-white mb-2">{{ $quiz->title }}</p>
                                <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="text-indigo-600 text-sm font-bold hover:underline">
                                    Take Quiz →
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm">No quizzes assigned to this course.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
