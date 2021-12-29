<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Traits\QueryCachebleTrait;

class AssociatedItem extends Model
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
        'associable_id',
        'associable_type',
        'identifier',
        'description',
    ];

    /**
     * Get the owning associable model.
     */
    public function associable()
    {
        return $this->morphTo();
    }
}
