<?php

namespace App\Http\Middleware;

use Closure;

class FreeCookie
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
        config()->set('session.driver', 'array');

        return $next($request);
    }
}
