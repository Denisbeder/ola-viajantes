<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Traits\QueryCachebleTrait;

class Related extends Model
{
    use QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'show_on'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'show_on' => 'collection',
    ];

    /**
     * Get the owning relatable model.
     */
    public function relatable()
    {
        return $this->morphTo();
    }
}
