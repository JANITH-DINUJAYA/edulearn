<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-1">
                <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! <span class="animate-bounce inline-block">👋</span>
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Your learning journey is <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $overallProgress }}%</span> complete. Keep pushing!
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('student.messages.index') }}"
                   class="relative p-3 bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm hover:shadow-md hover:scale-105 transition-all group">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 border-2 border-white dark:border-slate-800 rounded-full animate-pulse"></span>
                </a>

             @if(isset($streak) && $streak > 0)
<div class="flex items-center gap-2 bg-orange-50 dark:bg-orange-900/20 px-4 py-3 rounded-2xl border border-orange-100 dark:border-orange-800/30 shadow-sm">
    <span class="text-xl">🔥</span>
    <div class="flex flex-col">
        <span class="text-[10px] font-black text-orange-500 leading-none uppercase tracking-wider">Streak</span>
        <span class="text-sm font-black text-orange-700 dark:text-orange-400 leading-none">{{ $streak }} {{ Str::plural('DAY', $streak) }}</span>
    </div>
</div>
@endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. Banners & Notifications --}}
        @if(session('quiz_results'))
            <div class="mb-8 bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-indigo-100 dark:border-slate-700 relative overflow-hidden">
                <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                    <div class="flex items-center gap-5">
                        <div class="h-16 w-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">Recent Achievement</p>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ session('quiz_results')['title'] }}</h3>
                            <p class="text-sm text-gray-500 italic">Score: {{ session('quiz_results')['correct'] }}/{{ session('quiz_results')['total'] }} Correct</p>
                        </div>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-500/10 px-8 py-3 rounded-2xl border border-indigo-100">
                        <span class="text-4xl font-black text-indigo-600 dark:text-indigo-400">{{ session('quiz_results')['score'] }}%</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2. Modern Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            @php
                $stats = [
                    ['label' => 'Enrolled', 'val' => $enrolledCount, 'icon' => '📚', 'color' => 'indigo'],
                    ['label' => 'Lessons', 'val' => $completedLessonsCount, 'icon' => '✅', 'color' => 'emerald'],
                    ['label' => 'Avg Score', 'val' => $avgQuizScore.'%', 'icon' => '🎯', 'color' => 'amber'],
                    ['label' => 'Certificates', 'val' => $certificatesCount, 'icon' => '🎓', 'color' => 'purple'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 hover:border-indigo-400 transition-all group text-center md:text-left">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
                        <span class="text-2xl mb-2 md:mb-0">{{ $stat['icon'] }}</span>
                        <span class="text-2xl font-black text-gray-800 dark:text-white group-hover:scale-110 transition-transform">{{ $stat['val'] }}</span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- 3. Main Content --}}
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left Column: Progress & Expansion --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Overall Progress Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Course Progress</h3>
                            <p class="text-xs text-gray-500 uppercase font-black tracking-widest">Across all enrolled courses</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-black text-indigo-600">{{ $overallProgress }}%</span>
                        </div>
                    </div>

                    <div class="relative h-4 w-full bg-gray-100 dark:bg-slate-700 rounded-full mb-10 overflow-hidden">
                        <div class="absolute top-0 left-0 h-full bg-indigo-600 rounded-full transition-all duration-1000 shadow-lg shadow-indigo-200" style="width: {{ $overallProgress }}%">
                            <div class="w-full h-full opacity-30 bg-[linear-gradient(45deg,rgba(255,255,255,.15)_25%,transparent_25%,transparent_50%,rgba(255,255,255,.15)_50%,rgba(255,255,255,.15)_75%,transparent_75%,transparent)] bg-[length:1rem_1rem] animate-[stripes_1s_linear_infinite]"></div>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        @forelse($courses as $course)
                            <div class="p-4 rounded-2xl border border-gray-50 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 group hover:border-indigo-200 transition-all">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-bold text-gray-800 dark:text-white text-sm line-clamp-1 group-hover:text-indigo-600">
                                        <a href="{{ route('student.courses.show', $course->id) }}">{{ $course->title }}</a>
                                    </h4>
                                    <span class="text-[10px] font-black text-indigo-600">{{ $course->progress }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 transition-all duration-700" style="width: {{ $course->progress }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-10">
                                <p class="text-gray-400 italic text-sm">No courses found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Expansion Banner --}}
                <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-all duration-1000"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="text-2xl font-black mb-2">Expand Your Skillset</h3>
                            <p class="text-indigo-100">Unlock new potential with our expert-led programs.</p>
                        </div>
                        <a href="{{ route('student.courses.index') }}" class="px-8 py-3 bg-white text-indigo-600 rounded-2xl font-black hover:bg-indigo-50 transition-colors shadow-xl">
                            Explore All →
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Resume, Results & Quizzes --}}
            <div class="space-y-6">

                {{-- Quick Resume --}}
                @if($lastLesson && $lastLesson->course)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 text-slate-900 dark:text-white">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Current Module</h3>
                        <div class="mb-5">
                            <p class="text-xs font-bold text-indigo-400 mb-1 line-clamp-1">{{ $lastLesson->course->title }}</p>
                            <h4 class="text-lg font-black leading-tight">{{ $lastLesson->title }}</h4>
                        </div>
                        <a href="{{ route('student.lessons.show', $lastLesson->id) }}" class="flex items-center justify-center w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition-all">
                            Continue Learning →
                        </a>
                    </div>
                @endif
{{-- Graded Results Card --}}
<div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-gray-50 dark:border-slate-700 flex justify-between items-center">
        <h3 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest">My Grades</h3>
        <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 text-[10px] font-black rounded-lg">
            {{ $gradedSubmissions->count() }} RESULTS
        </span>
    </div>

    <div class="p-4 space-y-3">
        @forelse($gradedSubmissions as $result)
            {{-- We use a unique ID for each modal scope --}}
            <div x-data="{ open: false }" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 hover:border-indigo-200 transition-all">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <p class="text-[9px] font-black text-indigo-600 uppercase tracking-tighter line-clamp-1">
                            {{ $result->assignment->course->title }}
                        </p>
                        <h4 class="text-xs font-bold text-gray-800 dark:text-white line-clamp-1">
                            {{ $result->assignment->title }}
                        </h4>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">
                            {{ $result->grade }}
                        </span>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest">Grade</span>
                    </div>
                </div>

                <button @click="open = true"
                        class="w-full mt-2 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-all">
                    View Feedback
                </button>

                {{-- Feedback Modal --}}
                <template x-teleport="body">
                    <div x-show="open"
                         x-cloak
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                         x-transition>
                        <div @click.away="open = false" class="bg-white dark:bg-slate-800 w-full max-w-md rounded-3xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden">
                            <div class="p-8 text-center">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-full mb-4">
                                    <span class="text-3xl font-black text-emerald-600">{{ $result->grade }}</span>
                                </div>
                                <h4 class="text-xl font-black text-gray-800 dark:text-white mb-2">{{ $result->assignment->title }}</h4>
                                <p class="text-xs text-gray-500 mb-6 uppercase tracking-widest font-bold">{{ $result->assignment->course->title }}</p>

                                <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl text-left border border-slate-100 dark:border-slate-800">
                                    <p class="text-[10px] font-black text-indigo-600 uppercase mb-2">Instructor Feedback</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 italic leading-relaxed">
                                        {{-- This checks if feedback is NOT empty --}}
                                        @if(!empty($result->feedback))
                                            "{{ $result->feedback }}"
                                        @else
                                            "Excellent work! Your submission has been reviewed and graded. Keep up the consistent effort."
                                        @endif
                                    </p>
                                </div>
                                <button @click="open = false" class="mt-8 w-full py-4 bg-slate-900 dark:bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:opacity-90 transition-opacity">
                                    Close Result
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        @empty
            <div class="text-center py-8">
                <span class="text-3xl block mb-2">📄</span>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">No graded work found</p>
            </div>
        @endforelse
    </div>
</div>

                {{-- Quizzes Section --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest">Up Next</h3>
                        <form action="{{ route('student.dashboard') }}" method="GET">
                            <select name="course_id" onchange="this.form.submit()" class="text-[10px] font-black uppercase rounded-xl border-gray-200 dark:bg-slate-700 py-1 pl-2 pr-8 focus:ring-indigo-500">
                                <option value="">Filter</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" {{ $selectedCourseId == $c->id ? 'selected' : '' }}>{{ Str::limit($c->title, 12) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="p-4 space-y-3">
                        @forelse($upcomingQuiz as $quiz)
                            <div class="p-4 rounded-2xl border {{ $quiz->is_locked ? 'bg-gray-50 border-transparent' : 'bg-white dark:bg-slate-900 border-red-100 dark:border-red-900/30' }}">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ $quiz->is_locked ? 'bg-gray-200 text-gray-500' : 'bg-red-100 text-red-600' }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" /></svg>
                                    </div>
                                    <h5 class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-tight line-clamp-1">{{ $quiz->title }}</h5>
                                </div>
                                @if($quiz->is_locked)
                                    <div class="text-[10px] font-bold text-gray-400 bg-gray-100 py-2 rounded-lg text-center uppercase">Wait {{ $quiz->lock_time_left }}</div>
                                @else
                                    <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="block text-center py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-md shadow-red-100">Start Quiz</a>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <span class="text-3xl block mb-2">☕</span>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">No Quizzes Pending</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes stripes {
            from { background-position: 1rem 0; }
            to { background-position: 0 0; }
        }
    </style>
</x-app-layout>
