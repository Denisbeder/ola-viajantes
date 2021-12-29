<?php

namespace App\Http\Controllers\Admin;

use App\Media as Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;

class MediasController extends Controller
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
    public function edit(int $id, Request $request)
    {
        $record = $this->model->find($id);

        if (is_null($record)) {
            return redirect()->route($this->className() . '.index')->withInfo(config('app.admin.messages.id_not_found'));
        }
        
        $view = $request->isXmlHttpRequest() ? 'admin.medias.modal' : 'admin.medias.form';

        return view($view, compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        if ($request->has('sortable')) {
            $this->model->setNewOrder($id);

            return $this->redirectRoute($request, $id, false, $id);
        }

        $data = $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request) {
                $item->setCustomProperty('caption', $request->input('caption'));
                $item->setCustomProperty('coordinates', $request->input('coordinates'));
                $item->save();

                $this->flushCache($item);
            });

        return $this->redirectRoute($request, $id, route('medias.edit', $id), $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id, Request $request)
    {
        $id = explode(',', filter_var($id, FILTER_SANITIZE_STRING));

        $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) {
                $item->delete();
                $this->flushCache($item);
            });

        return $this->redirectRoute($request, $id, false);
    }

    protected function flushCache(Model $model)
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $path = ltrim($model->model->present()->url, '/');
        $url = $baseUrl . '/' . $path;

        Artisan::call("page-cache:clear {$path}"); 
        Artisan::call("page-cache:clear mobile/{$path}"); 
        Artisan::call("page-cache:clear pc__index__pc"); 
        Artisan::call("page-cache:clear mobile/pc__index__pc"); 

        (new PurgeNginxCacheService)->purgeSegments($url);
    }
}
