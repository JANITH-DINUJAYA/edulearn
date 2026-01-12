<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class SubmissionManagerController extends Controller
{
    public function index()
    {
        // Fetch submissions for assignments created by this instructor
        $submissions = Submission::whereHas('assignment', function($query) {
            $query->where('instructor_id', Auth::id());
        })->with(['user', 'assignment.course'])->latest()->get();

        return view('teacher.submissions.index', compact('submissions'));
    }

  public function download(Submission $submission)
{
    // Security check
    if ($submission->assignment->instructor_id !== Auth::id()) {
        abort(403);
    }

    // Get the full path
    $path = storage_path('app/public/' . $submission->file_path);

    if (!file_exists($path)) {
        return back()->with('error', 'File not found on server.');
    }

    // This approach is clearer for IDEs and very reliable
    return response()->download($path);
}
}
