<?php

namespace App;

use App\Supports\Traits\QueryCachebleTrait;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();

        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    /**
     * Set the name when is empty or not.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = (bool) strlen($value) ? $value : '';
    }
}
