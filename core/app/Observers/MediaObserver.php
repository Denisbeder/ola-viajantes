<?php

namespace App\Observers;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\Filesystem\Filesystem;
use Spatie\MediaLibrary\MediaObserver as BaseMediaObserver;

class MediaObserver extends BaseMediaObserver
{
    // Sobreescreve o método para que delete os arquivos de média separadamente
    public function deleted(Media $media)
    {
        if (in_array(SoftDeletes::class, class_uses_recursive($media))) {
            if (!$media->isForceDeleting()) {
                return;
            }
        }

        $directory = app(Filesystem::class)->getMediaDirectory($media);
        $pathFile = $directory . $media->file_name;
        app(Filesystem::class)->removeFile($media, $pathFile);
        
        if (count(Storage::allFiles('public/' . $directory)) === 0) {
            app(Filesystem::class)->removeAllFiles($media);
        }

    }
}
