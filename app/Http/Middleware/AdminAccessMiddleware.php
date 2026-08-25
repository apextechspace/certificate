<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAccessMiddleware
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
        // Check if the user is already authenticated
        if (auth()->check()) {
            return $next($request);
        }

        $expectedKey = env('ADMIN_ACCESS_KEY', 'umera2026');

        // If the key is provided in the query string, store it in the session
        if ($request->query('key') === $expectedKey) {
            Session::put('admin_access_granted', true);
        }

        // If they don't have the session flag, block them
        if (!Session::get('admin_access_granted')) {
            abort(404);
        }

        return $next($request);
    }
}
