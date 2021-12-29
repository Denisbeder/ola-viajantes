<?php

namespace App\Supports\Services;

use App\Post;
use App\View;

class MostViewedService
{

    public function get($limit = 5)
    {
        $collect = cache()->remember('view::post::video::gallery', 3600, function () use ($limit) {
            return Post::addSelect(['total' => View::selectRaw('count(id) as total')
                    ->where('viewable_type', 'App\\Post')
                    ->whereColumn('viewable_id', 'posts.id')
                    ->orderBy('total', 'desc')
                    ->limit(1)
                ])
                ->scheduled()
                ->limit($limit)
                ->orderBy('published_at', 'desc')
                ->get()
                ->sortByDesc('total');     
        });    

        return $collect;         
    }
}
