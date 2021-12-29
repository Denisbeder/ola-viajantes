<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Services\FormService;

class FormPresenter extends Presenter
{
    public function renderForm()
    {
        $service = new FormService($this->fields);
        return $service->render();
    }
}
