<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    public $pageCacheExcept = ['search', 'sitemap', 'googlenews', 'outdoor', 'preview'];

    public function __construct()
    {        
        if (!app()->environment('local')) {
            $routeName = optional(request()->route())->getName() ?? '';
            if (!in_array($routeName, $this->pageCacheExcept)) {
                $this->middleware('page-cache');
            }
        }
    }
}
