<?php

namespace App\Http\Controllers\Site;

use App\Events\ViewsEvent;
use App\Supports\Traits\SeoGenerateTrait;

class PromotionsController extends PageQueryViewController
{
    use SeoGenerateTrait;
    
    protected function queryBuilder()
    {
        return $this->page
            ->promotions()
            ->published()
            ->latest()
            ->with('media');
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

        return view('site.promotions.index', compact('datas', 'page', 'seo'));
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

        abort_if(is_null($data), 404);   
        
        $seo = $this->seoForIndexPage($page);

        $viewRegister = json_encode([
            'view_id' => $data->id,
            'view_type' => get_class($data),
            'serialize' => $dataSerialized,
        ], JSON_UNESCAPED_SLASHES);

        //event(new ViewsEvent($data));

        return view('site.promotions.show', compact('data', 'page', 'seo', 'viewRegister'));
    }
}
