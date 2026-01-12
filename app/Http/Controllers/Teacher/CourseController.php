<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class CourseController extends Controller
{
    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Now Intelephense knows $user has the 'courses' method
    $user->courses()->create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'status' => 'draft',
        'rating' => 0.00
    ]);

    return redirect()->route('instructor.dashboard')
                     ->with('success', 'Course created successfully!');
}
    public function destroy(Course $course)
{
    // 1. Authorization check
  if ((int) $course->instructor_id !== (int) Auth::id()) {
        abort(403);
    }

    // 2. Delete physical files from storage
    foreach ($course->lessons as $lesson) {
        if (Storage::disk('public')->exists($lesson->file_path)) {
            Storage::disk('public')->delete($lesson->file_path);
        }
    }

    // 3. Delete database record (Lessons will auto-delete if you set 'cascade' in migration)
    $course->delete();

    return back()->with('success', 'Course and all its content deleted successfully.');
}
public function manage()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $courses = $user->courses()->withCount('lessons')->get();

    return view('teacher.courses.manage', compact('courses'));
}
public function edit(Course $course)
{
    // Ensure the teacher owns this course
   if ((int) $course->instructor_id !== (int) Auth::id()) {
        abort(403);
    }

    return view('teacher.courses.edit', compact('course'));
}

// Add the Update method too for when the form is submitted
public function update(Request $request, Course $course)
{
   if ((int) $course->instructor_id !== (int) Auth::id()) {
        abort(403);
}

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $course->update($validated);

    return redirect()->route('instructor.courses.manage')->with('success', 'Course updated!');
}
public function show($id)
    {
        // Fetch the course and ensure it belongs to the logged-in teacher
        $course = Course::where('instructor_id', auth::id())
                        ->with(['lessons', 'quizzes']) // Eager load related data
                        ->findOrFail($id);

        return view('teacher.courses.show', compact('course'));
    }
}

