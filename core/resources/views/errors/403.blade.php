<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title>403 - {{ config('app.site.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/assets/admin/css/index.css') }}" rel="stylesheet">

</head>

<body>
    <div class='pos-a t-0 l-0 bgc-white w-100 h-100 d-f fxd-r fxw-w ai-c jc-c pos-r p-30'>
        <div class='mR-60'>
            <img alt='#' src='/assets/errors/img/403.png' />
        </div>

        <div class='d-f jc-c fxd-c'>
            <h1 class='mB-30 fw-900 lh-1 c-red-500' style="font-size: 60px;">403</h1>
            <h3 class='mB-10 fsz-lg c-grey-900 tt-c'>Permissão negada</h3>
            <p class='mB-30 fsz-def c-grey-700'>Você não tem permissão para acessar essa página. Entre em contato com o administrador do site.</p>
            <div>
                <a href="javascript:window.history.back();" type='primary' class='btn btn-primary'><i class="ti-arrow-left"></i> Voltar</a>
                <a href="{{ request()->is('admin*') ? '/admin/dashboard' : '/' }}" type='primary' class='btn btn-primary'><i class="ti-home"></i> Início</a>
            </div>
        </div>
    </div>
</body>

</html>