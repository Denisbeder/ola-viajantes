<?php

namespace App\Supports\Controllers;

use App\Post;
use App\Video;
use App\Advert;
use App\Gallery;
use App\Promotion;
use Illuminate\Http\Request;

class RelatedController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!$request->ajax(), 404);

        $queryString = filter_var($request->get('query'));

        $posts = Post::published()
            ->where('title', 'like', '%' . $queryString . '%')
            ->latest('created_at')
            ->limit(50)
            ->get();

        $video = Video::published()
            ->where('title', 'like', '%' . $queryString . '%')
            ->latest('created_at')->limit(50)
            ->get();

        $galleries = Gallery::published()
            ->where('title', 'like', '%' . $queryString . '%')
            ->latest('created_at')
            ->limit(50)
            ->get();

        $advert = Advert::published()
            ->where('title', 'like', '%' . $queryString . '%')
            ->latest('created_at')
            ->limit(50)
            ->get();

        $promotion = Promotion::published()
            ->where('title', 'like', '%' . $queryString . '%')
            ->latest('created_at')
            ->limit(50)
            ->get();

        $results = $posts
            ->merge($video)
            ->merge($galleries)
            ->merge($advert)
            ->merge($promotion);

        $results->map(function ($item) {
            $item->model = get_class($item);
            $item->url = config('app.url') . $item->present()->url;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $results->all()
        ]);
    }
}
