<?php

namespace App\Presenters;

use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use App\Supports\Services\EditorJsService;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;

class PagePresenter extends Presenter
{
    use PublishPresenterTrait, ImagesPresenterTrait;

    public function url()
    {
        return '/' . trim($this->uri(), '/');
    }

    public function uri()
    {
        $entity = $this->entity;
        $prefix = $entity->ancestors->sortByDesc('id')->pluck('slug')->implode('/');
        return '/' . $prefix . '/' . $this->slug;
    }

    public function titleHandle()
    {
        $prefix = (bool) count($this->ancestors) ? '|' : null;
        return $prefix . str_repeat('&ndash;&ndash;', $this->depth) . ' ' . $this->title;
    }

    public function managerTypeLabelWithHref()
    {
        $url = $this->managerButtonUrl();
        $href = sprintf('<a href="%s">%s</a>', $url, $this->managerTypeLabel());

        return !is_null($this->manager) && !is_null($url) ? $href : $this->managerTypeLabel();
    }

    public function managerTypeLabel()
    {
        $label = collect(config('app.admin.managers'))->where('model', @$this->manager['type'])->pluck('label')->first();
        if (!is_null($label)) {
            return $label;
        }
        return '<i class="text-black-50">Nenhum</i>';
    }

    public function managerButtonUrl()
    {
        if (!is_null($manager = $this->manager) && Str::contains($type = @$manager['type'], '\\') && $type !== 'App\\Page') {
            $classBasename = class_basename($type);
            $routeName = Str::plural(strtolower($classBasename)) . '.index';
            return route($routeName, ['ps' => $this->id]);
        } else {
            return route('pages.edit', ['id' => $this->id]);
        }
    }

    public function managerButton()
    {
        $url = $this->managerButtonUrl();
        $html = sprintf('<a href="%s" class="btn btn-light btn-sm border d-flex text-nowrap">%s <i class="ml-1 ti-new-window" style="margin-top: 2px"></i></a>', $url, $this->managerTypeLabel());

        return !is_null($this->manager) && !is_null($url) ? $html : null;
    }

    public function abilityName()
    {
        return sprintf('page_%s_%s', Str::slug(@$this->manager['type']), $this->id);
    }

    public function bodyHtml()
    {
        return (bool) strlen($body = $this->body) ? (new EditorJsService)->outputToHtml($body) : null;
    }

    public function writerAvatar($attributes = [], string $alt = null, $lazy = false)
    {
        $writerAvatar = $this->imgFirst('avatar', $attributes, $alt, $lazy);

        if (!is_null($writerAvatar)) {
            return $writerAvatar;
        }

        return;
    }

    public function writerName()
    {
        return @$this->writer['name'];
    }

    public function writerEmail()
    {
        return @$this->writer['email'];
    }

    public function writerDescription()
    {
        return @$this->writer['description'];
    }

    public function writerUrl()
    {
        return @$this->writer['url'];
    }
}
