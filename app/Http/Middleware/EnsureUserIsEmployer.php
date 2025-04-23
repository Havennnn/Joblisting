<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureUserIsEmployer
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
        // Check if user is logged in and is an employer
        if (Auth::check() && Auth::user()->isEmployer()) {
            $user = Auth::user();
            $currentRoute = $request->route()->getName();

            // Check if we just completed setup (special flag in session)
            if (Session::has('employer_setup_completed')) {
                return $next($request);
            }

            // Check if employer profile exists and setup is completed
            $setupCompleted = false;
            if ($user->employer) {
                $setupCompleted = $user->employer->setup_completed;
            }

            // If setup isn't completed and not on a setup page, redirect to setup
            $setupRoutes = [
                'employer.setup.index',
                'employer.setup.process',
                'employer.setup.skip'
            ];

            // Check if current route is a setup route
            $isSetupRoute = in_array($currentRoute, $setupRoutes) ||
                            str_starts_with($currentRoute, 'employer.setup.');

            if (!$setupCompleted && !$isSetupRoute) {
                return redirect()->route('employer.setup.index');
            }

            return $next($request);
        }

        // If user is not an employer, redirect to unauthorized page
        return redirect()->route('content.unavailable', ['intended' => $request->path()])
            ->with('error', 'Access denied: This area is for employers only.');
    }
}
