<x-app-layout>
    <div class="py-12 max-w-3xl mx-auto px-4">
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $quiz->title }}</h1>
            <p class="text-gray-500 mb-8">Please answer all questions carefully.</p>

            <form action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
                @csrf
                @foreach($quiz->questions as $index => $question)
                    <div class="mb-8 p-6 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
    <p class="font-semibold text-lg mb-4">{{ $index + 1 }}. {{ $question->question_text }}</p>

    {{-- Case 1: Multiple Choice --}}
    @if($question->type === 'multiple_choice')
        <div class="space-y-3">
            @foreach($question->options as $option)
                <label class="flex items-center p-3 border border-gray-200 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-white transition-colors">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="text-indigo-600" required>
                    <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $option }}</span>
                </label>
            @endforeach
        </div>

    {{-- Case 2: True or False --}}
    @elseif($question->type === 'true_false')
        <div class="flex gap-4">
            @foreach(['True', 'False'] as $value)
                <label class="flex-1 flex items-center justify-center p-4 border border-gray-200 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-white transition-colors">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $value }}" class="text-indigo-600" required>
                    <span class="ml-3 font-bold text-gray-700 dark:text-gray-300">{{ $value }}</span>
                </label>
            @endforeach
        </div>

    {{-- Case 3: Short Answer --}}
    @elseif($question->type === 'short_answer')
        <div class="mt-2">
            <input type="text"
                   name="answers[{{ $question->id }}]"
                   placeholder="Type your answer here..."
                   class="w-full p-4 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none"
                   required>
        </div>
    @endif
</div>
                @endforeach

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition-all">
                    Submit Quiz
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
