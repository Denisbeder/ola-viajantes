<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Destination extends MediaModel
{
    use QueryCachebleTrait, Searchable, PresentableTrait, HasSlug;
    use NodeTrait {
        NodeTrait::usesSoftDelete insteadof Searchable;
    }

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\DestinationPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 
        'slug', 
        'title', 
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
        //$array['body'] = $this->body;

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
     * Get all of the posts that are assigned this city.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'citable');
    }

}
