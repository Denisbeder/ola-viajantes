<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class PollOption extends Model
{
    use PresentableTrait, QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $presenter = 'App\Presenters\PollOptionPresenter';

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('totalVotes', function ($builder) {
            $builder->with('poll')->withCount('votes');
        });
    }

    /**
     * Get the percent.
     *
     * @return bool
     */
    public function getPercentAttribute()
    {
        $totalVotes = $this->poll->votes_count;
        return !$totalVotes ? 0 : number_format(round(($this->votes_count / $totalVotes) * 100));
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['percent'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Get the poll.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the votes of poll.
     */
    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }
}
