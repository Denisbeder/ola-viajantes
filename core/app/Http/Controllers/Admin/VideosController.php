<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Video as Model;
use App\Supports\Services\OembedService;
use App\Http\Controllers\Admin\Controller;
use App\Supports\Services\UploadedFileFromUrlService;
use App\Http\Requests\VideoFormRequest as FormRequest;

class VideosController extends Controller
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
        return view('admin.videos.index', compact('page', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage();
        return view('admin.videos.form', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        $inputs = $request->input();

        if (is_null($request->input('m'))) {
            $metas = (new OembedService)->fetch($request->get('url'));

            if (is_null($metas['script'])) {
                return redirect()->route('videos.create', ['m' => true])->withWarning(config('app.admin.messages.error_oembed'));
            }

            $inputs = $request->merge($metas)->input();
        }

        $data = $this->model->create($inputs);

        // Registra posição de destaque na home se houver uam destaque selecionado
        $data->highlight()->create(['position' => $request->input('highlight')]);

        $data->user()
            ->associate($request->user())
            ->save();

        // Salva as imagens na pasta e no banco de dados
        if (is_null($request->input('m'))) {
            if (!is_null($imgUrl = $inputs['image']['url'])) {
                $requestFile = (new UploadedFileFromUrlService($imgUrl))->create();
                $this->mediaSanitizeSave($data->addMediaFromUrl($imgUrl), $data->title, $requestFile, 'image');
            }
        } else {
            $this->addMedia('image', $data, $data->title, 'image');
        }

        return $this->redirectRoute($request, $data->id, 'videos.edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $page = $this->getPage();
        $record = $this->model->find($id);
        return view('admin.videos.show', compact('page', 'record'));
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
        return view('admin.videos.form', compact('page', 'record'));
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
            ->each(function ($item) use ($request, &$id) {
                if ($request->has('duplicate')) {
                    $duplicate = $item->replicate(['publish', 'user_id']);
                    $duplicate->user_id = $request->user()->id;
                    $duplicate->save();
                    $id[] = $duplicate->id;
                } else {
                    $item->fill($request->input())->save();

                    // Salva as imagens na pasta e no banco de dados
                    $this->addMedia('image', $item, $item->title, 'image');

                    // Registra posição de destaque na home se houver uam destaque selecionado
                    $item->highlight()->updateOrCreate(
                        ['highlightable_type' => get_class($this->model), 'highlightable_id' => $item->id],
                        ['position' => $request->input('highlight')]
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
    public function destroy(string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $this->model->destroy($id);

        return back()->withSuccess(config('app.admin.messages.success'));
    }
}
