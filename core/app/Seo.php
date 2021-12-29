<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Seo extends Model
{
    use QueryCachebleTrait, PresentableTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\SeoPresenter';

    protected $table = 'seo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'keywords',
        'description',
    ];

    /**
     * Get the owning seoable model.
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
