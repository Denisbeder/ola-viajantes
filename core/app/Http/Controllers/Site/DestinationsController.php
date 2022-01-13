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
        $perPage = 15;
        $destinationSelected = Destination::with([
            'posts' => function ($query) {
                $query->scheduled()->limit(200);
            }, 
            'descendants.posts' => function ($query) {
                $query->scheduled()->limit(200);
            }
        ])
        ->where('slug', $destination)
        ->first();

        $postsDescendants = $destinationSelected->descendants->pluck('posts')->flatten();
        $posts = $destinationSelected->posts;
        $postsMerge = $posts->merge($postsDescendants);

        $datas = $postsMerge->paginate($perPage);
    
        $seo = $this->seoSetType('WebPage')->seoSetTitle('Destinos')->seoForIndexPage();

        return view('site.destinations.posts', compact('datas', 'destinationSelected', 'seo'));
    }
}
