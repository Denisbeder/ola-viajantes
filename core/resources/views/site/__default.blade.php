<!DOCTYPE html>
<html lang="{{ str_replace('_BR', '-br', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('site._meta') 
    
    <link rel="icon" href="{{ asset('/assets/site/img/favicon.png') }}" type="image/png" />

    @include('site._fonts') 

    <!-- Styles -->
    <link http-equiv="x-pjax-version" href="{{ mix('/assets/site/css/style.css') }}" rel="stylesheet">

    @stack('head')

    {!! app('settingService')->get('scripts')['head'] ?? null !!}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="padding-top: 74px;">
    <div class="alert alert-danger text-center rounded-0 py-4 fixed-top"><strong><span class="d-none d-md-block">ESTA É UMA</span> VERSÃO DE DEMOSNTRAÇÃO</strong></div>
    @include('site._header')

    @yield('content')

    @include('site._footer')
    
    <script id="script-main" http-equiv="x-pjax-version" src="{{ mix('/assets/site/js/main.js') }}"></script>
    
    @stack('scripts')

    {!! app('settingService')->get('scripts')['footer'] ?? null !!}
</body>

</html>