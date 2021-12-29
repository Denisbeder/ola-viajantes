<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'America/Campo_Grande',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        //Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Collective\Html\HtmlServiceProvider::class,
        Spatie\Glide\GlideServiceProvider::class,
        Riverskies\Laravel\MobileDetect\MobileDetectServiceProvider::class,
        TeamTNT\Scout\TNTSearchScoutServiceProvider::class,
        \EloquentFilter\ServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\SupportServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        //'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        /*
         * Package Class Aliases...
         */
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'GlideImage' => Spatie\Glide\GlideImageFacade::class,
    ],

    // Extras Configs 
    'admin' => [
        'name' => 'Adminer',
        'messages' => [
            'success' => 'Resgistro salvo com sucesso',
            'error' => 'Aconteceu um erro inesperado ao tentar salvar o registro',
            'id_not_found' => 'Registro não foi encontrado',
            'error_oembed' => 'Não foi possível encontrar dados da URL informada, tente inserir manualmente',
            'token_mismatch' => 'Não foi possível enviar o formulário porque o Token de segurança expirou. Tente novamente agora ou atualize a página e tente novamente',
        ],
        'permissions' => [
            ['label' => 'Usuários', 'route' => 'users'],
            ['label' => 'Usuários Permissões', 'route' => 'userspermissions'],
            ['label' => 'Enquetes', 'route' => 'polls'],
            ['label' => 'Comentários', 'route' => 'comments'],
            ['label' => 'Categorias', 'route' => 'categories'],
            ['label' => 'Banners', 'route' => 'banners'],
            ['label' => 'Configurações', 'route' => 'settings'],
            //['label' => 'SEO', 'route' => 'seo'],
            ['label' => 'Menus', 'route' => 'menus'],
            ['label' => 'Páginas', 'route' => 'pages'],
            ['label' => 'Estatísticas', 'route' => 'statistics'],
            ['label' => 'Logs', 'route' => 'logs'],
            ['label' => 'Destaques da home', 'route' => 'highlights'],
            ['label' => 'Relacionados', 'route' => 'related'],
            ['label' => 'Conectar Facebook', 'route' => 'facebookconnect'],
            ['label' => 'Instagram Posts', 'route' => 'instagramposts'],
        ],
        'managers' => [
            [
                'model' => 'App\Post',
                'uses' => 'App\Http\Controllers\Site\PostsController',
                'label' => 'Posts',
            ],
            [
                'model' => 'App\Video',
                'uses' => 'App\Http\Controllers\Site\VideosController',
                'label' => 'Vídeo',
            ],
            [
                'model' => 'App\Gallery',
                'uses' => 'App\Http\Controllers\Site\GalleriesController',
                'label' => 'Galerias',
            ],
            [
                'model' => 'App\Form',
                'uses' => 'App\Http\Controllers\Site\FormsController',
                'label' => 'Formulários',
            ],
            [
                'model' => 'App\Listing',
                'uses' => 'App\Http\Controllers\Site\ListingsController',
                'label' => 'Listas',
            ],
            [
                'model' => 'App\Promotion',
                'uses' => 'App\Http\Controllers\Site\PromotionsController',
                'label' => 'Promoções',
            ],
            [
                'model' => 'App\Advert',
                'uses' => 'App\Http\Controllers\Site\AdvertsController',
                'label' => 'Mural de anúncios',
            ],
            [
                'model' => 'App\Shop',
                'uses' => 'App\Http\Controllers\Site\ShopsController',
                'label' => 'Loja',
            ],
            [
                'model' => 'App\Page',
                'uses' => 'App\Http\Controllers\Site\PagesController',
                'label' => 'Listar Subpáginas',
            ],
        ],
        'icons' => [
            [
                'key' => 'search',
                'label' => 'Busca',
                'code' => '<i class="fas fa-search"></i>',
                'unicode' => 'f002',
            ],
            [
                'key' => 'menu_burger',
                'label' => 'Menu Burger',
                'code' => '<i class="fas fa-bars"></i>',
                'unicode' => 'f0c9',
            ],
            [
                'key' => 'check',
                'label' => 'Check',
                'code' => '<i class="fas fa-check"></i>',
                'unicode' => 'f00c',
            ],
            [
                'key' => 'users',
                'label' => 'Usuários',
                'code' => '<i class="fas fa-users"></i>',
                'unicode' => 'f0c0',
            ],
            [
                'key' => 'user',
                'label' => 'Usuário',
                'code' => '<i class="fas fa-user"></i>',
                'unicode' => 'f007',
            ],
            [
                'key' => 'user-tie',
                'label' => 'Usuário com gravata',
                'code' => '<i class="fas fa-user-tie"></i>',
                'unicode' => 'f508',
            ],
            [
                'key' => 'times',
                'label' => 'Fechar',
                'code' => '<i class="fas fa-times"></i>',
                'unicode' => 'f00d',
            ],
        ]
    ],

    'banners' => [
        'positions' => [
            ['key' => 1, 'label' => 'Posição 1 abaixo do cabeçalho/topo (970x90 / 728x90 / 970x250)', 'formats' => [1, 2, 6, 20]],
            ['key' => 2, 'label' => 'Posição 2 barra lateral/sidebar acima da enquete ou colunas (300x250)', 'formats' => [3, 20]],
            //['key' => 4, 'label' => 'Posição 5 entre os slides (580x400 / 336x280 / 300x250)', 'formats' => [3, 4, 16, 20]],
        ],

        'formats' => [
            ['key' => 1, 'label' => 'Cabeçalho', 'w' => 728, 'h' => 90],
            ['key' => 2, 'label' => 'Cabeçalho grande', 'w' => 970, 'h' => 90],
            ['key' => 3, 'label' => 'Retângulo médio', 'w' => 300, 'h' => 250],
            ['key' => 6, 'label' => 'Outdoor', 'w' => 970, 'h' => 250],
            ['key' => 4, 'label' => 'Retângulo grande', 'w' => 336, 'h' => 280],
            ['key' => 16, 'label' => 'Netboard', 'w' => 580, 'h' => 400], 
            ['key' => 20, 'label' => 'Mobile', 'w' => 320, 'h' => 100],
            /* 
            ['key' => 21, 'label' => 'Botão', 'w' => 120, 'h' => 60],
            ['key' => 5, 'label' => 'Banner', 'w' => 468, 'h' => 60],
            ['key' => 7, 'label' => 'Metade da página', 'w' => 300, 'h' => 600],
            ['key' => 18, 'label' => 'Super Selo', 'w' => 320, 'h' => 100],
            ['key' => 19, 'label' => 'Outdoor grande', 'w' => 970, 'h' => 600],
            ['key' => 17, 'label' => 'Selo Fixo', 'w' => 150, 'h' => 80],
            ['key' => 8, 'label' => 'Meio-banner', 'w' => 234, 'h' => 60],
            ['key' => 9, 'label' => 'Botão', 'w' => 125, 'h' => 125],
            ['key' => 10, 'label' => 'Arranha-céu', 'w' => 120, 'h' => 600],
            ['key' => 11, 'label' => 'Banner vertical', 'w' => 120, 'h' => 240],
            ['key' => 1, 'label' => 'Retângulo pequeno', 'w' => 180, 'h' => 150],
            ['key' => 13, 'label' => 'Quadrado pequeno', 'w' => 200, 'h' => 200],
            ['key' => 14, 'label' => 'Quadrado', 'w' => 250, 'h' => 250],
            ['key' => 15, 'label' => 'Retrato', 'w' => 320, 'h' => 50], 
            
            */
        ],
    ],

    'site' => [
        'name' => 'Nome do site',
        'slogan' => '',
        'title_divisor' => '|',
        'color' => '#a1ca47',
    ]
];
