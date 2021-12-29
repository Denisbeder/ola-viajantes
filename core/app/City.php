<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Traits\QueryCachebleTrait;

class City extends Model
{
    use QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;
    
    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
