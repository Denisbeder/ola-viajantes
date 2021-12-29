<?php

namespace App\Supports\Traits;

trait HighlightPresenterTrait
{
    public function highlightLabel()
    {
        return !is_null($this->highlight) ? 'Posição ' . $this->highlight->position : '<i class="text-black-50">Não</i>';
    }
}