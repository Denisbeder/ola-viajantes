<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Listing as Model;
use App\Http\Requests\ListingFormRequest as FormRequest;

class ListingsController extends Controller
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
        return $this->model->with('media', 'page', 'category')->where('page_id', optional($page)->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage();
        $records = $this->getDatas($page)->withDepth()->latest()->paginate();
        return view('admin.listings.index', compact('page', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage();
        return view('admin.listings.form', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        $data = $this->model->create($request->input());

        $data->user()
            ->associate($request->user())
            ->save();

        // Salva as imagens na pasta e no banco de dados
        $this->addMedia('images', $data, $data->title, 'images');

        return $this->redirectRoute($request, $data->id);
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
        return view('admin.listings.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $page = $this->getPage();
        $record = $this->model->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        return view('admin.listings.form', compact('page', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequest $request, string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $data = $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request) {  
                $item->fill($request->input())->save();

                // Salva as imagens na pasta e no banco de dados
                $this->addMedia('images', $item, $item->title, 'images');
            });

        return $this->redirectRoute($request, $id, false, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $this->model->destroy($id);

        return back()->withSuccess(config('app.admin.messages.success'));
    }
}
