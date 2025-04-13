<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        // Log unauthorized access attempt
        Log::warning('Unauthorized access attempt', [
            'path' => $request->path(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Redirect to content unavailable page with the intended URL
        return redirect()->route('content.unavailable', ['intended' => $request->path()]);
    }
}
