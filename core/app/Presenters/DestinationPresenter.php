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
        $segment = request()->segment(1);
        $prefix = (bool) strlen($segment) ? '/' . $segment : 'destinos';
        return $prefix . '/' . $this->slug;
    }
}
