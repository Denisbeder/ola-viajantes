<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', config('app.admin.name'))</title>

    <link href="{{ mix('/assets/admin/css/index.css') }}" rel="stylesheet">
</head>

<body>
    @include('admin._spinner')

    @include('admin._sidebar')

    <div class="page-container">
        @include('admin._topbar')

        <main class='main-content bgc-grey-100'>
            <div id='mainContent'>
                @include('supports._messages')
                @yield('content')
            </div>
        </main>

    </div>

    @empty($forcePageSelected = session()->get('page.continue'))
    <script>
        const FORCE_PAGE_SELECTED = Boolean({{ !$forcePageSelected }});
        const FORCE_PAGE_SELECTED_OPTIONS = {!! (bool) strlen(session()->get('page.options')) ? 'JSON.parse(\'' . session()->get('page.options') . '\')' : 'false' !!};
    </script>
    @endempty
    <script async src="{{ mix('/assets/admin/js/index.js') }}"></script>
</body>

</html>