<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                Certificate <span class="text-emerald-600">Management</span> 📜
            </h2>
            <a href="{{ route('instructor.dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-slate-600">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="pb-4 px-4">Student Details</th>
                            <th class="pb-4 px-4">Course Name</th>
                            <th class="pb-4 px-4">Requested Date</th>
                            <th class="pb-4 px-4 text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($pendingCertificates as $request)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                                            {{ substr($request->student_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-bold text-slate-700 dark:text-slate-200 block">{{ $request->student_name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $request->student_email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400">{{ $request->course_title }}</span>
                                </td>
                                <td class="py-5 px-4 text-xs text-slate-400 font-medium">
                                    {{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}
                                </td>
                                <td class="py-5 px-4 text-right">
                                    <form action="{{ route('instructor.certificates.approve', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-2.5 bg-slate-900 dark:bg-emerald-600 hover:scale-105 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                            Issue Certificate
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center">
                                    <p class="text-slate-400 font-medium italic italic">No pending requests found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
