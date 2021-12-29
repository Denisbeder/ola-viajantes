<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Traits\QueryCachebleTrait;

class PollVote extends Model
{
    use QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    const UPDATED_AT = null;

    /**
     * Set the base cache tags that will be present
     * on all queries.
     *
     * @return array
     */
    protected function getCacheBaseTags(): array
    {
        return [
            'poll',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poll_option_id',
        'poll_id',
        'ip',
        'visitor_id',
        'device',
        'is_mobile',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_mobile' => 'boolean',
    ];

    /**
     * Get the poll.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the option.
     */
    public function option()
    {
        return $this->belongsTo(PollOption::class);
    }
}
