<?php

use Illuminate\Support\Facades\Route;

// clear info any web server
Route::any('/support/oembed', 'OembedController@fetch');

// Store Image from Editor and etc...
Route::post('/support/storeimage', 'StoreImageController@store');

// Store File from Editor and etc...
Route::post('/support/storefile', 'StoreFileController@store');

// Get files from storage and generate Thumbs
Route::get('/media/{path}', 'MediaController@show')->where('path', '.+')->middleware('free.cookie');

// Image default
Route::get('imagedefault', 'MediaController@imageDefault')->middleware('free.cookie');

Route::post('/support/sendmail', ['uses' => 'SendmailController@send'])->middleware(['web']);
Route::post('/support/comment/save', ['uses' => 'CommentController@save'])->middleware(['web']);
Route::post('/support/promotionparticipant/save', ['uses' => 'PromotionParticipantController@save'])->middleware(['web']);

// Store Adverts from users
Route::get('/support/adverts/{id}', 'AdvertsController@destroy');
Route::post('/support/adverts', 'AdvertsController@store');

// Combo Box City
Route::get('/support/cities', 'CitiesController@index');

// Find Relacioados in POSTS
Route::get('/support/related', 'RelatedController@index');

// Save poll vote
Route::post('/support/poll/{id}/save', ['uses' => 'PollsController@save'])->where('id', '[0-9]+');

// Clear cache for model
Route::get('/support/clearcache/{model?}', 'ClearCacheModelController@clear');

// View Register
Route::post('/support/view-register', 'ViewRegisterController@register');

// Facebook Connect
Route::get('/support/facebook/disconect', ['uses' => 'FacebookConnectController@disconect']);
Route::get('/support/facebook/callback', ['uses' => 'FacebookConnectController@callback']);
Route::get('/support/facebook/settings', ['uses' => 'FacebookConnectController@settings']);
Route::post('/support/facebook/settings', ['uses' => 'FacebookConnectController@settingsSave']);
Route::post('/support/facebook/share/{where}', ['uses' => 'FacebookConnectController@share']);
Route::get('/support/facebook/generate/canvas', ['uses' => 'FacebookConnectController@canvas']);

// Get CSRF Token
Route::get('/support/getcsrftoken', ['uses' => 'GetCSRFTokenController@get']);
