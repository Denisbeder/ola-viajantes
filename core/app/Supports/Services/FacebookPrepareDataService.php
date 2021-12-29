<?php

namespace App\Supports\Services;

use Exception;
use Carbon\Carbon;

use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\parse_query;

class FacebookPrepareDataService
{
    public $item;
    public $defaultTitle = 'Sem título';

    public function __construct(array $item = null)
    {
        if (!is_null($item)) {
            $this->setItem($item);
        }
    }

    public function setItem(array $item)
    {
        $this->item = collect($item);

        return $this;
    }
    
    public function getData()
    {
        return [
            'uid' => $this->getUid(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'description' => $this->getDescription(),
            'image' => $this->getImagePath(),
            'url' => $this->getPermalink(),
            'published_at' => $this->getCreatedTime(),
            'script' => $this->getScript(),
        ];
    }

    public function getUid()
    {
        return $this->item->get('id');
    }

    public function setDefaultTitle($str)
    {
        $this->defaultTitle = $str;
        
        return $this;
    }
    
    public function getTitle($default = null)
    {
        if (!is_null($default)) {
            $default = $default;
        } elseif ($this->defaultTitle !== 'Sem título') {
            $default = $this->defaultTitle;
        } else {
            $default = $this->defaultTitle . ' ' . md5($this->getUid());
        }

        $str = strip_tags($this->getText()) ?? $default;

        return Str::limit(Str::words($str, 10, ' [...]'), 100, null);
    }

    public function getText()
    {
        $str = null;

        if ($this->item->has('message')) {
            $str =  $this->item->get('message');
        } elseif ($this->item->has('description')) {
            $str =  $this->item->get('description');
        }

        $str = nl2br($str);

        return (bool) strlen($str) ? $str : null;
    }

    public function getDescription()
    {
        return Str::limit(strip_tags($this->getText()), 191);
    }

    public function getBody()
    {
        return $this->getText();
    }

    public function getScript()
    {
        return $this->item->get('embed_html');
    }

    public function getImagePath()
    {
        $path = null;

        if ($this->item->has('full_picture')) {
            $path = $this->item->get('full_picture');
        } elseif ($this->item->has('permalink_url')) {
            $baseUrl = 'https://www.facebook.com/';
            $pathCrawler = $baseUrl . ltrim(str_replace($baseUrl, '', $this->item->get('permalink_url')), '/');
            $path = $this->crawlerImage($pathCrawler);
        } elseif ($this->item->has('embed_html')) {
            $embed =  $this->item->get('embed_html');
            $pathCrawler = $this->parseEmbed($embed);
            $path = $this->crawlerImage($pathCrawler);
        }

        return $path;
    }

    public function getPermalink()
    {
        $url = $this->item->get('permalink_url');
        
        if (parse_url($url, PHP_URL_HOST) === null) {
            return 'https://facebook.com' . $url;
        }

        return $url;
    }

    public function getCreatedTime()
    {
        return Carbon::parse($this->item->get('created_time'));
    }

    private function parseEmbed($str)
    {
        preg_match('/src="([^"]*)"/i', $str, $array);
        $url = head($array);
        $urlParsed = parse_url($url);
        $urlQuery = $urlParsed['query'] ?? null;
        $urlQueryParsed = parse_query($urlQuery);
        $link = $urlQueryParsed['href'] ?? null;

        return $link;
    }

    private function crawlerImage($path)
    {
        try {
            $service = new OembedService;
            $fetch = $service->fetch($path);
            $image = $fetch['image'] ?? null;
            $imagePath = $image['url'] ?? null;
    
            return $imagePath;
        } catch (Exception $e) {
            return null;
        }
    }
    
}
