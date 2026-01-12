<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\Course;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();
        $currentMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');
        $pendingCertificates = $this->getPendingCertificateRequests($instructor->id);
        $stats = [
            'total_courses'     => $this->getTotalCourses($instructor->id),
            'courses_growth'    => $this->getCoursesGrowth($instructor->id),
            'total_students'    => $this->getTotalStudents($instructor->id),
            'students_growth'   => $this->getStudentsGrowth($instructor->id),
            'active_quizzes'    => $this->getActiveQuizzes($instructor->id),
            'pending_reviews'   => $this->getPendingReviews($instructor->id),
            'unread_messages'   => $this->getUnreadMessages($instructor->id),
            'avg_rating'        => $this->getAverageRating($instructor->id),
            'pending_certificates' => $pendingCertificates->count(),
        ];

        $recentActivities = $this->getRecentActivities($instructor->id);
        $topCourses = $this->getTopPerformingCourses($instructor->id);

        $earnings = [
            'current_month' => $this->getCurrentMonthEarnings($instructor->id, $currentMonth),
            'last_month'    => $this->getLastMonthEarnings($instructor->id, $lastMonth),
            'growth_percentage' => 0,
        ];

        if ($earnings['last_month'] > 0) {
            $earnings['growth_percentage'] = round(
                (($earnings['current_month'] - $earnings['last_month']) / $earnings['last_month']) * 100
            );
        }

        return view('teacher.dashboard', compact(
            'stats',
            'recentActivities',
            'topCourses',
            'earnings',
            'pendingCertificates'
        ));
    }

    // --- Added Methods to match your routes ---
    private function getPendingCertificateRequests($instructorId)
    {
        // Adjust 'certificate_requests' to match your actual database table name
        return DB::table('certificate_requests')
            ->join('courses', 'certificate_requests.course_id', '=', 'courses.id')
            ->join('users', 'certificate_requests.user_id', '=', 'users.id')
            ->where('courses.instructor_id', $instructorId)
            ->where('certificate_requests.status', 'pending')
            ->select(
                'certificate_requests.*',
                'users.name as student_name',
                'users.email as student_email',
                'courses.title as course_title'
            )
            ->get();
    }
    public function analytics()
    {
        return view('teacher.analytics.index');
    }

    public function students()
    {
        $instructorId = Auth::id();
        // Fetch students enrolled in this instructor's courses
        $students = DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->join('users', 'course_enrollments.student_id', '=', 'users.id')
            ->where('courses.instructor_id', $instructorId)
            ->select('users.*', 'courses.title as course_title', 'course_enrollments.enrolled_at')
            ->get();

        return view('teacher.students.index', compact('students'));
    }

    public function assignments()
    {
        $assignments = Assignment::where('instructor_id', Auth::id())
            ->with('course')
            ->get();

        return view('teacher.assignments.index', compact('assignments'));
    }

    public function earnings()
    {
        $instructorId = Auth::id();
        $history = DB::table('instructor_payments')
            ->where('instructor_id', $instructorId)
            ->orderBy('month', 'desc')
            ->get();

        return view('teacher.earnings.index', compact('history'));
    }

    /* ---------------- COURSES ---------------- */

    private function getTotalCourses($instructorId)
    {
        return DB::table('courses')
            ->where('instructor_id', $instructorId)
            ->count();
    }

    private function getCoursesGrowth($instructorId)
    {
        return DB::table('courses')
            ->where('instructor_id', $instructorId)
            ->where('status', 'active')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    /* ---------------- STUDENTS ---------------- */

    private function getTotalStudents($instructorId)
    {
        return DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->distinct()
            ->count('course_enrollments.student_id');
    }

    private function getStudentsGrowth($instructorId)
    {
        return DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->whereMonth('course_enrollments.enrolled_at', now()->month)
            ->whereYear('course_enrollments.enrolled_at', now()->year)
            ->count();
    }

    /* ---------------- QUIZZES ---------------- */

    private function getActiveQuizzes($instructorId)
    {
        return DB::table('quizzes')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->where('quizzes.status', 'active')
            ->count();
    }

    private function getPendingReviews($instructorId)
    {
        return DB::table('quiz_submissions')
            ->join('quizzes', 'quiz_submissions.quiz_id', '=', 'quizzes.id')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->where('quiz_submissions.status', 'pending')
            ->count();
    }

    /* ---------------- MESSAGES ---------------- */

    private function getUnreadMessages($instructorId)
    {
        return DB::table('messages')
            ->where('recipient_id', $instructorId)
            ->whereNull('read_at')
            ->count();
    }

    /* ---------------- RATINGS ---------------- */

    private function getAverageRating($instructorId)
    {
        return round(
        DB::table('course_ratings')
            ->join('courses', 'course_ratings.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->avg('course_ratings.rating') ?? 0,
        1
    );
    }


    /* ---------------- ACTIVITIES ---------------- */

    private function getRecentActivities($instructorId)
    {
        // Changed "Courses" to "courses" (lowercase) to avoid SQL errors on Linux servers
        return DB::table('courses')
            ->where('instructor_id', $instructorId)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($activity) {
                $activity->time_ago = Carbon::parse($activity->created_at)->diffForHumans();
                $activity->icon_config = $this->getActivityIconConfig($activity->type ?? 'default');
                return $activity;
            });
    }

    private function getActivityIconConfig($type)
    {
        $configs = [
            'enrollment' => [
                'icon' => 'user-plus',
                'bg_color' => 'bg-emerald-100 dark:bg-emerald-900/30',
                'text_color' => 'text-emerald-600'
            ],
            'comment' => [
                'icon' => 'message-square',
                'bg_color' => 'bg-blue-100 dark:bg-blue-900/30',
                'text_color' => 'text-blue-600'
            ],
            'quiz_completion' => [
                'icon' => 'check-circle',
                'bg_color' => 'bg-purple-100 dark:bg-purple-900/30',
                'text_color' => 'text-purple-600'
            ],
            'message' => [
                'icon' => 'mail',
                'bg_color' => 'bg-rose-100 dark:bg-rose-900/30',
                'text_color' => 'text-rose-600'
            ],
            'default' => [
                'icon' => 'bell',
                'bg_color' => 'bg-gray-100 dark:bg-gray-900/30',
                'text_color' => 'text-gray-600'
            ],
        ];

        return $configs[$type] ?? $configs['default'];
    }

    /* ---------------- TOP COURSES ---------------- */

   private function getTopPerformingCourses($instructorId)
{
    $gradients = [
        'from-indigo-500 to-purple-600',
        'from-emerald-500 to-teal-600',
        'from-orange-500 to-red-600',
    ];

    return DB::table('courses')
        ->leftJoin('course_enrollments', 'courses.id', '=', 'course_enrollments.course_id')
        // Join the ratings table to get live data
        ->leftJoin('course_ratings', 'courses.id', '=', 'course_ratings.course_id')
        ->select(
            'courses.id',
            'courses.title',
            // Calculate average rating dynamically
            DB::raw('AVG(course_ratings.rating) as live_rating'),
            DB::raw('COUNT(DISTINCT course_enrollments.student_id) as student_count')
        )
        ->where('courses.instructor_id', $instructorId)
        ->where('courses.status', 'active')
        ->groupBy('courses.id', 'courses.title')
        ->orderByDesc('live_rating') // Rank by live average
        ->orderByDesc('student_count')
        ->limit(3)
        ->get()
        ->map(function ($course, $index) use ($gradients) {
            $course->gradient = $gradients[$index] ?? $gradients[0];

            // Map the live_rating to a standard rating property for your Blade file
            $course->rating = round($course->live_rating ?? 0, 1);

            $words = explode(' ', $course->title);
            $initials = '';
            foreach ($words as $w) {
                $initials .= mb_substr($w, 0, 1);
            }
            $course->initials = strtoupper(substr($initials, 0, 2));

            return $course;
        });
}

    /* ---------------- EARNINGS ---------------- */

    private function getCurrentMonthEarnings($instructorId, $month)
    {
        return DB::table('instructor_payments')
            ->where('instructor_id', $instructorId)
            ->where('month', $month)
            ->sum('amount') ?? 0;
    }

    private function getLastMonthEarnings($instructorId, $month)
    {
        return DB::table('instructor_payments')
            ->where('instructor_id', $instructorId)
            ->where('month', $month)
            ->sum('amount') ?? 0;
    }
 public function certificatesIndex()
{
    $instructorId = Auth::id();

    // Fetch the pending requests specifically for this view
    $pendingCertificates = DB::table('certificate_requests')
        ->join('courses', 'certificate_requests.course_id', '=', 'courses.id')
        ->join('users', 'certificate_requests.user_id', '=', 'users.id')
        ->where('courses.instructor_id', $instructorId)
        ->where('certificate_requests.status', 'pending')
        ->select(
            'certificate_requests.*',
            'users.name as student_name',
            'users.email as student_email',
            'courses.title as course_title'
        )
        ->get();

    return view('teacher.certificates.index', compact('pendingCertificates'));
}
    public function approveCertificate($id)
{
    DB::table('certificate_requests')
        ->where('id', $id)
        ->update([
            'status' => 'approved',
            'updated_at' => now()
        ]);

    return back()->with('success', 'Certificate issued successfully!');
}
}
