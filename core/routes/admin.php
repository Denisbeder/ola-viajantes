<?php

use Illuminate\Support\Facades\Route;

// Login
Route::prefix('admin')
    ->group(function () {
        Route::get('/login', ['uses' => 'Admin\AuthController@showLoginForm'])->name('login');
        Route::post('/login', ['uses' => 'Admin\AuthController@login']);
        Route::get('/logout', ['uses' => 'Admin\AuthController@logout']);
    });

Route::middleware(['auth'])
    ->namespace('Admin')
    ->prefix('admin')
    ->group(function () {
        // Ao acessar a rota /admin redireciona para login
        Route::redirect('/admin', '/admin/login');

        // Dashboard
        Route::get('/dashboard', 'DashboardController@index');

        // Highlights
        Route::resource('highlights', 'HighlightsController')->except(['create', 'edit', 'store'])->parameters(['highlights' => 'id'])->middleware('can:highlights');

        // Relateds
        Route::resource('related', 'RelatedController')->only(['index'])->parameters(['related' => 'id'])->middleware('can:related');

        // Posts
        Route::resource('posts', 'PostsController')->parameters(['posts' => 'id']);

        // Galleries
        Route::resource('galleries', 'GalleriesController')->parameters(['galleries' => 'id']);

        // Videos
        Route::resource('videos', 'VideosController')->parameters(['videos' => 'id']);

        // Medias
        Route::resource('medias', 'MediasController')->only(['edit', 'update', 'destroy'])->parameters(['medias' => 'id']);

        // Forms
        Route::resource('forms', 'FormsController')->only(['index', 'store'])->parameters(['forms' => 'id']);

        // Menus
        Route::resource('menus', 'MenusController')->only(['index', 'store'])->parameters(['menus' => 'id'])->middleware('can:menus');

        // Lists
        Route::resource('listings', 'ListingsController')->parameters(['listings' => 'id']);

        // Promotions
        Route::resource('promotions', 'PromotionsController')->parameters(['promotions' => 'id']);

        // Promotions Participants
        Route::resource('promotionsparticipants', 'PromotionsParticipantsController')->parameters(['promotionsparticipants' => 'id']);

        // Adverts
        Route::resource('adverts', 'AdvertsController')->parameters(['adverts' => 'id']);

        // Users
        Route::resource('users', 'UsersController')->parameters(['users' => 'id'])->middleware('can:users');

        // Categories
        Route::resource('categories', 'CategoriesController')->parameters(['categories' => 'id'])->middleware('can:categories');

        // Pages
        Route::resource('pages', 'PagesController')->parameters(['pages' => 'id']);

        // Destinations
        Route::resource('destinations', 'DestinationsController')->parameters(['destinations' => 'id']);

        // Banners
        Route::resource('banners', 'BannersController')->parameters(['banners' => 'id'])->middleware('can:banners');

        // Polls
        Route::resource('polls', 'PollsController')->parameters(['polls' => 'id'])->middleware('can:polls');

        // Comments
        Route::resource('comments', 'CommentsController')->except(['store', 'edit'])->parameters(['comments' => 'id'])->middleware('can:comments');

        // Seos
        //Route::resource('seo', 'SeoController')->except(['create', 'store'])->parameters(['seo' => 'id'])->middleware('can:seo');

        // Instagram Posts
        Route::resource('instagramposts', 'InstagramPostsController')->only(['index', 'show'])->parameters(['instagramposts' => 'id'])->middleware('can:instagramposts');

        // Settings
        Route::resource('settings', 'SettingsController')->only(['index', 'store', 'update'])->parameters(['settings' => 'id'])->middleware('can:settings');
    });