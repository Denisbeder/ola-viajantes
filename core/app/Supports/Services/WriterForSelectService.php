<?php

namespace App\Supports\Services;

use App\Page;
use App\User;

class WriterForSelectService
{
    public $page;
    public $user;

    public function __construct()
    {
        $this->page = new Page;
        $this->user = new User;
    }

    public function list($pageId, $userId = null)
    {
        $collect = $this->get($pageId, $userId);

        return $collect->map(function ($item) {
            return $item->flatMap(function ($item) {
                return [$item->only(['model', 'id'])->put('type', 'dinamic')->sort()->toJson() => $item->get('name') . ' ('.$item->get('title').')'];
            });
        });
    }

    public function get($pageId, $userId = null)
    {
        $writersPage = $this->page
            ->where('id', $pageId)
            ->limit(1)
            ->get()
            ->map(function ($item) {
                $writer = is_array($item->writer) ? $item->writer + ['title' => $item->title, 'id' => $item->id, 'model' => get_class($item)] : $item->writer;
                return $this->filterWriter($writer);
            })
            ->filter(function ($item) {
                return $this->filterWriter($item);
            });

        $writersUser = $this->user
            ->where(function ($query) use ($userId) {
                if (!is_null($userId)) {
                    $query->where('id', $userId);
                }
            })
            ->where('uses_writer', 1)
            ->get()
            ->map(function ($item) {
                $writer = is_array($item->writer) ? $item->writer + ['title' => $item->name, 'id' => $item->id, 'model' => get_class($item)] : $item->writer;
                return $this->filterWriter($writer);
            })
            ->filter(function ($item) {
                return $this->filterWriter($item);
            });

        $collect = collect(['Página' => $writersPage])
            ->merge(collect(['Usuário' => $writersUser]))
            ->recursive();

        return $collect->map(function ($item) {
            return $item->filter(function ($item) {
                return $item->has('name');
            });
        })->filter(function ($item) {
            return $item->isNotempty();
        });
    }

    private function filterWriter($writer)
    {
        if (!is_array($writer)) {
            return $writer;
        }
        return array_filter_recursive($writer);
    }
}
