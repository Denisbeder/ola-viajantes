<?php

namespace App\Http\Controllers\Site;

use App\Post;

class RSSController extends Controller
{
    public function googleNews()
    {
        $entries = Post::published()->limit(60)->latest('published_at')->get();

        if($entries->isEmpty()) {
            return response()->noContent();
        }

        return response(view('supports.googlenews.xml-2', compact('entries')), 200, ['Content-Type' => 'text/xml; charset=utf-8']);
    }
}
