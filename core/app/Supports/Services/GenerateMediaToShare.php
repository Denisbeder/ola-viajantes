<?php

namespace App\Supports\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class GenerateMediaToShare
{
    public $logoPath;
    public $imgPath;
    public $fontPath;
    public $widthCanvas;
    public $heightCanvas;
    public $widthText;
    public $heightText;
    public $heightLogo;
    public $host;
    public $text;

    public function __construct($text, $imgPath = null)
    {
        $this->logoPath = public_path('assets/site/img/logo-color.png');
        $this->imgPath = $imgPath;
        $this->fontPath = public_path('assets/admin/fonts/Montserrat-Black.ttf');
        $this->widthCanvas = 1000;
        $this->heightCanvas = 1000;
        $this->widthText = $this->widthCanvas;
        $this->heightText = 350;
        $this->heightLogo = 80;
        $this->host = parse_url(config('app.url'), PHP_URL_HOST);
        $this->text = wordwrap($text, 33, PHP_EOL);  
    }

    public function make()
    {
        $logo = Image::make($this->logoPath)->heighten($this->heightLogo);

        $img = Image::make($this->imgPath)->fit($this->widthCanvas, $this->heightCanvas - $this->heightText);

        $canvasUrl = Image::canvas(250, 40)
            ->fill('#323393')
            ->text($this->host, 127.5, 20, function($font) {
                $fontPath = $this->fontPath;
                $font->file($fontPath);
                $font->size(16);
                $font->align('center');
                $font->valign('center');
                $font->color('#FFFFFF');
            });    

        $canvasText = Image::canvas($this->widthText, $this->heightText)
            ->fill('#323393')
            ->text($this->text, $this->widthText / 2, $this->heightText / 2, function($font) {
                $fontPath = $this->fontPath;
                $font->file($fontPath);
                $font->size(46);
                $font->align('center');
                $font->valign('center');
                $font->color('#FFFFFF');
            });
    
        $canvas = Image::canvas($this->widthCanvas, $this->heightCanvas);
        $canvas->insert($img, 'top');
        $canvas->insert($canvasText, 'bottom');
        $canvas->insert($canvasUrl->opacity(75), 'top-right', 40, 40);
        $canvas->insert($logo, 'bottom-center', 0, intval($this->heightText - ($this->heightLogo / 2)));

        $encode = $canvas->encode('jpg');
        $path = 'public/canvas/' . md5($this->text) . '.jpg';

        Storage::put($path, $encode);

        return storage_path('app/' . $path);
    }
}
