<?php

namespace App\Supports\Traits;

use Carbon\Carbon;

trait PublisedAtPresenterTrait
{
    public function forHumans()
    {
        $datetime = $this->published_at ?? $this->created_at;
        $publishedAt = Carbon::parse($datetime);
        if ($publishedAt->diffInHours(Carbon::now()) <= 12) {
            return ucfirst($publishedAt->diffForHumans());
        }
        return $publishedAt->formatLocalized('%d %B, %Y');
    }

    public function forHumansUnpublished()
    {
        $datetime = $this->unpublished_at;

        if (!isset($datetime) && is_null($datetime)) {
            return;
        }
        
        $unpublishedAt = Carbon::parse($datetime);

        return $unpublishedAt->format('\T\e\r\m\i\n\a \e\m d F, Y \à\s H\hi\m\i\n');
    }
}