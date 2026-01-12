<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('instructor.students.index') }}">My Students</a>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage and communicate with your enrolled students</p>
            </div>
            <div class="flex gap-3">
                <input type="text" placeholder="Search students..." class="rounded-xl border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white text-sm">
                <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-bold transition-all">
                    Export List
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-slate-700">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-900/50 border-b dark:border-slate-700">
                    <tr>
                        <th class="p-4 font-bold text-gray-700 dark:text-gray-200">Student</th>
                        <th class="p-4 font-bold text-gray-700 dark:text-gray-200">Enrolled Course</th>
                        <th class="p-4 font-bold text-gray-700 dark:text-gray-200">Progress</th>
                        <th class="p-4 font-bold text-gray-700 dark:text-gray-200">Joined Date</th>
                        <th class="p-4 font-bold text-gray-700 dark:text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-slate-700 text-gray-600 dark:text-gray-300">
    @forelse($students as $student)
    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
        <td class="p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center font-bold uppercase">
                {{ substr($student->name, 0, 2) }}
            </div>
            <div>
                <div class="font-bold text-gray-800 dark:text-white">{{ $student->name }}</div>
                <div class="text-xs opacity-60">{{ $student->email }}</div>
            </div>
        </td>
        <td class="p-4">
            {{-- Display the first course found for this teacher --}}
            {{ $student->enrolledCourses->first()->title ?? 'N/A' }}
        </td>
        <td class="p-4">
            @php $progress = $student->progress ?? 0; @endphp
            <div class="w-full bg-gray-200 dark:bg-slate-700 h-1.5 rounded-full">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
            <span class="text-[10px] mt-1">{{ $progress }}% Complete</span>
        </td>
        <td class="p-4 text-sm">
            {{ $student->created_at->format('M d, Y') }}
        </td>
        <td class="p-4">
            {{-- This link takes the teacher straight to the chat with this student --}}
            <a href="{{ route('instructor.messages.index', ['user_id' => $student->id]) }}"
               class="text-indigo-600 hover:text-indigo-800 font-bold text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                Message
            </a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="p-20 text-center">
            <div class="text-5xl mb-4">👥</div>
            <h3 class="text-xl font-bold dark:text-white">No students yet</h3>
            <p class="text-gray-500">When students enroll in your courses, they will appear here.</p>
        </td>
    </tr>
    @endforelse
</tbody>
            </table>

            <div class="hidden p-20 text-center">
                <div class="text-5xl mb-4">👥</div>
                <h3 class="text-xl font-bold dark:text-white">No students yet</h3>
                <p class="text-gray-500">When students enroll in your courses, they will appear here.</p>
            </div>
        </div>
    </div>
</x-app-layout>
