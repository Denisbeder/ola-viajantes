<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Traits\QueryCachebleTrait;

class Country extends Model
{
    use QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;
    
    public $timestamps = false;

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
