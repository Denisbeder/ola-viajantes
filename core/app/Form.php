<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use App\Supports\Traits\QueryCachebleTrait;

class Form extends Model
{
    use QueryCachebleTrait, PresentableTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\FormPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id', 'fields', 'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fields' => 'array',
    ];

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

}
