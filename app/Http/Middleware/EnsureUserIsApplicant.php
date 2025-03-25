<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApplicant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is not an employer
        if (Auth::check() && !Auth::user()->is_employer) {
            return $next($request);
        }

        // Redirect to login if not logged in, or to employer dashboard if user is an employer
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return redirect()->route('employer.dashboard');
    }
}
