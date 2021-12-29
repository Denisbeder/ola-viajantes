<?php

namespace App\Providers;

use App\Seo;

use App\Page;
use App\Post;
use App\Video;
use Exception;
use App\Advert;
use App\Gallery;
use App\Listing;
use App\Setting;
use App\Highlight;
use App\Promotion;
use Carbon\Carbon;
use League\Glide\Server;
use App\Observers\SeoObserver;
use League\Glide\ServerFactory;
use App\Observers\MediaObserver;
use App\Observers\HighlightObserver;
use App\Observers\ClearCacheObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaObserver as BaseMediaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return realpath(base_path() . '/../public');
        });

        $this->app->singleton(Server::class, function ($app) {
            return ServerFactory::create([
                'source' => config('filesystems.disks.public.root'),
                'cache' => storage_path('app/cache'),
            ]);
        });

        // Troca o Observer original por outro para susbstituir o método de delete
        $this->app->bind(BaseMediaObserver::class, function ($app) {
            return new MediaObserver;
        });

        $this->app->singleton('settingService', function () {
            try {
                $setting = Setting::firstOrFail();
                return collect($setting->data ?? [])->recursive();
            } catch(Exception $e) {
                return collect([]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = $this->app->getLocale();
        setlocale(LC_ALL, $locale.'.utf-8');
        Carbon::setLocale($locale);
        
        require_once base_path('resources/macros/form.php');
        require_once base_path('resources/macros/collection.php');

        Highlight::observe(HighlightObserver::class);
        Seo::observe(SeoObserver::class);
        Post::observe(ClearCacheObserver::class);
        Gallery::observe(ClearCacheObserver::class);
        Video::observe(ClearCacheObserver::class);
        Advert::observe(ClearCacheObserver::class);
        Listing::observe(ClearCacheObserver::class);
        Page::observe(ClearCacheObserver::class);
        Promotion::observe(ClearCacheObserver::class);

        if ((bool) strlen($siteName = app('settingService')->get('name'))) {
            $this->app['config']->set('app.site.name', $siteName);
        }

        if ((bool) strlen($siteSlogan = app('settingService')->get('slogan'))) {
            $this->app['config']->set('app.site.slogan', $siteSlogan);
        }

        if ((bool) strlen($idAnalytics = app('settingService')->get('analytics_id'))) {
            $this->app['config']->set('analytics.view_id', $idAnalytics);
        }
    }

}
