<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function request(Request $request, $courseId)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
        ]);

        // Prevent duplicate requests
        $exists = CertificateRequest::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already requested a certificate for this course.');
        }

        CertificateRequest::create([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
            'full_name' => $request->full_name,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Your certificate request has been sent successfully!');
    }
}
