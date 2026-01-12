<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Message; // If you want to track engagement
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
  public function index()
{
    $teacherId = Auth::id();

    // 1. Get IDs of courses owned by this teacher
    // We use the 'instructor_id' column which exists in the 'courses' table
    $courseIds = Course::where('instructor_id', $teacherId)->pluck('id');
    $totalCourses = $courseIds->count();

    // 2. Total Students
    // We look in 'course_enrollments' for any row matching the teacher's course IDs
    $totalStudents = DB::table('course_enrollments')
        ->whereIn('course_id', $courseIds)
        ->count();

    // 3. Revenue
    // We must JOIN the tables because 'course_enrollments' has the sales,
    // but 'courses' has the instructor_id and the price.
    $totalEarnings = DB::table('course_enrollments')
        ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
        ->where('courses.instructor_id', $teacherId)
        ->sum('courses.price');

    // 4. Top Performing Courses
    $topCourses = Course::where('instructor_id', $teacherId)
        ->withCount('enrollments')
        ->orderBy('enrollments_count', 'desc')
        ->take(5)
        ->get();

    return view('teacher.analytics.index', compact(
        'totalStudents',
        'totalCourses',
        'totalEarnings',
        'topCourses'
    ));
}
}
