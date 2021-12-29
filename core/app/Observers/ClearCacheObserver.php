<?php

namespace App\Observers;

use App\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;

class ClearCacheObserver
{
    public function saving(Model $model)
    {
        $this->clearHighlightCache($model);
        
        if ($model instanceof Page) {
            $this->clearModelFromPageManagerCache($model);
        }
        
        $this->purgeCache($model);
    }

    public function deleted(Model $model)
    {
        $this->clearHighlightCache($model);

        if ($model instanceof Page) {
            $this->clearModelFromPageManagerCache($model);
        }
        
        $this->purgeCache($model);
    }

    protected function clearModelFromPageManagerCache(Model $model)
    {
        $managerType = @$model->manager['type'];
        if ($managerType !== 'App\\Page' && !is_null($managerType)) {
            (new $managerType)->flushQueryCache();
        }      
    }

    protected function clearHighlightCache(Model $model)
    {
        if (method_exists($model, 'highlight')) {
            $model->highlight()->flushQueryCache();
        }
    }

    protected function purgeCache(Model $model)
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $path = ltrim($model->present()->url, '/');
        $url = $baseUrl . '/' . $path;

        Artisan::call("page-cache:clear pc__index__pc"); 
        Artisan::call("page-cache:clear mobile/pc__index__pc"); 
        Artisan::call("page-cache:clear {$path}");
        Artisan::call("page-cache:clear mobile/{$path}");
        Artisan::call("page-cache:clear ultimas");
        Artisan::call("page-cache:clear mobile/ultimas");
        
        (new PurgeNginxCacheService)->purgeSegments($url);
    }

}
