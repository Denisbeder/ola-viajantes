<?php

namespace App\Supports\Controllers;

use App\Setting;
use App\InstagramPost;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

class FacebookConnectController extends Controller
{
    public $facebook;
    public $helper;
    public $urlCallback;

    public function __construct()
    {
        $facebookService = app('facebookSDKService');
        $this->facebook = $facebookService;
        $this->helper = $this->facebook->loginHelper();
        $this->urlCallback = config('app.url') . '/support/facebook/callback';
    }

    public function settings(Request $request)
    {
        if (!facebook_access_token()) {
            abort(403, 'Token de acesso inválido.');
        }

        $pages = $this->facebook->getPages();
        $data = @Setting::first()->data['facebook'] ?? null;
        return view('supports.facebookconnect.settings', compact('pages', 'data'));
    }

    public function settingsSave(Request $request)
    {
        list($fb_page, $ig_account) = array_filter(explode(',', $request->get('fb_page')));
        $request->merge(['fb_page' => $fb_page, 'ig_account' => $ig_account]);
        $inputs = array_filter($request->only(['fb_page', 'ig_account', 'fb_fields', 'page_id_model']));
        
        $this->save($inputs);

        return response()->json([
            'error' => false,
            'msg' => 'Salvo com sucesso.'
        ]);
    }

    private function save($request)
    {
        $requestInputs = ['facebook' => $request];

        $model = Setting::first();
        
        if (!is_null($model)) {    
            $data = $model->data;

            if (Arr::has($data, 'facebook')) {
                $requestInputs = ['facebook' => array_merge($data['facebook'], $requestInputs['facebook'])];
            }

            // Remove esse campo quando for selecionado a opção "Nenhuma"
            if (!Arr::has($request, 'fb_fields')) {
                unset($requestInputs['facebook']['fb_fields']);
            }

            // Remove esse campo quando for selecionado a opção "Nenhuma"
            if (!Arr::has($request, 'page_id_model')) {
                unset($requestInputs['facebook']['page_id_model']);
            }

            $inputs = array_merge($data, $requestInputs); 
            
            $model->update(['data' => $inputs]);
        }
    }
    
    public function callback(Request $request)
    {
        try {
            if ($request->has('code') && !facebook_access_token()) {
                $accessToken = $this->helper->getAccessToken($this->urlCallback);
                $this->save(['access_token' => base64_encode(serialize($accessToken))]);
            } else {
                $accessToken = facebook_access_token();
            }

            return redirect()->route('settings.index');
            
            // Get items from page of user
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    public function share($where, Request $request)
    {        
        if (!facebook_access_token()) {
            return back()->withErrors('O Facebook não está conectado. Acesse as configurações para se conectar.');
        } 

        if ($where === 'instagram') {
            $img = (new \App\Supports\Services\GenerateMediaToShare($request->input('title'), $request->input('media_url')))->make();
            
            $create = InstagramPost::create([
                'caption' => $request->input('caption'),
                'url' => $request->input('url'),
            ]);

            $create->addMedia($img)->toMediaCollection();

            if (!app()->environment('local')) {
                $id = $this->getSettingsInstagramAccount();
                $postInstagram = $this->facebook->postInstagram($id, $create->getFirstMediaUrl(), $request->input('caption'));
                $postInstagramId = $postInstagram->getGraphNode()->getField('id');

                $create->update(['identifier' => $postInstagramId]);
            }
        }
        
        return redirect()->back()->with('success', 'Item compartilhado no Instagram com sucesso.');
    }

    public function canvas(Request $request)
    {
        if ($request->query('data') === '') {
            return null;
        }

        dd($request->query('data'));

        $image = $request->query('img');
        $text = $request->query('text');

        //return (new GenerateMediaToShare($text, $image))->make();
    }

    public function disconect()
    {
        $this->save(['access_token' => '']);

        return redirect()->back()->withSuccess('Você foi desconectado do Facebook com sucesso.');
    }

    private function getSettingsFacebookPage()
    {
        return @Setting::first()->data['facebook']['fb_page'];
    }

    private function getSettingsInstagramAccount()
    {
        return @Setting::first()->data['facebook']['ig_account'];
    }
}
