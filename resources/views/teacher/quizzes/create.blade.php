<x-app-layout>
    <div class="py-12" x-data="quizManager()">
        <form action="{{ route('instructor.quizzes.store') }}" method="POST">
            @csrf

            <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 border border-gray-100">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Quiz Title</label>
                <input type="text" name="title" required placeholder="e.g. Final Examination"
                       class="w-full rounded-xl border-gray-200 text-xl font-bold focus:border-purple-500 focus:ring-purple-500">

                <label class="block text-sm font-semibold text-gray-700 mt-4 mb-2">Link to Course</label>
                <select name="course_id" required class="w-full rounded-xl border-gray-200">
                    <option value="">Select a Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <template x-for="(question, index) in questions" :key="index">
                <div class="bg-white p-6 rounded-2xl shadow-sm mb-4 border-l-4 border-purple-500">

                    <input type="hidden" :name="'questions['+index+'][correct_answer]'" x-model="question.correct_answer">

                    <div class="flex justify-between mb-4">
                        <span class="font-bold text-purple-600" x-text="'Question ' + (index + 1)"></span>
                        <button type="button" @click="removeQuestion(index)" class="text-red-500 text-sm hover:underline">Remove</button>
                    </div>

                    <input type="text" :name="'questions['+index+'][text]'" x-model="question.text" required placeholder="Enter your question..."
                           class="w-full rounded-lg border-gray-200 mb-4 focus:ring-purple-500">

                    <select :name="'questions['+index+'][type]'" x-model="question.type" @change="question.correct_answer = ''"
                            class="w-full rounded-lg border-gray-200 mb-4 text-sm">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True / False</option>
                        <option value="short_answer">Short Answer</option>
                    </select>

                    <hr class="mb-4 border-gray-100">

                    <div x-show="question.type === 'multiple_choice'" class="space-y-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Options (Select the correct one):</p>
                        <template x-for="(opt, oIndex) in question.options" :key="oIndex">
                            <div class="flex gap-2 items-center">
                                <input type="radio"
                                       :name="'radio_group_' + index"
                                       :value="oIndex"
                                       x-model="question.correct_answer"
                                       :required="question.type === 'multiple_choice'">

                                <input type="text"
                                       :name="'questions['+index+'][options]['+oIndex+']'"
                                       x-model="question.options[oIndex]"
                                       placeholder="Option text"
                                       class="w-full text-sm border-gray-100 rounded-md"
                                       :required="question.type === 'multiple_choice'">
                            </div>
                        </template>
                        <button type="button" @click="addOption(index)" class="text-xs text-blue-500 font-bold mt-2">+ Add Option</button>
                    </div>

                    <div x-show="question.type === 'true_false'" class="space-y-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Select Correct Answer:</p>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg">
                                <input type="radio" x-model="question.correct_answer" value="True" :name="'radio_tf_' + index" :required="question.type === 'true_false'">
                                <span class="text-sm font-medium">True</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-4 py-2 rounded-lg">
                                <input type="radio" x-model="question.correct_answer" value="False" :name="'radio_tf_' + index" :required="question.type === 'true_false'">
                                <span class="text-sm font-medium">False</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="question.type === 'short_answer'" class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase">Correct Answer:</label>
                        <input type="text" x-model="question.correct_answer"
                               placeholder="Enter the correct answer text..."
                               class="w-full rounded-lg border-gray-200 text-sm bg-purple-50 focus:border-purple-500"
                               :required="question.type === 'short_answer'">
                    </div>
                </div>
            </template>

            <div class="flex gap-4 mt-8">
                <button type="button" @click="addQuestion()" class="bg-purple-100 text-purple-700 px-6 py-4 rounded-xl font-bold w-full hover:bg-purple-200 transition">
                    + Add New Question
                </button>
                <button type="submit" class="bg-purple-600 text-white px-6 py-4 rounded-xl font-bold w-full shadow-lg hover:bg-purple-700 transition">
                    Save Complete Quiz
                </button>
            </div>
        </form>
    </div>

    <script>
        function quizManager() {
            return {
                questions: [],
                addQuestion() {
                    this.questions.push({
                        type: 'multiple_choice',
                        options: ['', ''],
                        text: '',
                        correct_answer: ''
                    });
                },
                removeQuestion(index) {
                    this.questions.splice(index, 1);
                },
                addOption(qIndex) {
                    this.questions[qIndex].options.push('');
                }
            }
        }
    </script>
</x-app-layout>
