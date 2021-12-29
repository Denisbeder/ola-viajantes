<?php

namespace App\Http\Controllers\Site;

use App\Events\ViewsEvent;
use App\Supports\Traits\SeoGenerateTrait;

class VideosController extends PageQueryViewController
{
    use SeoGenerateTrait;
    
    protected function queryBuilder()
    {
        return $this->page
            ->videos()
            ->where('publish', 1)
            ->latest()
            ->with([
                'media',
                'page',
                'category',
            ]);
    }

    public function index()
    {        
        $page = $this->page;
        $category = $this->category;
        $datas = $this->query()->paginate();
        $datas->load('page');
        $current = null;
        $seo = $this->seoSetType('VideoGallery')->seoForIndexPage($page, $category);

        return view('site.videos.index', compact('datas', 'current', 'page', 'category', 'seo'));
    }

    public function indexCategory()
    {
        return $this->index();
    }

    public function show()
    {
        $page = $this->page;
        $category = $this->category;
        $current = $this->query()->first();
        $dataSerialized = serialize($current);

        abort_if(is_null($current), 404);

        $datas = $this->queryBuilder()->get()->whereNotIn('id', [$current->id])->paginate(6);

        $seo = $this->seoSetType('VideoGallery')->seoSetMediaCollection('image')->seoForShowPage($current);

        $viewRegister = json_encode([
            'view_id' => $current->id,
            'view_type' => get_class($current),
            'serialize' => $dataSerialized,
        ], JSON_UNESCAPED_SLASHES);

        //event(new ViewsEvent($data));

        return view('site.videos.index', compact('datas', 'current', 'page', 'category', 'seo', 'viewRegister'));
    }

}
