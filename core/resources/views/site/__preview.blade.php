<!DOCTYPE html>
<html lang="{{ str_replace('_BR', '-br', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="robots" content="noindex, nofollow">
    
    <link rel="icon" href="{{ asset('/assets/site/svg/favicon.svg') }}" type="image/png" />

    @include('site._fonts') 

    <title>@yield('page_title', config('app.site.name') . ' ' . (((bool) strlen($siteSlogan = config('app.site.slogan'))) ? config('app.site.title_divisor') . ' ' . $siteSlogan : ''))</title>
    
    <!-- Styles -->
    <link http-equiv="x-pjax-version" href="{{ mix('/assets/site/css/style.css') }}" rel="stylesheet">

    @stack('head')   

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="preview">
    @yield('content')

    <script async http-equiv="x-pjax-version" src="{{ mix('/assets/site/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>