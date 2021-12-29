<?php

namespace App\Supports\Controllers;

use App\Events\ViewsEvent;
use Exception;
use Illuminate\Http\Request;

class ViewRegisterController extends Controller
{
    public function register(Request $request)
    {
        abort_if(!$request->ajax(), 403);

        try {
            $input = $request->input('data');
            $input = decrypt(base64_decode($input));
            $input = json_decode($input, true);
            $unserialize = unserialize($input['serialize']);
    
            $data = $unserialize;
            
            event(new ViewsEvent($data));
        } catch (Exception $e) {
            return;
        }
    }
}
