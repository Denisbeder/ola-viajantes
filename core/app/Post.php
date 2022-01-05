<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use EloquentFilter\Filterable;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\HasSeoTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Post extends MediaModel
{
    use QueryCachebleTrait, Searchable, Filterable, HasSlug, HasSeoTrait, PresentableTrait, PublishedScopeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\PostPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'page_id',
        'slug',
        'publish',
        'draft',
        'commentable',
        'cover_inside',
        'hat',
        'title',
        'title_short',
        'description',
        'body',
        'author',
        'source',
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
        'draft' => 'boolean',
        'commentable' => 'boolean',
        'cover_inside' => 'boolean',
        'author' => 'json',
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
        //$array['body'] = $this->body;

        return $array;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        $sluggable = SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');

        if (!$this->draft) {
            $sluggable->doNotGenerateSlugsOnUpdate();
        }

        return $sluggable;
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
     * Get all of the destinations for the record.
     */
    public function destinations()
    {
        return $this->morphToMany(Destination::class, 'destinable');
    }

    /**
     * Get the comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the related.
     */
    public function related()
    {
        return $this->morphMany(Related::class, 'relatable');
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
     * Set the category_id.
     *
     * @param  string  $value
     * @return void
     */
    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = empty($value) || $value == 0 ? null : $value;
    }

    /**
     * Set the title empty string when is draft.
     *
     * @param  string  $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['title'] = '';
            $this->attributes['slug'] = '';
        } else {
            $this->attributes['title'] = $value;
        }
    }

}
