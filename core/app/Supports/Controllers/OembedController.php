<?php

namespace App\Supports\Controllers;

use App\Supports\Services\OembedService;
use Illuminate\Http\Request;

class OembedController extends Controller
{
    public function fetch(Request $request)
    {
        $metas = (new OembedService)->fetch($request->get('url'));

        $response = [
            'success' => true,
            'meta' => $metas
        ];

        return response()->json($response);
    }
}
