<header class="header">
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#" title="{{ config('app.site.name') }}">
    <img src="/assets/site/img/logo-color.png" class="logo" alt="{{ config('app.site.name') }}" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample07">
    @include('site._nav')
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown07">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
      </ul>

      @if(!app('mobile-detect')->isMobile())
        {!! app('menuRenderService')->setClassNav('nav nav-social nav-social-header')->setClassItemLink('nav-link px-2')->render('social_header') !!}
    @else
        <div class="dropdown dropdown-social">
            <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="lni lni-share"></i>
            </button>
            <div class="px-3 dropdown-menu" aria-labelledby="dropdownMenuButton">
                {!! app('menuRenderService')->setClassNav('nav nav-social nav-social-header')->setClassItemLink('nav-link px-2')->render('social_header') !!}
            </div>
        </div>
    @endif


      <form action="/busca" method="GET" class="relative form-inline my-2 my-md-0 search">
                    <input name="s" value="{{ request()->query('s') }}" class="rounded-pill form-control" type="text"
                        placeholder="Buscar" aria-label="Buscar">
                    <button type="submit" class="btn rounded-pill"><i class="lni lni-search-alt"></i></button>
                </form>
    </div>
  </div>
</nav>

</header>