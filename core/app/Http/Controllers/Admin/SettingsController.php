<?php

namespace App\Http\Controllers\Admin;

use App\Setting as Model;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;
use App\Http\Requests\FormFormRequest as FormRequest;

class SettingsController extends Controller
{
    protected $model;
    protected $filesystem;

    public function __construct(Model $model, Filesystem $filesystem)
    {
        parent::__construct();

        $this->middleware('needs.not.page.selected');

        $this->model = $model;

        $this->filesystem = $filesystem;
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
        $adsPath = public_path('ads.txt');
        if (!$this->filesystem->exists($adsPath)) {
            $this->filesystem->put($adsPath, '');
        }
        $ads = $this->filesystem->get($adsPath);

        return view('admin.settings.form', compact('record', 'ads'));
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

        if (!Arr::has($inputs, 'data')) {
            $inputs = Arr::add($inputs, 'data', null);
        }

        $this->model->truncate();
        $data = $this->model->firstOrCreate(Arr::only($inputs, ['data']));

        $this->fileAdsSave($request->input('ads'));

        return $this->redirectRoute($request, null, false, $data);
    }

    public function update(int $id)
    {
        session()->flash('success', 'Sucesso');
        if ($id === 1) {
            $this->maintenance();
        }

        if ($id === 2) {
            $this->flushCache();
        }

        if ($id === 3) {
            $this->sitemapGenerate();
        }
    }

    public function fileAdsSave($content = null)
    {
        $pathAds = public_path('ads.txt');
        $this->filesystem->put($pathAds, $content);
    }

    public function flushCache()
    {
        cache()->flush();
        Artisan::call('page-cache:clear');
        (new PurgeNginxCacheService)->purgeAll();
        return redirect()->back()->withSuccess('O cache do site foi limpo com sucesso.');
    }

    public function sitemapGenerate()
    {
        Artisan::call('sitemap:generate');
        echo redirect()->back()->withSuccess('O Sitemap gerado com sucesso.');

        return;
    }

    public function maintenance()
    {
        if (!auth()->user()->isSuperAdmin) {
            return;
        }

        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            return redirect()->back()->withSuccess('O site saiu do modo manutenção.');
        } else {
            Artisan::call('down');
            return redirect()->back()->withSuccess('O site entrou no modo manutenção.');
        }
    }
}
