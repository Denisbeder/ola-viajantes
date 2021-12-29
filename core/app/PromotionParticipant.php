<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;

class PromotionParticipant extends Model
{
    use PresentableTrait, Filterable, Notifiable;

    protected $presenter = 'App\Presenters\PromotionParticipantPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promotion_id',
        'name',
        'email',
        'phone',
        'data',
        'ip',
        'device',
        'is_mobile',
        'drawn',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'drawn',
    ];

    /**
     * Get the promotion.
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
