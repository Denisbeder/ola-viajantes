<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Poll extends Model
{
    use PresentableTrait, PublishedScopeTrait, QueryCachebleTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\PollPresenter';

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
            $builder->withCount('votes');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'publish', 'published_at', 'unpublished_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
        'unpublished_at',
    ];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the options of poll.
     */
    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    /**
     * Get the votes of poll.
     */
    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    /**
     * Scope a query remove specific id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeCurrent($query)
    {
        return $query->with(['options', 'options.votes', 'options.poll'])->scheduled()->latest('id');
    }
}
