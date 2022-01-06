<?php

namespace App\Http\Controllers\Site;

use App\Destination;
use App\Supports\Traits\SeoGenerateTrait;

class DestinationsController extends Controller
{    
    use SeoGenerateTrait;

    public function index()
    {
        $datas = Destination::defaultOrder()->get();
        $tree = $datas->toTree();
        $seo = $this->seoSetType('WebPage')->seoSetTitle('Destinos')->seoForIndexPage();

        return view('site.destinations.index', compact('datas', 'tree', 'seo'));
    }

}
