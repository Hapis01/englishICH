<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReadOnlyOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'owner') {
            if (!in_array($request->method(), ['GET', 'HEAD', 'OPTIONS']) && !$request->routeIs('admin.reports.generate')) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Action restricted. Owners have read-only access.'], 403);
                }
                return back()->with('error', 'Action restricted. Owners have read-only access.');
            }
        }

        return $next($request);
    }
}
