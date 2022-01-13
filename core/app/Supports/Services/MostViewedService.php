<?php

namespace App\Supports\Services;

use App\Post;
use App\View;

class MostViewedService
{
    public function get($limit = 5, $with = [])
    {   
        $key = 'view::post::video::gallery::' . $limit . '::' . implode('-', $with);
        $collect = cache()->remember($key, 3600, function () use ($limit, $with) {
            $query = Post::addSelect(['total' => View::selectRaw('count(id) as total')
                    ->where('viewable_type', 'App\\Post')
                    ->whereColumn('viewable_id', 'posts.id')
                    ->orderBy('total', 'desc')
                    ->limit(1)
                ])
                ->scheduled()
                ->limit($limit)
                ->orderBy('published_at', 'desc')
                ->get()->sortByDesc('total');   

            if (!empty($with)) {
                $query->load($with);
            }
                
            return $query;
        });    

        return $collect;         
    }
}
