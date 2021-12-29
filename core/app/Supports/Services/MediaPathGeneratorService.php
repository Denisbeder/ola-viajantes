<?php

namespace App\Supports\Services;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class MediaPathGeneratorService implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $model = strtolower(Str::plural(class_basename($media->model_type)));
        $id = $media->model_id;

        return $model . '/' . $id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'c/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'cri/';
    }
}
