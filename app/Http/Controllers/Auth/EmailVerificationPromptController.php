<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Determine dashboard route based on user role
        $dashboardRoute = $request->user()->role === 'teacher'
            ? route('teacher.dashboard')
            : route('student.dashboard');

        // If email already verified, redirect to role-based dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($dashboardRoute);
        }

        // Otherwise, show the email verification prompt
        return view('auth.verify-email');
    }
}
