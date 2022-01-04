<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\HasSeoTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Destination extends MediaModel
{
    use QueryCachebleTrait, PresentableTrait, HasSlug, HasSeoTrait, NodeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\DestinationPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'publish',
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
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        $slugOptions = SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');

            if((bool) !strlen($this->getAttribute('title')) && (bool) !strlen($this->getAttribute('slug'))) {
                $slugOptions->doNotGenerateSlugsOnCreate()->doNotGenerateSlugsOnUpdate();
            } else {
                $slugOptions->doNotGenerateSlugsOnUpdate();
            }

            return $slugOptions;
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the all posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Scope a query remove specific id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcept($query, $page = null)
    {
        return $query->where('id', '<>', $page);
    }
}
