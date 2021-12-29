<?php

namespace App\Supports\Services;

use App\Form;
use App\Page;
use App\Advert;
use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

class PageBuilderService
{
    public $page;
    public $managers;

    public function __construct()
    {
        $this->page = new Page;
        $this->managers = collect(config('app.admin.managers'));
    }

    public function getRoutes()
    {
        return $this->makeRoutes();
    }

    public function getPages()
    {
        try {
            return $this->page
            ->with([
                'categories' => function ($query) {
                    $query->where('publish', 1);
                },
                'ancestors',
            ])
            ->where('publish', 1)
            ->get();
        } catch (Exception $e) {
            return collect([]);
        }        
    }

    public function getManager($model, $value = null)
    {
        $collect = collect($this->managers->firstWhere('model', $model));

        return !is_null($value) ? $collect->get($value) : $collect;
    }

    public function managerIsInstanceOf($managerType, Model $class)
    {
        return !is_null($managerType) && new $managerType instanceof $class;
    }

    private function route(string $url, $action, $method = 'get')
    {
        if ($method === 'get') {
            $route = Route::get($url, $action);
        }

        if ($method === 'post') {
            $route = Route::post($url, $action);
        }

        return $route->middleware('web')->where('slug', '[0-9a-z\-]+');
    }

    private function routeAllowsParameterCategory($type)
    {
        if ($this->managerIsInstanceOf($type, new Form)) {
            return false;
        }

        if ($this->managerIsInstanceOf($type, new Advert)) {
            return false;
        }

        return true;
    }

    private function makeRoutes()
    {
        $pages = $this->getPages();

        if (is_null($pages)) {
            return;
        }

        foreach ($pages as $page) {
            $type = @$page->manager['type'];
            $slugParamter = $this->managerIsInstanceOf($type, $page) ? null : '/{slug?}';
            $categories = $page->categories;
            $uses = $this->getManager($page->manager['type'] ?? 'App\Page', 'uses');

            // Rotas com categoria
            if (!is_null($categories) && $this->routeAllowsParameterCategory($type)) {
                foreach ($categories as $category) {
                    $url = $category->present()->url . $slugParamter;

                    $this->route($url, $uses)->defaults('page', $page)->defaults('category', $category);

                    if ($this->managerIsInstanceOf($type, new Form)) {
                        $this->route($url, $uses, 'post')->defaults('page', $page)->defaults('category', $category);
                    }
                }
            }

            // Rotas sem categoria
            $url = $page->present()->url . $slugParamter;
            $this->route($url, $uses)->defaults('page', $page);

            if ($this->managerIsInstanceOf($type, new Form)) {
                $this->route($url, $uses, 'post')->defaults('page', $page);
            }
        }
    }
}
