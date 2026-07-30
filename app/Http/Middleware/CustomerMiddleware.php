<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow customer users to access the route.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        if (auth()->user()->isAdmin()) {
            if ($request->is('customer/documents*')) {
                return redirect()->route('admin.documents.index')
                    ->with('info', 'Redirected to Admin Document Verifications panel.');
            }
            return redirect()->route('admin.dashboard')
                ->with('info', 'Redirected to Admin Dashboard.');
        }

        return $next($request);
    }
}
