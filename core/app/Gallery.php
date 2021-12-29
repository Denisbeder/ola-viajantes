<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\HasSeoTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Gallery extends MediaModel
{
    use QueryCachebleTrait, Searchable, HasSlug, HasSeoTrait, PresentableTrait, PublishedScopeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\GalleryPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'category_id',
        'slug',
        'publish',
        'title',
        'description',
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
        'unpublished_at',
    ];

    public function shouldBeSearchable()
    {
        return (bool) $this->publish;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array['id'] = $this->id;
        $array['title'] = $this->title;
        $array['description'] = $this->description;
        
        return $array;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
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
     * Get the views.
     */
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Get the highlight.
     */
    public function highlight()
    {
        return $this->morphOne(Highlight::class, 'highlightable');
    }

    /**
     * Get the related.
     */
    public function related()
    {
        return $this->morphMany(Related::class, 'relatable');
    }

    /**
     * Get the related ids of Facebook copy posts.
     */
    public function associatedItems()
    {
        return $this->morphMany(AssociatedItem::class, 'associable');
    }

    /**
     * Get the category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Set the images.
     *
     * @param  string  $value
     * @return void
     */
    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = $this->setImages($value);
    }

}
