<?php

namespace App\Http\Controllers\Site;

class PreviewController extends Controller
{
    public function index($model, $id)
    {
        abort_unless(auth()->check(), 404);

        $model = "App\\{$model}";
        $instance = new $model;
        $data = $instance->with('media', 'category')->find($id);
    
        return view('site.previews.posts.index', compact('data'));
    }
}
