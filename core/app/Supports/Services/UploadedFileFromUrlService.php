<?php

namespace App\Supports\Services;

use Illuminate\Http\UploadedFile;

class UploadedFileFromUrlService
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function create()
    {        
        return new UploadedFile($this->getPath(), $this->getInfo('basename'));
    }

    public function getInfo($options = null)
    {
        $info = pathinfo($this->url);
        return is_null($options) ? $info : $info[$options];
    }

    public function getContents()
    {
        return file_get_contents($this->url);
    }

    public function getPath()
    {
        $path = tempnam(sys_get_temp_dir(), '_tmp');
        file_put_contents($path, $this->getContents());
        return $path;
    }
    
}
