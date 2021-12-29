<?php

namespace App\Presenters;

use Illuminate\Support\Arr;
use Laracasts\Presenter\Presenter;
use App\Supports\Traits\PublishPresenterTrait;
use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;

class BannerPresenter extends Presenter
{
    use PublishPresenterTrait;

    public function deviceLabel()
    {
        switch ($this->device) {
            case 'mobile':
                return 'Mobile';
                break;

            case 'desktop':
                return 'Desktop';
                break;

            case 'mobile_desktop':
                return 'Mobile e Desktop';
                break;

            default:
                return '<em class="text-muted">Não definido</em>';
                break;
        }
    }

    public function positionSize()
    {
        $position = collect(config('app.banners.positions'))->firstWhere('key', $this->position);
        $size = collect(config('app.banners.formats'))->firstWhere('key', $this->size);
        $sizeStr = !is_null($size) ? ' (' .@$size['w'] . 'x' . @$size['h'] . 'px)' : ' (--)';
        $script = (bool) strlen($this->script) ? ' (Script)' : '';

        return @$position['key'] . $sizeStr . $script;
    }

    public function positionLabel()
    {
        $position = collect(config('app.banners.positions'))->firstWhere('key', $this->position);

        return @$position['label'];
    }

    public function sizeLabel()
    {
        $size = collect(config('app.banners.formats'))->firstWhere('key', $this->size);

        return @$size['w'] . 'x' . @$size['h'] . 'px';
    }

    public function render(?array $attributes = null, $forceRenderMobile = false)
    {
        $attributesString = is_null($attributes) ? null : urldecode(str_replace(['=', '+'], ['="', ' '], http_build_query($attributes, '', '" ')) . '"');
        $entity = $this->entity;
        $firstMedia = $entity->getFirstMedia('banner');
        $urlFile = null;

        if (MobileDetect::isMobile() || $forceRenderMobile === true) {
            $firstMedia = $entity->getFirstMedia('banner_mobile');
        }

        if (!is_null($firstMedia)) {
            $urlFile = $firstMedia->getUrl();
        }

        if ((bool) !strlen($urlFile)) return;

        $mimeType = $firstMedia->mime_type;
        $size = collect(config('app.banners.formats'))->where('key', $this->size)->first();

        if ($mimeType === 'text/html') {
            $file = sprintf('<iframe %s src="%s" width="%s" height="%s" frameborder="0"></iframe>', $attributesString, $urlFile, $size['w'], $size['h']);
        } elseif ($mimeType === 'video/mp4') {
            $file  = '<video ' . $attributesString . ' width="' . $size['w'] . '" height="' . $size['h'] . '" autobuffer buffered loop autoplay muted>';
            $file .= '<source src="' . $urlFile . '" type="video/mp4">';
            $file .= '</video>';
        } else {
            $file = $firstMedia->img($attributes);
        }

        if ((bool) strlen($this->url)) {
            return sprintf('<a href="%s" target="_blank">%s</a>', $this->url, $file);
        }

        return $file;
    }
}
