<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate - This prevents the SQL error and tells you what's missing
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'questions' => 'required|array|min:1',
        ]);

        // 2. Create the Quiz
        $quiz = Quiz::create([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'status' => 'active'
        ]);

        // 3. Create Questions
        foreach ($request->questions as $qData) {
            $quiz->questions()->create([
                'question_text'  => $qData['text'],
                'type'           => $qData['type'],
                'options'        => $qData['options'] ?? null,
                'correct_answer' => $this->getCorrectAnswer($qData)
            ]);
        }

        return redirect()->route('instructor.dashboard')->with('success', 'Quiz created successfully!');
    }

    private function getCorrectAnswer($qData)
    {
        $type = $qData['type'] ?? '';
        $submittedAnswer = $qData['correct_answer'] ?? null;

        if ($type === 'multiple_choice') {
            Log::info("Teacher MCQ Save - Raw Index: " . ($submittedAnswer ?? 'NULL'));
            Log::info("Options available: " . json_encode($qData['options'] ?? []));

            if ($submittedAnswer !== null && is_numeric($submittedAnswer)) {
                $idx = (int)$submittedAnswer;
                if (isset($qData['options'][$idx])) {
                    $value = $qData['options'][$idx];
                    Log::info("Found matching option at index $idx: " . $value);
                    return $value;
                }
            }
            Log::error("MCQ Error: Index $submittedAnswer not found in options.");
            return '';
        }

        // For True/False or Short Answer
        $otherAnswer = $submittedAnswer ?? '';
        Log::info("Teacher Saving " . $type . " - Value: " . $otherAnswer);

        return $otherAnswer;
    }
}
