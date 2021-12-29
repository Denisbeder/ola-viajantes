<?php

namespace App\Supports\Services;

use App\Banner;
use Collective\Html\HtmlFacade as Html;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class BannerRenderService
{
    protected $position;
    protected $rand;
    protected $lazy;
    private $collection;

    public function __construct($position = null, $rand = true, $lazy = true)
    {
        $this->position = $position;
        $this->rand = $rand;
        $this->lazy = $lazy;
        $this->collection = $this->query();
    }

    private function query()
    {
        $query = Banner::with('media')->scheduled();

        if (is_null($this->position) || (bool) !$this->position) {
            return $query->get();
        }

        if (is_array($this->position)) {
            return $query->whereIn('position', $this->position)->get();
        }

        $collection = $query->where('position', $this->position)->get();

        if ($this->rand) {
            return $collection->shuffle();
        }

        return $collection;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getDatas($ignoreDevices = false)
    {
         // Filtra e recupera somente os registros que estiverem prontos para serem publicados
         $datas = $this->collection->filter(function ($item) {
            return $item->published_at <= now() || $item->published_at === null;
        });

        if ($ignoreDevices) {
            return $datas;
        }

        if (MobileDetect::isMobile()) {
            $datas = $datas->filter(function ($item) {
                return $item->device === 'mobile' || $item->device === 'mobile_desktop';
            });
        }  else {
            $datas = $datas->filter(function ($item) {
                return $item->device === 'desktop' || $item->device === 'mobile_desktop';
            });
        }

        return $datas;
    }

    public function toJson()
    {
        $datas = $this->getDatas(true);

        $result = $datas->map(function ($item) {
            return [
                'device' => $item->device,
                'content' => (string) $this->compose($item)
            ];
        });

        if($result->isEmpty()) {
            return null;
        }

        return base64_encode($result->toJson());
    }

    public function render(array $size = null)
    {
        $datas = $this->getDatas(); 

        $currentData = $datas->first(); 

        if ($datas->isEmpty() || is_null($currentData)) {
            return;
        }

        return $this->compose($currentData, $size);
    }

    private function compose($data, $size = null)
    {
        if ((bool) strlen($script = $data->script)) {
            return $script;
        }
        
        $dataSize = !is_null($size) ? $size : collect(config('app.banners.formats'))->firstWhere('key', $data->size);
        $dataWidth = @$dataSize['w'];
        $dataHeight = @$dataSize['h'];
        $dataPath = $data->getFirstMediaUrl('banner');
        if (!app()->environment('production')) {
            $dataPath = str_replace(config("app.url"), "", $dataPath);
        }
        $dataExtension = pathinfo($dataPath, PATHINFO_EXTENSION);
        
        if (in_array($dataExtension, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {  
            $file = $this->imageHtml($dataPath, $dataWidth, $dataHeight);
        }

        if ($dataExtension === 'mp4') {
            $file = $this->videoHtml($dataPath, $dataWidth, $dataHeight);
        }

        if ($dataExtension === 'html') {
            $file = $this->iframeHtml($dataPath, $dataWidth, $dataHeight);
        }

        if ((bool) strlen($data->url) && isset($file)) {
            return Html::link($data->url, $file, ['target' => '_blank'], null, false);
        }

        return $file ?? null;
    }
    
    public function imageHtml($src, $width, $height)
    {
        $html = Html::image($src, null, ['width' => $width, 'height' => $height]);

        if ($this->lazy) {
            $html = Html::image($src, null, ['width' => $width, 'height' => $height] + $this->getLazyClass());
            $html = $this->lazy ? str_replace('src=', 'data-src=', $html) : $html;
        }

        return $html;
    }

    public function videoHtml($src, $width, $height)
    {
        $html  = '<video width="' . $width . '" height="' . $height . '" ' . $this->getLazyClassAttribute() . ' autobuffer buffered loop autoplay muted>';
        $html .= '<source src="' . $src . '" type="video/mp4">';
        $html .= '</video>';

        return $html;
    }

    public function iframeHtml($src, $width, $height)
    {
        return sprintf('<iframe src="%s" width="%s" height="%s" frameborder="0" %s></iframe>', $src, $width, $height, $this->getLazyClassAttribute());
    }

    private function getLazyClass()
    {
        return $this->lazy ? ['class' => 'lazy'] : [];
    }

    private function getLazyClassAttribute()
    {        
        return Html::attributes($this->getLazyClass());
    }
}
