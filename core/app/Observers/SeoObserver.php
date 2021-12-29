<?php

namespace App\Observers;

use App\Seo;

class SeoObserver
{
    // Impede de inserir dados quando todos os campos forem vazios
    public function saving(Seo $model)
    {
        if ((bool) !strlen($model->title) && (bool) !strlen($model->description) && (bool) !strlen($model->keywords)) {
            return false;
        }
        
        return $model;
    }

}
