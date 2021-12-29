<?php

namespace App\Supports\Controllers;

use Illuminate\Http\Request;

class GetCSRFTokenController extends Controller
{
    
    public function get(Request $request)
    {
        abort_if(!$request->ajax(), 403);
        
        return csrf_token();
    }
}
