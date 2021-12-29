<?php

namespace App\Http\Controllers\Site;

use App\Events\ViewsEvent;
use App\Supports\Traits\SeoGenerateTrait;

class PostsController extends PageQueryViewController
{
    use SeoGenerateTrait;
    
    protected function queryBuilder()
    {
        return $this->page
            ->posts()
            ->published()
            ->latest('published_at')
            ->with('media', 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->page;
        $datas = $this->query()->paginate();
        $datas->load('page');
        $seo = $this->seoForIndexPage($page);

        return view('site.posts.index', compact('datas', 'page', 'seo'));
    }

    /**
     * Display a listing records of category.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCategory()
    {
        $page = $this->page;
        $category = $this->category;
        $datas = $this->query()->paginate();
        $datas->load('page');
        $seo = $this->seoForIndexPage($page, $category);

        return view('site.posts.index', compact('datas', 'page', 'category', 'seo'));
    }

    /**
     * Show the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $page = $this->page;
        $data = $this->query()->first();
        $dataSerialized = serialize($data);
        $view = 'site.posts.show';
        
        abort_if(is_null($data), 404);
        
        $data->load([
            'seo',
            'relatedInText',
            'comments' => function ($query) {
                $query->where('publish', 1)->latest('created_at')->limit(30);
            }
        ]);

        $seo = $this->seoForShowPage($data);

        $viewRegister = json_encode([
            'view_id' => $data->id,
            'view_type' => get_class($data),
            'serialize' => $dataSerialized,
        ], JSON_UNESCAPED_SLASHES);

        //event(new ViewsEvent($data));

        return view($view, compact('data', 'page', 'seo', 'viewRegister'));
    }
   
}
