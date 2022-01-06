<?php

use Illuminate\Support\Facades\Route;

Route::get('/', ['uses' => 'Site\HomeController@index']);

Route::get('/destinos', ['uses' => 'Site\DestinationsController@index']);

Route::get('/ultimas', ['uses' => 'Site\LatestRecordsController@index']);

Route::get('/busca', ['uses' => 'Site\SearchController@index'])->name('search');

Route::get('/linkbio', ['uses' => 'Site\LinkBioController@index'])->name('linkbio');

Route::get('/sitemap/{filename?}', ['uses' => 'Site\SitemapController@index'])->name('sitemap');

Route::get('/rss/googlenews', ['uses' => 'Site\RSSController@googleNews'])->name('googlenews');

Route::get('/preview/{model}/{id}', ['uses' => 'Site\PreviewController@index'])->where(['model' => '[a-z]+', 'id' => '[0-9]+'])->name('preview');
