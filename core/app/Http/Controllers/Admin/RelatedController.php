<?php

namespace App\Http\Controllers\Admin;

use App\Related as Model;

class RelatedController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->middleware('needs.not.page.selected');

        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->model
            ->with('relatable', 'relatable.related')
            ->select('relatable_id', 'relatable_type')
            ->groupByRaw('relatable_id, relatable_type')
            ->paginate();

        return view('admin.related.index', compact('records'));
    }

}
