<?php

namespace App\Http\Controllers\Admin;

use App\Menu as Model;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;
use App\Http\Requests\FormFormRequest as FormRequest;

class MenusController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        parent::__construct();

        $this->middleware('needs.not.page.selected');

        $this->model = $model;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = $this->model->first();

        return view('admin.menus.form', compact('record'));
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
        $inputs = array_filter_recursive($request->input());

        if (!Arr::has($inputs, 'header')) {
            $inputs = Arr::add($inputs, 'header', null);
        }

        if (!Arr::has($inputs, 'footer')) {
            $inputs = Arr::add($inputs, 'footer', null);
        }

        if (!Arr::has($inputs, 'sidebar')) {
            $inputs = Arr::add($inputs, 'sidebar', null);
        }

        if (!Arr::has($inputs, 'social_header')) {
            $inputs = Arr::add($inputs, 'social_header', null);
        }

        if (!Arr::has($inputs, 'social_footer')) {
            $inputs = Arr::add($inputs, 'social_footer', null);
        }

        $this->model->truncate();
        $data =  $this->model->firstOrCreate(Arr::only($inputs, ['header', 'footer', 'sidebar', 'social_header', 'social_footer']));

        $this->flushCache();

        return $this->redirectRoute($request, null, false, $data);
    }

    public function flushCache()
    {
        Artisan::call("page-cache:clear"); 
        (new PurgeNginxCacheService)->purgeAll();
    }
}
