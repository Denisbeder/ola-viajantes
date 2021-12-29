<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\HasSeoTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Page extends MediaModel
{
    use QueryCachebleTrait, PresentableTrait, HasSlug, HasSeoTrait, NodeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\PagePresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'manager',
        'slug',
        'title',
        'body',
        'writer',
        'publish',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish' => 'boolean',
        'manager' => 'array',
        'writer' => 'array',
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
     * Get the all galleries.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the all listings.
     */
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Get the all promotions.
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * Get the all videos.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get the all forms.
     */
    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    /**
     * Get the all adverts.
     */
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }

    /**
     * Get the all posts.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Set the Manager.
     *
     * @param  string  $value
     * @return void
     */
    public function setManagerAttribute($value)
    {
        $this->attributes['manager'] = !isset($value['type']) || (bool) !$value['type'] ? null : json_encode($value);
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
