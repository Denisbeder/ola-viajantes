<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Form as Model;
use Illuminate\Http\Request;
use App\Http\Requests\FormFormRequest as FormRequest;

class FormsController extends Controller
{
    protected $model;

    protected $page;

    public function __construct(Model $model, Page $page)
    {
        parent::__construct();

        $this->middleware('has.page.selected');

        $this->model = $model;

        $this->page = $page;
    }

    protected function getDatas($page)
    {
        return $this->model->where('page_id', optional($page)->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage();
        $record = $this->getDatas($page)->first();

        return view('admin.forms.form', compact('page', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        if ($request->has('fields')) {
            $inputs = $request->input();
        } else {
            $inputs = $request->merge(['fields' => null]);
        }

        $data = $this->model->updateOrCreate(['page_id' => $this->getPage()->id], $request->input());

        $data->user()
            ->associate($request->user())
            ->save();

        return $this->redirectRoute($request, null, false, $data);
    }
}
