<?php

namespace App\Http\Controllers\Admin;

use App\User as Model;
use App\Http\Requests\UserFormRequest as FormRequest;

class UsersController extends Controller
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
    private function query()
    {
        return $this->model->where(function ($query) {
            if (!auth()->user()->isSuperAdmin) {
                $query->where('admin', '<>', '-1');
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->query()
            ->latest()
            ->paginate();

        return view('admin.users.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {
        // Se preencher os campos de escritor seta que irá usar dados na página automatico
        if (!empty(array_filter_recursive($request->input('writer')))) {
            $request->merge(['uses_writer' => 1]);
        }

        $data = $this->model
            ->create($request->input());
            
        $data->user()
            ->associate($request->user())
            ->save();

        // Salva as imagens na pasta e no banco de dados
        $this->addMedia('avatar', $data, $data->writer['name'] ?? null, 'avatar');

        return redirect()->route('users.index')->withSuccess(config('app.admin.messages.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $record = $this->query()->where('id', $id)->first();

        return view('admin.users.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $record = $this->query()->where('id', $id)->first();

        if (is_null($record)) {
            return redirect()->route('users.index')->withInfo(config('app.admin.messages.id_not_found'));
        }

        return view('admin.users.form', compact('record'));
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

        $this->query()
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request) {
                $item->fill($request->input())->save();

                 // Salva as imagens na pasta e no banco de dados
                 $this->addMedia('avatar', $item, $item->writer['name'] ?? null, 'avatar');
            });

        return redirect()->back()->withSuccess(config('app.admin.messages.success'));
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

        $this->query()
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) {
                $item->delete();
            });

        return back()->withSuccess(config('app.admin.messages.success'));
    }
}
