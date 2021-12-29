<?php

namespace App\Http\Controllers\Site;

use App\Page;
use Illuminate\Support\Str;
use App\Supports\Traits\SeoGenerateTrait;

class PagesController extends Controller
{
    use SeoGenerateTrait;
    
    public $page;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $page = $this->page;
        $page->load(['children' => function ($query) {
            $query->where('publish', 1);
        }, 'seo']);
        $datas = $page->children->paginate();
        $seo = $this->seoForIndexPage($page);
        $view = Str::contains($page->slug, 'coluna') ? 'site.pages.index-columns' : 'site.pages.index';

        return view($view, compact('datas', 'page', 'seo'));
    }

    public function __invoke(Page $page)
    {
        $this->page = $page;

        return $this->index();
    }
}