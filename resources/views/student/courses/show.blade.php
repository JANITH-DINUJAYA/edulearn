<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        {{-- Course Title & Breadcrumb --}}
        <div>
            <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">
                {{ $course->title }}
            </h2>
            <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase rounded-md tracking-wider">
                    Student Portal
                </span>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium italic">
                    Keep up the great work!
                </p>
            </div>
        </div>

        {{-- Action Cards Container --}}
        <div class="flex flex-col sm:flex-row items-center gap-4">

            {{-- 1. Course Rating Card --}}
            <div class="w-full sm:w-48 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 relative overflow-hidden">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Course Rating</h3>
                    <div class="flex items-center gap-1">
                        <span class="text-xs font-black text-amber-500">
                            {{ number_format($course->ratings_avg_rating ?? 0, 1) }}
                        </span>
                        <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                </div>

                @php
                    // Use optional() and first() to safely check for the user's specific rating
                    $userRating = optional($course->ratings)->where('user_id', auth()->id())->first();
                @endphp

                @if($userRating)
                    <div class="flex flex-col items-center py-1">
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Your Score</p>
                        <div class="flex gap-0.5 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $userRating->rating ? 'text-amber-400' : 'text-gray-200 dark:text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                @else
                    <form action="{{ route('student.courses.rate', $course->id) }}" method="POST" x-data="{ hover: 0, rating: 0 }" class="flex flex-col items-center">
                        @csrf
                        <div class="flex gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0" class="focus:outline-none transition-transform hover:scale-110">
                                    <svg class="w-6 h-6 transition-colors" :class="(hover || rating) >= {{ $i }} ? 'text-amber-400' : 'text-gray-200 dark:text-slate-700'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" :value="rating">
                        <button type="submit" x-show="rating > 0" x-transition class="w-full py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                            Submit
                        </button>
                    </form>
                @endif
            </div>

            {{-- 2. Progress Ring Card --}}
            <div class="flex items-center gap-4 bg-white dark:bg-slate-800 p-3 pr-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="relative w-14 h-14 flex items-center justify-center">
                    <svg class="absolute w-full h-full -rotate-90">
                        <circle cx="28" cy="28" r="24" stroke="currentColor" stroke-width="5" fill="transparent" class="text-gray-100 dark:text-slate-700" />
                        <circle cx="28" cy="28" r="24" stroke="currentColor" stroke-width="5" fill="transparent"
                            stroke-dasharray="150.8"
                            stroke-dashoffset="{{ 150.8 - (150.8 * ($courseProgress ?? 0)) / 100 }}"
                            class="text-emerald-500 transition-all duration-1000 ease-out"
                            stroke-linecap="round" />
                    </svg>
                    <span class="text-xs font-black dark:text-white">{{ $courseProgress ?? 0 }}%</span>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-widest font-black text-gray-400 leading-none mb-1">Completion</p>
                    <p class="text-sm font-bold text-emerald-600 italic leading-none">Overall Progress</p>
                </div>
            </div>

        </div>
    </div>
</x-slot>
    <div class="py-10 max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left Content: Curriculum --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/50">
                        <h3 class="text-lg font-bold dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Course Modules
                        </h3>
                        <span class="px-3 py-1 bg-white dark:bg-slate-700 border border-gray-100 dark:border-slate-600 rounded-full text-[10px] font-black uppercase text-gray-500">
                            {{ $course->lessons->count() }} Lessons
                        </span>
                    </div>

                    <div class="divide-y divide-gray-50 dark:divide-slate-700">
                        @php $previousCompleted = true; @endphp
                        @foreach($course->lessons as $lesson)
                            @php
                                $isCompleted = in_array($lesson->id, $completedLessonIds ?? []);
                                $isUnlocked = $loop->first || $previousCompleted;
                            @endphp
                            <div class="group flex items-center justify-between p-5 transition-all {{ $isUnlocked ? 'hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5' : 'bg-gray-50/50 opacity-75' }}">
                                <div class="flex items-center gap-5">
                                    <div class="flex-shrink-0">
                                        @if($isCompleted)
                                            <div class="h-10 w-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 border border-emerald-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        @elseif(!$isUnlocked)
                                            <div class="h-10 w-10 rounded-xl bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100">
                                                {{ $loop->iteration }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold {{ $isUnlocked ? 'text-gray-800 dark:text-white' : 'text-gray-400' }}">{{ $lesson->title }}</h4>
                                        <p class="text-[10px] uppercase font-bold tracking-tighter text-gray-400 italic">Video Lesson</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($isUnlocked)
                                        <a href="{{ route('student.lessons.show', $lesson->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ $isCompleted ? 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200' : 'text-white bg-indigo-600 hover:bg-indigo-700 shadow-md border border-indigo-500' }}">
                                            {{ $isCompleted ? 'Review' : 'Play →' }}
                                        </a>
                                    @else
                                        <div class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg">
                                            <span class="text-[9px] uppercase tracking-widest font-black text-gray-400">Locked</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php $previousCompleted = $isCompleted; @endphp
                        @endforeach
                    </div>
                </div>
                {{-- Certificate Request Card --}}
{{-- Certificate Request Card --}}
@php
    // Check if a request already exists
    $existingRequest = \App\Models\CertificateRequest::where('user_id', auth()->id())
        ->where('course_id', $course->id)
        ->first();
@endphp

{{-- MAIN WRAPPER: Holds the Alpine.js state for the modal --}}
<div x-data="{ showModal: false }">

    {{-- 1. Feedback Alerts (Success/Error) --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 2. The Certificate Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Certification</h3>
            @if($existingRequest && $existingRequest->status == 'approved')
                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
            @elseif($existingRequest)
                <span class="flex h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
            @endif
        </div>

        <div class="text-center">
            @if($existingRequest)
                <div class="mb-4">
                    <div class="h-16 w-16 {{ $existingRequest->status == 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} dark:bg-slate-700 rounded-2xl mx-auto flex items-center justify-center mb-3">
                        @if($existingRequest->status == 'approved')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <h4 class="font-black text-gray-800 dark:text-white text-sm uppercase">
                        {{ $existingRequest->status == 'approved' ? 'Certificate Issued!' : 'Request Pending' }}
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1">
                        {{ $existingRequest->status == 'approved' ? 'Your certificate is ready for download.' : 'Your request is being reviewed by the instructor.' }}
                    </p>
                </div>

                @if($existingRequest->status == 'approved')
                    <button class="w-full py-3 bg-emerald-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg">
                        Download Certificate
                    </button>
                @else
                    <button disabled class="w-full py-3 bg-gray-100 text-gray-400 rounded-2xl text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                        Waiting for Review
                    </button>
                @endif

            @elseif(($courseProgress ?? 0) >= 100)
                <div class="mb-4">
                    <div class="h-16 w-16 bg-emerald-100 dark:bg-emerald-500/20 rounded-2xl mx-auto flex items-center justify-center text-emerald-600 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-black text-gray-800 dark:text-white text-sm uppercase">Course Complete!</h4>
                </div>
                <button @click="showModal = true" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition-transform active:scale-95">
                    Request Your Certificate
                </button>
            @else
                <div class="opacity-50 grayscale">
                    <div class="h-16 w-16 bg-gray-100 dark:bg-slate-700 rounded-2xl mx-auto flex items-center justify-center text-gray-400 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h4 class="font-bold text-gray-400 text-xs uppercase tracking-tight">Locked</h4>
                    <p class="text-[9px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">Reach 100% to unlock</p>
                </div>
            @endif
        </div>
    </div>

    {{-- 3. The Modal (Now correctly scoped and using x-cloak) --}}
    <div
        x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-cloak
    >
        <div
            @click.away="showModal = false"
            class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-2xl max-w-md w-full p-8 border border-white/20 transform transition-all"
            x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-90 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
        >
            <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Certificate Details</h3>
            <p class="text-xs text-gray-500 mb-6 font-medium italic">Please enter your name exactly as it should appear on the printed certificate.</p>

            <form action="{{ route('student.certificates.request', $course->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                    <input type="text" name="full_name" required placeholder="John Doe"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold dark:text-white">
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black uppercase text-gray-400 hover:text-gray-600 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">Send Request</button>
                </div>
            </form>
        </div>
    </div>

</div>
            </div>

            {{-- Right Sidebar --}}
            <div class="space-y-6">

                {{-- Assignment Download & Submission --}}
             {{-- Assignment Card --}}
<div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Course Assignment</h3>
            <p class="text-sm font-bold text-gray-800 dark:text-white">Instructions & Submission</p>
        </div>
        <div class="h-10 w-10 bg-purple-50 dark:bg-purple-500/10 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
    </div>
    {{-- Course Rating Card --}}

    <div class="space-y-10">
        @forelse($course->assignments ?? [] as $assignment)
            <div class="space-y-6">

                {{-- 1. INSTRUCTOR PORTION: THE DOWNLOAD --}}
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-0.5 bg-indigo-600 text-white text-[9px] font-black uppercase rounded">From Instructor</span>
                        <div class="h-[1px] flex-grow bg-gray-100 dark:bg-slate-700"></div>
                    </div>

                    <div class="p-4 bg-indigo-50/50 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/20 rounded-2xl">
                        <h4 class="text-xs font-bold text-gray-800 dark:text-white mb-2">{{ $assignment->title }}</h4>

                        @if($assignment->attachment_path)
                            <p class="text-[10px] text-gray-500 mb-4 italic">Please download the following guidelines before starting your work:</p>
                            <a href="{{ Storage::url($assignment->attachment_path) }}" download
                               class="flex items-center gap-3 p-3 bg-white dark:bg-slate-800 border border-indigo-200 dark:border-indigo-500/30 rounded-xl hover:shadow-md transition-all group">
                                <div class="bg-indigo-100 dark:bg-indigo-500/20 p-2 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase text-indigo-600">Download Brief</span>
                                    <span class="text-[9px] text-gray-400">PDF Document</span>
                                </div>
                            </a>
                        @else
                            <div class="flex items-center gap-2 text-gray-400 italic text-[10px]">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                No attachment provided for this task.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 2. STUDENT PORTION: THE SUBMISSION --}}
<div>
    <div class="flex items-center gap-2 mb-3">
        <span class="px-2 py-0.5 bg-purple-600 text-white text-[9px] font-black uppercase rounded">Your Submission</span>
        <div class="h-[1px] flex-grow bg-gray-100 dark:bg-slate-700"></div>
    </div>

    @php
        // Check if the current user has a submission for this assignment
        $userSubmission = $assignment->submissions->where('user_id', auth()->id())->first();
    @endphp

    @if($userSubmission)
        {{-- Show this if already submitted --}}
        <div class="p-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-2xl flex flex-col items-center justify-center text-center">
            <div class="h-12 w-12 bg-emerald-500 rounded-full flex items-center justify-center text-white mb-3 shadow-lg shadow-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-xs font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Submission Complete</p>
            <p class="text-[10px] text-emerald-600/70 mt-1 italic">Submitted on {{ $userSubmission->created_at->format('M d, Y') }}</p>

            {{-- Optional: Show the filename --}}
            <div class="mt-4 px-3 py-2 bg-white dark:bg-slate-800 rounded-lg border border-emerald-100 dark:border-emerald-900/50 flex items-center gap-2">
                <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A1 1 0 0111.293 2.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                <span class="text-[9px] font-bold text-gray-500 truncate max-w-[150px]">View Submission</span>
            </div>
        </div>
    @else
        {{-- Show the form if NOT submitted yet --}}
        <form action="{{ route('student.student.submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div class="group relative py-6 border-2 border-dashed border-gray-200 dark:border-slate-700 rounded-2xl flex flex-col items-center justify-center hover:border-purple-400 dark:hover:border-purple-500/50 hover:bg-purple-50/30 transition-all cursor-pointer">
                <input type="file" name="submission_file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                <svg class="w-8 h-8 text-gray-300 group-hover:text-purple-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <p class="text-[10px] font-bold text-gray-400 group-hover:text-purple-600 uppercase tracking-widest">Drop your file here</p>
            </div>

            <button type="submit" class="w-full py-3.5 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-purple-100 dark:shadow-none transition-all active:scale-[0.98]">
                Submit Assignment
            </button>
        </form>
        <p class="mt-4 text-[9px] text-gray-400 text-center uppercase font-bold tracking-tighter">
            Accepted: PDF, ZIP, DOCX (Max 10MB)
        </p>
    @endif
</div>

            </div>
            @if(!$loop->last) <hr class="border-gray-100 dark:border-slate-700 my-8"> @endif
        @empty
            <div class="py-10 text-center">
                <p class="text-xs text-gray-400 italic font-medium">No tasks assigned for this course.</p>
            </div>
        @endforelse
    </div>
</div>

                {{-- Instructor Card --}}
                @if($course->instructor)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/5 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Instructor Support</h3>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-14 w-14 bg-emerald-500 rounded-2xl rotate-3 flex items-center justify-center text-white text-xl font-black shadow-lg shadow-emerald-100">
                                <span class="-rotate-3">{{ strtoupper(substr($course->instructor->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white leading-tight">{{ $course->instructor->name }}</h4>
                                <p class="text-[10px] text-emerald-600 font-black uppercase italic mt-0.5">Verified Instructor</p>
                            </div>
                        </div>
                        <a href="{{ route('student.messages.create', ['recipient_id' => $course->instructor_id]) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            <span>Send Message</span>
                        </a>
                    </div>
                @endif

                {{-- Assessments Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Exams</h3>
                        <div class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                    </div>
                    <div class="space-y-4">
                        @forelse($course->quizzes as $quiz)
                            @php
                                $lastAttempt = $quiz->attempts()->where('user_id', auth()->id())->latest()->first();
                                $isPassed = $lastAttempt && $lastAttempt->score >= 70;
                            @endphp
                            <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-700">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-bold text-xs dark:text-white {{ $isPassed ? 'opacity-50' : '' }}">{{ $quiz->title }}</h4>
                                    @if($isPassed) <span class="text-emerald-500 text-xs">✓</span> @endif
                                </div>
                                @if($isPassed)
                                    <p class="text-[10px] font-bold text-emerald-600">PASSED: {{ $lastAttempt->score }}%</p>
                                @else
                                    <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="inline-block w-full text-center py-2 bg-indigo-600 text-white rounded-xl text-[9px] font-black tracking-widest uppercase">Start Quiz</a>
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-gray-400 text-xs italic">No exams available.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
