<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Services\EditorJsService;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;

class ListingPresenter extends Presenter
{
    use PublishPresenterTrait, ImagesPresenterTrait;

    public function bodyHtml()
    {
        return (bool) strlen($body = $this->body) ? (new EditorJsService)->outputToHtml($body) : null;
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
