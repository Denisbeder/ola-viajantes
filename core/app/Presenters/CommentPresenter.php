<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use App\Supports\Traits\PublishPresenterTrait;
use App\Supports\Traits\BasePresenterTrait;

class CommentPresenter extends Presenter
{
    use PublishPresenterTrait;
    
    public function gravatar()
    {
        $hash = md5(strtolower(trim($this->email)));
        return sprintf('https://www.gravatar.com/avatar/%s?d=mp', $hash);
    }

    public function mobile()
    {
        return $this->is_mobile ? 'Sim' : 'Não';
    }
}
