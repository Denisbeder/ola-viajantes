<?php

namespace App;

use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use QueryCachebleTrait, PresentableTrait;

    public $cacheFor = -1; // Forever

    protected static $flushCacheOnUpdate = true;

    public $timestamps = false;

    protected $presenter = 'App\Presenters\SettingPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

}
