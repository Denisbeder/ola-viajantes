<?php

namespace App\Supports\Services;

use Spatie\MediaLibrary\UrlGenerator\LocalUrlGenerator;

class MediaUrlGeneratorService extends LocalUrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return config('app.url') . '/media/' . $this->getPathRelativeToRoot();
    }
}
