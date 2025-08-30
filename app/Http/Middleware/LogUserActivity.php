<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            Log::info('User Activity:', [
                'user_id'   => Auth::id(),
                'name'      => Auth::user()->name,
                'email'     => Auth::user()->email,
                'path'      => $request->path(),
                'method'    => $request->method(),
                'ip'        => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);
        }


        return $next($request);
    }


}
