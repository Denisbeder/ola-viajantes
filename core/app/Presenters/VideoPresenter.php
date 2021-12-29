<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;
use App\Supports\Traits\CategoryPresenterTrait;
use App\Supports\Traits\HighlightPresenterTrait;
use App\Supports\Traits\PublisedAtPresenterTrait;

class VideoPresenter extends Presenter
{
    use PublishPresenterTrait, CategoryPresenterTrait, HighlightPresenterTrait, ImagesPresenterTrait, PublisedAtPresenterTrait; 

    public function summary($limit = 150)
    {
        return Str::limit(strip_tags(html_entity_decode($this->body)), $limit);
    }

    public function urlVideo()
    {
        $urlVideo = $this->entity->url;
        if (Str::contains($urlVideo, 'facebook') && Str::contains($urlVideo, 'video')) {
            $urlVideoFacebook = sprintf('https://www.facebook.com/plugins/video.php?href=%s&show_text=0', urlencode($urlVideo));
            return $urlVideoFacebook;
        }

        if (Str::contains($urlVideo, 'youtu')) {
            $parseUrlVideo = parse_url($urlVideo);
            if (isset($parseUrlVideo['query']) && !empty($parseUrlVideo['query'])) {
                parse_str($parseUrlVideo['query'], $parseQuery);
                if (isset($parseQuery['v']) && !empty($parseQuery['v'])) {
                    $urlVideo = sprintf('%s://%s%s?v=%s', $parseUrlVideo['scheme'], $parseUrlVideo['host'], $parseUrlVideo['path'], $parseQuery['v']);
                }
            }
        } 
        return $urlVideo;
    }
    
    public function url()
    {
        if (is_null($this->page)) {
            return;
        }
        
        $category = $this->category;
        $pageSlug = '/' . trim($this->page->present()->url, '/');
        $categorySlug = !is_null($category) ? '/' . $category->slug : null;
        $slug = '/' . $this->slug;
        return $pageSlug . $categorySlug . $slug;
    }
}
