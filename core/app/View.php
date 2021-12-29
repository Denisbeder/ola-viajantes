<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class View extends Model
{
    use QueryCacheable;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;
    
    const UPDATED_AT = null;

    /**
     * Get the owning commentable model.
     */
    public function viewable()
    {
        return $this->morphTo();
    }
    
}
