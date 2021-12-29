<?php

namespace App\Http\Middleware;

use Closure;
use App\Page;

class HasPageSelected
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
        $session = $request->session();

        $classModel = get_class($request->route()->getController()->getModel());

        $pagesOptions = Page::where('manager->type', $classModel)
            ->where(function ($query) use ($request) {
                if (!$request->user()->isSuperAdmin) {
                    $ids = array_map(function ($value) {
                        return last(explode('_', $value));
                    }, $request->user()->permissions['pages']);
                    
                    $query->whereIn('id', $ids);
                }
            })
            ->get()
            ->pluck('title', 'id')
            ->toJson();

        $routePrefix = head(explode('.', $request->route()->getName()));

        if (!is_null($ps = $request->query('ps'))) {
            $session->put('page.id', $ps);
            $session->put('page.route', $routePrefix);
        }

        if ($session->has('page.id') && $session->get('page.route') === $routePrefix) {
            $session->put('page.continue', true);
        } else {

            $session->put('page.continue', false);
        }

        $session->put('page.options', $pagesOptions);

        //$session->forget('page');

        return $next($request);
    }
}
