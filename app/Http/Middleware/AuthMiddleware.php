<?php

namespace App\Http\Middleware;

use Closure;
use Sentry;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(!Sentry::check()){
			return redirect()->to('/login');
		}
        return $next($request);
    }
}
