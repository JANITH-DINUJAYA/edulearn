<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    Welcome back, <span class="text-indigo-600">Instructor!</span> 👨‍🏫
                </h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium">Your educational empire at a glance.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl flex items-center gap-2">
                    <span class="text-amber-500 text-lg">⭐</span>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">
                        {{ number_format($stats['avg_rating'], 1) }} <span class="text-slate-400 font-medium">Avg Rating</span>
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-12">
            <div class="bg-indigo-600 rounded-[32px] shadow-xl shadow-indigo-200 dark:shadow-none p-7 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="text-4xl font-black">{{ $stats['total_courses'] }}</span>
                    </div>
                    <p class="text-indigo-100 text-xs font-black uppercase tracking-widest">Active Courses</p>
                    <div class="mt-4 flex items-center text-xs font-bold text-indigo-100 bg-white/10 w-fit px-3 py-1 rounded-full">
                        +{{ $stats['courses_growth'] }} this month
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 dark:bg-indigo-900 rounded-[32px] shadow-xl p-7 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-md">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-4xl font-black">{{ $stats['total_students'] }}</span>
                    </div>
                    <p class="text-slate-400 text-xs font-black uppercase tracking-widest">Total Students</p>
                    <div class="mt-4 flex items-center text-xs font-bold text-emerald-400">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                        +{{ $stats['students_growth'] }} Enrollments
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-[32px] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 p-7 group">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        {{-- Assuming you pass this count from your controller --}}
        <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $stats['pending_certificates'] ?? 0 }}</span>
    </div>
    <p class="text-slate-400 text-xs font-black uppercase tracking-widest">Cert. Requests</p>
    <div class="mt-4">
       <a href="{{ route('instructor.certificates.index') }}" class="text-[10px] font-black uppercase tracking-tighter text-emerald-600 hover:underline">
    Review Requests →
</a>
    </div>
</div>
            <div class="bg-white dark:bg-slate-800 rounded-[32px] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 p-7 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-violet-50 dark:bg-violet-900/30 rounded-2xl text-violet-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $stats['active_quizzes'] }}</span>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest">Active Quizzes</p>
                <p class="mt-4 text-xs font-bold text-violet-600">{{ $stats['pending_reviews'] }} Pending Reviews</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-[32px] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 p-7 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-rose-50 dark:bg-rose-900/30 rounded-2xl text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-4xl font-black text-slate-900 dark:text-white">{{ $stats['unread_messages'] }}</span>
                </div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest">Messages</p>
                <div class="mt-4">
                    @if($stats['unread_messages'] > 0)
                        <span class="px-3 py-1 bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-tighter rounded-full animate-pulse">Attention Required</span>
                    @else
                        <span class="text-xs font-bold text-emerald-500">Inbox Clear</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 p-8 md:p-10 shadow-sm">
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Recent Activity</h3>
                            <p class="text-sm font-medium text-slate-500">Real-time student engagement stream</p>
                        </div>
                        <a href="#" class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-700 transition-colors">View All</a>
                    </div>

                    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-6 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-slate-100 before:via-slate-100 before:to-transparent dark:before:from-slate-800 dark:before:via-slate-800">
                        @forelse($recentActivities as $activity)
                            <div class="relative flex items-center gap-6 group">
                                <div class="relative z-10 flex items-center justify-center w-12 h-12 rounded-2xl {{ $activity->icon_config['bg_color'] }} shadow-lg transition-transform group-hover:scale-110">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="flex-1 bg-slate-50 dark:bg-slate-800/50 rounded-[24px] p-5 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all hover:shadow-md">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="font-bold text-slate-900 dark:text-white">{{ $activity->title }}</h4>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $activity->time_ago }}</span>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $activity->description }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 font-medium">No activity recorded yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 p-8 md:p-10 shadow-sm">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-8">Performance Leaderboard</h3>
                    <div class="grid gap-4">
                        @forelse($topCourses as $course)
                            <div class="flex items-center justify-between p-5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-[28px] hover:shadow-xl hover:shadow-slate-100 dark:hover:shadow-none transition-all">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-gradient-to-br {{ $course->gradient }} rounded-2xl flex items-center justify-center text-white text-lg font-black shadow-inner">
                                        {{ $course->initials }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 dark:text-white text-lg">{{ $course->title }}</p>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md">{{ $course->student_count }} Students</span>
                                            <span class="text-xs font-black text-amber-500 tracking-tighter">⭐ {{ number_format($course->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('instructor.courses.show', $course->id) }}" class="p-3 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        @empty
                            <p class="text-slate-400 text-center py-8">No courses available for analysis.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-indigo-600 rounded-[40px] p-8 text-white shadow-2xl shadow-indigo-200 dark:shadow-none relative overflow-hidden">
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full"></div>
                    <h3 class="text-xl font-black mb-6 relative z-10 uppercase tracking-widest text-[10px] opacity-70">Power Tools</h3>
                    <div class="space-y-3 relative z-10">
                        <a href="{{ route('instructor.courses.create') }}" class="flex items-center gap-4 p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all font-bold text-sm">
                            <span class="bg-white/20 p-2 rounded-lg">➕</span> Create New Course
                        </a>
                        <a href="{{ route('instructor.quizzes.create') }}" class="flex items-center gap-4 p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all font-bold text-sm">
                            <span class="bg-white/20 p-2 rounded-lg">❓</span> Create Quiz
                        </a>
                        <a href="{{ route('instructor.content.upload') }}" class="flex items-center gap-4 p-4 bg-white/10 hover:bg-white/20 rounded-2xl transition-all font-bold text-sm">
                            <span class="bg-white/20 p-2 rounded-lg">☁️</span> Upload Content
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Monthly Revenue</h3>
                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    </div>
                    <p class="text-5xl font-black text-slate-900 dark:text-white tracking-tighter mb-4">
                        ${{ number_format($earnings['current_month'], 0) }}
                    </p>
                    <div class="flex items-center gap-2 mb-8">
                        @if($earnings['growth_percentage'] >= 0)
                            <span class="text-emerald-500 font-black text-xs bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-lg">↑ {{ abs($earnings['growth_percentage']) }}%</span>
                        @else
                            <span class="text-rose-500 font-black text-xs bg-rose-50 dark:bg-rose-900/30 px-2 py-1 rounded-lg">↓ {{ abs($earnings['growth_percentage']) }}%</span>
                        @endif
                        <span class="text-xs font-bold text-slate-400">vs last month</span>
                    </div>
                    <a href="{{ route('instructor.earnings') }}" class="block w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-center rounded-2xl font-black text-sm hover:scale-[1.02] transition-transform">Payout Settings</a>
                </div>

                <div class="bg-slate-50 dark:bg-slate-900/50 rounded-[40px] p-8 border border-slate-100 dark:border-slate-800">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 text-center">Management Suite</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $tools = [
                                ['Analytics', '📊', 'indigo', 'instructor.analytics'],
                                ['Students', '👥', 'emerald', 'instructor.students.index'],
                                ['Tasks', '📝', 'purple', 'instructor.assignments'],
                                ['Inbox', '💬', 'amber', 'instructor.messages.index'],
                                ['Submissions', '📥', 'blue', 'instructor.submissions.index'],
                                ['Results', '🏆', 'orange', 'instructor.results.upload'],
                                ['Certs', '📜', 'emerald', 'instructor.certificates.index'],
                                ['Library', '🛠️', 'red', 'instructor.courses.manage'],
                                ['Settings', '⚙️', 'rose', 'instructor.settings'],
                            ];
                        @endphp
                        @foreach($tools as $tool)
                            <a href="{{ route($tool[3]) }}" class="flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-{{ $tool[2] }}-500 transition-all hover:shadow-lg group">
                                <span class="text-2xl mb-2 group-hover:scale-125 transition-transform">{{ $tool[1] }}</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $tool[0] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm flex items-center gap-3 animate-bounce">
        <span>✅</span> {{ session('success') }}
    </div>
@endif


</x-app-layout>
