<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;
use App\Supports\Traits\CategoryPresenterTrait;
use App\Supports\Traits\HighlightPresenterTrait;
use App\Supports\Traits\PublisedAtPresenterTrait;

class AdvertPresenter extends Presenter
{
    use PublishPresenterTrait, CategoryPresenterTrait, HighlightPresenterTrait, ImagesPresenterTrait, PublisedAtPresenterTrait;

    public function summary($limit = 150)
    {
        return Str::limit(strip_tags(html_entity_decode($this->body)), $limit);
    }

    public function url()
    {
        if (!is_null($this->page)) {
            $pageSlug = '/' . trim($this->page->present()->url, '/');
            $slug = '/' . $this->slug;
            return $pageSlug . $slug;
        }

        return;
    }

    public function urlEdit()
    {
        return $this->url() . '?edit=true&token=' . $this->token;
    }

    public function urlDelete()
    {
        return '/support/adverts/' . $this->id . '?token=' . $this->token . '&continue=' . $this->page->present()->url;
    }
}
