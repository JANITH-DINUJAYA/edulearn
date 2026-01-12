<?php

namespace App\Http\Controllers\Teacher; // Ensure this matches your folder path

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function create()
    {
        // Fetch only submissions that haven't been graded yet
        $pendingSubmissions = Submission::whereHas('assignment', function($query) {
            $query->where('instructor_id', Auth::id());
        })
        ->where('status', '!=', 'graded')
        ->with(['user', 'assignment'])
        ->get();

        return view('teacher.results.upload', compact('pendingSubmissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id',
            'grade' => 'required|string|max:10',
            'feedback' => 'nullable|string'
        ]);

        $submission = Submission::findOrFail($request->submission_id);

        $submission->update([
            'status' => 'graded',
            'grade' => $request->grade,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Result and feedback sent to student!');
    }
}
