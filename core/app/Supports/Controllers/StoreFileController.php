<?php

namespace App\Supports\Controllers;

use Illuminate\Http\Request;
use App\Supports\Traits\StoreHasFileTrait;

class StoreFileController extends Controller
{
    use StoreHasFileTrait;

    public function store(Request $request)
    {
        $file = $this->getFileFromRequest($request);

        if (!$file) {
            return response()->noContent();
        }

        $destination = $request->get('destination');
        $baseUrl = config('app.url');   
        $store = $file->store('/public/' . ltrim($destination, '/'));
        $path = $baseUrl . '/media/' . ltrim(preg_replace('/\/?public\/?/', '', $store), '/');
        $response = $this->responseFormat($path, $file->getClientOriginalName(), $file->getSize(), $file->extension());

        return response()->json($response);
    }

    private function responseFormat($string, $name, int $size, $extension)
    {
        return [
            'success' => 1,
            'file' => [
                'url' => $string,
                'name' => $name,
                'size' => $size,
                'extension' => $extension,
            ]
        ];
    }
}
