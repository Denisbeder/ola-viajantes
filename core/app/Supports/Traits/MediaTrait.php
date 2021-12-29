<?php

namespace App\Supports\Traits;

use ZipArchive;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Filesystem\Filesystem;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

trait MediaTrait
{
    use HasMediaTrait;

    public $mediaCollection = 'images';

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('banner')->singleFile();
        $this->addMediaCollection('banner_mobile')->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->unzipConversion($media);
    }

    public function unzipConversion(Media $media)
    {
        if ($media->mime_type !== 'application/zip') {
            return;
        }

        $absolutePath = $media->getPath();
        $directory = rtrim(str_replace($media->file_name, '', $media->getPath()), '/');

        $filesystem = new Filesystem;
        $zip = new ZipArchive;
        $zip->open($absolutePath);
        $extract = $zip->extractTo($directory);
        $zip->close();
        $index = head($filesystem->glob($directory . '/*.html'));
        $indexBasename = $filesystem->basename($index);
        $indexMimeType = $filesystem->mimeType($index);
        $indexSize = $filesystem->size($index);

        $media->unsetEventDispatcher();
        $media->update(['file_name' => $indexBasename, 'mime_type' => $indexMimeType, 'size' => $indexSize]);

        unlink($absolutePath);
    }
}
