<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use App\Supports\Services\EditorJsService;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;

class DestinationPresenter extends Presenter
{
    use PublishPresenterTrait, ImagesPresenterTrait;

    public function url()
    {
        return '/' . trim($this->uri(), '/');
    }

    public function uri()
    {
        $entity = $this->entity;
        $prefix = $entity->ancestors->sortByDesc('id')->pluck('slug')->implode('/');
        return '/' . $prefix . '/' . $this->slug;
    }

    public function titleHandle()
    {
        $prefix = (bool) count($this->ancestors) ? '|' : null;
        return $prefix . str_repeat('&ndash;&ndash;', $this->depth) . ' ' . $this->title;
    }
}
