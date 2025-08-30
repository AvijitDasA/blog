<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,$role): Response
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }
        // dd($role);
        // If you are using Spatie Laravel Permission
        if (Auth::user()->hasRole($role)) {
            return $next($request);
        }

        // Fallback if role doesn't match
        abort(403, 'Access Denied - You do not have the required role.');
        // return $next($request);
    }
}
