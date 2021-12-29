<?php

namespace App\Supports\Services;

use App\Page;
use Illuminate\Support\Str;

class GetPageService
{
    protected $pageSelect;
    private $page;
    private $collection;
    private $items;
    private $limitTotal;
    private $limitPerPage;

    public function __construct($pageSelect, $limitTotal = 20, $limitPerPage = 1)
    {
        $this->items = collect([]);
        $this->limitTotal = $limitTotal;
        $this->limitPerPage = $limitPerPage;
        $this->pageSelect = $pageSelect;
        $this->page = $this->queryPage();
        $this->collection = $this->queryManagerCollection();
    }

    private function queryPage()
    {
        if (is_numeric($this->pageSelect)) {
            return Page::find($this->pageSelect);
        }

        return Page::firstWhere('slug', 'like', $this->pageSelect . '%');
    }

    private function queryManagerCollection()
    {
        if (is_null($this->page)) {
            return;
        }

        $managerType = $this->page->manager['type'];
        $relation = $this->getRelation($managerType);

        if (in_array($managerType, ['App\Form'])) {
            return null;
        }

        if ($managerType === 'App\Page') {
            return $this->allCollectionForPage($this->page);
        }

        return $this->page->{$relation}()
            ->scheduled()
            ->limit($this->limit)
            ->get()
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            });
    }

    private function allCollectionForPage($page)
    {
        $page->load(['children' => function ($query) {
            $query->where('publish', 1);
        }]);

        if ($page->children->isNotEmpty() || $page->manager['type'] === 'App\Page') {
            $page->children->map(function ($item) {
                return $this->allCollectionForPage($item);
            });
        } else {
            $managerType = $page->manager['type'];
            $relation = $this->getRelation($managerType);
            $collection = $page->{$relation}()
                ->with(['page', 'page.ancestors' => function ($query) {
                    $query->where('publish', 1);
                }])
                ->limit($this->limitPerPage)
                ->scheduled()
                ->latest('published_at')
                ->get()
                ->filter(function ($item) {
                    return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
                });
                
            $this->items->push($collection);
        }
        return $this->items->flatten()->take($this->limitTotal);
    }

    public function get()
    {
        return collect([
            'page' => $this->page,
            'collection' => $this->collection,
        ]);
    }


    public function getPage()
    {
        return $this->page;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getRelation($str)
    {
        return strtolower(Str::plural(class_basename($str)));
    }
}
