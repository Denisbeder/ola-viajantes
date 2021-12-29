<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title>Estamos em manutenção - {{ config('app.site.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/assets/admin/css/index.css') }}" rel="stylesheet">

</head>

<body>
    <div class='pos-a t-0 l-0 bgc-white w-100 h-100 d-f fxd-r fxw-w ai-c jc-c pos-r p-30'>        
        <div class='d-f jc-c fxd-c ai-c text-center'>
            <img alt='#' src='/assets/errors/img/503.jpg' class="img-fluid" />
            <h1 class='mB-30 fw-900 lh-1 c-red-500' style="font-size: 12vmin;">Estamos em manutenção</h1>
            <p class='mB-30 fsz-def c-grey-700'>O servidor está passando por manutenção, retornaremos em breve.</p>
        </div>
    </div>
</body>

</html>