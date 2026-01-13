<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Available Courses</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Explore new topics and expand your skillset today.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($courses as $course)
                <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col justify-between hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-500/30 transition-all duration-300 group">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-black text-gray-800 dark:text-white leading-tight group-hover:text-indigo-600 transition-colors">
                                {{ $course->title }}
                            </h2>

                            {{-- Rating Badge --}}
                            <div class="flex items-center gap-1.5 bg-amber-50 dark:bg-amber-900/20 px-2.5 py-1 rounded-xl border border-amber-100 dark:border-amber-800/30">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs font-black text-amber-700 dark:text-amber-400">
                                    {{ number_format($course->ratings_avg_rating ?? 0, 1) }}
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed line-clamp-3">
                            {{ $course->description }}
                        </p>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-50 dark:border-slate-700 pb-4">
                            <span>Curriculum</span>
                            <span class="text-indigo-600">{{ $course->ratings_count ?? 0 }} Reviews</span>
                        </div>

                        @if(auth()->user()->enrolledCourses->contains($course->id))
                            {{-- State: Already Enrolled --}}
                            <a href="{{ route('student.courses.show', $course->id) }}"
                               class="flex items-center justify-center w-full py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-colors">
                                Continue Learning →
                            </a>
                        @else
                            {{-- State: Not Enrolled (Direct Action) --}}
                            <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 dark:shadow-none transition-all hover:scale-[1.02] active:scale-95">
                                    Enroll Now
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('student.courses.details', $course->id) }}"
                           class="block text-center text-[10px] font-black text-gray-400 hover:text-indigo-600 uppercase tracking-tighter transition-colors">
                            View Syllabus & Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
