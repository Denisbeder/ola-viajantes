<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\VideoIdTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Video extends MediaModel
{
    use QueryCachebleTrait, Searchable, HasSlug, PresentableTrait, VideoIdTrait, PublishedScopeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\VideoPresenter';

    public $mediaCollection = 'image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'category_id',
        'publish',
        'title',
        'slug',
        'url',
        'description',
        'script',
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
        $array['seo_title'] = $this->seo_title;
        $array['seo_description'] = $this->seo_description;
        $array['seo_keywords'] = $this->seo_keywords;

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
     * Get the views.
     */
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Get the page.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the highlight.
     */
    public function highlight()
    {
        return $this->morphOne(Highlight::class, 'highlightable');
    }

    /**
     * Get the category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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
     * Get the related only in_text.
     */
    public function relatedInText()
    {
        return $this->morphMany(Related::class, 'relatable')->whereJsonContains('show_on', 'in_text');
    }

    /**
     * Get the related only in_home.
     */
    public function relatedInHome()
    {
        return $this->morphMany(Related::class, 'relatable')->whereJsonContains('show_on', 'in_home');
    }

    /**
     * Set the url video.
     *
     * @param  string  $value
     * @return void
     */
    public function setUrlAttribute($value)
    {
        $url = $value;
        $urlHost = parse_url($value, PHP_URL_HOST);
        $urlPath = parse_url($value, PHP_URL_PATH);

        if ($urlHost === 'youtu.be') {
            $url = sprintf('https://www.youtube.com/watch?v=%s', trim($urlPath, '/'));
        }

        $this->attributes['url'] = $url;
    }
}
