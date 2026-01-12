<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Course: {{ $course->title }}</h2>

                <form action="{{ route('instructor.courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Course Title</label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}"
                               class="w-full border-gray-300 dark:bg-slate-700 dark:text-white rounded-lg shadow-sm focus:border-indigo-500">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Description</label>
                        <textarea name="description" rows="5"
                                  class="w-full border-gray-300 dark:bg-slate-700 dark:text-white rounded-lg shadow-sm focus:border-indigo-500">{{ old('description', $course->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('instructor.courses.manage') }}" class="mr-4 text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
