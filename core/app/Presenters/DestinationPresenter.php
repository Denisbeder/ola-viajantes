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
        return '/' . $this->slug;
    }
}
