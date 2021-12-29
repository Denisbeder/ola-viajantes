<?php

namespace App;

use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use EloquentFilter\Filterable;
use Spatie\Sluggable\SlugOptions;
use App\Supports\Models\MediaModel;
use App\Supports\Traits\HasSeoTrait;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;
use App\Supports\Traits\PublishedScopeTrait;

class Advert extends MediaModel
{
    use QueryCachebleTrait, Searchable, PresentableTrait, Notifiable, Filterable, HasSlug, HasSeoTrait, PublishedScopeTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\AdvertPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'category_id',
        'city_id',
        'ip',
        'device',
        'is_mobile',
        'token',
        'email',
        'slug', 
        'title', 
        'body', 
        'publish', 
        'phones',
        'optional',
        'amount',
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
        'phones' => 'array',
        'optional' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['where'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array['id'] = $this->id;
        $array['title'] = $this->title;
        $array['phones'] = json_encode($this->phones);
        $array['optional'] = json_encode($this->optional);

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
     * Get the category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the page.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the related.
     */
    public function related()
    {
        return $this->morphMany(Related::class, 'relatable');
    }

    /**
     * Set the amount.
     *
     * @param  string  $value
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $amount = str_replace('.', '', $value);
        $amount = str_replace(',', '.', $amount);
        $this->attributes['amount'] = (bool) strlen($amount) ? $amount : null;
    }

    /**
     * Get the amount.
     *
     * @param  string  $value
     * @return void
     */
    public function getAmountAttribute($value)
    {
        return is_null($value) ? null : number_format($value, 2, ',', '.');
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getWhereAttribute()
    {
        return optional($this->city)->name ?? null;
    }
}
