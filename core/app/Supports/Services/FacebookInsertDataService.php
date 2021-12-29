<?php

namespace App\Supports\Services;

use Illuminate\Support\Arr;
use App\Supports\Services\FacebookPrepareDataService;

class FacebookInsertDataService
{
    public $setting;
    public $facebookService;
    public $facebookDataService;

    public function __construct()
    {
        $this->setting = app('settingService');
        $this->facebookService = app('facebookSDKService');
        $this->facebookDataService = new FacebookPrepareDataService();
    }
    
    public function insert()
    {
        $pageId = $this->getPageId();
        $pageModel = $this->getPageModel();

        if (is_null($pageId) || is_null($pageModel) || !facebook_access_token()) {
            return null;
        }

        $model = new $pageModel();
        $items = $this->getFacebookItems();

        $items->map(function ($item) use ($model, $pageId, $pageModel) {
            $data = $this->facebookDataService->setItem($item->uncastItems())->getData();
            $associatedItems = $model->associatedItems()->where('identifier', $item['id'])->where('associable_type', $pageModel)->get();
            
            if ($associatedItems->isEmpty()) {
                $create = $model->create(Arr::except($data, ['body']) + ['page_id' => $pageId, 'publish' => 1]);

                if ((bool) strlen($image = $data['image'])) {
                    $create->addMediaFromUrl($image)->toMediaCollection($create->mediaCollection ?? 'default');
                }

                $create->associatedItems()->create([
                    'identifier' => $data['uid'],
                    'description' => 'Item inserido do Facebook URL original ' . $data['url'],
                ]);
            }
        });
    }

    private function getFacebookItems()
    {
        $path = $this->getFacebookPage() . '/' . $this->getFacebookFields();
        return $this->facebookService->getFrom($path);
    }

    private function parsePageIdModel()
    {
        $pageIdModel = @$this->setting->get('facebook')['page_id_model'];

        if (!is_array($pageIdModel)) {
            return explode(',', $pageIdModel);
        }
        return [];
    }

    private function getPageId()
    {
        $pageIdModel = $this->parsePageIdModel();

        return $pageIdModel[0] ?? null;
    }

    private function getPageModel()
    {
        $pageIdModel = $this->parsePageIdModel();

        return $pageIdModel[1] ?? null;
    }

    private function getFacebookPage()
    {
        return @$this->setting->get('facebook')['fb_page'];
    }

    private function getFacebookFields()
    {
        return @$this->setting->get('facebook')['fb_fields'];
    }
}
