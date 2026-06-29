<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckClassSelection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to students
        if (Auth::check() && Auth::user()->role === 'student') {
            $user = Auth::user();
            
            if ($user->student_status === 'CLASS_NOT_SELECTED') {
                return redirect()->route('student.select.class')
                    ->with('info', 'Pilih kelas terlebih dahulu.');
            }
        }
        
        return $next($request);
    }
}
