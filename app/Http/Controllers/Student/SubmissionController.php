<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function store(Request $request, $assignmentId)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,zip,jpg,png,doc,docx|max:10240', // 10MB limit
        ]);

        if ($request->hasFile('submission_file')) {
            // Save file to storage/app/public/submissions
            $path = $request->file('submission_file')->store('submissions', 'public');

            // Save record to database
            Submission::create([
                'user_id' => Auth::id(),
                'assignment_id' => $assignmentId,
                'file_path' => $path,
            ]);

            return back()->with('success', 'Assignment submitted successfully!');
        }

        return back()->with('error', 'Something went wrong.');
    }
}
