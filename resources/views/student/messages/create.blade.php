<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow p-8">
            <h2 class="text-2xl font-bold mb-4 dark:text-white">Message to: {{ $teacher->name }}</h2>

          {{-- Change action="#" or the old route to student.messages.store --}}
{{-- Change the action to point to the .store route --}}
<form action="{{ route('student.messages.store') }}" method="POST">
    @csrf
    <input type="hidden" name="recipient_id" value="{{ $teacher->id }}">

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium dark:text-gray-200">Message Body</label>
            <textarea name="body" rows="5" required
                class="w-full mt-1 rounded-xl border-gray-300 dark:bg-slate-700 dark:text-white focus:ring-emerald-500"
                placeholder="Ask your instructor a question..."></textarea>
        </div>

        <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold transition-colors">
            Send Message
        </button>
    </div>
</form>
            </form>
        </div>
    </div>
</x-app-layout>
