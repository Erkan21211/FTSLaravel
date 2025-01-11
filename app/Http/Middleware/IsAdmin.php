<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // controleer of de gebruiker een admin is
    public function handle($request, Closure $next): mixed
    {

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        return $next($request);
    }
}
