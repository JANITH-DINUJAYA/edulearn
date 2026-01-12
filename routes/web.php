<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\MessageController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Student\SubmissionController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\ResultController;
use App\Http\Controllers\Teacher\SubmissionManagerController;
use App\Http\Controllers\Student\MessageController as StudentMessageController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Teacher\MessageController as TeacherMessageController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\CertificateController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Main dashboard redirect logic
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'teacher'
            ? redirect()->route('instructor.dashboard')
            : redirect()->route('student.dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Teacher / Instructor Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:teacher'])->prefix('teacher')->name('instructor.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        // Course Management
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/manage', [CourseController::class, 'manage'])->name('courses.manage');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

        // This fixes the instructor.courses.show error
        // Note: Using CourseController (Teacher) as defined in your imports
        Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

        // Quiz Management
        Route::get('/quizzes/create', function() {
            $courses = Auth::user()->courses;
            return view('teacher.quizzes.create', compact('courses'));
        })->name('quizzes.create');
        Route::post('/quizzes', [App\Http\Controllers\Teacher\QuizController::class, 'store'])->name('quizzes.store');

        // Content & Lessons
        Route::get('/content/upload', fn() => view('teacher.content.upload'))->name('content.upload');
        Route::post('/content/upload', [App\Http\Controllers\Teacher\LessonController::class, 'store'])->name('lessons.store');

     Route::get('/messages', [TeacherMessageController::class, 'index'])->name('messages.index');
    Route::get('/api/messages/{userId}', [TeacherMessageController::class, 'fetch'])->name('messages.fetch');
    Route::post('/api/messages', [TeacherMessageController::class, 'store'])->name('messages.store');
    Route::get('/students', [App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('students.index');
        // Statistics & Social
        Route::get('/earnings', fn() => view('teacher.earnings.index'))->name('earnings');

        Route::get('/analytics', [App\Http\Controllers\Teacher\AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments');
        Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/submissions', [SubmissionManagerController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/download/{submission}', [SubmissionManagerController::class, 'download'])->name('submissions.download');
   Route::get('/results/upload', [ResultController::class, 'create'])->name('results.create');
    // Results
    Route::get('/certificates', [App\Http\Controllers\Teacher\TeacherDashboardController::class, 'certificatesIndex'])
        ->name('certificates.index');

    Route::post('/certificates/{id}/approve', [App\Http\Controllers\Teacher\TeacherDashboardController::class, 'approveCertificate'])
        ->name('certificates.approve');
    Route::get('/results/upload', [ResultController::class, 'create'])->name('results.upload');
    Route::post('/results/store', [ResultController::class, 'store'])->name('results.store');
        Route::get('/settings', fn() => view('teacher.settings.index'))->name('settings');
    });

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        // The Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/lessons/{lesson}/complete', [StudentLessonController::class, 'complete'])->name('lessons.complete');
        // Courses
        Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
        Route::get('/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('lessons.show');
        // Quizzes
        Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
        Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('/student/courses/{course}', [App\Http\Controllers\Student\CourseController::class, 's'])
         ->name('student.courses.s');
        // Lessons
        Route::post('/courses/{course}/rate', [StudentCourseController::class, 'rate'])->name('student.courses.rate');
        Route::post('/courses/{id}/rate', [CourseController::class, 'rate'])->name('courses.rate');
        Route::post('/courses/{course}/request-certificate', [CertificateController::class, 'request'])->name('certificates.request');
        Route::post('/assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('student.submissions.store');
     // 1. This shows the form (GET)
Route::get('/messages', [StudentMessageController::class, 'index'])->name('messages.index');
    Route::get('/api/messages/{userId}', [StudentMessageController::class, 'fetch'])->name('messages.fetch');
    Route::post('/api/messages', [StudentMessageController::class, 'store'])->name('messages.store');
Route::get('/messages/create', [StudentMessageController::class, 'create'])->name('messages.create');
Route::post('/messages', [StudentMessageController::class, 'store'])->name('messages.store');
        Route::get('/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('lessons.show');
    });
});

// Standard Laravel Auth routes
require __DIR__.'/auth.php';
