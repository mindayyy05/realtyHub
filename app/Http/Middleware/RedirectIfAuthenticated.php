<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RedirectIfAuthenticated extends Middleware
{
    public function handle($request, \Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
