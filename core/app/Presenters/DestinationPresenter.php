<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;

class DestinationPresenter extends Presenter
{
    use PublishPresenterTrait, ImagesPresenterTrait;

    public function url()
    {
        $prefix = request()->segment(1);
        return '/' . $prefix . '/' . $this->slug;
    }
}
