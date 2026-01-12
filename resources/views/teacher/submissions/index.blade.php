<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                Student <span class="text-indigo-600">Submissions</span> 📥
            </h2>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Student</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Assignment</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Submitted Date</th>
                        <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-slate-400 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                        {{ strtoupper(substr($submission->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-700 dark:text-slate-200">{{ $submission->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $submission->assignment->title }}</p>
                                <p class="text-[10px] text-slate-400 font-medium uppercase">{{ $submission->assignment->course->title }}</p>
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-500 dark:text-slate-400">
                                {{ $submission->created_at->format('M d, Y • h:i A') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('instructor.submissions.download', $submission->id) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-xs font-black hover:scale-105 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    DOWNLOAD
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <p class="text-slate-400 font-medium">No submissions found yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
