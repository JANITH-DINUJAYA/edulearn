<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4">

        {{-- Success Message Alert --}}
        @if(session('success'))
            <div id="success-banner" class="mb-6 flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-3xl animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-emerald-500 rounded-2xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-emerald-600 uppercase tracking-widest">Success</p>
                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('success-banner').remove()" class="text-emerald-400 hover:text-emerald-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>

            <script>
                setTimeout(() => {
                    let banner = document.getElementById('success-banner');
                    if(banner) {
                        banner.style.transition = "opacity 0.5s ease";
                        banner.style.opacity = "0";
                        setTimeout(() => banner.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 p-8 shadow-xl">
            <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-2">Upload Results</h3>
            <p class="text-sm text-slate-500 mb-8">Provide grades and feedback for student submissions.</p>

            {{-- Ensure the route name matches your routes/web.php --}}
            <form action="{{ route('instructor.results.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Select Submission --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Select Student Submission</label>
                    <select name="submission_id" required class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        <option value="">-- Choose a pending submission --</option>
                        @foreach($pendingSubmissions as $sub)
                            <option value="{{ $sub->id }}">
                                {{ $sub->user->name }} — {{ $sub->assignment->title }} ({{ $sub->created_at->format('M d') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grade --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Grade (e.g. A+, 95%, Pass)</label>
                    <input type="text" name="grade" required placeholder="Enter grade..."
                           class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 focus:ring-2 focus:ring-indigo-500 dark:text-white">
                </div>

                {{-- Feedback --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Feedback to Student</label>
                    <textarea name="feedback" rows="4" placeholder="Write encouraging feedback..."
                              class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl py-4 focus:ring-2 focus:ring-indigo-500 dark:text-white"></textarea>
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black uppercase tracking-widest text-sm transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    Publish Result
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
