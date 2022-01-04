<?php

namespace App\Http\Controllers\Admin;

use App\Destination as Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\DestinationFormRequest as FormRequest;

class DestinationsController extends Controller
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
        $this->authorize('destinations'); 
        
        $user = auth()->user();

        $allowedPagesId = $this->extractIdPagesOfPermissionsPage($user->permissions['pages'] ?? []);

        $records = $this->model
            ->when(!$user->isSuperAdmin, function ($query) use ($allowedPagesId) {
                return $query->whereIn('id', $allowedPagesId);
            })
            ->with('children', 'ancestors')
            ->withDepth()
            ->whereIsRoot()
            ->defaultOrder()
            ->paginate();

        return view('admin.destinations.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('destinations');

        abort_if(!auth()->user()->isSuperAdmin, 403);

        return view('admin.destinations.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        $this->authorize('destinations');

        abort_if(!auth()->user()->isSuperAdmin, 403);

        $data = $this->model
            ->create($request->all());

        $data->user()
            ->associate($request->user())
            ->save();

        // Salva as imagens na pasta e no banco de dados
        $this->addMedia('images', $data, $data->title, 'images');
        $this->addMedia('avatar', $data, $data->writer['name'] ?? null, 'avatar');

        // Salva dados SEO 
        $data->seo()->create($this->seoInputs($request));

        $this->model->fixTree();

        Artisan::call('route:cache');

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
        $this->authorize('destinations');

        $record = $this->model->find($id);
        return view('admin.destinations.show', compact('record'));
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

        $this->authorize('edit', $record);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        return view('admin.destinations.form', compact('record'));
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
                // Verifica se tem autorização
                $this->authorize('edit', $item);

                if ($request->has('duplicate')) {
                    $duplicate = $item->replicate(['publish', 'user_id']);
                    $duplicate->user_id = $request->user()->id;
                    $duplicate->save();
                    $id[] = $duplicate->id;
                } else {
                    $item->fill($request->input())->save();

                    // Salva as imagens na pasta e no banco de dados
                    $this->addMedia('images', $item, $item->title, 'images');
                    $this->addMedia('avatar', $item, $item->writer['name'] ?? null, 'avatar');

                    // Salva dados SEO 
                    $item->seo()->updateOrCreate(
                        ['seoable_type' => get_class($this->model), 'seoable_id' => $item->id],
                        $this->seoInputs($request)
                    );
                }
            });

            $this->model->fixTree();

            Artisan::call('route:cache');

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

        $this->authorize('destinations');

        $this->model->destroy($id);

        $this->model->fixTree();

        Artisan::call('route:cache');

        return back()->withSuccess(config('app.admin.messages.success'));
    }

    public function extractIdPagesOfPermissionsPage(array $permissions)
    {
        return collect(array_map(function ($value) {
            return trim(last(explode('_', $value)));
        }, $permissions));
    }
}
