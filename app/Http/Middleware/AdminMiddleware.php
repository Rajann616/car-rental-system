<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow admin users to access the route.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in with an Admin account to access this page.');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('customer.dashboard')->with('error', 'Access Denied: Admin privileges are required to access the Admin Control Center.');
        }

        return $next($request);
    }
}
