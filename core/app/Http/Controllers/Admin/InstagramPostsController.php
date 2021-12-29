<?php

namespace App\Http\Controllers\Admin;

use App\InstagramPost as Model;
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\VideoFormRequest as FormRequest;

class InstagramPostsController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        parent::__construct();

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
        $records = $this->model->latest()->paginate();
        return view('admin.instagramposts.index', compact('records'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $record = $this->model->find($id);
        return view('admin.instagramposts.show', compact('record'));
    }
}
