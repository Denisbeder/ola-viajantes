<?php

namespace App\Http\Controllers\Site;

use App\Supports\Traits\SeoGenerateTrait;
use App\Supports\Services\LatestAllRecordsService;

class LatestRecordsController extends Controller
{
    use SeoGenerateTrait;
    
    public function index()
    {
        $datas = (new LatestAllRecordsService)->limit(50)->get()->paginate();

        $seo = $this->seoSetType('WebPage')->seoSetTitle('Últimas')->seoForIndexPage();

        return view('site.latest.index', compact('datas', 'seo'));
    }

}
