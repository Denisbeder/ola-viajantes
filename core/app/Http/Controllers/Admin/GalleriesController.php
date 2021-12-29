<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Gallery as Model;
use Illuminate\Http\Request;
use App\Http\Requests\GalleryFormRequest as FormRequest;

class GalleriesController extends Controller
{
    protected $model;

    public function __construct(Model $model, Page $page)
    {
        parent::__construct();

        $this->middleware('has.page.selected');
        
        $this->model = $model;

        $this->page = $page;
    }

    protected function getDatas($page) 
    {
        return $this->model->with('media', 'page', 'category', 'highlight')->where('page_id', optional($page)->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage();
        $records = $this->getDatas($page)->latest()->paginate();
        return view('admin.galleries.index', compact('page', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage();
        return view('admin.galleries.form', compact('page'));
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

        // Registra posição de destaque na home se houver uam destaque selecionado
        $data->highlight()->create(['position' => $request->input('highlight')]);

        // Salva dados SEO 
        $data->seo()->create($this->seoInputs($request));

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
        $page = $this->getPage();
        return view('admin.galleries.show', compact('record', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id, Request $request)
    {
        $page = $this->getPage();
        $record = $this->model->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        $imageIndex = $request->query('image');
        $view = !is_null($imageIndex) ? 'supports.images.caption' : 'admin.galleries.form';
        return view($view, compact('page', 'record', 'imageIndex'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequest $request, int $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $data = $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request, &$id) {
                if ($request->has('duplicate')) {
                    $duplicate = $item->replicate(['publish', 'user_id']);
                    $duplicate->user_id = $request->user()->id;
                    $duplicate->save();
                    $id[] = $duplicate->id;
                } else {
                    $item->fill($request->input())->save();

                    // Salva as imagens na pasta e no banco de dados
                    $this->addMedia('images', $item, $item->title, 'images');

                    // Registra posição de destaque na home se houver uam destaque selecionado
                    $item->highlight()->updateOrCreate(
                        ['highlightable_type' => get_class($this->model), 'highlightable_id' => $item->id],
                        ['position' => $request->input('highlight')]
                    );

                    // Salva dados SEO 
                    $item->seo()->updateOrCreate(
                        ['seoable_type' => get_class($this->model), 'seoable_id' => $item->id],
                        $this->seoInputs($request)
                    );
                }
            });

        if ($request->isXmlHttpRequest()) {
            return response()->json($data);
        }

        return $this->redirectRoute($request, $id, false, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $this->model->destroy($id);

        return back()->withSuccess(config('app.admin.messages.success'));
    }
}
