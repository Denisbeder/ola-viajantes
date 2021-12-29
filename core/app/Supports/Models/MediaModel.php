<?php

namespace App\Supports\Models;

use App\Supports\Traits\MediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class MediaModel extends Model implements HasMedia
{
    use MediaTrait;

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(800)
              ->height(800)
              ->sharpen(10)
              ->nonQueued();
    }
}
