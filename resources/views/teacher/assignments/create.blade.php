<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">Create Assignment 📝</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Assign tasks to your students and set deadlines.</p>
            </div>
            <a href="{{ route('instructor.assignments') }}"
               class="text-sm font-bold text-gray-400 hover:text-purple-600 transition-colors">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-purple-500 to-indigo-600"></div>

            <form action="{{ route('instructor.assignments.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Target Course</label>
                        <select name="course_id" required
                                class="w-full rounded-2xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 transition-all">
                            <option value="" disabled selected>Select a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Deadline (Optional)</label>
                        <input type="date" name="due_date"
                               class="w-full rounded-2xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 transition-all">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Assignment Title</label>
                    <input type="text" name="title" required
                           placeholder="e.g., Final Project: Advanced Laravel Architecture"
                           class="w-full text-lg font-bold rounded-2xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-purple-500 focus:border-purple-500 placeholder:text-gray-300">
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Detailed Instructions</label>
                    <textarea name="description" rows="6" required
                              placeholder="Describe the requirements, submission format, and grading criteria..."
                              class="w-full rounded-2xl border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Attachment (Resources, Rubrics, or Templates)</label>
                    <div class="relative group">
                        <input type="file" name="attachment" id="attachment"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-gray-200 dark:border-slate-600 rounded-2xl p-8 text-center group-hover:border-purple-400 transition-all bg-gray-50 dark:bg-slate-900/50">
                            <div class="text-3xl mb-2">📁</div>
                            <p class="text-sm font-bold text-gray-600 dark:text-gray-300" id="file-name">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOCX, or ZIP (Max 10MB)</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 border-t border-gray-50 dark:border-slate-700 pt-8">
                    <a href="{{ route('instructor.assignments') }}"
                       class="text-sm font-bold text-gray-400 hover:text-gray-600 dark:hover:text-white transition-all">
                        Discard Draft
                    </a>
                    <button type="submit"
                            class="px-10 py-4 bg-purple-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-purple-700 hover:shadow-lg hover:shadow-purple-200 dark:hover:shadow-none transition-all active:scale-95">
                        Publish Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('attachment').onchange = function () {
            const fileName = this.files[0] ? this.files[0].name : "Click to upload or drag and drop";
            document.getElementById('file-name').textContent = fileName;
        };
    </script>
</x-app-layout>
