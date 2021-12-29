<?php

namespace App\Supports\Services;

use Illuminate\Filesystem\Filesystem;

class PurgeNginxCacheService
{
    public $filesystem;
    public $cachePath = '/etc/nginx/cache/';

    public function __construct()
    {
        $this->filesystem = new Filesystem;
    }

    public function purge($urlKey)
    {
        /* $url = parse_url($urlKey);

        if (!$url) {
            return false;
        }
        
        $scheme = $url['scheme'];
        $host = $url['host'];
        $requestUri = @$url['path'];
        $hashs = collect([
            md5($scheme.'GET'.$host.$requestUri),
            md5('do_not_perform'.$scheme.'GET'.$host.$requestUri),
            md5('perform'.$scheme.'GET'.$host.$requestUri)
        ]);
        $paths = $hashs->map(function ($hash) {
            return $this->cachePath . substr($hash, -1) . '/' . substr($hash, -3, 2) . '/' . $hash;
        });

        $paths->each(function ($path) {
            $this->filesystem->delete($path);
        });

        return; */
        return;
    }

    public function purgeAll()
    {
        //return $this->filesystem->cleanDirectory($this->cachePath);
        return true;
    }

    public function purgeSegments($url)
    {
        /* if (!parse_url($url)) {
            return;
        }

        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . '/';
        $segments = collect(explode('/', trim(str_replace($baseUrl, '', $url), '/')))->prepend($baseUrl); 

        $segments->reduce(function ($carry, $item) {
            $url = ltrim($carry . '/' . $item, '/');    
            $url = str_replace('//', '/', $url);
            $url = str_replace(':/', '://', $url);
            (new PurgeNginxCacheService)->purge($url);
            return $url;
        }); */
        return;
    }
}
