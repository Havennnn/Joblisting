<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
            // If the user is an applicant but setup is not completed,
            // and the current route is not setup-related, redirect to setup
            $user = Auth::user();
            $currentRoute = $request->route()->getName();

            // Log middleware execution for debugging
            Log::info('EnsureUserIsApplicant middleware executed', [
                'user_id' => $user->id,
                'route' => $currentRoute,
                'has_profile' => $user->applicantProfile ? true : false,
                'setup_completed' => $user->applicantProfile ? $user->applicantProfile->setup_completed : false,
                'session_id' => $request->session()->getId(),
                'session_flag' => Session::has('applicant_setup_completed')
            ]);

            // Check if we just completed setup (special flag in session)
            if (Session::has('applicant_setup_completed')) {
                Log::info('Found applicant_setup_completed flag in session, bypassing setup check', [
                    'user_id' => $user->id
                ]);
                return $next($request);
            }

            // Check if profile exists and setup is not completed
            $setupCompleted = false;
            if ($user->applicantProfile) {
                $setupCompleted = $user->applicantProfile->setup_completed;
            }

            if (!$setupCompleted &&
                !in_array($currentRoute, [
                    'applicant.setup',
                    'applicant.setup.step-one',
                    'applicant.setup.step-two',
                    'applicant.setup.step-three',
                    'applicant.setup.previous',
                    'applicant.setup.skip'
                ])) {
                Log::info('Redirecting to setup from middleware', [
                    'user_id' => $user->id,
                    'route' => $currentRoute,
                    'setup_completed' => $setupCompleted
                ]);
                return redirect()->route('applicant.setup');
            }

            return $next($request);
        }

        // Redirect to login if not logged in, or to employer dashboard if user is an employer
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return redirect()->route('employer.dashboard');
    }
}
