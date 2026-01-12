<?php

namespace App\Http\Controllers\Student;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        // Load questions and options
        $quiz->load('questions');

        return view('student.quizzes.show', compact('quiz'));
    }
  public function submit(Request $request, Quiz $quiz)
{
    // 1. Get the answers array from the form
    $studentAnswers = $request->input('answers', []);
    $questions = $quiz->questions;
    $total = $questions->count();
    $correct = 0;

    foreach ($questions as $question) {
    $answer = $studentAnswers[$question->id] ?? null;

    if ($answer !== null) {
        // Clean both strings for comparison
        $submitted = trim($answer);
        $actual = trim($question->correct_answer);
     Log::info("Quiz ID: {$quiz->id} | Question ID: {$question->id}");
        Log::info("Type: {$question->type} | Submitted: '{$submitted}' | Actual In DB: '{$actual}'");
        if ($question->type === 'short_answer') {
            // Case-insensitive check
            if (strtolower($submitted) === strtolower($actual)) {
                $correct++;
            }
        } else {
            // Standard check with trim to avoid space errors
            // Use == instead of === if you want to be extra safe with numbers vs strings
            if ($submitted == $actual) {
                $correct++;
            }
        }
    }
}
    // 2. Calculate score
  $score = ($total > 0) ? round(($correct / $total) * 100) : 0;

    // Save to Database
    \App\Models\QuizAttempt::create([
        'user_id' => Auth::id(),
        'quiz_id' => $quiz->id,
        'score' => $score,
        'correct_answers' => $correct,
        'total_questions' => $total,
    ]);

    // NEW REDIRECT LOGIC:
    // This matches the @if(session('quiz_results')) in your dashboard
    return redirect()->route('student.dashboard')->with('quiz_results', [
        'title'   => $quiz->title,
        'correct' => $correct,
        'total'   => $total,
        'score'   => $score
    ]);
}
}
