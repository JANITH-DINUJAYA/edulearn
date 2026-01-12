<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\QuizAttempt;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Assignment; // Added
use App\Models\Submission; // Added
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    $lastActivity = $user->last_activity_at ? Carbon::parse($user->last_activity_at)->startOfDay() : null;

    if (!$lastActivity) {
        // First time ever logging in
        $user->streak_count = 1;
    } elseif ($lastActivity->eq($yesterday)) {
        // Logged in yesterday? Increment the streak
        $user->streak_count += 1;
    } elseif ($lastActivity->lt($yesterday)) {
        // Missed at least one day? Reset to 1
        $user->streak_count = 1;
    }
    // If $lastActivity->eq($today), we don't change anything (already counted for today)

    $user->last_activity_at = now();
    $user->save();
        $enrolledCourses = $user->enrolledCourses()->get();
        $enrolledIds = $enrolledCourses->pluck('id')->toArray();

        // 1. Base Stats
        $completedLessonsCount = $user->completedLessons()->count();
        $avgQuizScore = $user->quizSubmissions()->avg('score') ?? 0;
       $certificatesCount = \Illuminate\Support\Facades\DB::table('certificate_requests')
       ->where('user_id', $user->id)
    ->where('status', 'approved') // Or 'approved', depending on your DB string
    ->count();

        // 2. Multi-Activity Progress Calculation
        $totalActivitiesGlobal = 0;
        $completedActivitiesGlobal = 0;

        $courses = $enrolledCourses->map(function($course) use ($user, &$totalActivitiesGlobal, &$completedActivitiesGlobal) {
            // Count Lessons
            $lessonsCount = $course->lessons()->count();
            $lessonsDone = $user->completedLessons()->where('lesson_completions.course_id', $course->id)->count();

            // Count Quizzes (Considered done if attempted/passed based on your logic)
            $quizzesCount = $course->quizzes()->where('status', 'active')->count();
            $quizzesDone = QuizAttempt::where('user_id', $user->id)
                ->whereIn('quiz_id', $course->quizzes->pluck('id'))
                ->where('score', '>=', 70) // Only count as progress if passed
                ->distinct('quiz_id')
                ->count();

            // Count Assignments
            $assignmentsCount = $course->assignments()->count();
            $assignmentsDone = $user->submissions() // Assuming user has a submissions() relationship
                ->whereIn('assignment_id', $course->assignments->pluck('id'))
                ->distinct('assignment_id')
                ->count();

            // Calculate Sums
            $totalInCourse = $lessonsCount + $quizzesCount + $assignmentsCount;
            $doneInCourse = $lessonsDone + $quizzesDone + $assignmentsDone;

            // Set Individual Progress
            $course->progress = $totalInCourse > 0 ? round(($doneInCourse / $totalInCourse) * 100) : 0;

            // Update Global Totals for the Top Progress Bar
            $totalActivitiesGlobal += $totalInCourse;
            $completedActivitiesGlobal += $doneInCourse;

            return $course;
        });

        // 3. Final Global Progress
        $overallProgress = $totalActivitiesGlobal > 0
            ? round(($completedActivitiesGlobal / $totalActivitiesGlobal) * 100)
            : 0;

        // --- Rest of your logic (Last Lesson, Quizzes Filter, etc.) ---
        $lastLesson = $user->completedLessons()
            ->with('course')
            ->latest('lesson_completions.created_at')
            ->first();

        $selectedCourseId = $request->get('course_id');
        $quizQuery = Quiz::whereIn('course_id', $enrolledIds)->where('status', 'active');
        if ($selectedCourseId) { $quizQuery->where('course_id', $selectedCourseId); }

        $upcomingQuiz = $quizQuery->get()->filter(function($quiz) use ($user) {
            $passedAttempt = QuizAttempt::where('user_id', $user->id)
                ->where('quiz_id', $quiz->id)
                ->where('score', '>=', 70)
                ->exists();

            if ($passedAttempt) return false;

            $lastAttempt = QuizAttempt::where('user_id', $user->id)->where('quiz_id', $quiz->id)->latest()->first();
            if ($lastAttempt && $lastAttempt->score < 70) {
                $lockUntil = Carbon::parse($lastAttempt->created_at)->addHour();
                $quiz->is_locked = $lockUntil->isFuture();
                $quiz->lock_time_left = $quiz->is_locked ? $lockUntil->diffForHumans() : null;
            } else {
                $quiz->is_locked = false;
            }
            return true;
        });
        $gradedSubmissions = Submission::where('user_id', $user->id)
        ->where('status', 'graded') // Matches the status set in ResultController
        ->with('assignment.course')
        ->latest()
        ->get();
        $availableCourses = Course::whereNotIn('id', $enrolledIds)->where('status', 'active')->limit(3)->get();

        return view('student.dashboard', [
            'enrolledCount' => $enrolledCourses->count(),
            'gradedSubmissions' => $gradedSubmissions,
            'completedLessonsCount' => $completedLessonsCount,
            'avgQuizScore' => round($avgQuizScore),
            'certificatesCount' => $certificatesCount,
            'overallProgress' => $overallProgress,
            'courses' => $courses,
            'lastLesson' => $lastLesson,
            'upcomingQuiz' => $upcomingQuiz,
            'availableCourses' => $availableCourses,
            'selectedCourseId' => $selectedCourseId,
            'streak' => $user->streak_count
        ]);
    }
}
