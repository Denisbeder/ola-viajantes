<?php

namespace App\Supports\Traits;

trait CategoryPresenterTrait
{
    public function categoryTitleLabel()
    {
        return optional($this->category)->title ?? '<i class="text-black-50">Sem categoria</i>';
    }

    public function categoryTitleForFront()
    {
        $category = optional($this->category)->title;
        if ((bool) strlen($category)) {
            return '— ' . $category;
        }
        return;
    }
}