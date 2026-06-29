<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access admin dashboard');
        }

        // Check if user has admin or owner role
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Access denied. Admin or Owner privileges required.');
        }

        return $next($request);
    }
}
