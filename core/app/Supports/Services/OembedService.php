<?php

namespace App\Supports\Services;

use Embed\Embed;
use Illuminate\Support\Str;

class OembedService 
{
    public function fetch($url)
    {
        $info = Embed::create($url);

        return [
            'title' => $info->getTitle(),
            'description' => $info->getDescription(),
            'image' => [
                'url' =>  $info->getImage()
            ],
            'script' => $this->setScript($info),
            'url' => $url,
        ];
    }

    private function setScript($info) 
    {
        if (Str::is('*acebook', $info->providerName) && Str::contains($info->url, 'video')) {
            return sprintf('<iframe src="https://www.facebook.com/plugins/video.php?href=%s&show_text=0&width=%s&height=%s" style="border:none;overflow:hidden" width="%s" height="%s" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>', $info->getUrl(), $info->width, $info->height, $info->width, $info->height);
        }
        return $info->getCode();
    }
}
