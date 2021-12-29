<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Promotion extends MediaModel
{
    use QueryCachebleTrait, Searchable, PresentableTrait, HasSlug, PublishedScopeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\PromotionPresenter';

    public $mediaCollection = 'image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'mode',
        'slug', 
        'title', 
        'body', 
        'publish', 
        'published_at',        
        'unpublished_at',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish' => 'boolean',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array['id'] = $this->id;
        $array['title'] = $this->title;

        return $array;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the page.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the participants.
     */
    public function participants()
    {
        return $this->hasMany(PromotionParticipant::class);
    }

    /**
     * Get the related.
     */
    public function related()
    {
        return $this->morphMany(Related::class, 'relatable');
    }

}
