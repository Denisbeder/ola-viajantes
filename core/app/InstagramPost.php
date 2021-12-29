<?php

namespace App;

use App\Supports\Models\MediaModel;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class InstagramPost extends MediaModel
{
    use QueryCachebleTrait, PresentableTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\InstagramPostPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'caption',
        'location',
        'tags',
        'url',
    ];
}
