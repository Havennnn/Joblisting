<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Check if we're in the middle of a setup process
                if (session()->has('employer_setup_completed') || session()->has('applicant_setup_completed')) {
                    return $next($request);
                }

                // Redirect to appropriate dashboard based on user type
                if ($user->isEmployer()) {
                    // Check if setup is completed
                    if (!$user->employer || !$user->employer->setup_completed) {
                        return redirect()->route('employer.setup');
                    }
                    return redirect()->route('employer.dashboard');
                } else {
                    // Check if setup is completed
                    if (!$user->applicantProfile || !$user->applicantProfile->setup_completed) {
                        return redirect()->route('applicant.setup');
                    }
                    return redirect()->route('applicant.dashboard');
                }
            }
        }

        return $next($request);
    }
}
