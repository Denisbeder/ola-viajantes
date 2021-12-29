<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Post as Model;
use Illuminate\Http\Request;
use App\Http\Requests\PostFormRequest as FormRequest;

class PostsController extends Controller
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
        return $this->model->with(['category', 'page', 'media', 'highlight'])->withCount('comments')->where('page_id', optional($page)->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $this->getPage();

        $records = $this->getDatas($page)
                        ->filter($request->all())
                        ->with('highlight')
                        ->latest()
                        ->paginate();
                        
        return view('admin.posts.index', compact('page', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage();
        return view('admin.posts.form', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        $this->setAuthor($request);

        $inputs = $request->input();
        
        if ($request->input('publish') == 1 && $request->input('draft') == 1) {
            $inputs = $request->except(['publish']);
        }
        
        $data = $this->model->create($inputs);

        // Registra posição de destaque na home se houver uam destaque selecionado
        $data->highlight()->create(['position' => $request->input('highlight')]);

        if ($request->has('related')) {
            $relatedInput = array_map(function ($value) use ($request) {
                $value['show_on'] = $request->input('related_show_on') ?? null;
                return  $value; 
            }, $request->input('related'));
            $data->related()->createMany($relatedInput);
        }

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
        $record = $this->model->withCount('comments')->withCount('views')->find($id);
        $page = $this->getPage();
        return view('admin.posts.show', compact('record', 'page'));
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
        $record = $this->model->with('highlight', 'related')->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }

        return view('admin.posts.form', compact('page', 'record'));
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
        $this->setAuthor($request);

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
                    // Ao editar sempre remove a opção de rascunho
                    $inputs = $request->except(['draft']);

                    // Quando na edição clica no botão rascunho com a marcação de publicar checada desabilita a marcação de publicação
                    if ($request->input('publish') == 1 && $request->input('draft') == 1) {
                        $inputs = $request->except(['draft', 'publish']);
                    }

                    // Ao publicar um registro que esta em rascunho força a remoção da marcação de rascunho
                    if (!$request->has('draft') && $item->draft && $request->input('publish') == 1) {
                        $inputs = $request->merge(['draft' => 0])->input();     
                    }

                    $item->fill($inputs)->save();

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

                    // Sempre que atualizar remove todos os relacionados e adicona os novos mesm que sejam iguais
                    // Fazendo assim se algum ou todos forem removidos garante que isso aconteca
                    $item->related()->delete();
                    if ($request->has('related')) {
                        $relatedInput = array_map(function ($value) use ($request) {
                            $value['show_on'] = $request->input('related_show_on') ?? null;
                            return  $value; 
                        }, $request->input('related'));
                        $item->related()->createMany($relatedInput);
                    }

                }
                $item->flushQueryCache();
                $item->related()->flushQueryCache();
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

    protected function setAuthor($request)
    {
        if ((bool) strlen($authorName = $request->input('author_name'))) {
            $request->merge([
                'author' => ['type' => 'static', 'name' => $authorName]
            ]);
        } else {
            $request->merge([
                'author' => json_decode($request->input('author'), true)
            ]);
        }
    }
}
