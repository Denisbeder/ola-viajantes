<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Menu extends Model
{
    use QueryCachebleTrait, PresentableTrait;

    public $cacheFor = -1; // Forever

    protected static $flushCacheOnUpdate = true;

    public $timestamps = false;

    public $incrementing = false;
    
    protected $presenter = 'App\Presenters\MenuPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'header', 'footer', 'sidebar', 'social_header', 'social_footer'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'header' => 'array',
        'footer' => 'array',
        'sidebar' => 'array',
        'social_header' => 'array',
        'social_footer' => 'array',
    ];

}
