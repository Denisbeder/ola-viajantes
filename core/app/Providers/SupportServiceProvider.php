<?php

namespace App\Providers;

use App\Poll;
use Illuminate\Support\ServiceProvider;
use App\Supports\Services\GetPageService;
use App\Supports\Services\MenuRenderService;
use App\Supports\Services\MostViewedService;
use App\Supports\Services\FacebookSDKService;
use App\Supports\Services\PageBuilderService;
use App\Supports\Services\BannerRenderService;
use App\Supports\Services\WriterForSelectService;
use Illuminate\Contracts\Support\DeferrableProvider;

class SupportServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('facebookSDKService', function () {
            return new FacebookSDKService;
        });

        $this->app->bind('menuRenderService', function () {
            return new MenuRenderService;
        });

        $this->app->singleton('getPageService', function ($app, $params) {
            return new GetPageService(@$params[0], @$params[1]);
        });

        $this->app->singleton('pollService', function () {
            return Poll::current()
            ->get()
            ->sortByDesc('published_at')
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            })->first();
        });

        $this->app->singleton('bannerService', function ($app, $params) {
            $position = @$params[0];
            $rand = @$params[1];
            $lazy = @$params[2];
            return new BannerRenderService((int) $position, (bool) $rand, (bool) $lazy);
        });

        $this->app->singleton('mostViewedService', function () {
            return new MostViewedService;
        });

        $this->app->singleton('writerForSelectService', function () {
            return new WriterForSelectService;
        });

        $this->app->singleton('pageBuilderService', function () {
            $pageBuilderService = new PageBuilderService;

            return $pageBuilderService->getRoutes();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'facebookSDKService',
            'menuRenderService',
            'getPageService',
            'pollService',
            'bannerService',
            'mostViewedService',
            'writerForSelectService',
            'pageBuilderService',
        ];
    }
}
