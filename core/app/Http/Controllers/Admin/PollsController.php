<?php

namespace App\Http\Controllers\Admin;

use App\Poll as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;
use App\Http\Requests\PollFormRequest as FormRequest;

class PollsController extends Controller
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
        return view('admin.polls.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.polls.form');
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

        if ($request->has('options') && !empty($request->get('options'))) {
            $data->options()->createMany($request->get('options'));
        }

        $this->flushCache();

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
        return view('admin.polls.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $record = $this->model->with('options')->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        return view('admin.polls.form', compact('record'));
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

        // Atualiza a slug quando for atualizado o titulo da categoria
        $request->merge(['slug' => null]);

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
                    $inputOptions = $request->get('options');

                    // Deleta opcoes removidas
                    $item->options->filter(function ($item) use ($inputOptions) {
                        return !in_array($item->id, Arr::pluck($inputOptions, 'id'));
                    })->each(function ($item) {
                        $item->delete();
                    });

                    // Atualiza opções
                    if ($request->has('options') && !empty($inputOptions)) {
                        array_map(function ($value) use ($item) {
                            return $item->options()->updateOrcreate(
                                ['id' => @$value['id']],
                                ['title' => $value['title']]
                            );
                        }, $inputOptions);
                    }

                    $this->flushCache();
                }
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

        $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) {
                $item->delete();

                $this->flushCache();
            });

        return back()->withSuccess(config('app.admin.messages.success'));
    }

    protected function flushCache()
    {
        Artisan::call('page-cache:clear');
        (new PurgeNginxCacheService)->purgeAll();
    }
}
