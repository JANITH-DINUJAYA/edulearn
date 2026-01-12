<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// ADD THIS LINE BELOW:
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class AssignmentController extends Controller
{
    public function index()
    {
       $assignments = Assignment::where('instructor_id', Auth::id())
            ->with('course') // Good practice to eager load the course relationship
            ->get();

        return view('teacher.assignments.index', compact('assignments'));
    }
    public function create()
{
    // Fetch courses owned by the instructor to populate a dropdown
    $courses = Auth::user()->courses;
    return view('teacher.assignments.create', compact('courses'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'course_id'   => 'required|exists:courses,id',
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'due_date'    => 'nullable|date|after:today',
        'attachment'  => 'nullable|file|mimes:pdf,docx,zip|max:10240',
    ]);

    // 1. Initialize the attachment path as null
    $Path = null;

    // 2. Handle the file upload if it exists
    if ($request->hasFile('attachment')) {
        // This stores the file in storage/app/public/assignments
        $Path = $request->file('attachment')->store('assignments', 'public');
    }

    // 3. Create the assignment and include the file path
    Assignment::create([
        'course_id'       => $validated['course_id'],
        'instructor_id'   => Auth::id(),
        'title'           => $validated['title'],
        'description'     => $validated['description'],
        'due_date'        => $validated['due_date'],
        'attachment_path' => $Path, // Use the correct column name here
    ]);

    return redirect()->route('instructor.assignments')
                     ->with('success', 'Assignment created successfully!');
}
}
