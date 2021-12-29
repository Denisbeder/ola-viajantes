<?php

namespace App\Supports\Traits;

use Illuminate\Support\Str;

trait EditorJsTrait
{
    public function setBodyAttribute($value)
    {
        $decode = json_decode($value);

        $this->attributes['body'] = json_encode($decode, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get the body.
     *
     * @param  string  $value
     * @return string
     */
    public function getBodyAttribute($value)
    {
        $body = json_decode($value);
    
        if ((bool) !strlen($value) || !isset($body->blocks)) {
            return;
        }
        
        $collect = collect($body->blocks);
        $sanitizePathImages = $collect->map(function ($item) {
            if ($item->type === 'image') {
                $currentFileUrl = ltrim(optional($item->data->file)->url, '/');
                if (!Str::startsWith($currentFileUrl, 'storage') && !Str::startsWith($currentFileUrl, 'http') && (bool) strlen($currentFileUrl)) {
                    $item->data->file->url = '/storage/' . $currentFileUrl;
                }
            }
            return $item;
        });

        return json_encode(['blocks' => $sanitizePathImages], JSON_UNESCAPED_SLASHES);
    }
}
