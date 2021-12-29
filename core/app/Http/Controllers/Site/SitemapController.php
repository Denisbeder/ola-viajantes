<?php

namespace App\Http\Controllers\Site;

class SitemapController extends Controller
{    
    public function index($filename = null)
    {
        $filename = $filename ?? 'index.xml';
        $file = storage_path('app/public/sitemap/' . $filename);

        if (file_exists($file)) {
            $content = file_get_contents($file);
            return response($content, 200, [
                'Content-Type' => 'application/xml'
            ]);
        }
        
        abort(404);
    }
}
