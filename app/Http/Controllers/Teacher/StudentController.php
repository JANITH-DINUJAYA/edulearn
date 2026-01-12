<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        // This gets students who are enrolled in courses owned by this teacher
        $students = User::whereHas('enrolledCourses', function ($query) use ($teacherId) {
            $query->where('courses.instructor_id', $teacherId);
        })->get();

        // This 'compact' is what sends the variable to your Blade file
        return view('teacher.students.index', compact('students'));
    }
}
