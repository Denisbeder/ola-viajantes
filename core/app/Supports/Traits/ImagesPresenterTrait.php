<?php

namespace App\Supports\Traits;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade as Html;

trait ImagesPresenterTrait
{
    public function imgElement(string $src, string $alt = null, array $attributes = [])
    {
        return  Html::image($src, $alt, Arr::except($attributes, ['fit']));
    }

    public function imgFirst($collection, array $attributes = [], string $alt = null, $lazy = false)
    {
        if (!$this->entity->hasMedia($collection)) {
            return null;
        }
        
        if ($this->entity->getFirstMedia($collection)->hasGeneratedConversion('thumb')) {
            $path = $this->entity->getFirstMediaUrl($collection, 'thumb');
        } else {
            $path = $this->entity->getFirstMediaUrl($collection);
        }

        if (Str::contains(request()->fullUrl(), '.ngrok.')) {
            $path = str_replace(config("app.url"), "", $path);
        }

        $alt = optional($this->entity->getFirstMedia($collection))->getCustomProperty('caption');
        $coordinates = optional($this->entity->getFirstMedia($collection))->getCustomProperty('coordinates');
        
        if (!is_null($coordinates) && !is_null($arrayCoordinates = $this->getCoordenates($coordinates))) {
            $coordinates = implode('-', $arrayCoordinates);
            $attributes = array_merge($attributes, ['fit' => 'crop-' . $coordinates]);
        }

        return $this->img($path, $attributes, $alt, $lazy);
    }

    public function img(string $path, array $attributes = [], string $alt = null, $lazy = false)
    {
        if ((bool) !strlen($path)) return;

        $configs = http_build_query(Arr::only($attributes, ['width', 'height', 'fit']));
        $configs = !empty($configs) ? '?' . str_replace(['width', 'height'], ['w', 'h'], $configs) : null;
        $src = $path . $configs;
        $img = $this->imgElement($src, $alt, $attributes);
        $alt = is_null($alt) ? ($this->title ?? null) : $alt;

        if ($lazy) {
            if (is_array($lazy)) {
                $attributes = collect($attributes)->map(function ($item, $key) use ($lazy) {
                    return $item . ' ' . @$lazy[$key];
                })->toArray();
                $img = $this->imgElement($src, $alt, $attributes);
            }

            $img = str_replace('src', 'data-src', $img);
        }

        return $img;
    }

    public function imgs(array $attributes = [], $limit = null)
    {
        $images = $this->entity->getMedia('images');

        if ($images->isEmpty()) return;

        $result = '';
        foreach ($images->take($limit) as $img) {
            $result .= $this->img($img->getUrl(), $attributes, $img->getCustomProperty('caption'));
        }
        return $result;
    }

    public function imgsWithPopup(array $attributes = [])
    {
        $images = $this->entity->getMedia('images');

        if ($images->isEmpty()) return;

        $result = '';
        foreach ($images as $img) {
            $result .= '<a href="' . $img->getUrl() . '" class="popup-gallery" data-src="' . $img->getUrl() . '">';
            $result .= $this->img($img->getUrl(), $attributes, $img->getCustomProperty('caption'));
            $result .= '</a>';
        }
        return $result;
    }

    public function imgsEditable(array $attributes = [])
    {
        $images = $this->entity->getMedia('images');

        if ($images->isEmpty()) return;

        $result = '';
        foreach ($images as $k => $img) {
            $result .= '<div class="medias-item" data-index="' . $img->id . '" data-path="' . $img->getUrl() . '" data-caption="' . $img->getCustomProperty('caption') . '">';
            $result .= '<a href="/admin/medias/' . $img->id . '/edit" class="medias-item-caption ti-pencil ajax-popup-link image-focus-edit" title="Add Legenda"></a>';
            $result .= '<i class="medias-item-trash ti-trash" title="Deletar"></i>';
            $result .= $k == 0 ? '<div class="medias-item-cover">CAPA</div>' : null;
            $result .= '<a href="' . $img->getUrl() . '" title="' . $img->getCustomProperty('caption') . '" class="popup-gallery">';
            $result .= $this->img($img->getUrl(), $attributes, $img->getCustomProperty('caption'));
            $result .= '</a>';
            $result .= '</div>';
        }
        return $result;
    }

    private function getCoordenates($str) 
    {
        $coordenatesJson = preg_replace('/(\s*?{\s*?|\s*?,\s*?)([\'"])?([a-zA-Z0-9_]+)([\'"])?:/', '$1"$3":', $str);
        $coordenatesArray = json_decode($coordenatesJson, true);

        if (is_array($coordenatesArray)) {
            $coordenatesArray = array_filter($coordenatesArray, function ($value) {
                return is_numeric($value);
            });
        }
      
        return $coordenatesArray;        
    }
}
