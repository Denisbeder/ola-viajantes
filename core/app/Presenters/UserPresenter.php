<?php

namespace App\Presenters;

use App\Page;
use Laracasts\Presenter\Presenter;
use App\Supports\Traits\PublishPresenterTrait;

class UserPresenter extends Presenter {

    use PublishPresenterTrait;

    public function adminLabel()
    {
        return $this->is_admin ? 'Sim' : 'Não';
    }

    public function permissionsAvaliable()
    {
        if (is_null($this->permissions)) {
            return;
        }

        $permissions = collect(config('app.admin.permissions'));
        $html = '';
        foreach ($this->permissions as $k => $item) {
            if ($k === 'pages') {
                $pageIds = array_map(function ($value) {
                    return last(explode('_', $value));
                }, $item);
                $htmlElement = ' <div class="mb-1 badge bgc-blue-50 c-blue-700 p-10 lh-0 tt-c badge-pill">Página: ';
                $html .= $htmlElement . Page::find($pageIds)->pluck('title')->implode('</div>'.$htmlElement) . '</div> ';
            } else {
                $label = $permissions->whereIn('route', $item)->first()['label'];
                $html .= '<div class="mb-1 badge bgc-blue-50 c-blue-700 p-10 lh-0 tt-c badge-pill">' . $label . '</div> ';
            }
        }

        return $html;
    }
}