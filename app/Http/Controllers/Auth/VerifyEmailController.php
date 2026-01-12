<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Handle email verification for authenticated users.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Determine user dashboard based on role
        $dashboardRoute = $request->user()->role === 'teacher'
            ? route('teacher.dashboard')
            : route('student.dashboard');

        // If user already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($dashboardRoute . '?verified=1');
        }

        // Mark email as verified
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect to role-based dashboard
        return redirect()->intended($dashboardRoute . '?verified=1');
    }
}
