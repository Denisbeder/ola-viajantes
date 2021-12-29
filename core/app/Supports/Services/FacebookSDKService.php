<?php

namespace App\Supports\Services;

use Facebook\Facebook;
use App\Supports\Services\FacebookLoginPersistentDataService;

class FacebookSDKService
{
    private $facebook;
   
    public function __construct()
    {
        $this->facebook = new Facebook([
            'app_id' => '171596977602039',
            'app_secret' => '48de5dacaec2b8ae644a8c94e32fcbff',
            'default_graph_version' => 'v2.10',
            'persistent_data_handler' => new FacebookLoginPersistentDataService(),
            //'default_access_token' => facebook_access_token(), // optional
          ]);
    }

    public function instance()
    {
        return $this->facebook;
    }

    public function loginHelper()
    {
        // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
        return $this->facebook->getRedirectLoginHelper();
    }

    public function loginUrl()
    {
        return $this->loginHelper()
            ->getLoginUrl(config('app.url') . '/support/facebook/callback', [
                'pages_show_list',
                'pages_read_engagement',
                'public_profile',
                'ads_management',
                'business_management',
                'instagram_basic',
                'instagram_content_publish',
            ]);
    }

    public function getPages()
    {
        $accessToken = facebook_access_token();
        $response = $this->facebook->get('/me/accounts?fields=id,name,picture,instagram_business_account', $accessToken);
        $pages = $response->getGraphEdge();

        return $pages->map(function ($item) {
            $id = $item->getProperty('instagram_business_account')->getProperty('id');
            $item['instagram'] = $this->getInstagram($id);
            return $item;
        }); 
    }

    public function getPage($pageId)
    {
        $accessToken = facebook_access_token();
        $response = $this->facebook->get($pageId, $accessToken);
        return $response->getGraphNode();
    }

    public function getInstagramAccounts()
    {
        $pages = $this->getPages()->map(function ($item) {
            $id = $item->getProperty('instagram_business_account')->getProperty('id');

            return $this->getInstagram($id);
        });   
        
        return $pages;
    }

    public function getInstagram($id)
    {
        $accessToken = facebook_access_token();
        $response = $this->facebook->get('/' . $id . '?fields=biography,name,username,profile_picture_url,media{media_url,caption,permalink,id}', $accessToken);
        return $response->getGraphNode();
    }

    public function getFrom($path)
    {
        $accessToken = facebook_access_token();
        $response = $this->facebook->get($path, $accessToken);
        return $response->getGraphEdge();
    }    

    public function postInstagram($id, $imageUrl, $caption)
    {
        $accessToken = facebook_access_token();
        
        // Prepare post for publish
        $preparePublish = $this->facebook->post('/' . $id . '/media', [
            'image_url' => $imageUrl,
            'caption' => $caption
        ], $accessToken);

        // Get publish ID
        $publishId = $preparePublish->getGraphNode()->getField('id');

        // Finalize publish effective
        $publishFinalize = $this->facebook->post('/' . $id . '/media_publish', ['creation_id' => $publishId], $accessToken);

        return $publishFinalize;
    }  
}
