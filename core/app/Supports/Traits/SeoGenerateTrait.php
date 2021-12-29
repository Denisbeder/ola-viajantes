<?php

namespace App\Supports\Traits;

use App\Page;

trait SeoGenerateTrait
{

    protected $seoMediaCollection = 'images';

    protected $seoAttributes = [
        'page_type' => null,
        'page_headline' => null,
        'page_title' => null,
        'page_description' => null,
        'page_published' => null,
        'page_updated' => null,
        'page_author' => null,
        'page_keywords' => null,
        'page_image' => null,
        'page_image_width' => null,
        'page_image_height' => null,
        'page_url' => null,
    ];

    private function seoSetType($str)
    {
        $this->seoAttributes['page_type'] = $str;
        return $this;
    }

    private function seoSetHeadline($str)
    {
        $this->seoAttributes['page_headline'] = $str;
        return $this;
    }

    private function seoSetTitle($str)
    {
        $this->seoAttributes['page_title'] = sprintf('%s %s %s', $str, config('app.site.title_divisor'), config('app.site.name'));
        return $this;
    }

    private function seoSetDescription($str)
    {
        $this->seoAttributes['page_description'] = $str;
        return $this;
    }

    private function seoSetPublished($str)
    {
        $this->seoAttributes['page_published'] = $str;
        return $this;
    }

    private function seoSetUpdated($str)
    {
        $this->seoAttributes['page_updated'] = $str;
        return $this;
    }

    private function seoSetAuthor($str)
    {
        $this->seoAttributes['page_author'] = $str;
        return $this;
    }

    private function seoSetKeywords($str)
    {
        $this->seoAttributes['page_keywords'] = $str;
        return $this;
    }

    private function seoSetImage($str)
    {
        $this->seoAttributes['page_image'] = $str;
        return $this;
    }

    private function seoSetImageWidth($str)
    {
        $this->seoAttributes['page_image_width'] = $str;
        return $this;
    }

    private function seoSetImageHeight($str)
    {
        $this->seoAttributes['page_image_height'] = $str;
        return $this;
    }

    private function seoSetUrl($str)
    {
        $this->seoAttributes['page_url'] = $str;
        return $this;
    }

    private function seoSetMediaCollection($str)
    {
        $this->seoMediaCollection = $str;
        return $this;
    }


    private function seoForShowPage($data)
    {
        $baseUrl = trim(config('app.url'), '/');
        $imgFirst = $data->getFirstMediaUrl($this->seoMediaCollection, 'thumb');
        $imgDefaultPath = $baseUrl . '/imagedefault';
        $imgPath = (bool) !strlen($imgFirst) ? $imgDefaultPath : $imgFirst;
        $imgWidth = (bool) !strlen($imgFirst) ? null : $data->getFirstMedia($this->seoMediaCollection)->getCustomProperty('width');
        $imgHeight = (bool) !strlen($imgFirst) ? null : $data->getFirstMedia($this->seoMediaCollection)->getCustomProperty('Height');

        if (is_null($imgWidth) || is_null($imgHeight)) {
            $imgInfos = imageInfos($imgPath);
            $imgWidth = $imgInfos['width'] ?? null;
            $imgHeight = $imgInfos['height'] ?? null;
        }

        if (is_null($this->seoAttributes['page_type'])) {
            $this->seoSetType('Article');
        }

        if (is_null($this->seoAttributes['page_headline'])) {
            $this->seoSetHeadline($data->title);
        }

        if (is_null($this->seoAttributes['page_title'])) {
            $this->seoSetTitle(optional($data->seo)->title ?? $data->title);
        }

        if (is_null($this->seoAttributes['page_description'])) {
            $this->seoSetDescription(optional($data->seo)->description ?? ($data->description ?? null));
        }

        if (is_null($this->seoAttributes['page_published'])) {
            $this->seoSetPublished(isset($data->published_at) ? $data->published_at->toDateTimeLocalString() : $data->created_at->toDateTimeLocalString());
        }

        if (is_null($this->seoAttributes['page_updated'])) {
            $this->seoSetUpdated($data->updated_at->toDateTimeLocalString());
        }

        if (is_null($this->seoAttributes['page_author'])) {
            if (method_exists($data->present(), 'getAuthor')) {
                $this->seoSetAuthor($data->present()->getAuthor('name'));
            }
        }

        if (is_null($this->seoAttributes['page_keywords'])) {
            $this->seoSetKeywords(optional($data->seo)->keywords);
        }

        if (is_null($this->seoAttributes['page_image'])) {
            $this->seoSetImage($imgPath);
        }

        if (is_null($this->seoAttributes['page_image_width'])) {
            $this->seoSetImageWidth($imgWidth);
        }

        if (is_null($this->seoAttributes['page_image_height'])) {
            $this->seoSetImageHeight($imgHeight);
        }

        if (is_null($this->seoAttributes['page_url'])) {
            $this->seoSetUrl(request()->url());
        }

        $seo['page_type'] = $this->seoAttributes['page_type'];
        $seo['page_headline'] = $this->seoAttributes['page_headline'];
        $seo['page_title'] = $this->seoAttributes['page_title'];
        $seo['page_description'] = $this->seoAttributes['page_description'];
        $seo['page_published'] = $this->seoAttributes['page_published'];
        $seo['page_updated'] = $this->seoAttributes['page_updated'];
        $seo['page_author'] = $this->seoAttributes['page_author'];
        $seo['page_keywords'] = $this->seoAttributes['page_keywords'];
        $seo['page_image'] = $this->seoAttributes['page_image'];
        $seo['page_image_width'] = $this->seoAttributes['page_image_width'];
        $seo['page_image_height'] = $this->seoAttributes['page_image_height'];
        $seo['page_url'] = $this->seoAttributes['page_url'];

        return (object) $seo;
    }

    private function seoForIndexPage($data = null, $category = null)
    {
        $baseUrl = trim(config('app.url'), '/');
        $imgDefaultPath = $baseUrl . '/imagedefault';

        if ($data instanceof Page) {
            if ($data->hasMedia('images')) {
                $imgDefaultPath = $data->getFirstMediaUrl('images');
            }

            if ($data->hasMedia('avatar')) {
                $imgDefaultPath = $data->getFirstMediaUrl('avatar');
            }
        }

        if (is_null($this->seoAttributes['page_type'])) {
            $this->seoSetType('WebPage');
        }

        if (is_null($this->seoAttributes['page_title']) && !is_null($data)) {
            $this->seoSetTitle(str_replace('  ', ' ', sprintf('%s %s', optional($data->seo)->title ?? $data->title, optional($category)->title ?? null)));
        }

        if (is_null($this->seoAttributes['page_description']) && !is_null($data)) {
            $this->seoSetDescription(optional($data->seo)->description);
        }

        if (is_null($this->seoAttributes['page_keywords']) && !is_null($data)) {
            $this->seoSetKeywords(optional($data->seo)->keywords);
        }

        if (is_null($this->seoAttributes['page_image'])) {
            $this->seoSetImage($imgDefaultPath);
        }

        $seo['page_type'] = $this->seoAttributes['page_type'];
        $seo['page_title'] = $this->seoAttributes['page_title'];
        $seo['page_description'] = $this->seoAttributes['page_description'];
        $seo['page_keywords'] = $this->seoAttributes['page_keywords'];
        $seo['page_image'] = $this->seoAttributes['page_image'];

        return (object) $seo;
    }
}
