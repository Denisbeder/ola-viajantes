<?php

namespace App\Http\Middleware;

use Closure;

class UrlIntended
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
        $request->session()->put('url.intended', $request->fullUrl());

        return $next($request);
    }
}
