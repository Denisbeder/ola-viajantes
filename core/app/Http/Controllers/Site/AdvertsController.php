<?php

namespace App\Http\Controllers\Site;

use App\Events\ViewsEvent;
use App\Supports\Traits\SeoGenerateTrait;

class AdvertsController extends PageQueryViewController
{
    use SeoGenerateTrait;
    
    protected function queryBuilder()
    {
        return $this->page
            ->adverts()
            ->published()
            ->filter(request()->all())
            ->latest('published_at')
            ->latest('created_at')
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
        $category = $this->category;
        $datas = $this->query()->paginate();
        $wheres =  $this->page->adverts()->published()->get()->pluck('where')->unique();
        $datas->load('page');
        $seo = $this->seoForIndexPage($page);

        return view('site.adverts.index', compact('datas', 'page', 'category', 'wheres', 'seo'));
    }

    /**
     * Show the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (request()->has('token') && request()->has('edit')) {
            return $this->edit();
        }

        $page = $this->page;
        $data = $this->query()->first();
        $dataSerialized = serialize($data);
        
        abort_if(is_null($data), 404);        
        
        $data->load('seo');
        $seo = $this->seoForShowPage($data);

        $viewRegister = json_encode([
            'view_id' => $data->id,
            'view_type' => get_class($data),
            'serialize' => $dataSerialized,
        ], JSON_UNESCAPED_SLASHES);

        //event(new ViewsEvent($data));

        return view('site.adverts.show', compact('data', 'page', 'seo', 'viewRegister'));
    }

    /**
     * Edit the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $token = request()->get('token');
        $page = $this->page;
        $data = $this->query()->where('token', $token)->first();

        abort_if(is_null($data), 404);

        return view('site.adverts.edit', compact('data', 'page'));
    }
}
