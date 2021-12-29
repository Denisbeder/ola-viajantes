<?php

namespace App;

use App\Supports\Traits\MediaTrait;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use QueryCacheable, Notifiable, PresentableTrait, MediaTrait;

    public $cacheFor = 3600; // 1 hour

    protected static $flushCacheOnUpdate = true;

    protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'admin', 'publish', 'last_login', 'permissions', 'uses_writer', 'writer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'publish' => 'boolean',
        'uses_writer' => 'boolean',
        'permissions' => 'array',
        'writer' => 'array',
    ];

    protected $dates = ['last_login', 'deleted_at'];

    protected $appends = ['is_admin', 'is_super_admin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = ! is_null($value) ? bcrypt($value) : $this->attributes['password'];
    }

    public function getIsAdminAttribute()
    {
        return $this->admin === -1 || $this->admin === 1;
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->admin === -1;
    }
}
