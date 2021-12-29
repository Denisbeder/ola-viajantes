<?php

namespace App\Supports\Controllers;

use Illuminate\Http\Request;
use App\Supports\Traits\StoreHasFileTrait;
use App\Supports\Services\StorageImageService;

class StoreImageController extends Controller
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
        $storeService = new StorageImageService($file, $destination);
        $path = $storeService->store();
        $response = $this->responseFormat($baseUrl . $path);

        return response()->json($response);
    }

    private function responseFormat($string)
    {
        return [
            'success' => 1,
            'file' => [
                'url' => $string,
            ]
        ];
    }
}
