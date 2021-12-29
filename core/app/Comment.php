<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Comment extends Model
{
    use QueryCachebleTrait, PresentableTrait, Filterable, Notifiable;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\CommentPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'publish',
        'commentable_id',
        'commentable_type',
        'name',
        'email',
        'text',
        'ip',
        'device',
        'is_mobile',
    ];

    protected $casts = [
        'publish' => 'boolean',
    ];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
