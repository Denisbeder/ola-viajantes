<?php

namespace App\Supports\Traits;

use App\Supports\Services\UploadedFileFromUrlService;
use Illuminate\Http\Request;

trait StoreHasFileTrait
{
    public function getFileFromRequest(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
        } elseif ($request->hasFile('image')) {
            $file = $request->file('image');
        } elseif ($request->has('url')) {
            $file = (new UploadedFileFromUrlService($request->get('url')))->create();
        } else {
            return false;
        }
        return $file;
    }
}