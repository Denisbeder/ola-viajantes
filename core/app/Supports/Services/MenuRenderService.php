<?php

namespace App\Supports\Services;

use App\Menu;
use App\Page;
use Illuminate\Support\Str;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class MenuRenderService
{
    private $key;
    private $menu;
    private $pages;
    private $pagesId;
    private $classNav = 'nav';
    private $classItem = 'nav-item';
    private $classItemLink = 'nav-link';
    private $classActive = 'active';

    public function __construct()
    {
        $this->menu = $this->getMenu();
        $this->pagesId = $this->getPagesId();
        $this->pages = $this->getPages();
    }

    private function getMenu()
    {
        return Menu::first();
    }

    private function getPagesId()
    {
        return collect(optional($this->menu)->toArray())->map(function ($item) {
            return collect($item)->pluck('page')->filter();
        })->flatten()->unique();
    }

    private function getPages()
    {
        return Page::with(['categories' => function ($query) {
            $query->where('publish', 1)->orderby('title', 'asc');
        }, 'categories.page', 'children' => function ($query) {
            $query->where('publish', 1)->with(['posts' => function ($query) {
                $query->scheduled()->limit(5);
            }]);
        }])->find($this->pagesId);
    }

    public function setClassNav($str)
    {
        $this->classNav = $str;
        return $this;
    }

    public function setClassItem($str)
    {
        $this->classItem = $str;
        return $this;
    }

    public function setClassItemLink($str)
    {
        $this->classItemLink = $str;
        return $this;
    }

    public function setClassActive($str)
    {
        $this->classActive = $str;
        return $this;
    }

    public function getMenuByKey($key)
    {
        if (is_null($this->menu)) {
            return;
        }

        return collect($this->menu->{$key})->map(function ($item) {
            $item['url'] = @$item['url'];
            $item['useDropdow'] = false;
            $item['categories'] = collect([]);
            $item['childrens'] = collect([]);
            $item['posts'] = collect([]);
            
            if (isset($item['type']) && $item['type'] === 'dinamic') {
                $page = $this->getPage($item['page']);
                $posts = $page->posts()->orderby('published_at', 'desc')->limit(5)->get()->load('media');
                $childrens = $page->children;
                $item['url'] = $page->present()->url;
                $item['categories'] = $page->categories;
                $item['childrens'] = $childrens;

                if ($posts->isEmpty()) {
                    if (isset($item['childrens']) && count($item['childrens']) > 0) {
                        $item['posts'] = $item['childrens']->pluck('posts')->flatten();
                    } else {
                        $item['posts'] = collect([]);
                    }
                } else {
                    $item['posts'] = $posts;
                }
            }
            $item['useDropdow'] = ((isset($item['posts']) && count($item['posts']) > 0) || 
                                    (isset($item['childrens']) && count($item['childrens']) > 0) || 
                                    (isset($item['categories']) && count($item['categories']) > 0)) && 
                                    !MobileDetect::isMobile();
            $urlActive = trim($item['url'], '/') == '' ? '/' : trim($item['url'], '/').'*';
            $item['isActive'] = request()->is($urlActive);
            return $item;
        })->toArray();
    }

    public function render($key = 'header')
    {
        if (is_null($this->menu)) {
            return;
        }

        $this->key = $key;
        $items = $this->menu->{$key};

        if (is_null($items)) {
            return;
        }
        
        if (count($items) === 1) {
            $item = head($items);
            $class = $this->classItemLink !== 'nav-link' ? 'class="'.$this->classItemLink.'"' : '';
            return $this->setHref(@$item['title'], @$item['url'], @$item['icon'], $class);
        }

        $html = '<ul class="' . $this->classNav . '">';
        foreach ($items as $item) {
            $html .= $this->handleItem($item);
        }
        $html .= '</ul>';

        return $html;
    }

    private function handleItem($item)
    {
        if (!isset($item['type'])) {
            return $this->setItemStatic($item);
        }

        if ($item['type'] === 'static') {
            return $this->setItemStatic($item);
        }

        if ($item['type'] === 'dinamic') {
            return $this->setItemDinamic($item);
        }
    }

    private function setHref($title, $url, $icon = null, $attributes = null)
    {
        $icon = !is_html($icon) ? sprintf('<i class="%s"></i>', $icon) : $icon;
        
        $html = '<a href="' . $url . '" ' . $attributes . '>';
        $html .= $icon . ' ' . $title;
        $html .= '</a>';

        return $html;
    }

    private function setItem($title, $url, $icon = null, $dropdown = null, $activeExact = false)
    {
        $dropdownItemClass = !is_null($dropdown) ? 'dropdown' : '';
        $dropdownLinkClass = !is_null($dropdown) ? 'dropdown-toggle' : '';
        $dropdownLinkToggle = !is_null($dropdown) ? 'data-toggle="dropdown"' : '';
        $target = Str::contains($this->key, 'social') ? 'target="_blank"' : '';
        $href = !is_null($dropdown) ? '#' : $url;
        $activeClass = $this->setItemActive($url, $activeExact);
        $attributesHref = 'class="' . $this->classItemLink . ' ' . $dropdownLinkClass . '" ' . $dropdownLinkToggle . ' ' . $target;

        $html = '<li class="' . $this->classItem . ' ' . $activeClass . ' ' . $dropdownItemClass . '">';
        $html .= $this->setHref($title, $href, $icon, $attributesHref);
        $html .= $dropdown;
        $html .= '</li>';

        return $html;
    }

    private function setItemStatic($item)
    {
        return $this->setItem(@$item['title'], @$item['url'], @$item['icon'], null, true);
    }

    private function getPage($pageId)
    {
        return $this->pages->where('id', $pageId)->first();
    }

    private function setItemDinamic($item)
    {
        $page = $this->getPage($item['page']);

        $dropdownItems = null;

        if (@$item['submenu'] === 'page_categories') {
            $dropdownItems = $page->categories;
        }

        if (@$item['submenu'] === 'page_childrens') {
            $dropdownItems = $page->children;
        }

        $dropdown = $this->setItemDropdown($dropdownItems, $page);

        return $this->setItem($item['title'], $page->present()->url, @$item['icon'], $dropdown);
    }

    private function setItemDropdown($items, $page)
    {
        if (is_null($items) || $items->isEmpty()) {
            return;
        }

        $html = '<div class="dropdown-menu dropdown-menu-animate">';
        $html .= '<a class="dropdown-item" href="' . $page->present()->url . '">';
        $html .= 'Tudo';
        $html .= '</a>';
        foreach ($items as $item) {
            $html .= '<a class="dropdown-item" href="' . $item->present()->url . '">';
            $html .= $item->title;
            $html .= '</a>';
        }
        $html .= '</div>';

        return $html;
    }

    private function setItemActive($url, $exact = false)
    {
        if ($url === '/') {
            $is = request()->is('/');
        } elseif ($exact) {
            $is = request()->path() === trim($url, '/');
        } else {
            $is = request()->is(trim($url, '/') . '*');
        }
        return $is ? $this->classActive : '';
    }
}
