<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Upload Media ☁️</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="mb-6 p-4 bg-emerald-100 dark:bg-emerald-900/30 border-l-4 border-emerald-500 rounded-xl flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-emerald-500 rounded-full mr-3 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-emerald-800 dark:text-emerald-200 font-semibold">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 rounded-xl">
                <ul class="list-disc list-inside text-red-800 dark:text-red-200">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('instructor.lessons.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-10">
            @csrf

            <div class="max-w-md mx-auto space-y-6">
                <div>
                    <label class="block text-left text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Course</label>
                    <select name="course_id" required class="w-full rounded-xl border-gray-300 dark:bg-slate-900 dark:text-white focus:ring-blue-500">
                        @foreach(auth()->user()->courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-left text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lesson Title</label>
                    <input type="text" name="lesson_title" required placeholder="e.g. Introduction to PHP"
                           class="w-full rounded-xl border-gray-300 dark:bg-slate-900 dark:text-white focus:ring-blue-500">
                </div>

                <div x-data="{ fileName: null, isUploading: false }">
                    <label class="cursor-pointer block px-6 py-10 bg-gray-50 dark:bg-slate-900 border-2 border-dashed border-gray-300 dark:border-slate-700 rounded-2xl hover:border-blue-500 transition-colors">
                        <input type="file" name="file" class="hidden" @change="fileName = $event.target.files[0].name" required>

                        <div class="text-center">
                            <svg class="w-10 h-10 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-blue-600 font-semibold block" x-text="fileName ? fileName : 'Browse Files'"></span>
                            <p class="text-xs text-gray-500 mt-2">MP4, MOV, or PDF (Max 500MB)</p>
                        </div>
                    </label>

                    <button type="submit" @click="if(fileName) isUploading = true" class="mt-6 w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all shadow-lg flex items-center justify-center gap-2">
                        <span x-show="!isUploading">Start Upload</span>
                        <span x-show="isUploading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Uploading...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
