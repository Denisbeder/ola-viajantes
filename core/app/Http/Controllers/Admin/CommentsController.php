<?php

namespace App\Http\Controllers\Admin;

use App\Comment as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Supports\Services\PurgeNginxCacheService;

class CommentsController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->middleware('needs.not.page.selected');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $allowedPagesId = $this->extractIdPagesOfPermissionsPage($user->permissions['pages'] ?? []);

        $records = $this->model->when(!auth()->user()->isSuperAdmin, function ($query) use ($allowedPagesId) {
            $query->whereHasMorph('commentable', '*', function ($query) use ($allowedPagesId) {
                $query->whereIn('page_id', $allowedPagesId);
            });
        })
        ->filter($request->all())
        ->latest()
        ->paginate();

        return view('admin.comments.index', compact('records'));
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

        $data = $this->model
            ->whereIn('id', $id)
            ->get()
            ->each(function ($item) use ($request, &$id) {
                $this->authorize('edit', $item);
                $item->fill($request->input())->save();
                $this->flushCache($item);
                $id[] = $item->id;
            });

        if ($request->isXmlHttpRequest()) {
            return response()->json($data);
        }

        return $this->redirectRoute($request, $id, false, $data);
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

        $this->authorize('edit', $record);

        return view('admin.comments.show', compact('record'));
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
                $this->authorize('edit', $item);
                $item->delete();
                $this->flushCache($item);
            });

        return back()->withSuccess(config('app.admin.messages.success'));
    }

    public function extractIdPagesOfPermissionsPage(array $permissions)
    {
        return collect(array_map(function ($value) {
            return trim(last(explode('_', $value)));
        }, $permissions));
    }

    protected function flushCache(Model $model)
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $path = ltrim($model->commentable->present()->url, '/');
        $url = $baseUrl . '/' . $path;
        
        Artisan::call("page-cache:clear {$path}"); 
        Artisan::call("page-cache:clear mobile/{$path}"); 
        (new PurgeNginxCacheService)->purgeSegments($url);
    }
}
