<x-app-layout>
    <div class="py-12 max-w-5xl mx-auto px-4">
        {{-- Back Button --}}
        <a href="{{ route('student.courses.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 mb-6 inline-block">← Back to Catalog</a>

        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700">
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase rounded-full tracking-widest">New Program</span>
                        <h1 class="text-4xl font-black text-gray-900 dark:text-white mt-4">{{ $course->title }}</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-400 font-bold uppercase">Course ID</p>
                        <p class="font-mono text-indigo-500">#{{ $course->id }}</p>
                    </div>
                </div>

                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-10">
                    {{ $course->description }}
                </p>

                {{-- Curriculum Stats --}}
                <div class="grid grid-cols-3 gap-4 mb-10">
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl text-center">
                        <span class="block text-2xl mb-1">📖</span>
                        <span class="text-xs font-black dark:text-gray-300 uppercase">{{ $course->lessons_count }} Lessons</span>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl text-center">
                        <span class="block text-2xl mb-1">📝</span>
                        <span class="text-xs font-black dark:text-gray-300 uppercase">{{ $course->quizzes_count }} Quizzes</span>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl text-center">
                        <span class="block text-2xl mb-1">🎓</span>
                        <span class="text-xs font-black dark:text-gray-300 uppercase">Certificate</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-6 border-t border-gray-50 dark:border-slate-700 pt-10">
                    {{-- The Enroll Button --}}
                    <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-64 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 dark:shadow-none transition-all hover:scale-105">
                            Start Learning Now
                        </button>
                    </form>
                    <p class="text-sm text-gray-500 italic">Join {{ rand(100, 500) }}+ other students already in this course.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
