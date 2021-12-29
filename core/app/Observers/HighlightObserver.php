<?php

namespace App\Observers;

use App\Highlight;

class HighlightObserver
{
    // Impede que seja inserido quando não houver um valor selecionado
    public function saving(Highlight $model)
    {
        if (is_null($model->position)) {
            return false;
        }

        if ($model->position <= 0) {
            if ($model->exists) $model->delete();
            return false;
        }

        return $model;
    }
    
}
