<?php

namespace App\Http\Controllers\Admin;

use App\Highlight as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;

class HighlightsController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
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
        $records = $this->model
            ->with('highlightable')
            ->latest("updated_at")
            ->limit(200)
            ->get()
            ->groupBy("position")
            ->sortKeys()
            ->map(function ($item) {
                return $item->take(10);
            });

        return view('admin.highlights.index', compact('records'));
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
        return view('admin.highlights.show', compact('record'));
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

        $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request) {
                $item->fill($request->input())->save();
            });

        $this->flushCache();

        if ($request->ajax()) {
            return response()->json([
                'id' => $id
            ]);
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

        $this->flushCache();

        return back()->withSuccess(config('app.admin.messages.success'));
    }

    public function flushCache()
    {
        Artisan::call("page-cache:clear pc__index__pc"); 
        Artisan::call("page-cache:clear mobile/pc__index__pc"); 
        (new PurgeNginxCacheService)->purgeAll();
    }
}
