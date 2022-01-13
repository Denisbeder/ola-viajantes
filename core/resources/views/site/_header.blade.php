<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container d-flex">
            <button class="navbar-toggler order-0" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni lni-menu"></i>
            </button>  

            <a class="navbar-brand order-1" href="/" title="{{ config('app.site.name') }}">
                <img src="/assets/site/img/logo-color.png" class="logo" alt="{{ config('app.site.name') }}" />
            </a>                     

            @if(!app('mobile-detect')->isMobile())
                {!! app('menuRenderService')->setClassNav('nav nav-social nav-social-header mr-md-3 order-3')->setClassItemLink('nav-link px-2 pb-0 pt-1')->render('social_header') !!}
            @else
                <div class="dropdown dropdown-social order-3">
                    <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="lni lni-share"></i>
                    </button>
                    <div class="px-3 dropdown-menu" aria-labelledby="dropdownMenuButton">
                        {!! app('menuRenderService')->setClassNav('nav nav-social nav-social-header')->setClassItemLink('nav-link px-2')->render('social_header') !!}
                    </div>
                </div>
            @endif

            <form action="/busca" method="GET" class="relative form-inline my-2 my-md-0 search order-4">
                <input name="s" value="{{ request()->query('s') }}" class="rounded-pill form-control" type="text"
                    placeholder="Buscar" aria-label="Buscar">
                <button type="submit" class="btn rounded-pill"><i class="lni lni-search-alt"></i></button>
            </form>

            <div class="collapse navbar-collapse order-2" id="navbarsExample07">
                @include('site._nav')
            </div>    
        </div>
    </nav>
</header>