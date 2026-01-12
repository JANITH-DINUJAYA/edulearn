<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login'); // redirect to login if not logged in
        }

        // Check role
        if ($user->role !== $role) {
            abort(403, 'Unauthorized'); // 403 if role doesn't match
        }

        return $next($request);
    }
}
