<?php

namespace App\Http\Middleware;

use Closure;
use App\Page;

class NeedsNotPageSelected
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
        $request->session()->put('page.continue', true);

        return $next($request);
    }
}
