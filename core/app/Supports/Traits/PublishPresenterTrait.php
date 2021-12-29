<?php

namespace App\Supports\Traits;

use Carbon\Carbon;

trait PublishPresenterTrait
{
    public function buttonPublishLabel($str = 'Publicar')
    {
        return (bool) $this->publish ? 'Não ' . strtolower($str) : $str;
    }

    public function publishLabel($str = 'Publicado')
    {
        $color = (bool) $this->publish ? 'bgc-green-50 c-green-700' : 'bgc-red-50 c-red-700';
        $label = (bool) $this->publish ? $str : 'Não ' . strtolower($str);

        if (
            ($this->published_at > Carbon::now()) 
            || ($this->started_at > Carbon::now())
        ) {
            $str = 'Programado';
            $color = 'bgc-orange-50 c-orange-700';
            $label = $str;
        } elseif (
            (!is_null($this->unpublished_at) && $this->unpublished_at < Carbon::now())
            || (!is_null($this->finished_at) && $this->finished_at < Carbon::now())
        ) {
            $str = 'Expirado';
            $color = 'bgc-grey-50 c-grey-700';
            $label = $str;
        } else {
            $color = (bool) $this->publish ? 'bgc-green-50 c-green-700' : 'bgc-red-50 c-red-700';
            $label = (bool) $this->publish ? $str : 'Não ' . strtolower($str);
        }

        if ($this->draft) {
            $color = 'bgc-white border c-grey-500';
            $label = 'Rascunho';
        }
        
        return sprintf('<span class="badge badge-pill p-10 lh-0 tt-c %s">%s</span>', $color, $label);
    }
}