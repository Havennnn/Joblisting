<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            // Log middleware execution for debugging
            Log::info('EnsureUserIsEmployer middleware executed', [
                'user_id' => $user->id,
                'route' => $currentRoute,
                'has_employer' => $user->employer ? true : false,
                'setup_completed' => $user->employer ? $user->employer->setup_completed : false,
                'session_id' => $request->session()->getId(),
                'session_flag' => Session::has('employer_setup_completed')
            ]);

            // Check if we just completed setup (special flag in session)
            if (Session::has('employer_setup_completed')) {
                Log::info('Found employer_setup_completed flag in session, bypassing setup check', [
                    'user_id' => $user->id
                ]);
                return $next($request);
            }

            // Check if employer profile exists and setup is completed
            $setupCompleted = false;
            if ($user->employer) {
                $setupCompleted = $user->employer->setup_completed;
            }

            // If setup isn't completed and not on a setup page, redirect to setup
            if (!$setupCompleted &&
                !in_array($currentRoute, [
                    'employer.setup',
                    'employer.setup.step-one',
                    'employer.setup.step-two',
                    'employer.setup.step-three',
                    'employer.setup.previous',
                    'employer.setup.skip'
                ])) {
                Log::info('Redirecting to employer setup from middleware', [
                    'user_id' => $user->id,
                    'route' => $currentRoute,
                    'setup_completed' => $setupCompleted
                ]);
                return redirect()->route('employer.setup');
            }

            return $next($request);
        }

        // If user is not an employer, redirect to unauthorized page
        return redirect()->route('content.unavailable', ['intended' => $request->path()])
            ->with('error', 'Access denied: This area is for employers only.');
    }
}
