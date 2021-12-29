<?php

namespace App\Supports\Traits;

use Illuminate\Support\Str;
use App\Supports\Services\EditorJsService;
use App\Supports\Services\KeywordGeneratorService;

trait VideoIdTrait
{
    public static function bootVideoIdTrait()
    {
        self::saving(function ($model) {
            if (!is_null($model->vide_id) || !empty($model->vide_id)) {
                return;
            }

            $parseUrl = parse_url($model->url);

            if (!isset($parseUrl['query'])) {
                return;
            }

            parse_str($parseUrl['query'], $parseStr);

            if (!isset($parseStr['v'])) {
                return;
            }

            $model->setAttribute('video_id', $parseStr['v']);
        });
    }
}
