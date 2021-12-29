<?php

namespace App\Supports\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;

class StorageImageService
{
    public $file;
    public $baseDestination;
    public $destination;

    public function __construct(UploadedFile $file, $destination = null)
    {
        $this->file = $file;
        $this->baseDestination = str_replace('\\', '/', config('filesystems.disks.public.root'));
        $this->destination = rtrim($this->baseDestination . '/' . ltrim($destination, '/'), '/');
    }
    
    /**
     * Upload image to storage from URL.
     *
     * @param  string  $url
     * @param  integer  $id
     * @return string
     */
    public function store()
    {
        $basename = $this->getBasename();
        $path = $this->getPath($basename);
        $saveTo = $this->destination . '/' . $basename;
        
        $img = Image::make($this->file);
        
        // Redimensiona imagens maiores para um tamanho menor e se form uma imagem menor não faz nada
        $img->widen(1024, function ($constraint) {
            $constraint->upsize();
        })->heighten(768, function ($constraint) {
            $constraint->upsize();
        });

        // Garante que o diretório exista, caso contrário a imagem não será salva e será mostrado um erro 
        (new Filesystem)->ensureDirectoryExists($this->destination);

        // save image
        $save = $img->save($saveTo);

        return $path;
    }

    private function getExtension()
    {
        return $this->file->extension();
    }

    private function getName()
    {
        return $this->file->getClientOriginalName();
    }

    private function getFilename()
    {
        $name = $this->getName();
        $hashTime = microtime(true);
        return Str::slug(preg_replace('/\..*$/', '', $name), '_', config('app.locale')) . '_' . $hashTime;
    }

    private function getBasename()
    {
        $extension = $this->getExtension();        
        $filename = $this->getFilename();
        return $filename . '.' . $extension;
    }

    private function getPath($basename)
    {
        $path = str_replace(trim($this->baseDestination, '/'), '', $this->destination . '/' . $basename);
        return '/media/' . ltrim($path, '/');
    }
}
