<?php

namespace App\Supports\Traits;

use App\Seo;

trait HasSeoTrait
{    
    /**
     * Hook into the Eloquent model events to create or
     * update the slug as required.
     */
    public static function bootHasSeoTrait()
    {
        $model = (new static);
        $model->setAppends($model->appends + ['seo_title', 'seo_description', 'seo_keywords']);
    }  

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
   // protected $appends = ['seo_title', 'seo_description', 'seo_keywords'];

    /**
     * Get the title SEO for input.
     *
     * @return bool
     */
    public function getSeoTitleAttribute()
    {
        return $this->seo->title ?? null;
    }

    /**
     * Get the description SEO for input.
     *
     * @return bool
     */
    public function getSeoDescriptionAttribute()
    {
        return $this->seo->description ?? null;
    }

    /**
     * Get the keywords SEO for input.
     *
     * @return bool
     */
    public function getSeoKeywordsAttribute()
    {
        return $this->seo->keywords ?? null;
    }

     /**
     * Get the SEO.
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
