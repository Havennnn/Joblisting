<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SetUserLayout
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
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                View::share('layout', 'layouts.employer');
            } else {
                View::share('layout', 'layouts.applicant');
            }
        } else {
            View::share('layout', 'layouts.app');
        }

        return $next($request);
    }
}
