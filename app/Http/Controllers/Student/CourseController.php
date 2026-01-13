<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CourseController extends Controller
{
    public function index()
    {
        // Get only published courses
        $courses = \App\Models\Course::all();
        $courses = \App\Models\Course::withAvg('ratings', 'rating')
        ->withCount('ratings')
        ->get();
        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Load relations including assignments
    $course->load(['instructor', 'lessons', 'quizzes', 'assignments']);
    $course->load(['instructor', 'lessons', 'quizzes', 'assignments', 'ratings']);
    $course->loadAvg('ratings', 'rating');
    // 1. LESSON PROGRESS
    $completedLessonIds = DB::table('lesson_completions')
        ->where('student_id', $user->id)
        ->where('course_id', $course->id)
        ->pluck('lesson_id')
        ->toArray();

    // 2. QUIZ PROGRESS (Count passed quizzes)
    $completedQuizCount = \App\Models\QuizAttempt::where('user_id', $user->id)
        ->whereIn('quiz_id', $course->quizzes->pluck('id'))
        ->where('score', '>=', 70)
        ->distinct('quiz_id')
        ->count();

    // 3. ASSIGNMENT PROGRESS (Count submissions)
    // Using the relationship we added to the User model earlier
    $completedAssignmentCount = $user->submissions()
        ->whereIn('assignment_id', $course->assignments->pluck('id'))
        ->distinct('assignment_id')
        ->count();

    // 4. CALCULATE TOTALS
    $totalLessons = $course->lessons->count();
    $totalQuizzes = $course->quizzes->where('status', 'active')->count();
    $totalAssignments = $course->assignments->count();

    $totalItems = $totalLessons + $totalQuizzes + $totalAssignments;
    $completedItems = count($completedLessonIds) + $completedQuizCount + $completedAssignmentCount;

    // 5. FINAL PERCENTAGE
    $courseProgress = $totalItems > 0
        ? round(($completedItems / $totalItems) * 100)
        : 0;

    return view('student.courses.show', [
        'course' => $course,
        'instructor' => $course->instructor,
        'completedLessonIds' => $completedLessonIds,
        'courseProgress' => $courseProgress // Now includes Assignments and Quizzes!
    ]);
}
 public function enroll(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // syncWithoutDetaching ensures they don't enroll twice in the same course
        $user->enrolledCourses()->syncWithoutDetaching([$course->id]);

        return redirect()->route('student.dashboard')
                         ->with('success', 'Welcome to the course! Happy learning.');
    }
    public function s(Course $course)
    {
         $course->load(['lessons', 'quizzes']);
        return view('student.courses.s', compact('course'));
    }
    public function rate(Request $request, $id)
{
    // 1. Validate the input
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // 2. Save or Update the rating
    // This ensures one user can only have one rating per course
    \App\Models\CourseRating::updateOrCreate(
        [
            'course_id' => $id,
            'user_id' => Auth::id(),
        ],
        [
            'rating' => $request->rating,
        ]
    );

    // 3. Redirect back with a success message
    return back()->with('success', 'Thank you for your feedback!');
}
public function details(Course $course) {
    // Load counts and ratings for the landing page
    $course->loadCount('lessons', 'quizzes', 'assignments');
    return view('student.courses.details', compact('course'));
}


}
