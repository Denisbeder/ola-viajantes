<?php

namespace App\Supports\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

trait MediaLibraryTrait
{
    /**
	 * Add media to storage.
	 *
	 */
	protected function addMedia($input, Model $data, $filename = null, $collection = null)
	{
		if (!request()->has($input)) return;

		$collection = is_null($collection) ? $data->mediaCollection : $collection;

		if (is_array($requestInput = request()->get($input))) {
			if (empty(array_filter($requestInput))) return;
		}

		if (request()->hasFile($input)) {
			return $data->addMultipleMediaFromRequest([$input])
				->each(function ($fileAdder, $key) use ($filename, $collection, $input) {
					$files = request()->file($input);
					$request = is_array($files) ? $files[$key] : $files;
					$this->mediaSanitizeSave($fileAdder, $filename, $request, $collection ?? 'default');
				});
		} else {
			$request = request()->get($input);
			$fileAdder = $data->addMediaFromUrl($request);
			$this->mediaSanitizeSave($fileAdder, $filename, $request, $collection ?? 'default');
		}
	}

	/**
	 * Customize name files and set collection and save the media.
	 *
	 */
	protected function mediaSanitizeSave($fileAdder, $filename = null, UploadedFile $request, $collection)
	{
		if (!is_null($filename)) {
			$fileAdder->usingName($filename);
		}

		$imageInfos = imageInfos($request->getPathName());
		$width = $imageInfos[0] ?? null;
		$height = $imageInfos[1] ?? null;

		if (!is_null($width) && !is_null($height)) {
			$fileAdder->withCustomProperties(compact('width', 'height'));
		}

		$fileAdder->sanitizingFileName(function ($item) use ($filename) {
			$extension = pathinfo($item, PATHINFO_EXTENSION);
			return Str::slug($filename . '_' . microtime(true)) . '.' . $extension;
		})->toMediaCollection($collection);

		return $fileAdder;
	}
}