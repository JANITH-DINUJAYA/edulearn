<?php

namespace App\Http\Controllers\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use App\Models\LessonCompletion;
class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        // Load the course so we can show the sidebar/navigation
        $lesson->load('course.lessons');

        return view('student.lessons.show', compact('lesson'));
    }
   public function complete(Lesson $lesson)
{
    $userId = Auth::id();

    // Check if the record already exists using plain SQL logic
    $exists = DB::table('lesson_completions')
        ->where('student_id', $userId)
        ->where('lesson_id', $lesson->id)
        ->exists();

    if (!$exists) {
        DB::table('lesson_completions')->insert([
            'student_id'   => $userId,
            'lesson_id' => $lesson->id,
            'user_id'    => $userId,
            'course_id' => $lesson->course_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Find next lesson logic remains the same...
    $nextLesson = Lesson::where('course_id', $lesson->course_id)
        ->where('id', '>', $lesson->id)
        ->orderBy('id', 'asc')
        ->first();

    if ($nextLesson) {
        return redirect()->route('student.lessons.show', $nextLesson->id);
    }

    return redirect()->route('student.courses.show', $lesson->course_id);
}
}
