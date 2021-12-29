<?php

namespace App\Http\Controllers\Site;

use App\InstagramPost;

class LinkBioController extends Controller
{
    public function index()
    {
        $datas = InstagramPost::paginate();
        
        return view('site.linkbio.index', compact('datas'));
    }

}
