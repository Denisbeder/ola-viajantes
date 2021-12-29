<?php

namespace App\Http\Controllers\Admin;

use App\Banner as Model;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;
use App\Http\Requests\BannerFormRequest as FormRequest;

class BannersController extends Controller
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
        return view('admin.banners.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.form');
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

            
        $this->addMedia('file', $data, $data->title, 'banner');
        

        $this->flushCache();

        return redirect()->route('banners.index')->withSuccess(config('app.admin.messages.success'));
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
        return view('admin.banners.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $record = $this->model->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        return view('admin.banners.form', compact('record'));
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
                $this->addMedia('file', $item, $item->title, 'banner');


                $this->flushCache();
            });

        if ($request->isXmlHttpRequest()) {
            return response()->json($data);
        }

        return redirect()->back()->withSuccess(config('app.admin.messages.success'));
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

    protected function flushCache()
    {
        Artisan::call('page-cache:clear');
        (new PurgeNginxCacheService)->purgeAll();
    }

}
