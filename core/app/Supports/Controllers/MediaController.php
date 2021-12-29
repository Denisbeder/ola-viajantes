<?php

namespace App\Supports\Controllers;

use League\Glide\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    private $mimeTypeImages = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tif'];

    public function show(Request $request, Server $server, $path)
    {
        $relativePath = 'public/' . $path;
        
        if (!Storage::exists($relativePath)) {
            return response('Arquivo não existe.', 404, ['X-Robots-Tag' => 'nofollow, noindex']);
        }
        
        $mimeType = $this->getMimeType($relativePath);
        $fileContent = $this->getContent($relativePath);
        $robots = ($mimeType == 'text/html') ? ['X-Robots-Tag' => 'nofollow, noindex'] : [];
        

        if (in_array($mimeType, $this->mimeTypeImages) && !empty($request->query())) {
            return $server->outputImage($path, $request->query());
        }

        return response($fileContent, 200, ['Content-type' => $mimeType] + $robots);
    }

    public function imageDefault()
    {
        $logo = 'assets/site/img/logo-white.png';
        $watermark = Image::make($logo)->widen(300);
        $img = Image::canvas(800, 600, config('app.site.color'));
        $img->insert($watermark, 'center');
        return $img->response('webp');
    }

    private function getMimeType($path)
    {
        return Storage::mimeType($path);
    }

    private function getContent($path)
    {
        return Storage::get($path);
    }
}
