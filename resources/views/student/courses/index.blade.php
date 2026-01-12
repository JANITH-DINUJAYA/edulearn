<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Available Courses</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-gray-100 dark:border-slate-700 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-xl font-bold dark:text-white">{{ $course->title }}</h2>

                            {{-- START: RATING SECTION --}}
                            <div class="flex items-center gap-1 bg-amber-50 dark:bg-amber-900/20 px-2 py-1 rounded-lg">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs font-black text-amber-600">
                                    {{ number_format($course->ratings_avg_rating ?? 0, 1) }}
                                </span>
                            </div>
                            {{-- END: RATING SECTION --}}
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ Str::limit($course->description, 100) }}</p>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('student.courses.show', $course->id) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-500">
                            View Details →
                        </a>

                        {{-- Optional: Show total number of reviews --}}
                        <span class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">
                            {{ $course->ratings_count ?? 0 }} Reviews
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
