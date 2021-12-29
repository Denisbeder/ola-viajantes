<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Supports\Traits\MediaLibraryTrait;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
	use MediaLibraryTrait;
	
	public function __construct()
	{
		$this->middleware('url.intended')->only('index');
	}

	/**
	 * Get model of controller.
	 *
	 * @return string
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Get page selected of controller.
	 *
	 * @return string
	 */
	public function getPage()
	{
		$page = session()->get('page.route') === $this->className() ? $this->page->find(session()->get('page.id')) : null;

		if (!is_null($page)) {
			$this->authorize('page_' . Str::slug(get_class($this->getModel())) . '_' . optional($page)->id);
		}

		return $page;
	}

	/**
	 * Get class name sanitized.
	 *
	 * @return string
	 */
	protected function className()
	{
		return str_replace('controller', '', Str::slug(class_basename($this)));
	}

	/**
	 * Sanitized inputs for SEO.
	 *
	 * @return string
	 */
	protected function seoInputs(Request $request)
	{
		$input = [];
		if ($request->has('seo_title')) {
			$input['title'] = $request->input('seo_title');
		}

		if ($request->has('seo_keywords')) {
			$input['keywords'] = $request->input('seo_keywords');
		}

		if ($request->has('seo_description')) {
			$input['description'] = $request->input('seo_description');
		}

		return $input;
	}

	/**
	 * Redirect after execute request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Request
	 */
	protected function redirectRoute(Request $request, $id = null, $forceRedirectTo = false, $data = [])
	{
		$id = !is_array($id) ? [$id] : $id;
		$prefixRoute = $this->className();

		// Marca os IDs para destaca-los na index após a criação ou edição
		session()->flash('touched', implode(',', $id));

		if ($request->isXmlHttpRequest()) {
			return response()->json($data);
		}

		$parseUrlIntended = parse_url(session()->get('url.intended'));
		isset($parseUrlIntended['query']) ? parse_str($parseUrlIntended['query'], $queryString) : null;

		// Forças o redirecionameto para uma URL especifica
		if ($forceRedirectTo) {
			if (Str::contains($forceRedirectTo, '/') || filter_var($forceRedirectTo, FILTER_VALIDATE_URL)) {
				return redirect()->to($forceRedirectTo)->withSuccess(config('app.admin.messages.success'));
			}

			if (Str::contains($forceRedirectTo, '.')) {
				if (!is_null($id)) {
					return redirect()->route($forceRedirectTo, ['id' => implode(',', $id)])->withSuccess(config('app.admin.messages.success'));
				}
				return redirect()->route($forceRedirectTo)->withSuccess(config('app.admin.messages.success'));
			}

			$prefixRoute = $forceRedirectTo;
		}

		// Se os IDs for vários retorna para a página anterior somente
		if (count($id) > 1) {
			return redirect()->back()->withSuccess(config('app.admin.messages.success'));
		}

		// Se o botão salvar e continuar foi cliado redireciona para edição
		if ($request->has('submit_continue')) {
			return redirect()
				->route($prefixRoute . '.edit', ['id' => head($id)])
				->withSuccess(config('app.admin.messages.success'));
		} elseif ($request->has('draft')) {
			return redirect()
				->route($prefixRoute . '.edit', ['id' => head($id)])
				->with('preview', 'true');
		} elseif ($request->has('submit_new')) {
			return redirect()
				->route($prefixRoute . '.create', ['lc' => $request->get('submit_new') ?? head($id)])
				->withSuccess(config('app.admin.messages.success'));
		} else {
			return redirect()
				->route($prefixRoute . '.index', $queryString ?? null)
				->withSuccess(config('app.admin.messages.success'));
		}
	}
}
