<?php

namespace App\Supports\Controllers;

use App\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public $model;
    
    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $query = $this->model;

        if ($request->has('state')) {
            $state = filter_var($request->get('state'));
            $query = $query->where('state_id', $state);
        } else {
            $query = $query->limit(500);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }
}
