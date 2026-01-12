<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex text-sm text-gray-500 mb-1">
                    <a href="{{ route('student.courses.show', $lesson->course_id) }}" class="hover:text-indigo-600 transition flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Course
                    </a>
                    <span class="mx-2">/</span>
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $lesson->course->title }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $lesson->title }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left Side: Media Player & Content --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Dynamic Media Player Section --}}
                <div class="aspect-video bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-700 relative">
        @php
    // 1. Point to the correct database column
    $url = $lesson->file_path;

    // 2. Extract extension safely
    $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));

    // 3. Check for external links (YouTube, etc.)
    $isExternal = str_contains($url, 'youtube.com') || str_contains($url, 'vimeo.com') || str_contains($url, 'drive.google.com');

    // 4. Generate the URL.
    // If your DB has "lessons/filename.mp4", asset('storage/'.$url)
    // creates "http://localhost:8000/storage/lessons/filename.mp4"
    $fileUrl = $isExternal ? $url : asset('storage/' . $url);

    // 5. Determine content type
    $isVideo = in_array($extension, ['mp4', 'mov', 'webm', 'ogg']);
    $isPdf = ($extension === 'pdf');
@endphp

{{-- Debugging Tool: Uncomment the line below if it still doesn't show to see the path --}}
{{-- <div class="text-white bg-red-600 p-2 text-xs">Testing Path: {{ $fileUrl }}</div> --}}

@if($isExternal)
    <iframe class="w-full h-full" src="{{ $url }}" frameborder="0" allowfullscreen></iframe>

@elseif($isVideo)
    <video class="w-full h-full object-contain" controls preload="metadata" playsinline>
        <source src="{{ $fileUrl }}" type="video/{{ $extension === 'mov' ? 'quicktime' : 'mp4' }}">
        Your browser does not support the video tag.
    </video>

@elseif($isPdf)
    <iframe src="{{ $fileUrl }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>

@elseif(!empty($url))
    <div class="w-full h-full flex flex-col items-center justify-center text-white p-10 text-center">
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700">
            <svg class="w-16 h-16 mb-4 text-indigo-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-lg font-medium mb-4">View Resource ({{ strtoupper($extension) ?: 'FILE' }})</p>
            <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl font-bold transition">
                Open Resource
            </a>
        </div>
    </div>
@else
    <div class="w-full h-full flex items-center justify-center text-slate-500">
        <p>No media content provided for this lesson.</p>
    </div>
@endif
                </div>

                {{-- Lesson Description --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm p-8 border border-gray-100 dark:border-slate-700">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">About this Lesson</h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {!! $lesson->content !!}
                    </div>
                </div>
            </div>

            {{-- Right Side: Sidebar --}}
            <div class="space-y-6">

                {{-- Action Card --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm p-6 border border-gray-100 dark:border-slate-700">
                    <h4 class="font-bold text-gray-800 dark:text-white mb-4 text-xs uppercase tracking-widest">Lesson Status</h4>

                    @php
                        // Using DB Query directly since we aren't using a relationship model
                        $isDone = Illuminate\Support\Facades\DB::table('lesson_completions')
                            ->where('student_id', auth()->id())
                            ->where('lesson_id', $lesson->id)
                            ->exists();
                    @endphp

                    @if($isDone)
                        <div class="flex flex-col items-center text-center p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-900/30">
                            <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-emerald-800 dark:text-emerald-400 font-bold">Completed!</span>
                        </div>
                    @else
                        <form action="{{ route('student.lessons.complete', $lesson->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <span>Mark as Finished</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Playlist Navigation --}}
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm overflow-hidden border border-gray-100 dark:border-slate-700">
                    <div class="p-5 border-b dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                        <h4 class="font-bold text-gray-800 dark:text-white text-xs uppercase tracking-widest">Course Playlist</h4>
                    </div>
                    <div class="max-h-[450px] overflow-y-auto">
                        @foreach($lesson->course->lessons as $navLesson)
                            @php
                                // Check completion for each lesson in list
                                $navCompleted = Illuminate\Support\Facades\DB::table('lesson_completions')
                                    ->where('student_id', auth()->id())
                                    ->where('lesson_id', $navLesson->id)
                                    ->exists();
                                $isCurrent = $navLesson->id == $lesson->id;
                                $navExt = strtolower(pathinfo($navLesson->file_path, PATHINFO_EXTENSION));
                            @endphp
                            <a href="{{ route('student.lessons.show', $navLesson->id) }}"
                               class="flex items-center gap-3 p-4 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors {{ $isCurrent ? 'bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-500' : '' }}">

                                <div class="flex-shrink-0">
                                    @if($navCompleted)
                                        <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </div>
                                    @else
                                        <div class="text-lg">
                                            @if(in_array($navExt, ['mp4', 'mov', 'webm'])) 🎬 @elseif($navExt === 'pdf') 📄 @else 📖 @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold truncate {{ $isCurrent ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}">
                                        {{ $navLesson->title }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-tighter">
                                        {{ $navExt ?: 'Content' }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
