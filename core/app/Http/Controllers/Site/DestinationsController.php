<?php

namespace App\Http\Controllers\Site;

use App\Post;
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

    public function posts($destination)
    {
        $datas = Post::whereHas('destinations', function ($query) use ($destination) {
            $query->where('slug', $destination);
        })->scheduled()->paginate();

        $destinationSelected = Destination::where('slug', $destination)->first();
    
        $seo = $this->seoSetType('WebPage')->seoSetTitle('Destinos')->seoForIndexPage();

        return view('site.destinations.posts', compact('datas', 'destinationSelected', 'seo'));
    }

}
