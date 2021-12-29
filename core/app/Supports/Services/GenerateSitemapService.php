<?php

namespace App\Supports\Services;

use App\Page;
use App\Post;
use App\Video;
use App\Gallery;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;

class GenerateSitemapService
{
    public $filesystem;
    public $paths;  
    public $perFile = 1500;        
    public $maxItems = 4500;        

    public function __construct()
    {
        set_time_limit(0);
        $this->filesystem = new Filesystem;
        $this->paths = collect([]);        
    }
           
    public function handle()
    {        
        // Garante que a pasta de sitemap existe, caso não existir cria
        $this->filesystem->ensureDirectoryExists(storage_path('app/public/sitemap'));

        $this->handleItems(new Post);
        $this->handleItems(new Video);
        $this->handleItems(new Gallery);

        $sitemap = new Sitemap;

        $sitemap->add(Url::create('/')->setChangeFrequency('hourly')->setPriority('1'));
        $sitemap->add(Url::create(config('app.url') . '/')->setChangeFrequency('hourly')->setPriority('1'));

        Page::where('publish', 1)->get()->each(function ($item) use ($sitemap) {
            $sitemap->add(Url::create($item->present()->slug)->setChangeFrequency('monthly'));
        });

        $this->builder($sitemap, $this->paths, 'index.xml');
    }

    private function handleItems(Model $model)
    {
        $filename = strtolower(class_basename($model));
        $pathItems = collect([]);
        $sitemap = new Sitemap;

        $model->select(['slug', 'page_id', 'publish', 'published_at', 'unpublished_at', 'created_at'])
        ->latest()
        ->limit($this->maxItems)
        ->published()
        ->chunk($this->perFile, function ($item, $key) use (&$pathItems, $filename, $sitemap) {
            $pathFile = storage_path('app/public/sitemap/'.$filename.'_'.$key.'.xml');
            $pathItems->push($pathFile);

            $item->each(function ($item) use ($sitemap) {
                if (!$sitemap->hasUrl($item->present()->url)) {
                    $sitemap->add(Url::create($item->present()->url)->setPriority(0.5)->setChangeFrequency('never'));
                }
            });

            $sitemap->writeToFile($pathFile);
        });

        $this->builder(new Sitemap, $pathItems, 'index_'.$filename.'.xml');

        $this->paths->push('index_'.$filename.'.xml');
    }

    private function builder(Sitemap $sitemap, Collection $paths, $filename)
    {
        if (!$paths->isEmpty()) {
            $paths->each(function ($path) use ($sitemap) {
                $sitemap->add(Url::create($this->handleUrlXML($path)));
            });
        }

        $writePath = storage_path('app/public/sitemap/' . $filename);

        $sitemap->writeToFile($writePath);
    }

    private function handleUrlXML($path)
    {
        return '/sitemap/' . str_replace(storage_path('app/public/sitemap/'), '', $path);
    }
}
