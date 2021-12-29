<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Traits\PublishPresenterTrait;

class CategoryPresenter extends Presenter
{
    use PublishPresenterTrait;

    public function pageTitleLabel()
    {
        return !is_null($this->page) ? $this->page->title : '<i class="text-black-50">Nenhuma</i>';
    }

    public function url()
    {
        if (is_null($this->page)) {
            return;
        }
        
        $pageSlug = '/' . trim($this->page->present()->url, '/');
        $slug = '/' . $this->slug;
        return $pageSlug . $slug;
    }

    public function totalRecords()
    {
        $model = $this->page->manager['type'] ?? null;

        if (!is_null($model)) {
            return $model::where('category_id', $this->id)->count();
        }
        return 0;
    }

}
