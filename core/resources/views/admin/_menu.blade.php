<li class="nav-item">
    <a class="sidebar-link" href="/admin/dashboard">
        <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Visão geral</span>
    </a>
</li>

@php
    $pages = App\Page::defaultOrder()->get();
    $abilitiesPages = $pages->map(function ($item) {
        return $item->present()->abilityName;
    })->toArray();
@endphp
@canany($abilitiesPages)
<li class="nav-item dropdown {{ request()->is(['posts*', '*lisings*', '*videos*', '*forms*', '*galleries*', '*promotions*', '*adverts*']) ? 'open' : '' }}"><a class="dropdown-toggle" href="javascript:void(0);">
    <span class="icon-holder"><i class="c-silver-500 ti-files"></i></span>
    <span class="title">Páginas</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
    <ul class="dropdown-menu">
        <li><hr class="my-0 py-0"></li>

        @can('pages')
        <li class="d-flex align-items-center"><a class="sidebar-link" href="/admin/pages"><i class="text-black-50 ti-settings mr-2"></i> Gerenciar páginas</a></li>
        <li><hr class="my-0 py-0"></li>
        @endcan

        @foreach ($pages as $page)  
            @can($page->present()->abilityName)          
            <li class="d-flex align-items-center"><a class="sidebar-link" href="{{ $page->present()->managerButtonUrl }}"><i class="text-black-50 ti-file mr-2"></i> {{ $page->title }}</a></li>
            @endcan
        @endforeach

        <li><hr class="my-0 py-0"></li>
    </ul>
</li>
@elsecanany(['pages'])
<li class="nav-item">
    <a class="sidebar-link" href="/admin/pages">
        <span class="icon-holder">
            <i class="c-silver-500 ti-files"></i>
        </span>
        <span class="title">Páginas</span>
    </a>
</li> 
@endcanany

@can('highlights')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/highlights">
        <span class="icon-holder">
            <i class="c-green-500 ti-pin2"></i>
        </span>
        <span class="title">Destaques da Home</span>
    </a>
</li>
@endcan

@can('related')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/related">
        <span class="icon-holder">
            <i class="c-indigo-500 ti-link"></i>
        </span>
        <span class="title">Relacionados</span>
    </a>
</li>
@endcan

@can('instagramposts')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/instagramposts">
        <span class="icon-holder">
            <i class="c-pink-500 ti-instagram"></i>
        </span>
        <span class="title">Instagram Posts</span>
    </a>
</li>
@endcan

@can('menus')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/menus">
        <span class="icon-holder">
            <i class="c-teal-300 ti-menu"></i>
        </span>
        <span class="title">Menus</span>
    </a>
</li>
@endcan

{{-- <li class="nav-item">
    <a class="sidebar-link" href="/admin/posts">
        <span class="icon-holder">
            <i class="c-green-500 ti-write"></i>
        </span>
        <span class="title">Posts</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/videos">
        <span class="icon-holder">
            <i class="c-red-500 ti-video-camera"></i>
        </span>
        <span class="title">Vídeos</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/galleries">
        <span class="icon-holder">
            <i class="c-blue-500 ti-gallery"></i>
        </span>
        <span class="title">Galerias</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/listings">
        <span class="icon-holder">
            <i class="c-green-500 ti-layout-list-thumb"></i>
        </span>
        <span class="title">Listas</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/adverts">
        <span class="icon-holder">
            <i class="c-deep-orange-600 ti-announcement"></i>
        </span>
        <span class="title">Mural de anúncios</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/promotions">
        <span class="icon-holder">
            <i class="c-blue-grey-700 ti-gift"></i>
        </span>
        <span class="title">Promoções</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link" href="/admin/forms">
        <span class="icon-holder">
            <i class="c-green-500 ti-layout-cta-btn-left"></i>
        </span>
        <span class="title">Formulários</span>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a class="sidebar-link" href="/admin/shop">
        <span class="icon-holder">
            <i class="c-deep-orange-600 ti-shopping-cart"></i>
        </span>
        <span class="title">Loja</span>
    </a>
</li> --}}

@can('polls')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/polls">
        <span class="icon-holder">
            <i class="c-brown-600 ti-bar-chart"></i>
        </span>
        <span class="title">Enquetes</span>
    </a>
</li>
@endcan

@can('comments')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/comments">
        <span class="icon-holder">
            <i class="c-yellow-800 ti-comment"></i>
        </span>
        <span class="title">Comentários</span>
    </a>
</li>
@endcan

@can('categories')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/categories">
        <span class="icon-holder">
            <i class="c-green-500 ti-bookmark"></i>
        </span>
        <span class="title">Categorias</span>
    </a>
</li>
@endcan

@can('banners')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/banners">
        <span class="icon-holder">
            <i class="c-orange-500 ti-blackboard"></i>
        </span>
        <span class="title">Banners</span>
    </a>
</li>
@endcan

@can('users')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/users">
        <span class="icon-holder">
            <i class="c-purple-500 ti-user"></i>
        </span>
        <span class="title">Usuários</span>
    </a>
</li>
@endcan

{{-- @can('seo')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/seo">
        <span class="icon-holder">
            <i class="c-teal-300 ti-panel"></i>
        </span>
        <span class="title">SEO</span>
    </a>
</li>
@endcan --}}

@can('settings')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/settings">
        <span class="icon-holder">
            <i class="c-gray-500 ti-settings"></i>
        </span>
        <span class="title">Configuração geral</span>
    </a>
</li>
@endcan

@can('logs')
<li class="nav-item">
    <a class="sidebar-link" href="/admin/logs">
        <span class="icon-holder">
            <i class="c-red-500 ti-info-alt"></i>
        </span>
        <span class="title">Logs do sistema</span>
    </a>
</li>
@endcan